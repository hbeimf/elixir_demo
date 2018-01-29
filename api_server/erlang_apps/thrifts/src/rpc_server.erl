-module(rpc_server).

%% Thrift needs this for the message types:
% -include("exampleService_thrift.hrl").
-include("rpc_service_thrift.hrl").

%% Just for tests:
-ifdef(TEST).
-include_lib("eunit/include/eunit.hrl").
-endif.

-export([
	start/0,
         start/1,  % I use this to start the Thrift service
         stop/1,   % Should be obvious from above
         handle_function/2,  % Erlang Thrift will call this with new messages.
         handle_error/2
        ]).

start() -> 
	{ok, Val} = sys_config:get_config(rpc),
	{_, {port, Port}, _} = lists:keytake(port, 1, Val),
	start(Port).
start(Port) ->
    thrift_socket_server:start([{handler, ?MODULE},  % this module
                                {port, Port},
                                {service, rpc_service_thrift},  % as generated from thrift/example.thrift
                                {name, rpc_service_thrift}]).

stop(Server) ->
    thrift_socket_server:stop(Server).

handle_error(_P1, _P2) -> 
	% io:format("====error: ~p~n ", [{P1, P2}]),
	ok.

handle_function(call, TheMessageRecord) ->
    %% unpack these or not, whatever.  Point is it's a record:
    % _Id = TheMessageRecord#message.id,
    % _Msg = TheMessageRecord#message.text,

    io:format("request : ~p ~n ", [TheMessageRecord]),

    %% at this point you probably want to talk to a pool of gen_servers
    %% or something like that.

    %% send a reply per the service definition in thrift/example.thrift:
    {reply, #'Message'{id = 1, text = <<"Thanks!">>}}.

-ifdef(TEST).

% simple_test() ->
%     {ok, Server} = start(9000),
%     Res = example_client:request("localhost", 9000, 12345, <<"Hello, service">>),
%     stop(Server),
%     ?assert(Res#message.text =:= <<"Thanks!">>).

-endif.