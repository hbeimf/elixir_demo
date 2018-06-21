-module(client_hub).

-behaviour(gen_server).
% --------------------------------------------------------------------
% Include files
% --------------------------------------------------------------------

% --------------------------------------------------------------------
% External exports
% --------------------------------------------------------------------
-export([]).

% gen_server callbacks
-export([start_link/0]).
-export([init/1, handle_call/3, handle_cast/2, handle_info/2, terminate/2, code_change/3]).

% -record(state, {}).
-record(state, {
	socket, 
	transport, 
	data,
	ip,
	port}).

% --------------------------------------------------------------------
% External API
% --------------------------------------------------------------------
-export([send/0, send/1]).


-include("inner_msg_proto.hrl").
-include("inner_cmd.hrl").


send() -> 
	Type = 1111, 
	Bin = <<"test send!!">>,
	P = tcp_package:package(Type, Bin),

	Type1 = 2222, 
	Bin1 = <<"test sendXX!!">>,
	P1 = tcp_package:package(Type1, Bin1),

	Type2 = 9999, 
	Bin2 = <<"test sendXX!!">>,
	P2 = tcp_package:package(Type2, Bin2),

	PP = <<P/binary, P1/binary, P2/binary>>,
	send(PP).


send(Package) -> 
	gen_server:cast(?MODULE, {send, Package}).

% doit(FromPid) ->
%     gen_server:cast(?MODULE, {doit, FromPid}).



start_link() ->
    gen_server:start_link({local, ?MODULE}, ?MODULE, [], []).


% --------------------------------------------------------------------
% Function: init/1
% Description: Initiates the server
% Returns: {ok, State}          |
%          {ok, State, Timeout} |
%          ignore               |
%          {stop, Reason}
% --------------------------------------------------------------------
init([]) ->
	{Ip, Port} = rconf:read_config(hub_server),

	case ranch_tcp:connect(Ip, Port,[],3000) of
		{ok,Socket} ->
	        ok = ranch_tcp:setopts(Socket, [{active, once}]),
			erlang:start_timer(1000, self(), {regist}),
			{ok, #state{socket = Socket, transport = ranch_tcp, data = <<>>, ip = Ip, port = Port} };
		{error,econnrefused} -> 
			erlang:start_timer(3000, self(), {reconnect,{Ip,Port}}),
			{ok,#state{socket = econnrefused, transport = ranch_tcp, data = <<>>,ip = Ip, port = Port}};

		{error,Reason} ->
			{stop,Reason}
	end.



% --------------------------------------------------------------------
% Function: handle_call/3
% Description: Handling call messages
% Returns: {reply, Reply, State}          |
%          {reply, Reply, State, Timeout} |
%          {noreply, State}               |
%          {noreply, State, Timeout}      |
%          {stop, Reason, Reply, State}   | (terminate/2 is called)
%          {stop, Reason, State}            (terminate/2 is called)
% --------------------------------------------------------------------

% handle_call({doit, FromPid}, _From, State) ->
%     io:format("doit  !! ============== ~n~n"),

%     lists:foreach(fun(_I) ->
%         FromPid ! {from_doit, <<"haha">>}
%     end, lists:seq(1, 100)),

%     {reply, [], State};
handle_call(_Request, _From, State) ->
    Reply = ok,
    {reply, Reply, State}.

% --------------------------------------------------------------------
% Function: handle_cast/2
% Description: Handling cast messages
% Returns: {noreply, State}          |
%          {noreply, State, Timeout} |
%          {stop, Reason, State}            (terminate/2 is called)
% --------------------------------------------------------------------
handle_cast({send, Package}, State=#state{
		socket=Socket, transport=_Transport, data=_LastPackage}) ->
    % io:format("send cast !! ============== ~n~n"),
    % {ok, GoMBox} = application:get_env(go, go_mailbox),
    % io:format("message ~p!! ============== ~n~n", [GoMBox]),
    % gen_server:cast(GoMBox, {Msg, self()}),

    % P1 = tcp_package:package(Type, Bin),

    % P = <<P1/binary, P1/binary>>,
    % ranch_tcp:send(Socket, P),
    ranch_tcp:send(Socket, Package),

    {noreply, State};
handle_cast(_Msg, State) ->
    {noreply, State}.

% --------------------------------------------------------------------
% Function: handle_info/2
% Description: Handling all non call/cast messages
% Returns: {noreply, State}          |
%          {noreply, State, Timeout} |
%          {stop, Reason, State}            (terminate/2 is called)
% --------------------------------------------------------------------
% handle_info(_Info, State) ->
%     {noreply, State}.

handle_info({tcp, Socket, CurrentPackage}, State=#state{
		socket=Socket, transport=Transport, data=LastPackage}) -> 
		% when byte_size(Data) > 1 ->
	Transport:setopts(Socket, [{active, once}]),
	PackageBin = <<LastPackage/binary, CurrentPackage/binary>>,

	case parse_package(PackageBin, State) of
		{ok, waitmore, Bin} -> 
			{noreply, State#state{data = Bin}};
		_ -> 
			{stop, stop_noreason,State}
	end;
handle_info({timeout,_,{regist}}, State=#state{socket=Socket}) ->
	% 注册代理 
	Bin = client_package:regist_proxy(),
	ranch_tcp:send(Socket, Bin),
	% 同步客户信息
	sync_client(),
	{noreply, State};
handle_info({timeout,_,{reconnect,{Ip,Port}}}, #state{transport = Transport} = State) ->
	io:format("reconnect ip:[~p],port:[~p] ~n",[Ip,Port]),
	case Transport:connect(Ip,Port,[],3000) of
		{ok,Socket} ->
	        ok = Transport:setopts(Socket, [{active, once}]),
			erlang:start_timer(1000, self(), {regist}),
			{noreply,State#state{socket = Socket}};
		{error,Reason} ->
			io:format("==============Res:[~p]~n",[Reason]),
			erlang:start_timer(3000, self(), {reconnect,{Ip,Port}}),
			{noreply, State}
	end;
handle_info({tcp_closed, _Socket}, #state{ip = Ip, port = Port} = State) ->
	io:format("~p:~p  tcp closed  !!!!!! ~n~n", [?MODULE, ?LINE]),
	% {stop, normal, State};
	erlang:start_timer(3000, self(), {reconnect,{Ip,Port}}),
	{noreply, State#state{socket = undefined ,data = <<>>}};
handle_info({tcp_error, _, _Reason}, #state{ip = Ip, port = Port} = State) ->
	erlang:start_timer(3000, self(), {reconnect,{Ip,Port}}),
	{noreply, State#state{socket = undefined ,data = <<>>}};
	% {stop, Reason, State};
handle_info(timeout, State) ->
	% {stop, normal, State};
	{noreply, State};
handle_info(_Info, State) -> 
	% {stop, normal, State}.
	{noreply, State}.
% --------------------------------------------------------------------
% Function: terminate/2
% Description: Shutdown the server
% Returns: any (ignored by gen_server)
% --------------------------------------------------------------------
terminate(_Reason, _State) ->
    ok.

% --------------------------------------------------------------------
% Func: code_change/3
% Purpose: Convert process state when code is changed
% Returns: {ok, NewState}
% --------------------------------------------------------------------
code_change(_OldVsn, State, _Extra) ->
    {ok, State}.


% private functions


parse_package(Bin, State) ->
	case tcp_package:unpackage(Bin) of
		{ok, waitmore}  -> {ok, waitmore, Bin};
		{ok,{Type, ValueBin},LefBin} ->
			ctrl_client_hub:action(Type, ValueBin, State),
			parse_package(LefBin, State);
		_ ->
			error		
	end.

% 当链接建立后，或重连后同步客户信息到hub 
sync_client() ->
	Count = table_client_list:count(),
	case Count < 10 of
		true -> 
			ClientList = table_client_list:select(),
			sync_client(ClientList),
			ok;
		_ -> 
			ok
	end,
	ok.

sync_client([]) ->
	ok;
sync_client(ClientList) -> 
	ClientList1 = lists:foldl(fun(Client, Res) -> 
		InnerLogin = #'InnerLogin'{
	                    	user_id = table_client_list:get_client(Client, userid),
	                    	token = table_client_list:get_client(Client, token),
	                    	proxy_id = table_client_list:get_client(Client, proxy_id),
	                    	ip = table_client_list:get_client(Client, ip),
	                    	login_time = table_client_list:get_client(Client, logtime)
	             },
		[InnerLogin|Res]
	end, [], ClientList),

	% INNER_CMD_SYNC_CLIENTS
	InnerSyncClients = #'InnerSyncClients'{
		clients = ClientList1
	},
	Bin = inner_msg_proto:encode_msg(InnerSyncClients),
            	PackageLogin = tcp_package:package(?INNER_CMD_SYNC_CLIENTS, Bin),
             client_hub:send(PackageLogin),
	ok. 