-module(ctrl_from_hub).
%% API.
-export([action/3]).
-include_lib("inner_msg_proto.hrl").
-include_lib("inner_cmd.hrl").
-include("msg_proto.hrl").
-include("cmd.hrl").

action(?INNER_CMD_LOGIN_REPLY, {_UserId, ErrorType, _Msg}, _State) ->
	% #'InnerLoginReply'{user_id = UserId, error_type = ErrorType, msg = _Msg} = inner_msg_proto:decode_msg(DataBin,'InnerLoginReply'),
	% io:format("mod:~p, line:~p, param:~p~n ", [?MODULE, ?LINE, {checkpass, UserId, ErrorType}]),
	case ErrorType of 
		2 -> 	
			%  登录成功
			Msg = unicode:characters_to_list("登录成功!"),
		         	LoginReply = #'LoginReply'{
		                        error_type = 1,
		                        msg = Msg
		                    },
		            Bin = msg_proto:encode_msg(LoginReply),
		            PackageLoginReply = tcp_package:package(?CMD_LOGIN_REPLY, Bin),
		            self() ! {tcp_send, PackageLoginReply},
			{checkpass, true};
		3 -> 
			% 账号在其它地方重复登录了 
			Msg = unicode:characters_to_list("账号在其它地方登录!"),
		         	LoginReply = #'LoginReply'{
		                        error_type = 2,
		                        msg = Msg
		                    },
		            Bin = msg_proto:encode_msg(LoginReply),
		            PackageLoginReply = tcp_package:package(?CMD_LOGIN_REPLY, Bin),
		            self() ! {tcp_send, PackageLoginReply},
		            self() ! {close_client_connect, "account login at other place!"},
			ok;
		_ -> 
			{checkpass, false}
	end;
action(_Cmd, _ReqTuple, _State) ->
	% io:format("mod:~p, line:~p, param:~p~n ", [?MODULE, ?LINE, {Type, DataBin}]). 
	ok.



