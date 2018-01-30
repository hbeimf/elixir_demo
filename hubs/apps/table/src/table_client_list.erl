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


get_client(Client, userid) ->
      Client#?TABLE.userid;
get_client(Client, proxy_id) ->
      Client#?TABLE.proxy_id;
get_client(Client, token) ->
      Client#?TABLE.token.


%% == 数据操作 ===============================================

%% 增加一行
add(UserId, ProxyId, Token) ->
    Row = #?TABLE{userid = UserId, proxy_id = ProxyId, token=Token},
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
        Recs = mnesia:match_object(?TABLE, {?TABLE, UserId, '_', Token}, read),
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



