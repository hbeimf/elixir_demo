% parse_package_from_client.erl

% fun_get_entrance.erl
-module(parse_package_from_client).
-compile(export_all).

-include("log.hrl").
-include("gw_proto.hrl").
-include("cmdid.hrl").


parse_package(Bin, State) ->
	case glibpack:unpackage(Bin) of
		{ok, waitmore}  -> 
			?LOG({wait_mote, Bin}),
			{ok, waitmore, Bin};
		%% 请求进入游戏 此协议由客户端统一调用 cmd=5 客户端发起请求
		{ok, {?CMD_ID_5, ServerType, ServerId, _DataBin}, _RightPackage, NextPageckage} ->
			?LOG({?CMD_ID_5, Bin}),
			handler_change_game_server:action(ServerType, ServerId, State),
			parse_package(NextPageckage, State);
		
		%%请求获取入口 action = 1006     cmd 对应3
		% {ok, {3, _ServerType, _ServerId, _DataBin}, RightPackage, NextPageckage} ->
		% 	?LOG({have_login, 3, <<"XXXXXXXXXXXX">>}),
		% 	case fun_get_entrance:action(RightPackage, State) of
		% 		{ok, Uid, Reply} ->
		% 			self() ! {transport, Reply},
		% 			% ClientPid = self(),
		% 			% spawn(fun() -> 
		% 			% 	ClientPid ! {transport, Reply}
		% 			% end),
		% 			parse_package(NextPageckage, State);
		% 		Reason -> 
		% 			?LOG({"error ", Reason}),
		% 			error
		% 	end;

		%%请求获取入口 cmd=1 客户端发起请求
		{ok, {?CMD_ID_1, _ServerType, _ServerId, _DataBin}, RightPackage, NextPageckage} ->
			?LOG({not_login, ?CMD_ID_1, <<"XXXXXXXXXXXX">>}),
			case fun_get_entrance:action(RightPackage, State) of
				{ok, _Uid} ->
					% {ok, NextPageckage, Uid};
					parse_package(NextPageckage, State);
				{ok, _Uid, _ServerTypeReq} ->
					% {ok, NextPageckage, Uid, ServerTypeReq};
					parse_package(NextPageckage, State);
				Reason -> 
					?LOG({"login error ", Reason}),
					% {error, stop}
					error
			end;

		%% 透传 100
		{ok, {?CMD_ID_100, _ServerType, _ServerId, Payload}, _RightPackage, NextPageckage} ->
			% handler_change_game_server:action(ServerType, ServerId, State),
			?LOG({?CMD_ID_100, Bin}),
			handler_transport:action(Payload, State),
			parse_package(NextPageckage, State);
		_ ->
			?LOG({error, Bin}),
			error		
	end.

