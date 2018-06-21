-module(ctrl_client_hub).
%% API.
-export([action/3]).


-include_lib("inner_msg_proto.hrl").
-include_lib("inner_cmd.hrl").


% action(1111, DataBin) ->
% 	P = tcp_package:package(1112, DataBin),
% 	self() ! {tcp_send, P},
% 	io:format("~n ==XX ~ntype:~p, bin: ~p ~n ", [1111, DataBin]);

action(?INNER_CMD_LOGIN_REPLY, DataBin, _State) ->
	#'InnerLoginReply'{user_id = UserId, error_type = ErrorType, msg = Msg} = inner_msg_proto:decode_msg(DataBin,'InnerLoginReply'),
	case table_client_list:select(UserId) of 
		[] -> 
			ok;
		[Client|_] -> 
			ClientPid = table_client_list:get_client(Client, pid),
			% ClientPid ! {from_hub, ?INNER_CMD_LOGIN_REPLY, DataBin},
			ClientPid ! {from_hub, ?INNER_CMD_LOGIN_REPLY, {UserId, ErrorType, Msg}},

			ok
	end,
	ok; 
action(_Cmd, _DataBin, _State) ->
	% io:format("mod:~p, line:~p, param:~p~n", [?MODULE, ?LINE, {UserId, ErrorType, Msg}]),
	% io:format("~n client receive reply here =============== ~ntype:~p, bin: ~p ~n ", [Cmd, DataBin]). 
	ok.





