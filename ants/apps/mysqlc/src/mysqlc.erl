-module(mysqlc).

%% API
% -export([start_link/0]).

-compile(export_all).

% insert(Sql, ParamsList) ->
% 	insert(pool1, Sql, ParamsList).
% insert(Pool, Sql, ParamsList) ->
% 	mysql_poolboy:query(Pool, Sql, ParamsList). 

% select() -> 
% 	Sql = "select * from system_menu limit 3",
% 	select(Sql).

% select(Sql) -> 
% 	case select_from_pool(pool1, Sql) of 
% 		{ok, KeyList, DataList} -> 
% 			RowList = lists:foldl(fun(Data, Res) -> 
% 				T = lists:zip(KeyList, Data),
% 				[T|Res]
% 			end, [], DataList),
% 			{ok, RowList};
% 		Error -> 
% 			Error
% 	end.

select_from_pool(Pool, Sql) ->
	mysql_poolboy:query(Pool, Sql).	 


pool() -> 
	pool1.


test() -> 
	select_from_pool(pool(), "show tables").



