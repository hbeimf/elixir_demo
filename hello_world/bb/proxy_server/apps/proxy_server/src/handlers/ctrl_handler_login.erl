-module(ctrl_handler_login).
%% API.
-export([action/3]).

-include("msg_proto.hrl").
-include("cmd.hrl").
-include("inner_msg_proto.hrl").
-include("inner_cmd.hrl").

-include("state.hrl").



action(?CMD_LOGIN, DataBin, #state{socket=Socket}) ->
	% io:format("login: ~p~n", [DataBin]),

	#'Login'{user_id = UserId, token = Token}
		= msg_proto:decode_msg(DataBin,'Login'),

            Hash = "userinfo@"++libfun:to_str(UserId),
            Key = "token",
            case redisc:hget(Hash, Key) of
                {ok,undefined} ->
                    ?LOG("hash undefined 111"),
                    {islogin, false};
                {ok, Token} ->
                    Ip  =  case ranch_tcp:peername(Socket) of
                        {ok, {TupleIp, _Port}} ->
                            ListIp = tuple_to_list(TupleIp),
                            ListIp1 = lists:map(fun(X)-> libfun:to_str(X) end, ListIp),
                            IpStr = string:join(ListIp1, "."),
                            libfun:to_binary(IpStr);
                        _ ->
                            <<"">>
                    end,

                    LogTime = libfun:time(),
                    {_, _, ProxyId} = rconf:read_config(proxy_server),

                    % io:format("~p~n", [{UserId, Token, Ip}]),
                    let_other_pre_user_logout(UserId),
                    % timer:sleep(1000),
                    % table_client_list:add(UserId, ProxyId, LogTime, Token,  Ip, self(), 0),

                    % SceneId = 0,
                    % TeacherId = 0,
                    % 如果是断线重连，则恢复之前的绑定关系
                    {TeacherId, SceneId} = user_status(UserId),

                    SchoolId = school_id(UserId),
                    RoleId = role_id(UserId),
                    table_client_list:add(UserId, ProxyId, LogTime, Token,  Ip, SceneId, TeacherId, SchoolId, RoleId, self()),

                    online_student:set_online_student(SchoolId),
                    % inner login
                    InnerLogin = #'InnerLogin'{
                    	user_id = UserId,
                    	token = Token,
                    	proxy_id = ProxyId,
                    	ip = Ip,
                    	login_time = LogTime
                    },

                    Bin = inner_msg_proto:encode_msg(InnerLogin),
                    PackageLogin = tcp_package:package(?INNER_CMD_LOGIN, Bin),
                    client_hub:send(PackageLogin),

                    cache_userinfo(UserId),
                    {islogin, true, UserId, Token};
            _ ->
                ?LOG("hash undefined 222"),
                {islogin, false}
            end;
action(_Type, _DataBin, _State) ->
            ?LOG("hash undefined 333"),
	{islogin, false}.

% priv fun ===============================================
%% 缓存客户的 名称 ， 图像url
cache_userinfo(UserId) ->
    Hash = "userinfo@"++libfun:to_str(UserId),
    KeyName = "name",
    KeyUrl = "url",
    case mysqlc:user_info(UserId) of
        {ok, []} ->
            ok;
        {ok, [Info|_]} ->
            {_, {_, Name}, _ } = lists:keytake(<<"name">>, 1, Info),
            {_, {_, Url}, _ } = lists:keytake(<<"url">>, 1, Info),
            redisc:hset(Hash, KeyName, Name),
            redisc:hset(Hash, KeyUrl, Url),
            ok
    end,
    ok.


user_status(UserId) ->
    StateKey = "userstate@"++libfun:to_str(UserId),
    case redisc:get(StateKey) of
        {ok,undefined} ->
                    {0, 0};
        {ok, ClientBin} ->
            Client = binary_to_term(ClientBin),
            TeacherId = table_client_list:get_client(Client, teacher_id),
            SceneId = table_client_list:get_client(Client, scene_id),

            %% 将最后一个广播消息发送给客户端 ，
            % sync_send_msg(TeacherId),

            {TeacherId, SceneId};
        _ ->
            {0, 0}
    end.

% sync_send_msg(TeacherId) ->
%     MsgKey = "msg@"++libfun:to_str(TeacherId),
%     case redisc:get(MsgKey) of
%         {ok,undefined} ->
%             ok;
%         {ok, DataBin} ->
%             PackageBin = tcp_package:package(?BROADCAST_MSG_REPLY, DataBin),
%             self() ! {tcp_send, PackageBin},
%             ok;
%         _ ->
%             ok
%     end.

let_other_pre_user_logout(UserId) ->
    ClientList = table_client_list:select(UserId),
    foreach_client(ClientList, UserId),
    ok.

foreach_client([], _) ->
    ok;
foreach_client(ClientList, UserId) ->
    lists:foreach(fun(Client) ->
        ClientPid = table_client_list:get_client(Client, pid),
        Msg = unicode:characters_to_list("账号在其它地方登录!"),
         LoginReply = #'LoginReply'{
                        error_type = 2,
                        msg = Msg
                    },

            Bin = msg_proto:encode_msg(LoginReply),
            PackageLoginReply = tcp_package:package(?CMD_LOGIN_REPLY, Bin),
            ClientPid ! {tcp_send, PackageLoginReply},
            ClientPid ! {close_client_connect, "account login at other place!"},
        ok
    end,  ClientList),
    ?LOG({"account login at other place!!", UserId}),
    timer:sleep(100), 
    ok.


school_id(UserId) ->
    Res = mysqlc:school_id(UserId),
    parse_school_id(Res).

parse_school_id({ok, []}) ->
    0;
parse_school_id({ok, [[{_, Id}|_]|_]}) ->
    Id;
parse_school_id(_) ->
    0.


role_id(UserId) ->
    mysqlc:role_id(UserId).
