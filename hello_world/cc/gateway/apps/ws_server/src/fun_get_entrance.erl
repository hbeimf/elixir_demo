% fun_get_entrance.erl
-module(fun_get_entrance).
-compile(export_all).

-include("log.hrl").
-include("gw_proto.hrl").
-include("cmdid.hrl").
-include("code.hrl").

get_entrance(ServerType, _Identity) ->
	get_entrance(ServerType).	


%% 根据serverType 获取对应大厅的入口地址返回 
% fun_get_entrance:get_entrance("1001").
get_entrance(ServerType1) ->
	ServerType = glib:to_str(ServerType1),
	?LOG({url_cnfig, ServerType}),
	case sys_config:get_config(server_type) of 
		{ok, ConfigServerType} -> 
			?LOG({server_type, ConfigServerType}),
			lists:foldl(fun({Config, Url}, Reply)-> 
				Key = glib:to_str(Config),
				St = glib:ltrim(Key, "server_type_"),
				?LOG({Config, Url, Reply, Key, St, ServerType}),
				case St =:= ServerType of 
					true -> 
						[Url|Reply];
					_ -> 
						Reply
				end
			end, [], ConfigServerType);
		_ -> 
			[]
	end.
	
	% <<"http://www.baidu.com/">>.


% 发起的请求 ==============================================

% message GetEntranceReq{   //请求获取入口 cmd=1 客户端发起请求
%     string  identity = 1;
%     string  channel_id = 2;
%     string  server_type  = 3;

% }
% message GetEntranceRes{      //获取入口回复  cmd=2 请求入口地址的回应  【网关回复】
%     string  entrace_url  = 1;
% }
action(Package, _State) -> 
	case glibpack:unpackage(Package) of
		% {ok, waitmore}  -> 
		% 	?LOG({"unpackage error"}),
		% 	{error, stop};
		{ok, {_CmdId, _ServerType1, _Sid, DataBin}, _RightPackage, _NextPageckage} ->
			?LOG({cool, DataBin}),

			#'GetEntranceReq'{identity = Identity, 'server_type' = ServerType, 
					channel_id = ChannelId} = gw_proto:decode_msg(DataBin,'GetEntranceReq'),
			?LOG({cmd3, Identity, ServerType, ChannelId}),

			%% 先认证身份
			LoginRes = login_by_VerifyReq(Identity, ChannelId),
			case reply_by_login_res(LoginRes) of 
				{reply_entrace_url_here, Uid} -> 
					?LOG({reply_entrace_url_here, Uid}),
					send_by_server_type(ServerType, <<"0">>),
					{ok, Uid, term_to_binary({ServerType, self()})};
				{reply_at_game_server_link, ServerType1, ServerId, Uid} ->
					%%　此处缓存　　ServerType，　等游戏服应答后，如果允许按此值　取EntraceUrl　，则还要用，
					send_by_server_type(ServerType1, ServerId),
					?LOG({reply_from_gs}),
					{ok, Uid, term_to_binary({ServerType, self()})};
				_ ->
					error
			end;
			% ok;
		_ ->
			?LOG("login error 222"),
			{error, stop}
	end.

send_by_server_type(ServerType, ServerId) ->
	?LOG({server_type, ServerType}),
	case get_entrance(ServerType) of
		[] ->
			%% 配置文件还没填好
			?LOG({error}),
			ReplyBin = handler_change_game_server:reply_error_msg(?CODE_ID_1004, "游戏入口配置文件还没填好"),
			self() ! {send, ReplyBin},
			ok;
		[EntraceUrl|_] ->
			GetEntranceRes = #'GetEntranceRes'{entrace_url = EntraceUrl, server_type = ServerType, server_id = ServerId},
			GetEntranceResBin = gw_proto:encode_msg(GetEntranceRes),
		    ReplyPackage = glibpack:package(?CMD_ID_1_REPLY, GetEntranceResBin),
		    ?LOG({echo, EntraceUrl, ReplyPackage}),
			self() ! {send, ReplyPackage},
			ok
	end,
	?LOG(<<"echo...">>),
	ok.


%% 根据身份验证来进行回复
%% 身份验证成功, 则检查是否存在与游戏服之间的连接 ，如果存在连接 ，
reply_by_login_res({ok, Uid, _Reply}) ->
	?LOG({<<"login success!">>, Uid}),
	% self() ! {transport, Reply},

	case table_client_list:select(Uid) of 
		[] ->
			%% 直接回复
			?LOG("reply here"),
			{reply_entrace_url_here, Uid};
		[Client|_] ->
			?LOG("reply here22"),
			PidBackend = table_client_list:get_client(Client, pid_backend),
			ServerType = table_client_list:get_client(Client, server_type),
			ServerId = table_client_list:get_client(Client, server_id),


			reply_by_pid_backend(PidBackend, ServerType, ServerId, Uid)
			% reply_at_game_server_link
	end;
%% 身份验证失败
reply_by_login_res({ok, Reply}) ->
	% {reply_then_close, Reply};
	self() ! {transport, Reply},
	self() ! close,
	ok.


reply_by_pid_backend(PidBackend, ServerType, ServerId, Uid) ->
	case erlang:is_pid(PidBackend) andalso glib:is_pid_alive(PidBackend) of
		true -> 
			%% 2.1, 如果存在连接 ， 给游戏服发断开 package
			case ServerType of 
				<<"">> -> 
					{reply_entrace_url_here, Uid};
				_ ->
					{reply_at_game_server_link, ServerType, ServerId, Uid}
			end;
		_ -> 
			?LOG("reply here33"),
			{reply_entrace_url_here, Uid}
	end.


% message VerifyReq{    //请求认证 action=1001  cmd 对应1  http
%     string identity = 1; //用户身份
%     string channel_id = 2;
% }
login_by_VerifyReq(Identity, ChannelId) ->
	VerifyReq = #'VerifyReq'{
                        identity = Identity,
                        channel_id = ChannelId
                    },
    VerifyReqBin = gw_proto:encode_msg(VerifyReq),

    handler_login:login_by_VerifyReq(VerifyReqBin).


