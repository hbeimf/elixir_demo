% -define(LOG(X), io:format("~n==========log========{~p,~p}==============~n~p~n", [?MODULE,?LINE,X])).
-define(LOG(X), true).

% -define(LOG_CHANGE_GS(X), io:format("~n==========LOG_CHANGE_GS========{~p,~p}==============~n~p~n", [?MODULE,?LINE,X])).
-define(LOG_CHANGE_GS(X), true).

-define(LOG1(X), io:format("~n==========log1========{~p,~p}==============~n~p~n", [?MODULE,?LINE,X])).
% -define(LOG1(X), true).



-record(state_client, { 
	uid=0,
	islogin = false,
	isTick = false,  %% 是否被踢
	stype =0,
	sid=0,
	front_pid=0,
	backend_pid=0,
	data
	}).


