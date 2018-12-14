% handler_get_entrance.erl
-module(handler_get_entrance).

-export([init/3]).
-export([handle/2]).
-export([terminate/3]).

-include("log.hrl").
-include("gw_proto.hrl").

%% 请求获取入口 http api
% http://192.168.1.188:8899/GetEntrance?server_type=1001&channel_id=123&identity=CPIHEioKBDEwMDESATEaHXdzOi8vbG9jYWxob3N0Ojc3ODgvd2Vic29ja2V0IAwaATA=
% https://api.wl860.com/Api/test?username=mf001&money=10000

% message GetEntranceReq{   //请求获取入口 action = 1006     cmd 对应3 客户端发起请求
%     string  identity = 1;
%     string channel_id = 2;
%     string  server_type  = 3;

% }

% message GetEntranceRes{      //获取入口回复  action  = 1007 请求入口地址的回应  【网关回复】
%     string  entrace_url  = 1;
% }


init(_Transport, Req, []) ->
	{ok, Req, undefined}.

handle(Req, State) ->
	{Method, _} = cowboy_req:method(Req),
	{ServerType, _} = cowboy_req:qs_val(<<"server_type">>, Req),
	{Identity, _} = cowboy_req:qs_val(<<"identity">>, Req),
	{ChannelId, _} = cowboy_req:qs_val(<<"channel_id">>, Req),

	{ok, Req4} = reply(Method, ServerType, ChannelId, Identity, Req),
	{ok, Req4, State}.

reply(<<"GET">>, undefined, undefined, undefined, Req) ->
	% cowboy_req:reply(400, [], <<"Missing server_type & identity  parameter.">>, Req);
	Msg1 = unicode:characters_to_binary("出错了!! server_type & identity & channel_id 参数没传 "),
	Data1 = [{<<"code">>, 1}, {<<"msg">>, Msg1}],
	Json1 = jsx:encode(Data1),
	cowboy_req:reply(200, header_list(), Json1, Req);

reply(<<"GET">>, undefined, _ChannelId, _Identity, Req) ->
	Msg1 = unicode:characters_to_binary("出错了!! server_type 参数没传 "),
	Data1 = [{<<"code">>, 1}, {<<"msg">>, Msg1}],
	Json1 = jsx:encode(Data1),
	cowboy_req:reply(200, header_list(), Json1, Req);

reply(<<"GET">>, _ServerType, undefined, _Identity, Req) ->
	Msg1 = unicode:characters_to_binary("出错了!!  channel_id 参数没传 "),
	Data1 = [{<<"code">>, 1}, {<<"msg">>, Msg1}],
	Json1 = jsx:encode(Data1),
	cowboy_req:reply(200, header_list(), Json1, Req);

reply(<<"GET">>, _ServerType, _ChannelId, undefined, Req) ->
	Msg1 = unicode:characters_to_binary("出错了!!  identity 参数没传 "),
	Data1 = [{<<"code">>, 1}, {<<"msg">>, Msg1}],
	Json1 = jsx:encode(Data1),
	cowboy_req:reply(200, header_list(), Json1, Req);

reply(<<"GET">>, ServerType, ChannelId, Identity, Req) ->
	try
		case get_entrance(ServerType, ChannelId, Identity) of 
			{_St, []} -> 
				Msg2 = unicode:characters_to_binary("配置文件还没填好!! "),
				Data2 = [{<<"code">>, 1}, {<<"msg">>, Msg2}],
				Json2 = jsx:encode(Data2),
				cowboy_req:reply(200, header_list(), Json2, Req);
			{St, [EntranceUrl|_]} ->
				Msg = unicode:characters_to_binary("测试!! "),
				Data = [{<<"code">>, 0}, {<<"msg">>, Msg}, {<<"server_type">>, St}, {<<"entrace_url">>, glib:to_binary(EntranceUrl)}],
				Json = jsx:encode(Data),
				cowboy_req:reply(200, header_list(), Json, Req);
			{error, login_failed, Msg5} ->
				% Msg5 = unicode:characters_to_binary("认证失败!! "),
				Data5 = [{<<"code">>, 1}, {<<"msg">>, Msg5}],
				Json5 = jsx:encode(Data5),
				cowboy_req:reply(200, header_list(), Json5, Req)
		end

	catch _:_ ->
		?LOG(<<"proto decode error">>),
		Msg1 = unicode:characters_to_binary("出错了!! "),
		Data1 = [{<<"code">>, 1}, {<<"msg">>, Msg1}],
		Json1 = jsx:encode(Data1),
		cowboy_req:reply(200, header_list(), Json1, Req)
	end;

reply(_, _, _,_, Req) ->
	%% Method not allowed.
	cowboy_req:reply(405, Req).

terminate(_Reason, _Req, _State) ->
	ok.

% cors
header_list() ->
	[
		{<<"content-type">>, <<"text/javascript; charset=utf-8">>},
		{<<"Access-Control-Allow-Origin">>, <<"*">>},
		{<<"Access-Control-Allow-Headers">>, <<"X-Requested-With">>},
		{<<"Access-Control-Allow-Methods">>, <<"GET,POST">>}
	].

% priv

get_entrance(ServerType, ChannelId, Identity) ->
	% fun_get_entrance:get_entrance(ServerType).
	% 先认证身份
	LoginRes = fun_get_entrance:login_by_VerifyReq(Identity, ChannelId),
	?LOG({LoginRes}),
	case reply_by_login_res(LoginRes) of 
		{ok, Uid} ->
			?LOG({ok, Uid, ServerType}),
			{ServerType, fun_get_entrance:get_entrance(ServerType)};
		{ok, Uid, ServerType1} ->
			?LOG({ok, Uid, relply1,  ServerType1}),
			{ServerType1, fun_get_entrance:get_entrance(ServerType1)};
		{error, login_failed, Msg}->
			{error, login_failed, Msg};
		Reply ->
			Reply
	end.




reply_by_login_res({ok, Uid, Reply}) ->
	?LOG({<<"login success!">>, Uid}),
	% self() ! {transport, Reply},

	Msg = get_msg(Reply),
	?LOG({msg, Msg}),

	case table_client_list:select(Uid) of 
		[] ->
			%% 直接回复
			% ?LOG("reply here"),
			{ok, Uid};
		[Client|_] ->
			% ?LOG("reply here22"),
			PidBackend = table_client_list:get_client(Client, pid_backend),
			ServerType = table_client_list:get_client(Client, server_type),
			case erlang:is_pid(PidBackend) andalso glib:is_pid_alive(PidBackend) of
				true -> 
					%% 2.1, 如果存在连接 ， 给游戏服发断开 package
					case ServerType of 
						<<"">> -> 
							{ok, Uid};
						_ ->
							{ok, Uid, ServerType}
					end;
				_ -> 
					% ?LOG("reply here33"),
					{ok, Uid}
			end
	end;
%% 身份验证失败
reply_by_login_res({ok, Reply}) ->
	Msg = get_msg(Reply),
	?LOG({msg, Msg}),
	{error, login_failed, Msg}.


get_msg(Package) ->
	?LOG({get_msg}),
	case glibpack:unpackage(Package) of
		{ok, {_CmdId, _ServerType, _ServerId, DataBin}, _RightPackage, _NextPageckage} ->
			#'VerifyRes'{code = _Code, uid= _Uid, msg = Msg} = gw_proto:decode_msg(DataBin,'VerifyRes'),
			Msg;
		_ ->
			<<"">>
	end.

