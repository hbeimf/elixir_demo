-module(controller).
-compile(export_all).

action(Cmd, Bin) -> 
	io:format("cmd: ~p~n", [{?MODULE, ?LINE, Cmd, Bin}]),
	ok.



