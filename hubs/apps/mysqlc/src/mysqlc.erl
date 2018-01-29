-module(mysqlc).

%% API
% -export([start_link/0]).

-compile(export_all).

% mysqlc:insert().

% insert() -> 
% 	Sql = "INSERT INTO `online_log` (`gametype`, `gamemod`, `onlinecount`, `gamecount`, `time`) VALUES (?,?,?,?,?)",
% 	ParamsList = [1,1,0,1,1],
% 	insert(pool1, Sql, ParamsList).
insert(Sql, ParamsList) ->
	insert(pool1, Sql, ParamsList).
insert(Pool, Sql, ParamsList) ->
	mysql_poolboy:query(Pool, Sql, ParamsList). 

% mysql:query(Pid, "INSERT INTO `online_log` (`gametype`, `gamemod`, `onlinecount`, `gamecount`, `time`) VALUES (?,?,?,?,?);", 
% 				[GameType,GameMod,PlayingUserCount,PlayingUserCount,TimeStamp]),

% mysqlc:select().
select() -> 
	Sql = "select id, server_id from ms_game_log limit 3",
	select(pool1, Sql).
select(Pool, Sql) ->
	mysql_poolboy:query(Pool, Sql).	 


test() -> 
	select(pool1, "show tables").




