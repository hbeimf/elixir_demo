% parse_package_from_gwc.erl
-module(parse_package_from_gwc).
-compile(export_all).

-include("gateway_proto.hrl").
-include("gwc_proto.hrl").
-include("cmd_gateway.hrl").
-include_lib("ws_server/include/log.hrl").
-include_lib("ws_server/include/code.hrl").


parse_package(Bin, State) ->
    case glib:unpackage(Bin) of
        {ok, waitmore}  -> {ok, waitmore, Bin};
        {ok,{Cmd, ValueBin},LefBin} ->
            action(Cmd, ValueBin, State),
            parse_package(LefBin, State);
        _ ->
            error       
    end.

% 判断用户是否在游戏中
action(?GATEWAY_CMD_IS_PLAYING_GAME, Package, _State) ->
    {isPlayingGameReq, Uid, SeqID, FromGs} = binary_to_term(Package),
    ?LOG_CHANGE_GS({isPlayingGameReq, Uid, SeqID, FromGs}),
    case table_client_list:select(Uid) of
        [] ->
            %% 回复不在线
            ?LOG_CHANGE_GS({isPlayingGameReq, Uid, SeqID, FromGs}),
            ReplyBin = term_to_binary({isPlayingGameRes, Uid, SeqID, FromGs, false}),
            Package1 = glib:package(?GATEWAY_CMD_IS_PLAYING_GAME_REPLY, ReplyBin),           
            control_center_handler_client:send(Package1),
            ok;
        [Client|_] ->
            ?LOG_CHANGE_GS({isPlayingGameReq, Uid, SeqID, FromGs}),
            PidBackend = table_client_list:get_client(Client, pid_backend),
            case erlang:is_pid(PidBackend) andalso glib:is_pid_alive(PidBackend) of 
                true ->
                    ReplyBin = term_to_binary({isPlayingGameRes, Uid, SeqID, FromGs, true}),
                    Package2 = glib:package(?GATEWAY_CMD_IS_PLAYING_GAME_REPLY, ReplyBin),           
                    control_center_handler_client:send(Package2),
                    ok;
                _ ->
                    ReplyBin = term_to_binary({isPlayingGameRes, Uid, SeqID, FromGs, false}),
                    Package3 = glib:package(?GATEWAY_CMD_IS_PLAYING_GAME_REPLY, ReplyBin),           
                    control_center_handler_client:send(Package3),
                    ok
            end,
            ok
    end,
    ok;


% GATEWAY_CMD_FORBIDDEN_IP
%% 将ip 拉入 黑/白名单，不允许连接
action(?GATEWAY_CMD_FORBIDDEN_IP, Package, _State) ->
    Info = binary_to_term(Package),
    case Info of 
        {add, Ip} ->
            ?LOG({add, Ip}),
            table_forbidden_ip:add(Ip),
            ok;
        {del, Ip} ->
            ?LOG({del, Ip}),
            table_forbidden_ip:delete(Ip),
            ok;
        _ ->
            ok
    end,
    ok;

%% 游戏服上线了，
action(?GATEWAY_CMD_GS_REPORT, Package, _State) -> 
    ?LOG({?GATEWAY_CMD_GS_REPORT, Package}),
    #'ReportServerInfo'{serverType = ServerType, 
                        serverID = ServerID,
                        serverURI = ServerURI, 
                        max = Max} = gateway_proto:decode_msg(Package,'ReportServerInfo'),
    ?LOG({ServerType, ServerID, ServerURI, Max}),
    table_game_server_list:add(ServerID, ServerType, ServerURI, Max),
    ok;

% // 1011  ，游戏服节点崩溃了
% message GsHalt{    
%     string serverType = 1; //服务器类型
%     string serverID = 2;    //服务器ID  自行分配
% }
action(?GATEWAY_CMD_GS_HALT, Package, _State) -> 
    ?LOG({?GATEWAY_CMD_GS_HALT, Package}),
    #'GsHalt'{serverType = ServerType, serverID = ServerID} = gateway_proto:decode_msg(Package,'GsHalt'),
    ?LOG({gs_halt, ServerType, ServerID}),
    table_game_server_list:delete(ServerID),
    ok;

% message BroadcastByUID{    //请求认证 Cmd=1
%     repeated Uids uids = 1; //用户身份
%     bytes  payload = 2;     //透传消息体
% }

% message Uids {
%  string uid = 1; //
% }

%%　广播 
action(?GATEWAY_CMD_BROADCAST_1, Package, _State) -> 
    ?LOG({?GATEWAY_CMD_BROADCAST_1, Package}),
    #'BroadcastByUID'{uids = Uids, payload = Payload} = gwc_proto:decode_msg(Package,'BroadcastByUID'),
    ?LOG({broadcast1, Uids, Payload}),

    lists:foreach(fun(#'Uids'{uid = Uid}) -> 
        ?LOG({broadcast, Uid}),
        Clients = table_client_list:select(Uid),
        send_to_client(Clients, Payload),
        ok
    end, Uids),
    ok;
% message Broadcast{    //请求认证 Cmd=2
%     string serverType = 1; //服务器类型
%     string serverID = 2;    //服务器ID  自行分配
%     bytes  payload = 3; //透传消息体
% }
%%　广播
action(?GATEWAY_CMD_BROADCAST_2, Package, _State) -> 
    ?LOG({?GATEWAY_CMD_BROADCAST_2, Package}),
    #'Broadcast'{serverType = ServerType, serverID = ServerID, payload = Payload} = gwc_proto:decode_msg(Package,'Broadcast'),
    ?LOG({broadcast2, ServerType, ServerID, Payload}),
    Clients = table_client_list:select(ServerType, ServerID),
    send_to_client(Clients, Payload),
    ok;

% 踢用户
action(?GATEWAY_CMD_TICK_USER, Package, _State) ->
    ?LOG1({?GATEWAY_CMD_TICK_USER, Package}),
    #'TickUser'{uid = Uid} = gwc_proto:decode_msg(Package,'TickUser'),
    ?LOG1({uid, Uid}),
    Clients = table_client_list:select(Uid),
    ?LOG1({clients, Clients}),   
    tick_client(Clients),
    ok;

%%　单点登录被挤下线来消息通知, 发送一个被挤下线的消息通知，再close掉连接 
action(?GATEWAY_CMD_USER_LOGIN_OTHER_PLACE, Package, _State) ->
    ?LOG1({?GATEWAY_CMD_USER_LOGIN_OTHER_PLACE, Package}),
    % #'UserLoginOtherPlace'{uid = Uid} = gateway_proto:decode_msg(Package,'UserLoginOtherPlace'),
    % ?LOG1({login_other_place, Uid}),
    
    % Clients = table_client_list:select(Uid),
    % ReplyBin = handler_change_game_server:reply_error_msg(?CODE_ID_1006, "账户在其它地方登录!"),
    % send_to_client(Clients, ReplyBin),
    % close_client(Clients),

    ok;

action(_Cmd, Package, _State) -> 
    ?LOG({<<"ignore packge">>, Package}),
    ok.


% priv

% 关闭用户连接
close_client([]) -> 
    ok;
close_client(Clients) ->
    lists:foreach(fun(Client) -> 
        Pid = table_client_list:get_client(Client, pid_front),
        case erlang:is_pid(Pid) andalso glib:is_pid_alive(Pid) of
            true -> 
                Pid ! tick,
                Pid ! close,
                ok;
            _ ->
                ok
        end  
    end, Clients),
    ok.


% 踢掉用户
tick_client([]) -> 
    ok;
tick_client(Clients) ->
    lists:foreach(fun(Client) -> 
        Pid = table_client_list:get_client(Client, pid_front),
        case erlang:is_pid(Pid) andalso glib:is_pid_alive(Pid) of
            true -> 
                %% 在把客户端踢掉之前发一个提示消息
                %% 除了单点登录不发客户断线通知给游戏服，其它情况都要发用户已断线 
                ?LOG1({clients, Clients}),
                ReplyBin = handler_change_game_server:reply_error_msg(?CODE_ID_1005, "被管理员踢出游戏了"),
                Pid ! {send, ReplyBin},
                %
                % Pid ! tick,
                Pid ! close,
                ok;
            _ ->
                ok
        end  
    end, Clients),
    ok.


send_to_client([], _Payload) ->
    ok;
send_to_client(Clients, Payload) ->
    lists:foreach(fun(Client) -> 
        Pid = table_client_list:get_client(Client, pid_front),
        case erlang:is_pid(Pid) andalso glib:is_pid_alive(Pid) of
            true -> 
                ?LOG1({send, Payload}),
                Pid ! {send, Payload},
                ok;
            _ ->
                ok
        end
    end, Clients),
    ok.
    

