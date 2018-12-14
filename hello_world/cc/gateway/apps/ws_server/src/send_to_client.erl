% send_to_client.erl
-module(send_to_client).
-compile(export_all).

-include("log.hrl").
-include("gw_proto.hrl").
-include("cmdid.hrl").
-include("code.hrl").


%% 单节点中的单点登录，踢掉在这多前登录过的客户端 
%% send_to_client:login_only_one_place(Uid).
login_only_one_place(Uid) ->
	?LOG({login_only_one_place, Uid}),

	Clients = table_client_list:select(Uid),
    ReplyBin = handler_change_game_server:reply_error_msg(?CODE_ID_1006, "账户在其它地方登录"),
    parse_package_from_gwc:send_to_client(Clients, ReplyBin),
    parse_package_from_gwc:close_client(Clients),
	ok.


