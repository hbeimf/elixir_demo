-module(tcps_handler).
-behaviour(gen_server).
-behaviour(ranch_protocol).

%% API.
-export([start_link/4]).

%% gen_server.
-export([init/1]).
-export([handle_call/3]).
-export([handle_cast/2]).
-export([handle_info/2]).
-export([terminate/2]).
-export([code_change/3]).

-define(TIMEOUT, 5000).

% -record(state, {socket, transport, data}).
-include("state.hrl").

% http://blog.csdn.net/yuanfengyun/article/details/49329327
% http://www.cnblogs.com/bicowang/p/4263227.html
%% 宏定义
% -define( PORT, 2345 ).
% -define( HEAD_SIZE, 4 ).
% %% 解数字类型用到的宏
% -define( UINT, 32/unsigned-little-integer).
% -define( INT, 32/signed-little-integer).
% -define( USHORT, 16/unsigned-little-integer).
% -define( SHORT, 16/signed-little-integer).
% -define( UBYTE, 8/unsigned-little-integer).
% -define( BYTE, 8/signed-little-integer).

%% API.

start_link(Ref, Socket, Transport, Opts) ->
	{ok, proc_lib:spawn_link(?MODULE, init, [{Ref, Socket, Transport, Opts}])}.

%% gen_server.

%% This function is never called. We only define it so that
%% we can use the -behaviour(gen_server) attribute.
%init([]) -> {ok, undefined}.

init({Ref, Socket, Transport, _Opts = []}) ->
	ok = ranch:accept_ack(Ref),
	ok = Transport:setopts(Socket, [{active, once}]),
	io:format("~p:~p  ========= tcp connect  !!!!!! ~n~n", [?MODULE, ?LINE]),

	gen_server:enter_loop(?MODULE, [],
		#state{socket=Socket, transport=Transport, data= <<>>},
		?TIMEOUT).

handle_info({tcp, Socket, CurrentPackage}, State=#state{ socket=Socket, transport=Transport, data=LastPackage}) -> 
	Transport:setopts(Socket, [{active, once}]),
	PackageBin = <<LastPackage/binary, CurrentPackage/binary>>,
	case parse_package(PackageBin, State) of
		{ok, waitmore, Bin} -> 
			{noreply, State#state{data = Bin}};
		_ -> 
			{stop, stop_noreason,State}
	end;	
handle_info({tcp_send, Package}, #state{transport = Transport,socket=Socket} = State) ->
	Transport:send(Socket, Package),
	{noreply, State};
handle_info({tcp_closed, _Socket}, State) ->
	io:format("~p:~p  tcp closed  !!!!!! ~n~n", [?MODULE, ?LINE]),
	%% 当代理连接断开时，要清理代理相关的数据
	% table_proxy_server_list:delete(self()),
	{stop, normal, State};
handle_info({tcp_error, _, Reason}, State) ->
	{stop, Reason, State};
handle_info(timeout, State) ->
	{stop, normal, State};
handle_info(_Info, State) ->
	{stop, normal, State}.

handle_call(_Request, _From, State) ->
	{reply, ok, State}.

handle_cast(_Msg, State) ->
	{noreply, State}.

terminate(_Reason, _State) ->
	table_proxy_server_list:delete(self()),
	ok.

code_change(_OldVsn, State, _Extra) ->
	{ok, State}.


%% ====================================================================
%% Internal functions
%% ====================================================================
parse_package(Bin, State) ->
	case glib:unpackage(Bin) of
		{ok, waitmore}  -> {ok, waitmore, Bin};
		{ok,{Cmd, ValueBin},LefBin} ->
			action(Cmd, ValueBin, State),
			parse_package(LefBin, State);
		_Any ->
			% io:format("XXXXXXXXXX unpack error: ~p ~n ", [{?MODULE, ?LINE, Bin, Any}]),
			error		
	end.



%% 注册proxy
action(1, DataBin, #state{ socket=Socket, transport=_Transport, data=_LastPackage}) -> 
	{ProxyId, Port} = binary_to_term(DataBin),
	% Ip = "127.0.0.12",
	Ip  =  case ranch_tcp:peername(Socket) of 
                        {ok, {TupleIp, _Port}} ->
                            ListIp = tuple_to_list(TupleIp),
                            ListIp1 = lists:map(fun(X)-> glib:to_str(X) end, ListIp),
                            IpStr = string:join(ListIp1, "."),
                            glib:to_binary(IpStr);
                        _ -> 
                            <<"">>
             end,

	table_proxy_server_list:add(ProxyId, Ip, Port, self()),
	ok;

%% 注册 client 
action(2, Bin, _State) ->
	{UserId, ProxyId, Token} = binary_to_term(Bin),
	%% 单点登录在此处处理
	let_other_client_logout(UserId),
	table_client_list:add(UserId, ProxyId, Token),
	ok;

%% 注消 client 
action(3, Bin, _State) ->
	{UserId, _ProxyId, Token} = binary_to_term(Bin),
	table_client_list:delete(UserId, Token),
	ok;

action(Cmd, DataBin, _State) ->
	io:format("~n ================================= ~nCmd:~p, bin: ~p ~n ", [Cmd, DataBin]),
	ok.

%% 单点登录在此处处理
let_other_client_logout(UserId) ->
	table_client_list:select(UserId),
	ok. 
