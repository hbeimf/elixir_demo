%%%-------------------------------------------------------------------
%% @doc ants public API
%% @end
%%%-------------------------------------------------------------------

-module(ants_app).

-behaviour(application).

%% Application callbacks
-export([start/2, stop/1]).

%%====================================================================
%% API
%%====================================================================

start(_StartType, _StartArgs) ->
	% rtime:run(),
    ants_sup:start_link().

%%--------------------------------------------------------------------
stop(_State) ->
    ok.

%%====================================================================
%% Internal functions
%%====================================================================
