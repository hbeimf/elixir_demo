-module(table_client_list).
-compile(export_all).

-include_lib("stdlib/include/qlc.hrl").
%% 定义记录结构
-include_lib("table/include/table.hrl").

-include_lib("ws_server/include/log.hrl").

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

select(Uid) ->
    do(qlc:q([X || X <- mnesia:table(?TABLE),
                X#?TABLE.uid =:= Uid
            ])).

select(ServerType, ServerID) ->
    do(qlc:q([X || X <- mnesia:table(?TABLE),
                X#?TABLE.server_type =:= ServerType,
                X#?TABLE.server_id =:= ServerID
            ])).



get_client(Client, uid) ->
      Client#?TABLE.uid;
get_client(Client, pid_front) ->
      Client#?TABLE.pid_front;
get_client(Client, pid_backend) ->
      Client#?TABLE.pid_backend;
get_client(Client, server_type) ->
      Client#?TABLE.server_type;
get_client(Client, cache_bin) ->
      Client#?TABLE.cache_bin;
get_client(Client, server_id) ->
      Client#?TABLE.server_id.

%% == 数据操作 ===============================================

%% 增加一行
% add(_UserId, undefined, undefined, undefined) ->
%     ok;
add(Uid, PidFront, PidBackend, ServerType,  ServerId) ->
    % Row = #?TABLE{
    %     uid = Uid, 
    %     pid_front = PidFront, 
    %     pid_backend = PidBackend, 
    %     server_type = ServerType,  
    %     server_id = ServerId,
    %     cache_bin = <<"">>
    % },

    % F = fun() ->
    %         mnesia:write(Row)
    % end,
    % mnesia:transaction(F).
    add(Uid, PidFront, PidBackend, ServerType,  ServerId, <<"">>).


add(Uid, PidFront, PidBackend, ServerType,  ServerId, CacheBin) ->
    {PidBackend2, ServerType2, ServerId2} = case select(Uid) of
        [] ->
            {PidBackend, ServerType, ServerId};
        [Client|_] -> 
            PidBackend1 = table_client_list:get_client(Client, pid_backend),
            ServerType1 = table_client_list:get_client(Client, server_type),
            ServerId1 = table_client_list:get_client(Client, server_id),
            {PidBackend1, ServerType1, ServerId1}
    end,     

    Row = #?TABLE{
        uid = Uid, 
        pid_front = PidFront, 
        pid_backend = PidBackend2, 
        server_type = ServerType2,  
        server_id = ServerId2,
        cache_bin = CacheBin
    },

    F = fun() ->
            mnesia:write(Row)
    end,
    mnesia:transaction(F).





% table_client_list:update(1, scene_id, 11).
update(Uid, Key, Val) ->
    case select(Uid) of
        [] ->
            ok;
        [Client|_] -> 
            % Row = Client#?TABLE{scene_id = SceneId},
            Row = new_client(Client, Key, Val),
            update_row(Row)
    end.


% -record(client_list, {
%   uid=0, %%  客户端  uid
%   pid_front=0, %%  客户端连接代理的 pid
%   pid_backend=0,  %%  连接游戏服的 pid
%   server_type="", %%   连接游戏服type
%   server_id=0 %%  连接游戏服 id
% }).


% new_client(Client, userid, UserId) ->
%      Client#?TABLE{userid = UserId};
new_client(Client, uid, Val) ->
      Client#?TABLE{uid = Val};
new_client(Client, pid_front, Val) ->
      Client#?TABLE{pid_front = Val};
new_client(Client, pid_backend, Val) ->
      Client#?TABLE{pid_backend = Val};
new_client(Client, server_type, Val) ->
      Client#?TABLE{server_type = Val};
new_client(Client, cache_bin, Val) ->
      Client#?TABLE{cache_bin = Val};
new_client(Client, server_id, Val) ->
      Client#?TABLE{server_id = Val};
new_client(Client, _, _) ->
      Client.

update_row(Row) -> 
    F = fun() ->
            mnesia:write(Row)
    end,
    mnesia:transaction(F).

%%　连接断开时清理资源
clear_user(Uid, Pid, client) ->
    ?LOG({client_closed, Uid}),
    Clients = select(Uid),
    clear_user(Clients, client, Uid, Pid),
    ok.

clear_user(Uid, gs) ->
    ?LOG({gs_closed, Uid}),
    Clients = select(Uid),
    clear_user_gs(Clients, gs, Uid),
    ok.

clear_user([], client, _Uid, _Pid) ->
    ok;
clear_user([Client|OtherClient], client, Uid, Pid) ->
    ?LOG({Client, client, Uid, Pid}),
    case get_client(Client, pid_front) of 
        Pid ->
            ?LOG({Client, client, Uid, Pid}),
            PidBackend = get_client(Client, pid_backend),
            case erlang:is_pid(PidBackend) andalso glib:is_pid_alive(PidBackend) of
                true ->
                    ?LOG({Client, client, Uid, Pid}),
                    ok;
                _ ->
                    ?LOG({Client, client, Uid, Pid}),
                    delete(Uid),
                    ok
            end,
            clear_user(OtherClient, client, Uid, Pid);
        _ ->
           clear_user(OtherClient, client, Uid, Pid)
    end. 

clear_user_gs([], gs, _) ->
    ok;  
clear_user_gs([Client|OtherClient], gs, Uid) ->
    PidFront = get_client(Client, pid_front),
    case erlang:is_pid(PidFront) andalso glib:is_pid_alive(PidFront) of
        true ->
            ok;
        _ ->
            delete(Uid),
            ok
    end,
    clear_user_gs(OtherClient, gs, Uid).



%% 删除一行
delete(Uid) ->
    Oid = {?TABLE, Uid},
    F = fun() ->
            mnesia:delete(Oid)
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



