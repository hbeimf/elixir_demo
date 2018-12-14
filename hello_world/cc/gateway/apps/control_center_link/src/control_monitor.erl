% control_monitor.erl

%% gen_server代码模板

-module(control_monitor).

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

% -include_lib("ws_server/include/log.hrl").
% -include("cmd_gateway.hrl").

-include("gateway_proto.hrl").
-include("cmd_gateway.hrl").
-include_lib("ws_server/include/log.hrl").

% -record(state_client, { 
% 	uid=0,
% 	islogin = false,
% 	stype =0,
% 	sid=0,
% 	front_pid=0,
% 	backend_pid=0,
% 	data
% 	}).


-record(state, { 
	pid=0
	}).

-define(TIMER, 10000).
% --------------------------------------------------------------------
% External API
% --------------------------------------------------------------------
% -export([doit/1]).

% doit(FromPid) ->
%     gen_server:cast(?MODULE, {doit, FromPid}).



% -export([start_goroutine/0, info/0, stop_goroutine/1, send_cast/2]).
-export([send/1]).
send(Package) ->
    % case ets:match_object(?WS_CONTROL_CENTER, #control_center_handler_client{key = key(), _='_'}) of
    %     [{?WS_CONTROL_CENTER, _Key, Pid}] -> 
    %         Pid ! {binary, Package},
    %         ok;
    %     [] -> ok
    % end, 
    gen_server:cast(?MODULE, {send, Package}),
    ok.


report_gw() ->
	{ok, Config} = sys_config:get_config(node),
	{_, {node_id, NodeId}, _} = lists:keytake(node_id, 1, Config),

	{ok, Config1} = sys_config:get_config(http),
	{_, {host, Host}, _} = lists:keytake(host, 1, Config1),
	{_, {port, Port}, _} = lists:keytake(port, 1, Config1),

	WsAddr = lists:concat(["ws://", Host, ":", Port, "/websocket"]),
	%%　上报网关信息
    GatewayLogin = #'Gateway'{
                        gateway_id = NodeId,
                        % ws_addr = <<"ws://localhost:7788/websocket">>
                        ws_addr = WsAddr
                    },

    PbBin = gateway_proto:encode_msg(GatewayLogin),
    Package = glib:package(?GATEWAY_CMD_REPORT, PbBin),
    send(Package),
   	ok.

% info() ->
%     gen_server:call(?MODULE, info).

% start_goroutine() ->
%     gen_server:call(?MODULE, start_goroutine).

% stop_goroutine(GoMBox) ->
%     gen_server:call(?MODULE, {stop_goroutine, GoMBox}).

% send_cast(GoMBox, Msg) ->
%     gen_server:cast(?MODULE, {send_cast, GoMBox, Msg}).

% get_gombox() ->
%     gen_server:call(?MODULE, get_gombox).

% start_link() ->
%     gen_server:start_link({local, ?MODULE}, ?MODULE, [], []).

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
	erlang:send_after(?TIMER, self(), connect),
    case control_center_handler_client:start_link(1) of
    	{ok, Pid} ->
		    State = #state{pid = Pid},
		    report_gw(),
		    {ok, State};
		_ ->	
			State = #state{pid = 0},
		    {ok, State}
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
handle_cast({send, Package}, State = #state{pid = Pid}) ->
    Pid ! {binary, Package},
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
handle_info(connect, State = #state{pid = Pid}) ->
    % io:format("update  ================== ~n~p~n", [State]),
    % 计时器，任务自动运行
    % ?LOG({<<"connect_gwc">>}),
    _TRef = erlang:send_after(?TIMER, self(), connect),
    case erlang:is_pid(Pid) andalso glib:is_pid_alive(Pid) of
    	true ->
    		% ?LOG({reconnect_gwc, Pid, true}),
    		{noreply, State};
    	_ -> 
    		?LOG({<<"reconnect_gwc">>}),
		    NewState = case control_center_handler_client:start_link(1) of
		    	{ok, Pid1} ->
		    		report_gw(),
				    #state{pid = Pid1};
				_ ->
					State
			end,
		    {noreply, NewState}
	end;
handle_info(_Info, State) ->
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

