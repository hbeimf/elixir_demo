-module(handler_change_game_server).
-compile(export_all).

-include("log.hrl").
-include("gw_proto.hrl").
-include("cmdid.hrl").
-include("code.hrl").




% test() -> 
% 	Package = <<"">>,
% 	action(Package).

% 换服逻辑
%% 进入游戏 

%%　


action(ServerType, ServerId, State = #state_client{uid = Uid}) -> 
	?LOG_CHANGE_GS({change_game_server, ServerType, ServerId, State}),
	% Reply = can_change_game_server(Uid),
	% ?LOG_CHANGE_GS({change_game_server, Reply}),
	case can_change_game_server(Uid) of
		true -> 
			%%　如果此时允许换换，则z
			case choose_game_server(glib:to_binary(ServerType), glib:to_binary(ServerId)) of
				[] ->
					?LOG_CHANGE_GS({have_no_game_server, ServerType, ServerId}),
					%% 当没有可用的服务器时，此时应该回复一个消息给 client
					%  message CommonStatus {  //通用信息 action=1005
					%     int32 code = 1;
					%     string msg = 2;
					% }
					% cmdid = 4,
					% code = 10003
					% msg = "没有可用的游戏服"
					ReplyBin = enter_game_res(?CODE_ID_1, "没有可用的游戏服"),
					self() ! {send, ReplyBin},

					ok;
				[GameServer|_] ->
					ServerID = table_game_server_list:get_client(GameServer, server_id),
					ServerType1 = table_game_server_list:get_client(GameServer, server_type),
					ServerURI = table_game_server_list:get_client(GameServer, server_uri),

					?LOG_CHANGE_GS({choose_ws_addr, ServerURI}),
					{ok, Pid} = game_server_client_handler:start_link(ServerURI, ServerID, ServerType1, Uid),
					?LOG_CHANGE_GS({game_server_link_pid, Pid}),
					% //action = 1013  网关与服务器建立连接后，推送此协议  cmd<=100
					% Bin = push_connect_msg(Uid),
					% ?LOG({push_uid, Bin}),
					% Pid ! {transport, Bin},
					table_client_list:update(Uid, pid_backend, Pid),
					table_client_list:update(Uid, server_type, ServerType1),
					table_client_list:update(Uid, server_id, ServerID),

					%% 同步客户端信息
					send_package_to_gwc:client_sync(Uid),

					ReplyBin = enter_game_res(?CODE_ID_0, "换服成功！"),
					self() ! {send, ReplyBin},
					ok
			end;
		{true, ServerType11, _ServerId11} ->
			?LOG_CHANGE_GS({login, {ServerType, ServerId}}),
			ReplyBin = enter_game_res(?CODE_ID_0, "续连成功！"),
			self() ! {send, ReplyBin},
			ok;
		Any -> 
			?LOG_CHANGE_GS({Any}),
			
			%% 如果此时不允许换服　logic here
			%  message CommonStatus {  //通用信息 action=1005
			%     int32 code = 1;
			%     string msg = 2;
			% }
			% cmdid = 4,
			% code = 10002
			% msg = "换服失败"
			ReplyBin = enter_game_res(?CODE_ID_1, "换服失败"),
			self() ! {send, ReplyBin},
			ok
	end,
	ok.


% message EnterGameRes{      //进入游戏回复 cmd=6【网关回复】
%     int32  code  = 1;
%     string msg = 2;
% }


enter_game_res(Code, Msg) ->
	EnterGameRes = #'EnterGameRes'{
                        code = Code,
                        msg = unicode:characters_to_binary(Msg)
                    },
    EnterGameResBin = gw_proto:encode_msg(EnterGameRes),
    glibpack:package(?CMD_ID_5_REPLY, EnterGameResBin).	





%  message CommonStatus {  //通用信息 action=1005
%     int32 code = 1;
%     string msg = 2;
% }
%%　换服不成功时，发送给客户端的消息
reply_error_msg(Code, Msg) ->
	ConnectReq = #'CommonStatus'{
                        code = Code,
                        msg = unicode:characters_to_binary(Msg)
                    },
    ConnectReqBin = gw_proto:encode_msg(ConnectReq),
    glibpack:package(?CMD_ID_10, ConnectReqBin).	



% 推送给游戏服，让游戏服拿到刚建立连接的Uid
% push_connect_msg(Uid) -> 
% 	ConnectReq = #'ConnectReq'{
%                         uid = Uid
%                     },
%     ConnectReqBin = gw_proto:encode_msg(ConnectReq),
%     Msg = #'Msg'{
%                         action = 1013,
%                         msgBody = ConnectReqBin,
%                         uid = <<"0">>
%                     },

%     MsgBin = gw_proto:encode_msg(Msg),
%     CmdId = 99,
%     glibpack:package(CmdId, MsgBin).


% 检测当前客户端是否能连接到新的游戏服
can_change_game_server(Uid) -> 
	?LOG_CHANGE_GS({can_change_game_server, Uid}),
	case table_client_list:select(Uid) of 
		[] ->
			?LOG_CHANGE_GS({false, not_login}),
			{false, not_login};
		Clients ->

			?LOG_CHANGE_GS(Clients),
			[Client|_] = Clients,
			PidBackend = table_client_list:get_client(Client, pid_backend),
			ServerType = table_client_list:get_client(Client, server_type),
			ServerId = table_client_list:get_client(Client, server_id),
			?LOG_CHANGE_GS({PidBackend, ServerType, ServerId}),
			case erlang:is_pid(PidBackend) andalso glib:is_pid_alive(PidBackend) of 
				true ->
					?LOG_CHANGE_GS({PidBackend, ServerType, ServerId}),
					%%　如果已经有一个到游戏服的活着的链接，则不能再建更多的连接,返回 false
					%% 逻辑变了，如果还是连接同一台机器的话，则可以例外让连接，但不能选成别的游戏服
					{true, ServerType, ServerId};
				_ -> 
					?LOG_CHANGE_GS({PidBackend, ServerType, ServerId}),
					true
			end
	end.
	


%%　此处逻辑还要改，比如人数限制啥的逻辑都还没加。
% choose_game_server(ServerType, ServerId) ->
% 	expect_choose_game_server(ServerType, ServerId).

choose_game_server(ServerType, ServerId) ->
	GameServers = expect_choose_game_server(ServerType, ServerId),
	choose_gs(GameServers).


choose_gs([]) ->
	[];
choose_gs([GameServer|OtherGameServer]) ->
	ServerId = table_game_server_list:get_client(GameServer, server_id),
	ServerType = table_game_server_list:get_client(GameServer, server_type),
	Max = table_game_server_list:get_client(GameServer, max),
	Max1 = glib:to_integer(Max),

	Key = get_key(ServerType, ServerId),
	?LOG({key, Key}),
	{ok, Current} = redisc:incr(Key),
	Current1 = glib:to_integer(Current),

	case Current1 > Max1 of
		true ->
			redisc:decr(Key),
			choose_gs(OtherGameServer);
		_ -> 
			[GameServer]
	end.


% handler_change_game_server:expect_choose_game_server(1000, 0).
expect_choose_game_server(ServerType, 0) -> 
	table_game_server_list:select(ServerType);
expect_choose_game_server(ServerType, <<"0">>) -> 
	table_game_server_list:select(ServerType);
expect_choose_game_server(ServerType, ServerId) -> 
	table_game_server_list:select(ServerType, ServerId).


get_key(ServerType, ServerId) ->
	Key = lists:concat(["client_num:", glib:to_str(ServerType), ":", glib:to_str(ServerId)]),
	Key.



