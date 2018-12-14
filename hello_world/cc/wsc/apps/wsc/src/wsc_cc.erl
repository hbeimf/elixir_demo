-module(wsc_cc).

-behaviour(websocket_client_handler).
-include_lib("glib/include/log.hrl").
-include_lib("glib/include/hall_proto.hrl").

-define( UINT, 32/unsigned-little-integer).
-define( USHORT, 16/unsigned-little-integer).

-export([
         start_link/1,
         init/2,
         websocket_handle/3,
         websocket_info/3,
         websocket_terminate/3
        ]).

start_link(Index) ->
    % crypto:start(),
    % ssl:start(),
    % websocket_client:start_link("wss://echo.websocket.org", ?MODULE, []).
  
    websocket_client:start_link("ws://localhost:8899/ws", ?MODULE, [Index]).
    % websocket_client:start_link("ws://127.0.0.1:9102", ?MODULE, [Index]).

    
    % websocket_client:start_link("ws://14.192.8.251:8899/ws", ?MODULE, [Index]).


    

init([Index], _ConnState) ->
    % websocket_client:cast(self(), {text, <<"message 1">>}),
    % io:format("client pid: ~p ~n", [self()]),

    {ok, Index}.

% websocket_handle({pong, _}, _ConnState, State) ->
%     {ok, State};
% websocket_handle({text, Msg}, _ConnState, 5) ->
%     io:format("Received msg ~p~n", [Msg]),
%     {close, <<>>, "done"};

websocket_handle({binary, Bin}, _ConnState, State) ->
    % ?LOG({binary, Bin}),

	% io:format("Client received binary here ~p~n", [Bin]),
    % <<_/32, Bin1/binary>> = Bin,
    % <<_Len:?UINT, Bin1/binary>> = Bin,

    <<Len:?UINT, CmdId:?USHORT, ServerType:?USHORT, _Ser:?UINT, DataBin/binary>> = Bin,


    ?LOG( {{len, Len}, {binary, Bin}, {len, byte_size(Bin)}, {payload_len, byte_size(DataBin)}}),

    case Len =:= 39 of 
        true -> 
            Json = glib:to_str(DataBin),
            % Json2 = jsx:decode(DataBin),
            ?LOG({json1, Json, DataBin}),

            % Json1 = jsx:decode(Json),

            % ?LOG({json, Json, Json1}),
            ok;
        _ ->
            ok
    end,





    % #'Msg'{action = Action, 'msgBody' = MsgBody} = hall_proto:decode_msg(DataBin,'Msg'),
    % ?LOG({{action, Action}, {msg_body, MsgBody}}),


    % #'Msg'{action = Action, 'msgBody' = MsgBody} = hall_proto:decode_msg(Bin1,'Msg'),
	{ok, State};
websocket_handle(Msg, _ConnState, State) ->
    io:format("Client ~p received msg:~n~p~n", [State, Msg]),
    % timer:sleep(1000),
    % BinInt = list_to_binary(integer_to_list(State)),
    % {reply, {text, <<"hello, this is message #", BinInt/binary >>}, State + 1}.
    {ok, State}.


websocket_info(close, _ConnState, _State) ->
	{close, <<>>, "done"};
websocket_info({text, Txt}, _ConnState, State) ->
	{reply, {text, Txt}, State};
websocket_info({binary, Bin}, _ConnState, State) ->
    io:format("send All XXXXXXXXXXXX ==========~n" ),
	{reply, {binary, Bin}, State}.

websocket_terminate(Reason, _ConnState, State) ->
    io:format("~nClient closed in state ~p wih reason ~p~n", [State, Reason]),
    ok.