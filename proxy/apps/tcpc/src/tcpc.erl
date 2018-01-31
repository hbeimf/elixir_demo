-module(tcpc).
-compile(export_all).

test() -> 
	call(pool1, test_call),
	cast(pool1, test_cast).


call(PoolName, Request) ->
    poolboy:transaction(PoolName, fun(Worker) ->
        gen_server:call(Worker, {req, Request})
    end).

cast(PoolName, Request) ->
    poolboy:transaction(PoolName, fun(Worker) ->
        gen_server:cast(Worker, {req, Request})
    end).

send(Package) -> 
	cast(pool1, {send, Package}).

