-module(call_server_action).

%% Thrift needs this for the message types:
-include("call_service_thrift.hrl").
% -include_lib("parser/include/head.hrl").
-include_lib("parser/include/head.hrl").

-export([
	start/0,
         start/1,  % I use this to start the Thrift service
         stop/1,   % Should be obvious from above
         handle_function/2,  % Erlang Thrift will call this with new messages.
         handle_error/2
        ]).

start() -> 
	start(9009).
start(Port) ->
    thrift_socket_server:start([{handler, ?MODULE},  % this module
                                {port, Port},
                                {service, call_service_thrift},  % as generated from thrift/example.thrift
                                {name, call_service_thrift}]).

stop(Server) ->
    thrift_socket_server:stop(Server).

handle_error(_P1, _P2) -> 
	% io:format("====error: ~p~n ", [{P1, P2}]),
	ok.

handle_function(call, {TheMessageRecord}) ->
    %% unpack these or not, whatever.  Point is it's a record:
    % _Id = TheMessageRecord#message.id,
    % _Msg = TheMessageRecord#message.text,

    % io:format("answer: ~p ~n ", [TheMessageRecord]),
    ?LOG({TheMessageRecord#'Message'.id, TheMessageRecord#'Message'.text}),

    %% at this point you probably want to talk to a pool of gen_servers
    %% or something like that.
    parser:go_by_id(TheMessageRecord#'Message'.text),
    %% send a reply per the service definition in thrift/example.thrift:
    {reply, #'Message'{id = TheMessageRecord#'Message'.id, text = <<"ok">>}};
handle_function(_, TheMessageRecord) ->
    %% unpack these or not, whatever.  Point is it's a record:
    % _Id = TheMessageRecord#message.id,
    % _Msg = TheMessageRecord#message.text,

    % ?LOG({Call, TheMessageRecord}),
    % io:format("answer: ~p ~n ", [TheMessageRecord]),

    %% at this point you probably want to talk to a pool of gen_servers
    %% or something like that.

    %% send a reply per the service definition in thrift/example.thrift:
    {reply, #'Message'{id = 1, text = <<"error!">>}}.

