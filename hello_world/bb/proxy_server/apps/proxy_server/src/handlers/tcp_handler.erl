-module(tcp_handler).
-behaviour(gen_server).
-behaviour(ranch_protocol).

%% API.
-export([start_link/4]).

%% gen_server.
-export([init/1]).
-export([handle_call/3]).
-export([handle_cast/2]).
-export([handle_info/2]).
-export([terminate/2]).
-export([code_change/3]).

-define(TIMEOUT, 5000).

% -record(state, {socket, transport, data, islogin = false}).
-include("state.hrl").
-include("inner_msg_proto.hrl").
-include("inner_cmd.hrl").
-include("cmd.hrl").

% http://blog.csdn.net/yuanfengyun/article/details/49329327
% http://www.cnblogs.com/bicowang/p/4263227.html
%% 宏定义
% -define( PORT, 2345 ).
% -define( HEAD_SIZE, 4 ).
% %% 解数字类型用到的宏
% -define( UINT, 32/unsigned-little-integer).
% -define( INT, 32/signed-little-integer).
% -define( USHORT, 16/unsigned-little-integer).
% -define( SHORT, 16/signed-little-integer).
% -define( UBYTE, 8/unsigned-little-integer).
% -define( BYTE, 8/signed-little-integer).

%% API.

start_link(Ref, Socket, Transport, Opts) ->
	{ok, proc_lib:spawn_link(?MODULE, init, [{Ref, Socket, Transport, Opts}])}.

%% gen_server.

%% This function is never called. We only define it so that
%% we can use the -behaviour(gen_server) attribute.
%init([]) -> {ok, undefined}.

init({Ref, Socket, Transport, _Opts = []}) ->
	ok = ranch:accept_ack(Ref),
	ok = Transport:setopts(Socket, [{active, once}]),
	gen_server:enter_loop(?MODULE, [],
		#state{socket=Socket, transport=Transport, data= <<>>, islogin = false, userid=0, token=""},
		?TIMEOUT).


handle_info({tcp, Socket, CurrentPackage}, State=#state{socket=Socket, transport= Transport, data=LastPackage, islogin = false}) -> 
	
	% io:format("=========islogin:false =====================~n"),
	Transport:setopts(Socket, [{active, once}]),
	PackageBin = <<LastPackage/binary, CurrentPackage/binary>>,
	case parse_package_login(PackageBin, State) of
		{ok, waitmore, Bin} -> 
			{noreply, State#state{data = Bin}};
		{islogin, LeftBin, UserId, Token} -> 
			handle_info({tcp, Socket, LeftBin}, State#state{socket=Socket, transport= Transport, data= <<>>, islogin = checking, userid=UserId, token=Token});
		_ ->
			{stop, stop_noreason, State}
	end;	
handle_info({tcp, Socket, CurrentPackage}, State=#state{socket=Socket, transport= Transport, data=LastPackage, islogin = checking}) -> 
	% ok = Transport:setopts(Socket,[{active,once}]),
	Transport:setopts(Socket,[{active,once}]),
	PackageBin = <<LastPackage/binary, CurrentPackage/binary>>,
	NewState = State#state{data = PackageBin},
	{noreply, NewState};
handle_info({tcp, Socket, CurrentPackage}, State=#state{socket=Socket, transport= Transport, data=LastPackage, islogin = true}) -> 
	% io:format("mod:~p, line:~p, param:~p~n ", [?MODULE, ?LINE, {islogin, true}]),
	
	Transport:setopts(Socket, [{active, once}]),
	PackageBin = <<LastPackage/binary, CurrentPackage/binary>>,

	case parse_package(PackageBin, State) of
		{ok, waitmore, Bin} -> 
			{noreply, State#state{data = Bin}};
		_ -> 
			{stop, stop_noreason,State}
	end;	
handle_info({tcp_send, Package}, #state{transport = _Transport, socket=Socket, userid= UserId} = State) ->
	case glib:unpackage(Package) of 
		{ok, {1004, _}, _} -> 
			%% 如果是心跳回复，则直接忽略
			ok;
		{ok, {Cmd, _}, _} -> 
			?LOG({<<"tcp_send, uid: ">>, UserId, Cmd}),
			ok;
		_ -> 
			?LOG({<<"tcp_send_pack, uid: ">>, UserId, Package}),
			ok
	end,
	% ?LOG({"tcp_send:", UserId, Package}),
	ranch_tcp:send(Socket, Package),
	{noreply, State};
handle_info({from_hub, Type, ReqTuple}, #state{transport = _Transport,socket = Socket, data=LastPackage, userid=UserId, token=_Token} = State) ->
	case ctrl_from_hub:action(Type, ReqTuple, State) of
		% {ok, NewState} ->
		% 	Transport:send(Socket, PackageBin),
		% 	{noreply, NewState};
		{checkpass, true} ->
			%% 如果学生一登录就与老师绑定了上课关系，说明是断线重连， 
			%% 如果老师在群控中， 则将老师最后一个广播消息推送过去 
			?LOG("login..."),
			case table_client_list:select(UserId) of 
				[] ->
					ok;
				[Client|_] ->
					case table_client_list:get_client(Client, teacher_id) of 
						0 -> 	
							%% 有可能当前登录的是一位老师角色 
							%% 检查是否有当前角色的广播消息，有的话则推送给客户端 
							?LOG({<<"broadcast to teacher, teacher_id:">>, UserId}),
							case ctrl_handler:is_group_control(UserId) of 
								true -> 
									MsgKey = "msg@"++libfun:to_str(UserId),
									case redisc:get(MsgKey) of 
										{ok,undefined} -> 
											ok;
										{ok, Msg} ->
											%% 如果获取到了广播消息 , 与通用 广播消息区分，用新的协议号 1026来发送
											PackageBin = tcp_package:package(?BROADCAST_MSG_V2_REPLY, Msg),
											self() ! {tcp_send, PackageBin};
										_ -> 
											ok			
									end;
								_ -> 
									ok
							end;
						TeacherId -> 
							%% 如果是学生登录, 并且与老师绑定 了上课关系 ，
							%% 检查是否在群控中
							?LOG("student login"),
							case ctrl_handler:is_group_control(TeacherId) of 
								true -> 
									?LOG("student login: is_group_control"),
									MsgKey = "msg@"++libfun:to_str(TeacherId),
									case redisc:get(MsgKey) of 
										{ok,undefined} -> 
											?LOG({"not send msg", MsgKey}),
											ok;
										{ok, Msg} ->
											?LOG({"send msg", Msg}),
											%% 如果获取到了广播消息 , 与通用 广播消息区分，用新的协议号 1026来发送
											PackageBin = tcp_package:package(?BROADCAST_MSG_V2_REPLY, Msg),
											
											Pid = table_client_list:get_client(Client, pid),
											Pid ! {tcp_send, PackageBin};
										_ -> 
											?LOG({"not send msg XX", MsgKey}),
											ok			
									end;
								_ ->
									?LOG("not send msg YY"),
									ok
							end
					end
			end, 
	
			%% 如果有人登录成功， 主动推送所有在线但没有上课的学生给客户端 
			SchoolId = school_id(UserId), 
			broadcast_to_teacher(SchoolId),
			%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

			NewState =  State#state{islogin = true, data = <<>>},
			handle_info({tcp, Socket, LastPackage}, NewState);
		{checkpass, false} -> 
			{stop, user_check_token_fail, State};
		_ ->
			% Transport:send(Socket, PackageBin),
			{noreply, State}
	end;
handle_info({tcp_closed, _Socket}, State) ->
	% io:format("~p:~p  tcp closed  !!!!!! ~n~n", [?MODULE, ?LINE]),
	?LOG(<<"tcp closed CLOSED!!!!!">>),
	{stop, normal, State};
handle_info({tcp_error, _, Reason}, State) ->
	{stop, Reason, State};
handle_info(timeout, State) ->
	{stop, normal, State};
handle_info({close_client_connect, Reason}, State) ->
	{stop, Reason, State};
handle_info(_Info, State) ->
	{stop, normal, State}.

handle_call(_Request, _From, State) ->
	{reply, ok, State}.

handle_cast(_Msg, State) ->
	{noreply, State}.

terminate(_Reason, #state{socket=Socket, transport= Transport, userid=UserId, token=Token}) ->
	?LOG({<<"connect closed, uid:">>, UserId}),
	case erlang:is_integer(UserId) andalso UserId > 0 of
		true -> 
			?LOG("close clean"),
			% inner logout
			{_, _, ProxyId} = rconf:read_config(proxy_server),
			InnerLogout = #'InnerLogout'{user_id = UserId, token = Token, proxy_id = ProxyId},
			Bin = inner_msg_proto:encode_msg(InnerLogout),
			PackageLogout = tcp_package:package(?INNER_CMD_LOGOUT, Bin),
			client_hub:send(PackageLogout),

			% 设置下线客户端 的状态 ，并保持 5 秒钟，
			case table_client_list:select(UserId, Token) of 
				[] -> 
					ok;
				[Client|_] ->
					StateKey = "userstate@"++libfun:to_str(UserId),
					StateVal = term_to_binary(Client),
					redisc:setex(StateKey, StateVal, 900),
					ok
			end,

			%% 检查是否为老师下线，
			client_timer:timer(UserId),
			
			table_client_list:delete(UserId, Token),

			SchoolId = school_id(UserId), 
			online_student:set_online_student(SchoolId),
			% 广播通知其它客户端，有人下线了
			offline_student:broadcast_to_other_client(SchoolId, UserId),

			%% 如果有人登录成功或下线， 主动推送所有在线但没有上课的学生给客户端
			broadcast_to_teacher(SchoolId),
			ok;
		_ ->	
			?LOG({"close clean ignore", UserId}),
			ok
	end,
	Transport:close(Socket),
	ok.

code_change(_OldVsn, State, _Extra) ->
	{ok, State}.


%% ====================================================================
%% Internal functions
%% ====================================================================
parse_package(Bin, State) ->
	case tcp_package:unpackage(Bin) of
		{ok, waitmore}  -> {ok, waitmore, Bin};
		{ok,{Type, ValueBin},LefBin} ->
			ctrl_handler:action(Type, ValueBin, State),
			parse_package(LefBin, State);
		_ ->
			error		
	end.


parse_package_login(Bin, State) ->
	case tcp_package:unpackage(Bin) of
		{ok, waitmore}  -> {ok, waitmore, Bin};
		{ok,{Type, ValueBin},LefBin} ->
			case ctrl_handler_login:action(Type, ValueBin, State) of
				{islogin, true, UserId, Token} ->
					{islogin, LefBin, UserId, Token};
				Reason -> 
					?LOG({"login error 111", Reason}),
					{error, stop}
			end;
		_ ->
			?LOG("login error 222"),
			{error, stop}		
	end.

school_id(UserId) ->
    Res = mysqlc:school_id(UserId),
    parse_school_id(Res).

parse_school_id({ok, []}) ->
    0;
parse_school_id({ok, [[{_, Id}|_]|_]}) ->
    Id;
parse_school_id(_) -> 
    0.

%% 如果有人登录成功或下线， 主动推送所有在线但没有上课的学生给客户端 
broadcast_to_teacher(SchoolId) -> 
	StudentList = table_client_list:select_free_student_by_school_id(SchoolId, 0),
	PbBin = ctrl_handler:online_student_reply(StudentList),
	PackageBin = tcp_package:package(?GET_ONLINE_FREE_STUDENT_REPLY, PbBin),

	%% 给老师广播消息
	case table_client_list:select_student_by_school_id(SchoolId, 1) of
		[] ->
			ok;
		Teachers -> 
			lists:foreach(fun(Teacher) -> 
				Pid = table_client_list:get_client(Teacher, pid),
				Pid ! {tcp_send, PackageBin}
			end, Teachers),
			ok
	end,
	ok.

