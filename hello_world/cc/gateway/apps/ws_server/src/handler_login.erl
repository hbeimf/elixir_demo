-module(handler_login).
-compile(export_all).
-include("log.hrl").
-include("gw_proto.hrl").
-include("action.hrl").
-include("cmdid.hrl").



parse_package_login(Bin, State) ->
	case glibpack:unpackage(Bin) of
		{ok, waitmore}  -> 
			{ok, waitmore, Bin};
		%%请求获取入口 cmd=1 客户端发起请求
		{ok, {?CMD_ID_1, _ServerType, _ServerId, _DataBin}, RightPackage, NextPageckage} ->
			?LOG({cmd1, ?CMD_ID_1, <<"XXXXXXXXXXXX">>}),
			case fun_get_entrance:action(RightPackage, State) of
				{ok, Uid} ->
					{ok, NextPageckage, Uid};
				{ok, Uid, ServerTypeReq} ->
					{ok, NextPageckage, Uid, ServerTypeReq};
				Reason -> 
					?LOG({"login error ", Reason}),
					{error, stop}
			end;
		%% 登录 请求认证 cmd=3  http
		{ok, {?CMD_ID_3, _ServerType, _OtherParam, _DataBin}, RightPackage, NextPageckage} ->
			?LOG({cmd3, ?CMD_ID_3}),
			case action(RightPackage) of
				{ok, Uid, Reply} ->
					self() ! {send, Reply},
					{ok, NextPageckage, Uid};
				{ok, Reply} ->
					{reply_then_close, Reply};
				Reason -> 
					?LOG({"login error 111", Reason}),
					{error, stop}
			end;
		_ ->
			?LOG("login error 222"),
			{error, stop}		
	end.

%%　去账户中心去认证
% test() -> 
% 	Package = <<"">>,
% 	action(Package).


% action(Package) ->
% 	ok.

action(Package) -> 
	try
		?LOG({login_api, Package}),
		case glibpack:unpackage(Package) of
			{ok, waitmore}  -> 
				?LOG(<<"waitmore">>),
				error;
			{ok, {_CmdId, _ServerType, _Sid, DataBin}, _RightPackage, _NextPageckage} ->
				?LOG({<<"login_by_VerifyReq">>}),
				login_by_VerifyReq(DataBin);
			_ ->
				?LOG("login error 222"),
				error
		end
	catch _:_ ->
		error
	end.

login_by_VerifyReq(DataBin) ->
	{ok,[{url,LoginApi}|_]} = sys_config:get_config(login_api),
	% ?LOG({login_api, LoginApi}),

	Url = LoginApi ++ base64:encode_to_string(DataBin),

	?LOG({url_login, Url}),
	Reply = glib:http_get(Url),
	?LOG({login_reply, Reply}),

	Reply1 = base64:decode(Reply),

	% #'Msg'{action = _, msgBody = _, uid= Uid} = gw_proto:decode_msg(Reply1,'Msg'),
	% ?LOG({uid, Uid}),

	% {ok, Uid, Reply1}.

	% message VerifyRes{          //请求认证回复 cmd=2 供客户端使用
	%     int32  code  = 1;       //错误编码， 0：成功， 非0：失败
	%     string uid = 2;      //如果id 不为 ""， 说明
	% }

	#'VerifyRes'{code = Code, uid= Uid, msg = Msg} = gw_proto:decode_msg(Reply1,'VerifyRes'),

	?LOG({login_reply, Code, Uid, Msg}),

	%% 登录外面包上协议 头部分

	Reply2 = glibpack:package(?CMD_ID_3_REPLY, Reply1),

	?LOG({len, byte_size(Reply2)}),
	reply(Code, Uid, Reply2).

%% 0 成功 
reply(0, Uid, Reply) ->
	{ok, Uid, Reply};
reply(_, _Uid, Reply) ->
	{ok, Reply}.





