-module(send).
-compile(export_all).

-define(ETS_OPTS,[set, public ,named_table , {keypos,2}, {heir,none}, {write_concurrency,true}, {read_concurrency,false}]).

-define(WS_CLIENTS, ws_clients).
-record(ws_clients, {
	key,
	val
}).

-include_lib("glib/include/gw_proto.hrl").
-include_lib("glib/include/hall_proto.hrl").

-include_lib("glib/include/log.hrl").
% -include("gateway_cmd.hrl").
-include_lib("glib/include/cmdid.hrl").

-define( UINT, 32/unsigned-little-integer).

test() ->
	test1(),
	test2(),
	test100(),
	ok.

test100() ->
	transport().

test1() ->
	test_login(),
	ok.

test2() ->
	test_change_server(),
	ok.



% message Msg{
%     uint32 action = 1;
%     bytes  msgBody = 2;
%     string uid = 3;     //网关层使用
% }

% message GetEntranceReq{   //请求获取入口 action = 1006     cmd 对应3 客户端发起请求
%     string  identity = 1;
%     string channel_id = 2;
%     string  server_type  = 3;

% }

% message GetEntranceRes{      //获取入口回复  action  = 1007 请求入口地址的回应  【网关回复】
%     string  entrace_url  = 1;
% }

test3() -> 
	GetEntranceReq = #'GetEntranceReq'{
                        identity = <<"d+TY8ha8MM5L16PF9jKslxQfLfEKKmzwybf9Zx7LzVYuNIgVcATOxcf7QuDE8MLyre8e5grLrHncn8vT5z5e6JA21TNs4S\/bHEFq+HapSPL8eyMNcQtnxEMsTfAso4L8">>,
                        channel_id = <<"2">>,
                        server_type = <<"1000">> 
                    },
    GetEntranceReqBin = gw_proto:encode_msg(GetEntranceReq),

    % ?LOG({verify, VerifyReqBin}),

    % Msg = #'Msg'{
    %                     action = 1006,
    %                     msgBody = GetEntranceReqBin,
    %                     uid = <<"123456">>
    %                 },

    % MsgBin = gw_proto:encode_msg(Msg),

    % decode_test(MsgBin),

    Package = glibpack:package(?CMD_ID_1, GetEntranceReqBin),
	{ok, Pid} = get_client(),
	Pid ! {binary, Package},
	ok.



% decode_test(DataBin) -> 
% 	?LOG({cool, DataBin}),
% 	#'Msg'{action = _, 'msgBody' = MsgBody, uid= _} = gw_proto:decode_msg(DataBin,'Msg'),
% 	?LOG(MsgBody),
% 	#'GetEntranceReq'{identity = Identity, 'server_type' = Server_type} = gw_proto:decode_msg(MsgBody,'GetEntranceReq'),
% 	?LOG({Identity, Server_type}),
	
% 	ok.



transport1() -> 
	% MsgBin = <<"123">>,
	VerifyReq = #'VerifyReq'{
                        identity = <<"d+TY8ha8MM5L16PF9jKslxQfLfEKKmzwybf9Zx7LzVYuNIgVcATOxcf7QuDE8MLyre8e5grLrHncn8vT5z5e6JA21TNs4S\/bHEFq+HapSPL8eyMNcQtnxEMsTfAso4L8">>,
                        channel_id = <<"1">>
                    },
    VerifyReqBin = hall_proto:encode_msg(VerifyReq),
    Msg = #'Msg'{
                        action = 2006,
                        msgBody = VerifyReqBin
                    },
    MsgBin = hall_proto:encode_msg(Msg),
    % Txt = glibpack:package(?CMD_ID_3, VerifyReqBin),
    Len = byte_size(MsgBin) + 4,
    Payload = <<Len:?UINT, MsgBin/binary>>,
	Bin = glibpack:package(?CMD_ID_100, 0, Payload),
	{ok, Pid} = get_client(),
	Pid ! {binary, Bin},
	ok.
	


transport() -> 
	MsgBin = <<"123">>,
	Txt = glibpack:package(?CMD_ID_100, 1000, MsgBin),
	{ok, Pid} = get_client(),
	Pid ! {binary, Txt},
	ok.


	% ok.

test_change_server() ->
	MsgBin = <<"">>,
	Txt = glibpack:package(?CMD_ID_5, 1000, MsgBin),
	{ok, Pid} = get_client(),
	Pid ! {binary, Txt},
	ok.


% https://api.wl860.com/Api/test?username=mf001&money=10000
test_login() -> 
	VerifyReq = #'VerifyReq'{
                        identity = <<"d+TY8ha8MM5L16PF9jKslxQfLfEKKmzwybf9Zx7LzVYuNIgVcATOxcf7QuDE8MLyre8e5grLrHncn8vT5z5e6Bp4xJSCDg+v0YB\/WXE4bHmoKbEFCbRjh36vWxwU0vTo">>,
                        channel_id = <<"1">>
                    },
    VerifyReqBin = gw_proto:encode_msg(VerifyReq),

    % ?LOG({verify, VerifyReqBin}),

    % Msg = #'Msg'{
    %                     action = 1001,
    %                     msgBody = VerifyReqBin,
    %                     uid = <<"123456">>
    %                 },

    % MsgBin = gw_proto:encode_msg(Msg),

    Txt = glibpack:package(?CMD_ID_3, VerifyReqBin),
	{ok, Pid} = get_client(),
	Pid ! {binary, Txt},
	ok.




% test() -> 
% 	%Txt = <<"hello world">>,
% 	Txt = glibpack:package(1, <<"hello world! ">>),
% 	% {ok, Pid} = wsc_cc:start_link(),
% 	{ok, Pid} = get_client(),
% 	% Pid ! {binary, <<Bin/binary,Bin/binary,Bin/binary>>},
% 	Pid ! {binary, Txt},
% 	ok.

% test_bin() -> 
% 	Bin = create_package(),
% 	% binary(PackageBinary).
% 	{ok, Pid} = wsc_cc:start_link(),
% 	% Pid ! {binary, <<Bin/binary,Bin/binary,Bin/binary>>},
% 	Pid ! {binary, Bin},
% 	ok.

create_package() -> 
	<<"hello world">>.


get_client() ->
	get_client(1).

get_client(Index) -> 
	case ets:match_object(?WS_CLIENTS, #ws_clients{key = Index,_='_'}) of
		[{?WS_CLIENTS, Key, Val}] -> {ok, Val};
		[] ->{error,not_exist}
	end.

init() -> 
	init_ws_clients().

init_ws_clients() -> 
	ets:new(?WS_CLIENTS, ?ETS_OPTS),
	lists:foreach(fun(Index) -> 
		{ok, Pid} = wsc_cc:start_link(Index),
		ets:insert(?WS_CLIENTS, #ws_clients{key=Index, val=Pid})
	end, [1,2,3,4,5,6]),

	ok.

