% parse_package_from_gs.erl
% parse_package_from_client.erl

% fun_get_entrance.erl
-module(parse_package_from_gs).
-compile(export_all).

-include_lib("ws_server/include/log.hrl").
-include_lib("ws_server/include/gw_proto.hrl").
-include_lib("ws_server/include/cmdid.hrl").
-include("gs_state.hrl").

% priv
parse_package(Bin, State) ->
    case glibpack:unpackage(Bin) of
        {ok, waitmore}  -> {ok, waitmore, Bin};
        % {ok, RightPackage, LefBin} ->
        {ok, {CmdId, ServerType, OtherParam, DataBin}, RightPackage, NextPageckage}->
            controller({{CmdId, ServerType, OtherParam, DataBin}, RightPackage, NextPageckage}, State),
            parse_package(NextPageckage, State);
        _ ->
            error       
    end.




% 2, 根据uid 去查是否与游戏服建立连接
% 2.1, 如果存在连接 ， 给游戏服发断开 package
% 	message CloseReq{          //断开用户连接 action = 1011  此协议是网关发送给各个服务器， 协议格式 len|4{**请求与回复都CmdId用4**}（2字节）|0(2字节)|0（4字节）| 原有消息体
% 	    string uid = 1;
% 	}
% 2.1.reply, 游戏服回应
% message CloseRes{           //断开的回复  action = 1012
%     int32  code  = 1;       //断开结果的错误码， 成功： 0，失败 ： 1  
%     // 如果成功， 根据 GetEntranceReq.server_type取配置文件对应的url 打包 gw.GetEntranceRes 返回 Cmd内{cmdId=4} 
%        如果失败,即不允许断开，根据 CloseRes.server_type 取配置文件对应的url 打包 [gw.GetEntranceRes] 返回,  {cmdId=4} 
%     string uid = 2;
%     string server_type = 3;
%     string server_id = 4;
% }

% controller({{4, ServerType, _OtherParam, DataBin}, _RightPackage, _NextPageckage}, _State= #state{uid = Uid}) ->
% 	?LOG({<<"cmdid4">>, ServerType, DataBin}),
% 	#'Msg'{action = Action, msgBody = MsgBody, uid= _Uid} = gw_proto:decode_msg(DataBin,'Msg'),
% 	action(Action, MsgBody, Uid),
% 	ok;
controller({{_CmdId, _ServerType, _OtherParam, _DataBin}, RightPackage, _NextPageckage}, _State= #state{uid = Uid}) ->
	?LOG({<<"package from gs">>, RightPackage, Uid}),
	case table_client_list:select(Uid) of 
        [] -> 
            ok;
        [Client|_] ->
            Pid = table_client_list:get_client(Client, pid_front),
            Pid ! {transport, RightPackage}
    end,

    % ?LOG({<<"from gs:">>, RightPackage, Uid, State}),
	ok.



% action(1012, Bin, Uid) ->
% 	#'CloseRes'{code = Code, uid= _, server_type = ServerType, server_id = _ServerID} = gw_proto:decode_msg(Bin,'CloseRes'),
% 	case Code of
% 		0 ->
% 			%% 与后端服务器断开成功, 此时serverType 要拿请求时的 serverType,
% 			% reply(123, Uid),
% 			case table_client_list:select(Uid) of 
% 		        [] -> 
% 		            ok;
% 		        [Client|_] ->
% 		            CacheBin = table_client_list:get_client(Client, cache_bin),
% 		            {Server_type_req, PidFrom} = binary_to_term(CacheBin),
% 		            reply(Server_type_req, PidFrom, Uid)
% 		    end,
% 			ok;
% 		_ ->
% 			%%　与后端服务器断开失败
% 			case table_client_list:select(Uid) of 
% 		        [] -> 
% 		            ok;
% 		        [Client|_] ->
% 		            Pid = table_client_list:get_client(Client, pid_front),
% 		            % Pid ! {transport, Bin}
% 		            reply(ServerType, Pid, Uid)
% 		    end,
			
% 			ok
% 	end,
% 	ok;
% action(_Action, _Bin, _Uid) ->
% 	ok.



% reply(ServerType, PidFrom, _Uid) ->
% 	EntraceUrl = fun_get_entrance:get_entrance(ServerType),
% 	GetEntranceRes = #'GetEntranceRes'{entrace_url = EntraceUrl},
% 	GetEntranceResBin = gw_proto:encode_msg(GetEntranceRes),
%     Msg = #'Msg'{
%                         action = 1007,
%                         msgBody = GetEntranceResBin,
%                         uid = <<"0">>
%                     },

%     MsgBin = gw_proto:encode_msg(Msg),
%     ReplyPackage = glibpack:package(3, MsgBin),
% 	PidFrom ! {transport, ReplyPackage},
% 	ok.


% send_client_by_uid(Uid, Bin) ->
% 	case table_client_list:select(Uid) of 
%         [] -> 
%             ok;
%         [Client|_] ->
%             Pid = table_client_list:get_client(Client, pid_front),
%             Pid ! {transport, Bin}
%     end.


% action(?GATEWAY_CMD_GS_REPORT, Package, _State) -> 
%     ?LOG({?GATEWAY_CMD_GS_REPORT, Package}),
%     #'ReportServerInfo'{serverType = ServerType, 
%                         serverID = ServerID,
%                         serverURI = ServerURI, 
%                         max = Max} = gateway_proto:decode_msg(Package,'ReportServerInfo'),
%     ?LOG({ServerType, ServerID, ServerURI, Max}),
%     table_game_server_list:add(ServerID, ServerType, ServerURI, Max),
%     ok;

% action(RightPackage, State= #state{uid = Uid}) -> 
%     case table_client_list:select(Uid) of 
%         [] -> 
%             ok;
%         [Client|_] ->
%             Pid = table_client_list:get_client(Client, pid_front),
%             Pid ! {transport, RightPackage}
%     end,

%     ?LOG({<<"from gs:">>, RightPackage, Uid, State}),
%     ok.