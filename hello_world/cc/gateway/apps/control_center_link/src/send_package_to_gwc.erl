% send_package_to_gwc.erl
-module(send_package_to_gwc).
-compile(export_all).
-include_lib("ws_server/include/log.hrl").
-include("gateway_proto.hrl").
-include("cmd_gateway.hrl").


% send_package_to_gwc:client_sync(Uid),
client_sync(Uid) -> 
    ?LOG({Uid, sync}),

    Clients = table_client_list:select(Uid),
    client_list_sync(Clients),
    ok.

client_list_sync([]) ->
    ok;
client_list_sync([Client|Tail]) ->
    Uid = table_client_list:get_client(Client, uid),
    ServerType = table_client_list:get_client(Client, server_type),
    ServerId = table_client_list:get_client(Client, server_id),

    {ok, Config} = sys_config:get_config(node),
    {_, {node_id, NodeId}, _} = lists:keytake(node_id, 1, Config),

    ?LOG({Uid, ServerType, ServerId, NodeId}),

    ClientLoginReq = #'ClientLoginReq'{
                        uid = Uid,
                        server_type = glib:to_str(ServerType),
                        server_id = glib:to_str(ServerId),
                        gateway_id = glib:to_str(NodeId)
                    },
    ClientLoginReqBin = gateway_proto:encode_msg(ClientLoginReq),

    Package = glib:package(?GATEWAY_CMD_SEND_CLIENT_LOGIN, ClientLoginReqBin),

    control_center_handler_client:send(Package),
    client_list_sync(Tail).






client_login(Uid) ->
	?LOG({Uid, login}),
    client_sync(Uid).

	% ClientLoginReq = #'ClientLoginReq'{
 %                        uid = Uid
 %                    },
 %    ClientLoginReqBin = gateway_proto:encode_msg(ClientLoginReq),

 %    Package = glib:package(?GATEWAY_CMD_SEND_CLIENT_LOGIN, ClientLoginReqBin),

 %    control_center_handler_client:send(Package),

	% ok.




client_logout(Uid) ->
    Clients = table_client_list:select(Uid),
	?LOG({Uid, Clients, logout}),
    client_list_logout(Clients).

	

client_list_logout([]) ->
    ok;
client_list_logout([Client|Tail]) ->
    ?LOG({logout}),
    Uid = table_client_list:get_client(Client, uid),
    ServerId = table_client_list:get_client(Client, server_id),
    ?LOG({logout, ServerId}),
    

    ClientLogoutReq = #'ClientLogoutReq'{
                        uid = Uid,
                        serverID = glib:to_str(ServerId)
                    },
    ClientLogoutReqBin = gateway_proto:encode_msg(ClientLogoutReq),
    ?LOG({logout}),
    

    Package = glib:package(?GATEWAY_CMD_SEND_CLIENT_LOGOUT, ClientLogoutReqBin),
    ?LOG({logout}),
    
    control_center_handler_client:send(Package),

    client_list_logout(Tail).


