-module(ctrl_handler).
%% API.
% -export([action/3, test/0]).
-export([action/3]).
%%
-export([online_student_reply/1, is_group_control/1]).

-include("msg_proto.hrl").
-include("cmd.hrl").
-include("state.hrl").

%% 心跳 包
action(?HEART_BEAT, _DataBin, _State) ->
	PackageBin = tcp_package:package(?HEART_BEAT_REPLY, <<"">>),
	self() ! {tcp_send, PackageBin},
	ok;

% 获取临时教室在线学生 
action(?GET_CLASS_ONLINE_STUDENT, DataBin, _State) ->
	#'GetClassOnlineStudent'{school_id = _SchoolId, teacher_id = TeacherId} = msg_proto:decode_msg(DataBin,'GetClassOnlineStudent'),
	StudentList = table_client_list:select_by_teacher_id(TeacherId),
	?LOG({<<"get online student bind teacher">>, StudentList}),
	PbBin = online_class_student_reply(StudentList),
	PackageBin = tcp_package:package(?GET_CLASS_ONLINE_STUDENT_REPLY, PbBin),
	self() ! {tcp_send, PackageBin},
	ok;

% 获取在线学生
action(?GET_ONLINE_STUDENT, DataBin, _State) ->
	#'GetOnlineStudent'{school_id = SchoolId} = msg_proto:decode_msg(DataBin,'GetOnlineStudent'),
	StudentList = table_client_list:select_student_by_school_id(SchoolId, 0),
	?LOG({<<"get online student by school_id">>, StudentList}),
	PbBin = online_student_reply(StudentList),
	PackageBin = tcp_package:package(?GET_ONLINE_STUDENT_REPLY, PbBin),
	self() ! {tcp_send, PackageBin},
	ok;

% 获取在线学生, {未上课的在线学生}
action(?GET_ONLINE_FREE_STUDENT, DataBin, _State) ->
	#'GetOnlineStudent'{school_id = SchoolId} = msg_proto:decode_msg(DataBin,'GetOnlineStudent'),
	% StudentList = table_client_list:select_student_by_school_id(SchoolId, 0),
	StudentList = table_client_list:select_free_student_by_school_id(SchoolId, 0),

	?LOG({<<"get online student, not bind teacher">>, StudentList}),
	PbBin = online_student_reply(StudentList),
	PackageBin = tcp_package:package(?GET_ONLINE_FREE_STUDENT_REPLY, PbBin),
	self() ! {tcp_send, PackageBin},
	ok;

%% ****************************************************************
%% 开始广播，老师学生建立临时教室 
%%%% 创建临时教室时，将老师最后一条广播消息广播给加进教室的孩子{20180420} ，
action(?CREATE_CLASSROOM, DataBin, _State) -> 
	?LOG({<<"create classroom">>}),
	create_classroom(DataBin),
	ok;

%% 删除临时教室里的学生, 比如添加错误的学生
action(?DELETE_STUDENT_FROM_CLASSROOM, DataBin, _State) -> 
	% io:format("~n================================= mod:~p, line: ~p ~n ~p~n ", [?MODULE, ?LINE, DataBin]),
	?LOG(DataBin),
	delete_student_from_classroom(DataBin),
	ok;

%% 教师在教室里广播消息
action(?BROADCAST_MSG, DataBin, _State) -> 
	#'BroadcastMsg'{teacher_id = TeacherId, payload = _Payload} = msg_proto:decode_msg(DataBin,'BroadcastMsg'),
	Students = table_client_list:select_by_teacher_id(TeacherId),
	% 将最后一个广播消息缓存, 缓存300秒 
	MsgKey = "msg@"++libfun:to_str(TeacherId),
	% redisc:setex(MsgKey, DataBin, 900),
	redisc:setex(MsgKey, DataBin, 3600),
	?LOG({"cache broadcast msg", MsgKey}),

	?LOG("broadcast msg "),
	%% 只有老师在群控状态 中， 才广播消息
	case is_group_control(TeacherId) of 
		true -> 
			?LOG({"broadcast msg", Students}),
			broadcast_msg(Students, DataBin);
		_ -> 
			ok
	end,		
	% StatusKey = "is_group_control@"++libfun:to_str(TeacherId),
	% case redisc:get(StatusKey) of 
	% 	{ok, undefined} ->
	% 		ok;
	% 	{ok, <<"1">>} -> 
	% 		?LOG({"broadcastXXX", Students}),
	% 		broadcast_msg(Students, DataBin);
	% 	_ -> 
	% 		ok
	% end,		

	% broadcast_msg(Students, DataBin),
	ok;

%% 锁屏
action(?LOCK_SCREEN, DataBin, _State) -> 
	#'LockScreen'{teacher_id = TeacherId, status = _Status} = msg_proto:decode_msg(DataBin,'LockScreen'),
	Students = table_client_list:select_by_teacher_id(TeacherId),
	lock_screen(Students, DataBin),
	ok;

% IS_GROUP_CONTROL
%%  是否群控中状态设置 
action(?IS_GROUP_CONTROL, DataBin, _State) -> 
	#'IsGroupControl'{teacher_id = TeacherId, status = StatusNum} = msg_proto:decode_msg(DataBin,'IsGroupControl'),
	%% 设置是否在群控中状态
	?LOG({<<" XX set is_group_control, status:">>, StatusNum}),
	StatusKey = "is_group_control@"++libfun:to_str(TeacherId),
	redisc:set(StatusKey, StatusNum),
	% broadcast_msg(Students, DataBin),
	ok;


%% 开始测评 
action(?START_EVALUATION, DataBin, _State) -> 
	?LOG({<<"start evaluation">>}),
	#'StartEvaluation'{
		teacher_id = TeacherId, 
		curriculum_id = CurriculumId,
		curriculum_step_id = CurriculumStepId,
		music_name = MusicName
	} = msg_proto:decode_msg(DataBin,'StartEvaluation'),
	
	%% 创建测评批次号，
	% SceneId = glib:uid(),
	SceneId = mysqlc:scene_id(),
	%% 更新老师测评批次号
	table_client_list:update(TeacherId, scene_id, SceneId),

	%% 在数据库里添加测评记录
	mysqlc:add_evaluation_record(TeacherId, SceneId, CurriculumId, CurriculumStepId, MusicName),

	%% 回复测评批次给老师
	StartEvaluationReply = #'StartEvaluationReply'{evaluation_id = SceneId},
	Package = msg_proto:encode_msg(StartEvaluationReply),
	PackageBin = tcp_package:package(?START_EVALUATION_REPLY, Package),
	?LOG({?START_EVALUATION_REPLY, PackageBin}),
	self() ! {tcp_send, PackageBin},

	StudentList = table_client_list:select_by_teacher_id(TeacherId),
	?LOG(StudentList),
	lists:foreach(fun(Student) -> 
		UserId = table_client_list:get_client(Student, userid),
		%% 更新测评批次号 
		table_client_list:update(UserId, scene_id, SceneId),
		Pid = table_client_list:get_client(Student, pid),
		%% 给班里的学生和老师都发送这个数据包，
		Pid ! {tcp_send, PackageBin},
		ok
	end, StudentList),
	ok;

%% 重新测评搞一个新协议
%% 重新测评
action(?START_EVALUATION_AGAIN, DataBin, _State) -> 
	#'StartEvaluationAgain'{
		evaluation_id = EvaluationId,   %% 测评批次号 SceneId
		students = Students
	} = msg_proto:decode_msg(DataBin,'StartEvaluationAgain'),

	%% 测评包
	StartEvaluationReply = #'StartEvaluationReply'{evaluation_id = EvaluationId},
	Package = msg_proto:encode_msg(StartEvaluationReply),
	PackageBin = tcp_package:package(?START_EVALUATION_AGAIN_REPLY, Package),

	%% 遍历 需 要重新测评的学生，给每个学生发送测评 消息 PackageBin
	lists:foreach(fun(#'StudentId'{user_id = UserId}) -> 
		case table_client_list:select(UserId) of 
			[] -> 
				ok;
			[Client|_] -> 
				Pid = table_client_list:get_client(Client, pid),
				Pid ! {tcp_send, PackageBin}
		end
	end, Students),
	ok;
	
%% 学生上报测评分数
action(?REPORT_EVALUATION_SCORE, DataBin, _State) -> 
	#'ReportEvaluationScore'{
		user_id = UserId, 
		score = Score, 
		curriculum_id = CurriculumId,
		curriculum_step_id = CurriculumStepId,
		music_name = MusicName
	} = msg_proto:decode_msg(DataBin,'ReportEvaluationScore'),
	%% 
	[Student|_] = table_client_list:select(UserId),
	TeacherId = table_client_list:get_client(Student, teacher_id),
	SceneId = table_client_list:get_client(Student, scene_id),
	[Teacher|_] = table_client_list:select(TeacherId),
	TeacherPid = table_client_list:get_client(Teacher, pid),
	%% 发送成绩给老师端 , 增加了学生姓名&图像属性
	ReportEvaluationScoreReply = #'ReportEvaluationScoreReply'{
		user_id = UserId, 
		score = Score, 
		curriculum_id = CurriculumId,
		curriculum_step_id = CurriculumStepId,
		music_name = MusicName,
		name = get_cache(UserId, "name"), %% 学生姓名
		url = get_cache(UserId, "url")  %% 学生图像
	},
	Package = msg_proto:encode_msg(ReportEvaluationScoreReply),
	PackageBin = tcp_package:package(?REPORT_EVALUATION_SCORE_REPLY, Package),
	TeacherPid ! {tcp_send, PackageBin},
	%% 将成绩写入数据库 *********
	mysqlc:add_evaluation(UserId, TeacherId, SceneId, Score, CurriculumId, CurriculumStepId, MusicName),
	ok;

%% 老师获取测评列表
action(?GET_EVALUATION_SCORE, DataBin, _State) -> 
	#'GetEvaluationScore'{
		evaluation_id = EvaluationId
	} = msg_proto:decode_msg(DataBin,'GetEvaluationScore'),

	%% 根据老师发来的批次号查询学生上报的成绩返回 
	EvaluationScoreList = get_evaluation_score(EvaluationId),

	GetEvaluationReply = #'GetEvaluationReply'{
		score = EvaluationScoreList
	},
	Package = msg_proto:encode_msg(GetEvaluationReply),
	PackageBin = tcp_package:package(?GET_EVALUATION_SCORE_REPLY, Package),
	self() ! {tcp_send, PackageBin},
	ok;


%% 下课
action(?CLASS_IS_OVER, DataBin, _State) -> 
	#'ClassIsOver'{teacher_id = TeacherId} = msg_proto:decode_msg(DataBin,'ClassIsOver'),
	StudentList = table_client_list:select_by_teacher_id(TeacherId),
	class_is_over(StudentList, TeacherId),

	?LOG({<<"XX class is over, teacher_id:">>, TeacherId}),
	%% 下课时删除老师是否群控中的状态 
	StatusKey = "is_group_control@"++libfun:to_str(TeacherId),
	redisc:del(StatusKey),
	ok;


% 容错处理, 直接忽略不可识别的协议 
action(Cmd, DataBin, _State) ->
	% P = tcp_package:package(Type+1, DataBin),
	% self() ! {tcp_send, P},
	% io:format("~n ================================= ~ntype:~p, bin: ~p ~n ", [Type, DataBin]). 
	% io:format("mod:~p, line:~p, param:~p~n ", [?MODULE, ?LINE, {Cmd, DataBin}]),
	?LOG({Cmd, DataBin}),
	ok.

% ctrl_handler:test().
% private fun ================================================
%% 返回测评列表
get_evaluation_score(EvaluationId) -> 
	case mysqlc:get_evaluation_record(EvaluationId) of 
		{ok, []} ->
			[];
		{ok, Rows} -> 
			lists:foldl(fun(Row, Res) -> 
				{_, {_, UserId}, _} = lists:keytake(<<"user_id">>, 1, Row),
				{_, {_, Score}, _} = lists:keytake(<<"score">>, 1, Row),
				{_, {_, CurriculumId}, _} = lists:keytake(<<"curriculum_id">>, 1, Row),
				{_, {_, CurriculumStepId}, _} = lists:keytake(<<"curriculum_step_id">>, 1, Row),
				{_, {_, MusicName}, _} = lists:keytake(<<"music_name">>, 1, Row),

				ReportEvaluationScoreReply = #'ReportEvaluationScoreReply'{
					user_id = UserId, 
					score = Score, 
					curriculum_id = CurriculumId,
					curriculum_step_id = CurriculumStepId,
					music_name = MusicName,
					name = get_cache(UserId, "name"), %% 学生姓名
					url = get_cache(UserId, "url")  %% 学生图像
				},

				[ReportEvaluationScoreReply|Res]	
			end, [], Rows)
	end. 

%% 客户端是否在群控中
is_group_control(Uid) ->
	StatusKey = "is_group_control@"++libfun:to_str(Uid),
	case redisc:get(StatusKey) of 
		{ok,undefined} -> 
			false;
		{ok, <<"1">>} -> 
			true;
		{ok, 1} -> 
			true;
		_ -> 
			false
	end.

class_is_over([], TeacherId) -> 
	clear_teacher_msg(TeacherId),
	ok;
class_is_over(StudentList, TeacherId) ->
	clear_teacher_msg(TeacherId), 
	PackageBin = tcp_package:package(?CLASS_IS_OVER_REPLY, <<"">>),
	lists:foreach(fun(Student) -> 
		Pid = table_client_list:get_client(Student, pid),
		UserId = table_client_list:get_client(Student, userid),
		table_client_list:update(UserId, teacher_id, 0),
		Pid ! {tcp_send, PackageBin}
	end, StudentList),
	ok.

%% 清除老师最后一个广播消息的缓存 
clear_teacher_msg(TeacherId) -> 
	MsgKey = "msg@"++libfun:to_str(TeacherId),
	redisc:del(MsgKey),
	ok.

broadcast_msg([], _DataBin) ->
	% io:format("mod:~p, line:~p, broadcast~n ", [?MODULE, ?LINE]),
	ok; 
broadcast_msg(Students, DataBin) -> 
	% io:format("mod:~p, line:~p, param:~p~n ", [?MODULE, ?LINE, {Students, Payload}]),
	% Payload1 = msg_proto:encode_msg(Payload),
	PackageBin = tcp_package:package(?BROADCAST_MSG_REPLY, DataBin),
	lists:foreach(fun(Student) -> 
		UserId = table_client_list:get_client(Student, userid),
		?LOG({<<"send msg to :">>, UserId }),
		Pid = table_client_list:get_client(Student, pid),
		Pid ! {tcp_send, PackageBin}
	end, Students),
	ok.


%% 锁屏消息广播，定制的广播协议 
lock_screen([], _DataBin) -> 
	ok;
lock_screen(Students, DataBin) -> 
	PackageBin = tcp_package:package(?LOCK_SCREEN_REPLY, DataBin),
	lists:foreach(fun(Student) -> 
		UserId = table_client_list:get_client(Student, userid),
		?LOG({<<"lock screen msg to :">>, UserId }),
		Pid = table_client_list:get_client(Student, pid),
		Pid ! {tcp_send, PackageBin}
	end, Students),
	ok.


% private fun ================================================
delete_student_from_classroom(Bin) ->
	#'CreateClassroom'{teacher_id = TeacherId, students = Students} = msg_proto:decode_msg(Bin,'CreateClassroom'),
	% io:format("mod:~p, line:~p~n, data:~p~n", [?MODULE, ?LINE, {TeacherId, Students}]),
	?LOG({<<"delete student from school">>, TeacherId, Students}),
	delete_student_from_classroom(TeacherId, Students),
	ok.

delete_student_from_classroom(_TeacherId, []) ->
	ok;
delete_student_from_classroom(_TeacherId, Students) ->
	?LOG(Students),

	lists:foreach(fun(#'StudentId'{user_id = UserId}) -> 
		% table_client_list:update(UserId, teacher_id, TeacherId)
		table_client_list:update(UserId, teacher_id, 0),
		?LOG(UserId),

		?LOG(table_client_list:select(UserId)),
		%% 移除学生时，给每个被移除班级的学生发送广播回复, 回复协议号和uid
		case table_client_list:select(UserId) of 
			[] -> 
				ok;
			[Client|_] -> 
				?LOG(Client),
				StudentId = #'StudentId'{
					user_id = UserId
				},
				Package = msg_proto:encode_msg(StudentId),
				PackageBin = tcp_package:package(?DELETE_STUDENT_FROM_CLASSROOM_REPLY, Package),
				Pid = table_client_list:get_client(Client, pid),
				Pid ! {tcp_send, PackageBin},
				ok;
			_ ->
				ok
		end,
		ok
	end, Students),
	ok.  

% test ==========================================
% test() -> 
% 	test_CreateClassroom().

% test_CreateClassroom() -> 
% 	Students = [
% 		#'StudentId'{ user_id = 1},
% 		#'StudentId'{ user_id = 2},
% 		#'StudentId'{ user_id = 3}
% 	],
% 	CreateClassroom = #'CreateClassroom'{
% 		teacher_id = 1,
% 		students = Students
% 	},

% 	B = msg_proto:encode_msg(CreateClassroom),
% 	create_classroom(B).

% private fun ================================================
create_classroom(Bin) -> 
	#'CreateClassroom'{teacher_id = TeacherId, students = Students} = msg_proto:decode_msg(Bin,'CreateClassroom'),
	% io:format("mod:~p, line:~p~n, data:~n~p~n", [?MODULE, ?LINE, {TeacherId, Students}]),
	?LOG({TeacherId, Students}),
	create_classroom(TeacherId, Students),
	ok.

create_classroom(_TeacherId, []) ->
	ok;
create_classroom(TeacherId, Students) ->
	lists:foreach(fun(#'StudentId'{user_id = UserId}) -> 
		%% 学生收到被加入教室 的回复 
		% CREATE_CLASSROOM_REPLY
		StudentId = #'StudentId'{
					user_id = UserId
				},
		Package = msg_proto:encode_msg(StudentId),

		PBin = tcp_package:package(?CREATE_CLASSROOM_REPLY, Package),
		case table_client_list:select(UserId) of 
			[] -> 
				ok;
			[Client1|_] -> 
				Pid1 = table_client_list:get_client(Client1, pid),
				Pid1 ! {tcp_send, PBin}
		end,

		%% 检查是否在群控中
		case is_group_control(TeacherId) of 
			true -> 
				%% 将老师最后一个广播消息发送给学生
				MsgKey = "msg@"++libfun:to_str(TeacherId),
				case redisc:get(MsgKey) of 
					{ok,undefined} -> 
						ok;
					{ok, Msg} ->
						%% 如果获取到了广播消息 , 与通用 广播消息区分，用新的协议号 1026来发送
						PackageBin = tcp_package:package(?BROADCAST_MSG_V2_REPLY, Msg),
						case table_client_list:select(UserId) of 
							[] -> 
								ok;
							[Client|_] -> 
								Pid = table_client_list:get_client(Client, pid),
								Pid ! {tcp_send, PackageBin}
						end,
						ok;
					_ -> 
						ok			
				end,
				ok;
			_ ->
				ok
		end,
		
		%%更新学生与老师的绑定关系 
		table_client_list:update(UserId, teacher_id, TeacherId)
	end, Students),
	ok.  

% test ==========================================
% test() -> 
% 	test_online_student_reply().

% test_online_student_reply() -> 
% 	StudentList = table_client_list:select_student_by_school_id(5, 0),
% 	online_student_reply(StudentList).

% private fun ================================================
online_student_reply([]) -> 
	GetOnlineStudentReply = #'GetOnlineStudentReply'{
		student = []
	},
	msg_proto:encode_msg(GetOnlineStudentReply);
online_student_reply(StudentList) -> 
	Students = lists:foldl(fun(Student, Reply) -> 
		% Name = "name", %%  待获取
		% Url = "url", %% 待获取
		Uid = table_client_list:get_client(Student, userid),
		StudentInfo = #'StudentInfo'{
			user_id = Uid,
			name = get_cache(Uid, "name"), 
			url = get_cache(Uid, "url")
		},
		% io:format("mod:~p, line:~p~n==============~p~n", [?MODULE, ?LINE, [StudentInfo]]),
		?LOG({<<"online students reply">>, StudentInfo}),
		[StudentInfo|Reply]
	end, [], StudentList),
	GetOnlineStudentReply = #'GetOnlineStudentReply'{
		student = Students
	},
	msg_proto:encode_msg(GetOnlineStudentReply).

get_cache(Uid, Key) ->
	Hash = "userinfo@"++libfun:to_str(Uid),
	% KeyName = "name",
	% KeyUrl = "url",
	 case redisc:hget(Hash, Key) of 
                {ok,undefined} -> 
                    <<"">>;
                {ok, Val} -> 
                	Val;
                _ -> 
                	<<"">>
             end.



online_class_student_reply([]) -> 
	GetClassOnlineStudentReply = #'GetClassOnlineStudentReply'{
		student = []
	},
	msg_proto:encode_msg(GetClassOnlineStudentReply);
online_class_student_reply(StudentList) -> 
	Students = lists:foldl(fun(Student, Reply) -> 
		% Name = "name", %%  待获取
		% Url = "url", %% 待获取
		Uid = table_client_list:get_client(Student, userid),
		StudentInfo = #'StudentInfo'{
			user_id = Uid, 
			name = get_cache(Uid, "name"), 
			url = get_cache(Uid, "url")
		},
		[StudentInfo|Reply]
	end, [], StudentList),
	GetClassOnlineStudentReply = #'GetClassOnlineStudentReply'{
		student = Students
	},
	msg_proto:encode_msg(GetClassOnlineStudentReply).

