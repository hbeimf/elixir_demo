%%%-------------------------------------------------------------------
%% @doc table public API
%% @end
%%%-------------------------------------------------------------------

-module(table_app).

-behaviour(application).

%% Application callbacks
-export([start/2, stop/1]).

%%====================================================================
%% API
%%====================================================================

start(_StartType, _StartArgs) ->
    table_create:init(),
    % table_create:start(),
    table_sup:start_link().

%%--------------------------------------------------------------------
stop(_State) ->
    ok.

%%====================================================================
%% Internal functions
%%====================================================================
