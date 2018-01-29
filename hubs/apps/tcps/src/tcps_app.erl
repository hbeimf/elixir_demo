%%%-------------------------------------------------------------------
%% @doc tcps public API
%% @end
%%%-------------------------------------------------------------------

-module(tcps_app).

-behaviour(application).

%% Application callbacks
-export([start/2, stop/1]).

%%====================================================================
%% API
%%====================================================================

start(_StartType, _StartArgs) ->
	{ok, Config} = sys_config:get_config(tcp),
	{_, {port, Port}, _} = lists:keytake(port, 1, Config),

	{ok, _} = ranch:start_listener(tcp_server, 10, ranch_tcp, [{port, Port}], tcp_handler, []),
    tcps_sup:start_link().

%%--------------------------------------------------------------------
stop(_State) ->
    ok.

%%====================================================================
%% Internal functions
%%====================================================================
