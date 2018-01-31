-module(controller).
-compile(export_all).

action(Cmd, Bin) -> 
	io:format("controller echo: ~p~n", [{?MODULE, ?LINE, Cmd, Bin}]),
	ok.



