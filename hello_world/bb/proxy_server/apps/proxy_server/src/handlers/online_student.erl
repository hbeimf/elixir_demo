-module(online_student).
-compile(export_all).

% online_student:test().
% test() -> 
% 	set_online_student(1).


% lists:member(3, [1,2,3]).
% online_student:set_online_student(10000).
% online_student:get_online_student(10000).



% 设置在线学生
set_online_student(SchoolId) -> 
	% io:format("mod:~p, line:~p, data:~p~n~n", [?MODULE, ?LINE, SchoolId]),
	StudentList = table_client_list:select_student_by_school_id(SchoolId, 0),
	% io:format("mod:~p, line:~p, data:~p~n~n", [?MODULE, ?LINE, StudentList]),
	UserIdList = online_student_id_list(StudentList),
	% UserIdList.
	set_online_student(SchoolId, UserIdList).


set_online_student(SchoolId, UserIdList) -> 
	% io:format("mod:~p, line:~p, data:~p~n~n", [?MODULE, ?LINE, {SchoolId, UserIdList}]),
	redisc:set(school_key(SchoolId), term_to_binary(UserIdList)),
	ok.

%% 获取学校在线学生
get_online_student(SchoolId) ->
	case redisc:get(school_key(SchoolId)) of
		{ok, undefined} -> 
			[];
		{ok, Binary} -> 
			binary_to_term(Binary)
	end. 

school_key(SchoolId) -> 
	"online@"++ libfun:to_str(SchoolId).

online_student_id_list([]) -> 
	[];
online_student_id_list(StudentList) -> 
	lists:foldl(fun(Student, Reply) -> 
		% io:format("mod:~p, line:~p, data:~p~n~n", [?MODULE, ?LINE, Student]),
		UserId = table_client_list:get_client(Student, userid), 
		% io:format("mod:~p, line:~p, data:~p~n~n", [?MODULE, ?LINE, UserId]),
		[libfun:to_binary(UserId)|Reply]
	end, [], StudentList).