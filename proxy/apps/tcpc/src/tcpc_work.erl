%% gen_server代码模板

-module(tcpc_work).

-behaviour(gen_server).
% --------------------------------------------------------------------
% Include files
% --------------------------------------------------------------------

% --------------------------------------------------------------------
% External exports
% --------------------------------------------------------------------
-export([]).

% gen_server callbacks
-export([start_link/1]).
-export([init/1, handle_call/3, handle_cast/2, handle_info/2, terminate/2, code_change/3]).

-record(state, {
	socket, 
	transport, 
	data,
	ip,
	port}).


% --------------------------------------------------------------------
% External API
% --------------------------------------------------------------------
% -export([get_config/1]).
% -define(ETS_OPTS,[set, public ,named_table , {keypos,2}, {heir,none}, {write_concurrency,true}, {read_concurrency,false}]).

% -define(SYS_CONFIG, sys_config).
% -record(sys_config, {
% 	key,
% 	val
% }).

% sys_config:get_config(mysql).
% :sys_config.get_config(:mysql)
% get_config(Key) -> 
% 	case ets:match_object(?SYS_CONFIG, #sys_config{key = Key,_='_'}) of
% 		[{?SYS_CONFIG, Key, Val}] -> {ok, Val};
% 		[] ->{error,not_exist}
% 	end.

start_link(Args) ->
    % gen_server:start_link({local, ?MODULE}, ?MODULE, [], []).
    gen_server:start_link(?MODULE, Args, []).



% --------------------------------------------------------------------
% Function: init/1
% Description: Initiates the server
% Returns: {ok, State}          |
%          {ok, State, Timeout} |
%          ignore               |
%          {stop, Reason}
% --------------------------------------------------------------------
init(_Args) ->
	% ?MODULE = ets:new(?SYS_CONFIG, ?ETS_OPTS),

 %    	case read_config_file() of
	% 	{ok, ConfigList} -> 
	% 		lists:foreach(fun({Key, Val}) -> 
	% 			ets:insert(?SYS_CONFIG, #sys_config{key=Key, val=Val})
	% 		end, ConfigList),
	% 		ok;
	% 	_ -> 
	% 		ok
	% end,

    	% {ok, []}.

    	% {Ip, Port} = rconf:read_config(hub_server),
    	{Ip, Port} = {"127.0.0.1",  9910},
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
handle_cast({send, Package}, State=#state{socket=Socket, transport=_Transport, data=_LastPackage}) ->
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
	% Bin = client_package:regist_proxy(),
	ProxyId = 1,
	Ip = "127.0.0.1",
	Port = 9999,
	Bin = term_to_binary({ProxyId, Ip, Port}),
	Bin1 = glib:package(1, Bin),
	ranch_tcp:send(Socket, Bin1),
	% 同步客户信息
	% sync_client(),
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

% handle_info(Info, State) ->
%     % 接收来自go 发过来的异步消息
%     io:format("~nhandle info BBB!!============== ~n~p~n", [Info]),
%     {noreply, State}.

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
	case glib:unpackage(Bin) of
		{ok, waitmore}  -> {ok, waitmore, Bin};
		{ok,{Cmd, ValueBin},LefBin} ->
			action(Cmd, ValueBin, State),
			parse_package(LefBin, State);
		_ ->
			error		
	end.

action(_Cmd, _DataBin, _State) ->
	% io:format("mod:~p, line:~p, param:~p~n", [?MODULE, ?LINE, {UserId, ErrorType, Msg}]),
	% io:format("~n client receive reply here =============== ~ntype:~p, bin: ~p ~n ", [Cmd, DataBin]). 
	ok.


% read_config_file() -> 
% 	ConfigFile = root_dir() ++ "config.ini",
% 	case file_get_contents(ConfigFile) of
% 		{ok, Config} -> 
% 			zucchini:parse_string(Config);
% 		_ -> 
% 			ok
% 	end.

% root_dir() ->
% 	replace(os:cmd("pwd"), "\n", "/"). 

% file_get_contents(Dir) ->
% 	case file:read_file(Dir) of
% 		{ok, Bin} ->
% 			% {ok, binary_to_list(Bin)};
% 			{ok, Bin};
% 		{error, Msg} ->
% 			{error, Msg}
% 	end.

% replace(Str, SubStr, NewStr) ->
% 	case string:str(Str, SubStr) of
% 		Pos when Pos == 0 ->
% 			Str;
% 		Pos when Pos == 1 ->
% 			Tail = string:substr(Str, string:len(SubStr) + 1),
% 			string:concat(NewStr, replace(Tail, SubStr, NewStr));
% 		Pos ->
% 			Head = string:substr(Str, 1, Pos - 1),
% 			Tail = string:substr(Str, Pos + string:len(SubStr)),
% 			string:concat(string:concat(Head, NewStr), replace(Tail, SubStr, NewStr))
% 	end.
