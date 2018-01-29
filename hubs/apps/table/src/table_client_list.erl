-module(table_client_list).
-compile(export_all).

-include_lib("stdlib/include/qlc.hrl").
%% 定义记录结构
-include_lib("table/include/table.hrl").

-define(TABLE, client_list).

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

get_proxy_id(Client) -> 
        Client#client_list.proxy_id.

get_client(Client, pid) ->
      Client#?TABLE.pid;
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
get_client(Client, scene_id) ->
      Client#?TABLE.scene_id;
get_client(Client, teacher_id) ->
      Client#?TABLE.teacher_id;
get_client(Client, school_id) ->
      Client#?TABLE.school_id;
get_client(Client, role_id) ->
      Client#?TABLE.role_id.

%% == 数据操作 ===============================================

%% 增加一行
add(UserId, ProxyId, LogTime, Ip, Token) ->
    Row = #?TABLE{userid = UserId, proxy_id = ProxyId, logtime = LogTime, ip = Ip, token=Token},
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



