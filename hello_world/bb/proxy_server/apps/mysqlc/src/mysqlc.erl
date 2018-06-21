-module(mysqlc).

%% API
% -export([start_link/0]).

-compile(export_all).

% mysqlc:insert().

% insert() -> 
% 	Sql = "INSERT INTO `online_log` (`gametype`, `gamemod`, `onlinecount`, `gamecount`, `time`) VALUES (?,?,?,?,?)",
% 	ParamsList = [1,1,0,1,1],
% 	insert(pool1, Sql, ParamsList).
% insert(Sql, ParamsList) ->
% 	insert(pool1, Sql, ParamsList).
% insert(Pool, Sql, ParamsList) ->
% 	mysql_poolboy:query(Pool, Sql, ParamsList). 

% % mysql:query(Pid, "INSERT INTO `online_log` (`gametype`, `gamemod`, `onlinecount`, `gamecount`, `time`) VALUES (?,?,?,?,?);", 
% % 				[GameType,GameMod,PlayingUserCount,PlayingUserCount,TimeStamp]),

% % mysqlc:select().
% select() -> 
% 	Sql = "select id, server_id from ms_game_log limit 3",
% 	select(pool1, Sql).
select(Pool, Sql) ->
	mysql_poolboy:query(Pool, Sql).	 


test() -> 
	select(pool1, "show tables").

pool() -> 
	pool1.

parse_res({ok, KeyList, DataList}) -> 
    RowList = lists:foldl(fun(Data, Res) -> 
        T = lists:zip(KeyList, Data),
        [T|Res]
    end, [], DataList),
    {ok, RowList};
parse_res(_Error) ->  
    {ok, []}. 


school_id() ->
	school_id(23).
school_id(UserId) -> 
    Sql = "SELECT school_id FROM system_account WHERE id = ? LIMIT 1",
    Res = mysql_poolboy:query(pool(), Sql, [UserId]),
    parse_res(Res).

%% 学生返回 0 ， 其它返回 1
role_id() -> 
    role_id(23).
role_id(UserId) -> 
     Sql = "SELECT id, account_id FROM t_student WHERE account_id = ? LIMIT 1",
     Res = mysql_poolboy:query(pool(), Sql, [UserId]),
     case parse_res(Res) of 
        {ok, []} ->
            1;
        _ ->
            0
    end. 

% 添加测评数据
add_evaluation() -> 
    add_evaluation(123456, 222222, glib:uid(), 100, 1, 2, "MusicName"),
    ok.
add_evaluation(UserId, TeacherId, SceneId, Score, CurriculumId, CurriculumStepId, MusicName) -> 
    Time = glib:time(),
    SqlInsert = "REPLACE INTO `t_evaluation` (`user_id`, `teacher_id`, `scene_id`, `score`, `curriculum_id`, `curriculum_step_id`, `music_name`, `created_at`, `updated_at`) VALUES (?,?,?,?,?,?,?,?,?)",
    ParamsList = [glib:to_integer(UserId), glib:to_integer(TeacherId), glib:to_integer(SceneId), glib:to_integer(Score), glib:to_integer(CurriculumId), CurriculumStepId, MusicName, Time, Time],
    mysql_poolboy:query(mysqlc:pool(), SqlInsert, ParamsList),
    ok.


add_evaluation_record() -> 
    add_evaluation_record(123456, glib:uid(), 111, 2, "MusicName").
add_evaluation_record(TeacherId, SceneId, CurriculumId, CurriculumStepId, MusicName) ->
    Time = glib:time(),
    SqlInsert = "INSERT INTO `t_evaluation_record` (`teacher_id`, `scene_id`, `curriculum_id`, `curriculum_step_id`, `music_name`, `created_at`, `updated_at`) VALUES (?,?,?,?,?,?,?)",
    ParamsList = [glib:to_integer(TeacherId), glib:to_integer(SceneId), glib:to_integer(CurriculumId), CurriculumStepId, MusicName, Time, Time],
    mysql_poolboy:query(mysqlc:pool(), SqlInsert, ParamsList),
    ok.
    
% mysqlc:get_evaluation_record().
get_evaluation_record() -> 
    get_evaluation_record(72933547316383744).
get_evaluation_record(SceneId) ->
    Sql = "SELECT `user_id`, `teacher_id`, `scene_id`, `score`, `curriculum_id`, `curriculum_step_id`, `music_name` FROM  t_evaluation WHERE scene_id = ?",
    Res = mysql_poolboy:query(mysqlc:pool(), Sql, [SceneId]),
    parse_res(Res).

domain() -> 
    case sys_config:get_config(htgl) of
        {ok, Config} -> 
            {_, {domain, Domain}, _} = lists:keytake(domain, 1, Config),
            Domain;
        _ -> 
            <<"">>
    end.

% 返回客户端的名称和图像 url
user_info(Uid) ->
    account_info_teacher(Uid).

account_info_teacher(Uid) -> 
    Sql = "SELECT a.account_id as uid, a.name, concat(?, a.dir) as url, a.school_id, b.name as school_name, a.course_type
        FROM t_teacher as a 
        LEFT JOIN t_school_organization as b ON a.school_id = b.id 
        WHERE a.account_id = ? 
        LIMIT 1",
    Res = mysql_poolboy:query(mysqlc:pool(), Sql, [domain(), Uid]),
    case parse_res(Res) of
        {ok, []} -> 
            account_info_student(Uid);
        Info ->
            Info
    end.

account_info_student(Uid) -> 
    Sql = "SELECT a.account_id as uid, a.name, concat(?, a.dir) as url, a.school_id, b.name as school_name, a.course_type
        FROM t_student as a 
        LEFT JOIN t_school_organization as b ON a.school_id = b.id 
        WHERE a.account_id = ? 
        LIMIT 1",
    Res = mysql_poolboy:query(mysqlc:pool(), Sql, [domain(), Uid]),
    parse_res(Res).


% CREATE TABLE `t_evaluation_record` (
%   `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
%   `teacher_id` int(11) NOT NULL DEFAULT '0' COMMENT '老师id',
%   `scene_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '测评批次',
%   `curriculum_id` int(11) NOT NULL DEFAULT '0' COMMENT '课程id',
%   `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
%   `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
%   PRIMARY KEY (`id`)
% ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='测评记录';

% CREATE TABLE `t_evaluation` (
%   `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
%   `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '学生id',
%   `teacher_id` int(11) NOT NULL DEFAULT '0' COMMENT '老师id',
%   `scene_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '测评批次',
%   `score` int(11) NOT NULL DEFAULT '0' COMMENT '所得分数',
%   `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
%   `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
%   PRIMARY KEY (`id`)
% ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='测评成绩';

% mysqlc:scene_id().
scene_id() -> 
	Rand = glib:uid(),
	Sql = "select id from t_evaluation_record where scene_id = ? limit 1",
	Res = mysql_poolboy:query(mysqlc:pool(), Sql, [Rand]),
    	case parse_res(Res) of
	        {ok, []} -> 
	            Rand;
	        _Info ->
	            scene_id()
	end.
