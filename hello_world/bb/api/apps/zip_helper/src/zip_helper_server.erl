%% gen_server代码模板

-module(zip_helper_server).

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

% --------------------------------------------------------------------
% External API
% --------------------------------------------------------------------
% -export([doit/1]).

% doit(FromPid) ->
%     gen_server:cast(?MODULE, {doit, FromPid}).



% -export([start_goroutine/0, info/0, stop_goroutine/1, send_cast/2]).

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
    _TRef = erlang:send_after(1000, self(), update),
    {ok, []}.

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
% handle_cast({send_cast, GoMBox, Msg}, State) ->
%     io:format("send cast !! ============== ~n~n"),
%     % {ok, GoMBox} = application:get_env(go, go_mailbox),
%     % io:format("message ~p!! ============== ~n~n", [GoMBox]),
%     gen_server:cast(GoMBox, {Msg, self()}),
%     {noreply, State};
% handle_cast({doit, FromPid}, State) ->
%     io:format("doit  !! ============== ~n~n"),

%     lists:foreach(fun(_I) ->
%         timer:sleep(10),
%         FromPid ! {from_doit, <<"haha">>}
%     end, lists:seq(1, 1000)),

%     {noreply, State};
handle_cast(_Msg, State) ->
    {noreply, State}.

% --------------------------------------------------------------------
% Function: handle_info/2
% Description: Handling all non call/cast messages
% Returns: {noreply, State}          |
%          {noreply, State, Timeout} |
%          {stop, Reason, State}            (terminate/2 is called)
% --------------------------------------------------------------------
handle_info(update, State) ->
    % io:format("update  ================== ~n~p~n", [State]),
    % 计时器，任务自动运行

    {{_Year, _Mon, _Day},{Hour, Min, Seconds}} = glib:timestamp_to_datetime(glib:time()),

    % io:format("update  ================== ~n~p~n", [Date]),
    run(Hour, Min, Seconds),

    _TRef = erlang:send_after(1000, self(), update),
    {noreply, []};
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
run(3, 1, 1) ->
    zip_helper:zip(),
    zip_cmd:bak(),
    qrcode_cmd:make(),
    ok;
run(4, 1, 1) ->
    {ok, L} = inet:getif(),
    IpList = glib:get_ip(),
    case lists:member({192,168,1,49}, IpList) of 
        true -> 
            zip_cmd:sync(),
            ok;
        _ -> 
            ok
    end,
    ok;
run(_, _, _) ->
    ok.
