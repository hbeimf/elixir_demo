%%%-------------------------------------------------------------------
%% @doc proxy_server top level supervisor.
%% @end
%%%-------------------------------------------------------------------

-module(proxy_server_sup).

-behaviour(supervisor).

%% API
-export([start_link/0]).

%% Supervisor callbacks
-export([init/1]).

-define(SERVER, ?MODULE).

%%====================================================================
%% API functions
%%====================================================================

start_link() ->
    supervisor:start_link({local, ?SERVER}, ?MODULE, []).

%%====================================================================
%% Supervisor callbacks
%%====================================================================

%% Child :: {Id,StartFunc,Restart,Shutdown,Type,Modules}
init([]) ->

    HubServer = {client_hub,{client_hub,start_link,[]},
    	permanent, 5000, worker, [client_hub]},
   
    ClientTimer = {client_timer,{client_timer,start_link,[]},
    	permanent, 5000, worker, [client_timer]},

        
    Children = [HubServer, ClientTimer],
    {ok, { {one_for_all, 10, 10}, Children} }.

%%====================================================================
%% Internal functions
%%====================================================================
