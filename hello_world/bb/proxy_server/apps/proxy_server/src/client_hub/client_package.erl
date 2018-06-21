-module(client_package).

% -export([encode/0]).

-compile(export_all).
-include_lib("inner_msg_proto.hrl").
-include_lib("inner_cmd.hrl").




% package_encode:regist_proxy().
regist_proxy() -> 
	{Ip, Port, Id} = rconf:read_config(proxy_server),
	Register = #'InnerRegistProxy'{id = Id, ip = Ip, port = Port},
	Bin = inner_msg_proto:encode_msg(Register),
	tcp_package:package(?INNER_CMD_REGIST_PROXY, Bin).



















