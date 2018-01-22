-module(table_proxy_server_list).
-compile(export_all).

-include_lib("stdlib/include/qlc.hrl").
%% 定义记录结构
-include_lib("table/include/table.hrl").

% -include_lib("hall/include/record.hrl").

-define(TABLE, proxy_server_list).

% -record(client_list, {
% 	userid=0,
% 	proxy_id=0,
% 	logtime=0, 
% 	ip=""
% }).




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
select(ProxyId) ->
    do(qlc:q([X || X <- mnesia:table(?TABLE),
                X#?TABLE.id =:= ProxyId
            ])).

get_proxy_pid(Proxy) -> 
        Proxy#?TABLE.pid.

%% == 数据操作 ===============================================

%% 增加一行
% add(_UserId, undefined, undefined, undefined) ->
%     ok;
add(Id, Ip, Port, Pid) ->
    Row = #?TABLE{id = Id, ip = Ip, port = Port, pid = Pid},
    F = fun() ->
            mnesia:write(Row)
    end,
    mnesia:transaction(F).

%% 删除一行
% delete(UserId) ->
%     Oid = {?TABLE, UserId},
%     F = fun() ->
%             mnesia:delete(Oid)
%     end,
%     mnesia:transaction(F).

delete(Pid) ->
    F = fun() -> 
        Recs = mnesia:match_object(?TABLE, {?TABLE, '_', '_', '_', Pid}, read),
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



