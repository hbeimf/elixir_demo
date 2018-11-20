%%%-------------------------------------------------------------------
%% @doc app_use_elixir public API
%% @end
%%%-------------------------------------------------------------------

-module(app_use_elixir_app).

-behaviour(application).

%% Application callbacks
-export([start/2, stop/1]).

%%====================================================================
%% API
%%====================================================================

start(_StartType, _StartArgs) ->
    app_use_elixir_sup:start_link().

%%--------------------------------------------------------------------
stop(_State) ->
    ok.

%%====================================================================
%% Internal functions
%%====================================================================
