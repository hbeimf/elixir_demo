%%%-------------------------------------------------------------------
%% @doc tcpc top level supervisor.
%% @end
%%%-------------------------------------------------------------------

-module(tcpc_sup).

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
% init([]) ->
%     {ok, { {one_for_all, 0, 1}, []} }.
% https://github.com/devinus/poolboy
init([]) ->
    % {ok, Pools} = application:get_env(example, pools),
    Pools = [
    	{pool1, [{size, 10},{max_overflow, 20}], []}
    	% ,
            % {pool2, [{size, 5}, {max_overflow, 10}], 
            % [
            %     {hostname, "127.0.0.1"},
            %     {database, "db2"},
            %     {username, "db2"},
            %     {password, "abc123"}
            % ]}
    ],


    PoolSpecs = lists:map(fun({Name, SizeArgs, WorkerArgs}) ->
        PoolArgs = [{name, {local, Name}},
            		{worker_module, tcpc_work}] ++ SizeArgs,
        poolboy:child_spec(Name, PoolArgs, WorkerArgs)
    end, Pools),
    {ok, {{one_for_one, 10, 10}, PoolSpecs}}.


%%====================================================================
%% Internal functions
%%====================================================================
