-module(ws_handler_from_client).
-behaviour(cowboy_websocket_handler).

-export([init/3]).
-export([websocket_init/3]).
-export([websocket_handle/3]).
-export([websocket_info/3]).
-export([websocket_terminate/3]).
% -export([select/0, select/1]).


-include("log.hrl").
% -include_lib("stdlib/include/qlc.hrl").


init({tcp, http}, _Req, _Opts) ->
	process_flag(trap_exit, true),
	{upgrade, protocol, cowboy_websocket}.

websocket_init(_TransportName, Req, _Opts) ->
	% erlang:start_timer(1000, self(), <<"Hello!">>),
	% ?LOG("client ws init"),
	% {{{P1,P2,P3,P4}, _Port}, _} = cowboy_req:peer(Req),
	% Ip = lists:concat([P1,".", P2, ".", P3, ".", P4]),
	% % ?LOG({ip, Ip}),
	% Ip1 = glib:to_binary(Ip),
	% ?LOG({ip, Ip1}),

	% {ok,[Ip1|_], _} = 
	Ip1 = case cowboy_req:parse_header(<<"x-forwarded-for">>, Req) of 
		{ok,[Ip|_], _} ->
			Ip;
		_ -> 
			{{{P1,P2,P3,P4}, _Port}, _} = cowboy_req:peer(Req),
			Ip = lists:concat([P1,".", P2, ".", P3, ".", P4]),
			glib:to_binary(Ip)
	end,

	?LOG({client_ip, Ip1}),

	% Ip1 = <<"">>,

	case table_forbidden_ip:select(Ip1) of
		[] ->
			State = #state_client{uid = 0, islogin = false, isTick = false, stype = 0, sid = 0, front_pid = self(), backend_pid=0, data= <<>>},
			{ok, Req, State};
		_ ->
			{shutdown, Req, forbidden_ip}
	end.

% websocket_handle({text, Msg}, Req, {_, Uid} = State) ->
% 	?LOG({Uid, Msg}),
% 	Clients = select(Uid),
% 	?LOG(Clients),
% 	broadcast(Clients, Msg),
% 	{ok, Req, State};
	% {reply, {text, << "That's what she said! ", Msg/binary >>}, Req, State};
websocket_handle({binary, CurrentPackage}, Req, State = #state_client{islogin = false, data= LastPackage}) ->
	?LOG({"binary recv: ", CurrentPackage}),

	PackageBin = <<LastPackage/binary, CurrentPackage/binary>>,

	case handler_login:parse_package_login(PackageBin, State) of 
		{ok, waitmore, Bin} -> 
			% {noreply, State#state{data = Bin}};
			{ok, Req, State#state_client{data = Bin}};
		% {islogin, LeftBin, Uid} -> 
		{ok, NextPageckage, Uid} ->
			% self() ! {send, Reply},
			?LOG({"login success:", Uid}),
			send_to_client:login_only_one_place(Uid),
			table_client_list:add(Uid, self(), 0, 0, 0),
			send_package_to_gwc:client_login(Uid),
			websocket_handle({binary, NextPageckage}, Req, State#state_client{uid = Uid, islogin = true, data= <<>>});
		{ok, NextPageckage, Uid, ServerTypeReq} ->
			?LOG({"login success:", Uid}),
			send_to_client:login_only_one_place(Uid),
			table_client_list:add(Uid, self(), 0, 0, 0, ServerTypeReq),
			send_package_to_gwc:client_login(Uid),
			websocket_handle({binary, NextPageckage}, Req, State#state_client{uid = Uid, islogin = true, data= <<>>});
		{reply_then_close, Reply} ->
			websocket_handle({reply_then_close, Reply}, Req, State);
		_ ->
			{shutdown, Req, State}
	end;
websocket_handle({binary, CurrentPackage}, Req, State = #state_client{islogin = true, data= LastPackage}) ->
	?LOG({"had logined, then binary recv: ", CurrentPackage}),

	PackageBin = <<LastPackage/binary, CurrentPackage/binary>>,
	case parse_package_from_client:parse_package(PackageBin, State) of 
		{ok, waitmore, Bin} -> 
			{ok, Req, State#state_client{data = Bin}};
		_ -> 
			{shutdown, Req, State}
	end;
websocket_handle({reply_then_close, Reply}, Req, State) ->
	?LOG({reply_then_close, Reply, {state, State}}),
	self() ! close,
    {reply, {binary, Reply}, Req, State};
websocket_handle(Data, Req, State) ->
	?LOG({"XXy", Data}),
	{ok, Req, State}.

% websocket_info({broadcast, Msg}, Req, {_, Uid} = State) ->
% 	?LOG({broadcast, Msg}),
% 	{reply, {text, << "That's what she said! ", Msg/binary >>}, Req, State};
% {transport, RightPackage}
websocket_info({transport, RightPackage}, Req, State) ->
    ?LOG({transport, RightPackage, {state, State}}),
    {reply, {binary, RightPackage}, Req, State};
websocket_info({timeout, _Ref, Msg}, Req, State) ->
	{reply, {text, Msg}, Req, State};
websocket_info({send, PackageBin}, Req, State) ->
	{reply, {binary, PackageBin}, Req, State};
websocket_info(close, Req, State) ->
	?LOG1(close),
	{shutdown, Req, State};
websocket_info(tick, Req, State) ->
	?LOG1({tick}),
	{ok, Req, State#state_client{isTick = true}};
websocket_info(Info, Req, State) ->
	?LOG({info, Info}),
	{ok, Req, State}.

%% 
websocket_terminate(_Reason, _Req, _State = #state_client{islogin = true, isTick = IsTick, uid = Uid}) ->
	% ?LOG({<<"client closed">>, Uid}),
	?LOG_CHANGE_GS({<<"client closed">>, Uid}),
	case IsTick of 
		true ->
			?LOG_CHANGE_GS({<<"client closed">>, Uid}),
			ok;
		_ ->
			?LOG_CHANGE_GS({<<"client closed">>, Uid}),
			send_package_to_gwc:client_logout(Uid),
			ok
	end,

	?LOG_CHANGE_GS({Uid, self(), client}),
	table_client_list:clear_user(Uid, self(), client),
	ok;
websocket_terminate(Reason, _Req, _State) ->
	?LOG({<<"client closed">>, Reason}),
	ok.



