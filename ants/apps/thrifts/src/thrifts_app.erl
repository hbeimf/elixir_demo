%%%-------------------------------------------------------------------
%% @doc thrifts public API
%% @end
%%%-------------------------------------------------------------------

-module(thrifts_app).

-behaviour(application).

%% Application callbacks
-export([start/2, stop/1]).

%%====================================================================
%% API
%%====================================================================

start(_StartType, _StartArgs) ->
	call_server_action:start(),
    thrifts_sup:start_link().

%%--------------------------------------------------------------------
stop(_State) ->
    ok.

%%====================================================================
%% Internal functions
%%====================================================================