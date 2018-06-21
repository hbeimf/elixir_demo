%%%-------------------------------------------------------------------
%% @doc proxy_server public API
%% @end
%%%-------------------------------------------------------------------

-module(proxy_server_app).

-behaviour(application).

%% Application callbacks
-export([start/2, stop/1]).

%%====================================================================
%% API
%%====================================================================

start(_StartType, _StartArgs) ->
	{_Ip, Port, _Id} = rconf:read_config(proxy_server),
	{ok, _} = ranch:start_listener(proxy_server, 10, ranch_tcp, [{port, Port}], tcp_handler, []),

    proxy_server_sup:start_link().

%%--------------------------------------------------------------------
stop(_State) ->
    ok.

%%====================================================================
%% Internal functions
%%====================================================================
