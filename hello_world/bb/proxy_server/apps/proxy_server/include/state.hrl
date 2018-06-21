-define(LOG(X), io:format("~n==========log========{~p,~p}==============~n~p~n", [?MODULE,?LINE,X])).
% -define(LOG(X), true).

-record(state, {
	socket, 
	transport, 
	data, 
	islogin = false,
	userid=0, 
	token}).