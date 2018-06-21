-module(offline_student).
-compile(export_all).

-include("msg_proto.hrl").
-include("cmd.hrl").

% 给 ShooleId 学校其它客户端 广播 UserId 客户端下线的消息
broadcast_to_other_client(SchoolId, UserId) ->
	Clients = table_client_list:select_by_school_id(SchoolId),
	lists:foreach(fun(Client) -> 
		%% 发送消息，
		Pid = table_client_list:get_client(Client, pid),

		Offline = #'StudentId'{
	                        user_id = UserId
	             },

	            Bin = msg_proto:encode_msg(Offline),
	            PackageOffline = tcp_package:package(?BROADCAST_OFFLINE, Bin),
	            Pid ! {tcp_send, PackageOffline},
	            ok
	end, Clients),
	ok.













