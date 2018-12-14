-module(game_server_client_handler).

-behaviour(websocket_client_handler).

-export([
         start_link/4,
         init/2,
         websocket_handle/3,
         websocket_info/3,
         websocket_terminate/3
        ]).

-include_lib("ws_server/include/log.hrl").

% 进程状态
% -record(state, { 
%     uid,
%     server_type,
%     server_id,
%     data
%     }).
-include("gs_state.hrl").

-include_lib("ws_server/include/cmdid.hrl").


start_link(ServerURI, ServerID, ServerType, Uid) ->
    % crypto:start(),
    % ssl:start(),
    % websocket_client:start_link("wss://echo.websocket.org", ?MODULE, []).
  
    % websocket_client:start_link("ws://localhost:8899/ws", ?MODULE, [Index]).
    websocket_client:start_link(ServerURI, ?MODULE, [ServerID, ServerType, Uid]).

init([ServerID, ServerType, Uid|_], _ConnState) ->
    process_flag(trap_exit, true),
    % websocket_client:cast(self(), {text, <<"message 1">>}),
    % io:format("client pid: ~p ~n", [self()]),
    State = #state{uid = Uid, server_type = ServerType, server_id = ServerID, data= <<>>},
    {ok, State}.

% websocket_handle({pong, _}, _ConnState, State) ->
%     {ok, State};
% websocket_handle({text, Msg}, _ConnState, 5) ->
%     io:format("Received msg ~p~n", [Msg]),
%     {close, <<>>, "done"};

% websocket_handle({binary, CurrentPackage}, _ConnState, State= #state{data= LastPackage}) ->
%     ?LOG({"binary recv: ", CurrentPackage}),
%     PackageBin = <<LastPackage/binary, CurrentPackage/binary>>,
%     case parse_package_from_gs:parse_package(PackageBin, State) of 
%         {ok, waitmore, NextBin} -> 
%             {ok, State#state{data = NextBin}};
%         _ -> 
%             {close, <<>>, "done"}
%     end;
	% {ok, State};

websocket_handle({text, Msg}, _ConnState, State= #state{uid = Uid, data= _LastPackage}) ->
    % io:format("Received msg ~p~n", [Msg]),
    ?LOG({recv_text, Msg}),
    Bin = package_send_bin(Msg),
    case table_client_list:select(Uid) of 
        [] -> 
            ok;
        [Client|_] ->
            Pid = table_client_list:get_client(Client, pid_front),
            Pid ! {transport, Bin}
    end,
    {ok, State};
websocket_handle({binary, CurrentPackage}, _ConnState, State= #state{uid = Uid, data= _LastPackage}) ->
    % PackageBin = <<LastPackage/binary, CurrentPackage/binary>>,
    ?LOG({recv_binary, CurrentPackage}),
    Bin = package_send_bin(CurrentPackage),
    case table_client_list:select(Uid) of 
        [] -> 
            ok;
        [Client|_] ->
            Pid = table_client_list:get_client(Client, pid_front),
            Pid ! {transport, Bin}
    end,
    {ok, State};
websocket_handle(Msg, _ConnState, State) ->
    io:format("Client ~p received msg:~n~p~n", [State, Msg]),
    % timer:sleep(1000),
    % BinInt = list_to_binary(integer_to_list(State)),
    % {reply, {text, <<"hello, this is message #", BinInt/binary >>}, State + 1}.
    {ok, State}.

websocket_info({transport, RightPackage}, _ConnState, State) ->
    ?LOG({transport, RightPackage, {state, State}}),
    {reply, {binary, RightPackage}, State};
websocket_info(close, _ConnState, _State) ->
	{close, <<>>, "done"};
websocket_info({text, Txt}, _ConnState, State) ->
	{reply, {text, Txt}, State};
websocket_info({binary, Bin}, _ConnState, State) ->
    % io:format("send All XXXXXXXXXXXX ==========~n" ),
	{reply, {binary, Bin}, State};
websocket_info(_Msg, _ConnState, State) ->
    {ok, State}.

websocket_terminate(Reason, _ConnState, State = #state{uid = Uid, server_type = ServerType, server_id = ServerID, data= _LastPackage}) ->
    % io:format("~nClient closed in state ~p wih reason ~p~n", [State, Reason]),
    ?LOG_CHANGE_GS({<<"GameServer Closed">>, State, Reason, self()}),
    ?LOG_CHANGE_GS({Uid, gs}),
    table_client_list:clear_user(Uid, gs),
    %% 连接数释放
    Key = handler_change_game_server:get_key(ServerType, ServerID),
    {ok, Num} = redisc:decr(Key),
    Num1 = glib:to_integer(Num), 
    case Num1 < 0 of 
        true ->
            redisc:set(Key, 0);
        _ ->
            ok
    end,
    ok.

package_send_bin(Data) ->
    BinMsg = glib:to_binary(Data),
    % CmdId = 123,
    glibpack:package(?CMD_ID_100, BinMsg).