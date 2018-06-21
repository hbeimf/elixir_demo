-module(table_client_list).
-compile(export_all).

-include_lib("stdlib/include/qlc.hrl").
%% 定义记录结构
-include_lib("table/include/table.hrl").

-define(TABLE, client_list).

test() -> 
	ok.

%%== 查询 =====================================

do(Q) ->
    F = fun() -> qlc:e(Q) end,
    {atomic,Val} = mnesia:transaction(F),
    Val.

%% SELECT * FROM table
%% 选取所有列
select() ->
    do(qlc:q([X || X <- mnesia:table(?TABLE)])).

%% SELECT * FROM table WHERE table.quantity < 250
%% 选取指定条件的数据
select(UserId) ->
    do(qlc:q([X || X <- mnesia:table(?TABLE),
                X#?TABLE.userid =:= UserId
            ])).

select(UserId, Token) ->
    do(qlc:q([X || X <- mnesia:table(?TABLE),
                X#?TABLE.userid =:= UserId,
                X#?TABLE.token =:= Token
            ])).

% table_client_list:select_by_school_id().
select_by_school_id() ->
    select_by_school_id(5).
select_by_school_id(SchoolId) ->
    do(qlc:q([X || X <- mnesia:table(?TABLE),
                X#?TABLE.school_id =:= SchoolId
            ])).

% table_client_list:select_by_teacher_id().
select_by_teacher_id() ->
    select_by_teacher_id(5).
select_by_teacher_id(TeacherId) ->
    do(qlc:q([X || X <- mnesia:table(?TABLE),
                X#?TABLE.teacher_id =:= TeacherId
            ])).

% table_client_list:select_student_by_school_id().
select_student_by_school_id() -> 
  select_student_by_school_id(1, 0).  
select_student_by_school_id(SchoolId, RoleId) -> 
  do(qlc:q([X || X <- mnesia:table(?TABLE),
                X#?TABLE.school_id =:= SchoolId,
                X#?TABLE.role_id =:= RoleId
            ])).

%% 获取自由学生
select_free_student_by_school_id(SchoolId, RoleId) -> 
  do(qlc:q([X || X <- mnesia:table(?TABLE),
                X#?TABLE.school_id =:= SchoolId,
                X#?TABLE.role_id =:= RoleId,
                X#?TABLE.teacher_id =:= 0
            ])).

get_proxy_id(Client) -> 
        get_client(Client, proxy_id).

get_client(Client, userid) ->
      Client#?TABLE.userid;
get_client(Client, proxy_id) ->
      Client#?TABLE.proxy_id;
get_client(Client, logtime) ->
      Client#?TABLE.logtime;
get_client(Client, token) ->
      Client#?TABLE.token;
get_client(Client, ip) ->
      Client#?TABLE.ip;
get_client(Client, pid) ->
      Client#?TABLE.pid;
get_client(Client, teacher_id) ->
      Client#?TABLE.teacher_id;
get_client(Client, school_id) ->
      Client#?TABLE.school_id;
get_client(Client, role_id) ->
      Client#?TABLE.role_id;
get_client(Client, scene_id) ->
      Client#?TABLE.scene_id.
      
%% == 数据操作 ===============================================

%% 增加一行
% add(_UserId, undefined, undefined, undefined) ->
%     ok;
add(UserId, ProxyId, LogTime, Token,  Ip, SceneId, TeacherId, SchoolId, RoleId, Pid) ->
    Row = #?TABLE{
        userid = UserId, 
        proxy_id = ProxyId, 
        logtime = LogTime, 
        token = Token,  
        ip = Ip, 
        scene_id = SceneId,
        teacher_id = TeacherId, %%
        school_id = SchoolId, %%
        role_id = RoleId, %%
        pid = Pid},

    F = fun() ->
            mnesia:write(Row)
    end,
    mnesia:transaction(F).

% table_client_list:update(1, scene_id, 11).
update(UserId, Key, Val) ->
    case select(UserId) of
        [] ->
            ok;
        [Client|_] -> 
            % Row = Client#?TABLE{scene_id = SceneId},
            Row = new_client(Client, Key, Val),
            update_row(Row)
    end.

% new_client(Client, userid, UserId) ->
%      Client#?TABLE{userid = UserId};
new_client(Client, proxy_id, ProxyId) ->
      Client#?TABLE{proxy_id = ProxyId};
new_client(Client, logtime, LogTime) ->
      Client#?TABLE{logtime = LogTime};
new_client(Client, token, Token) ->
      Client#?TABLE{token = Token};
new_client(Client, ip, Ip) ->
      Client#?TABLE{ip = Ip};
new_client(Client, pid, Pid) ->
      Client#?TABLE{pid = Pid};
new_client(Client, teacher_id, TeacherId) ->
      Client#?TABLE{teacher_id = TeacherId};
new_client(Client, school_id, SchoolId) ->
      Client#?TABLE{school_id = SchoolId};
new_client(Client, role_id, RoleId) ->
      Client#?TABLE{role_id = RoleId};
new_client(Client, scene_id, SceneId) ->
      Client#?TABLE{scene_id = SceneId};
new_client(Client, _, _) ->
      Client.

update_row(Row) -> 
    F = fun() ->
            mnesia:write(Row)
    end,
    mnesia:transaction(F).

%% 删除一行
delete(UserId) ->
    Oid = {?TABLE, UserId},
    F = fun() ->
            mnesia:delete(Oid)
    end,
    mnesia:transaction(F).

delete(UserId, Token) ->
    F = fun() -> 
        Recs = mnesia:match_object(?TABLE, {?TABLE, UserId, '_', '_', Token, '_', '_', '_', '_', '_', '_'}, read),
        % io:format("XXXXXXXX mod:~p, line:~p, recs:~p~n", [?MODULE, ?LINE, Recs]),
        lists:foreach(fun(Rec) -> 
            % io:format("YYYYYYY mod:~p, line:~p, rec:~p~n", [?MODULE, ?LINE, Rec]),
            mnesia:delete_object(?TABLE, Rec, write)  
        end, Recs)
    end,
    mnesia:transaction(F). 

count() -> 
    F = fun() ->  
        mnesia:table_info(?TABLE, size)  
    end,  
    case mnesia:transaction(F) of
        {atomic,Size} ->
            Size;
        _ -> 
            0
    end. 



