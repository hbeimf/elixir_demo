-module(client_timer).
-include("state.hrl").
%% gen_server代码模板

% -module(workboy_server).

-behaviour(gen_server).
% --------------------------------------------------------------------
% Include files
% --------------------------------------------------------------------

% --------------------------------------------------------------------
% External exports
% --------------------------------------------------------------------
-export([]).

% gen_server callbacks
-export([start_link/0]).
-export([init/1, handle_call/3, handle_cast/2, handle_info/2, terminate/2, code_change/3]).

% -record(state, {}).
% download
% rest
% analyse

% --------------------------------------------------------------------
% External API
% --------------------------------------------------------------------
-export([timer/1]).
timer(Uid) ->
	case table_client_list:select(Uid) of
		[] ->
			ok;
		[Client|_] -> 
			case table_client_list:get_client(Client, role_id) of
				1 -> 
					%% 如果发现是老师，则启动计时器
					gen_server:cast(?MODULE, {timer, Uid});
				_ -> 
					ok
			end	
	end.
    
start_link() ->
    gen_server:start_link({local, ?MODULE}, ?MODULE, [], []).

% start_link() ->
%     gen_server:start_link(?MODULE, [], []).


% --------------------------------------------------------------------
% Function: init/1
% Description: Initiates the server
% Returns: {ok, State}          |
%          {ok, State, Timeout} |
%          ignore               |
%          {stop, Reason}
% --------------------------------------------------------------------
init([]) ->
	 % _TRef = erlang:send_after(1000, self(), save),
    {ok, []}.

% --------------------------------------------------------------------
% Function: handle_call/3
% Description: Handling call messages
% Returns: {reply, Reply, State}          |
%          {reply, Reply, State, Timeout} |
%          {noreply, State}               |
%          {noreply, State, Timeout}      |
%          {stop, Reason, Reply, State}   | (terminate/2 is called)
%          {stop, Reason, State}            (terminate/2 is called)
% --------------------------------------------------------------------
handle_call(_Request, _From, State) ->
    Reply = ok,
    {reply, Reply, State}.

% --------------------------------------------------------------------
% Function: handle_cast/2
% Description: Handling cast messages
% Returns: {noreply, State}          |
%          {noreply, State, Timeout} |
%          {stop, Reason, State}            (terminate/2 is called)
% --------------------------------------------------------------------
handle_cast({timer, Uid}, State) ->
	% NewState = CodeList,
	% 15分钟后发送定时器 检查老师是否上线，
	 _TRef = erlang:send_after(900000, self(), {unbind, Uid}),
	 ?LOG("logout , set timer !!"),
	{noreply, State};
handle_cast(_Msg, State) ->
    {noreply, State}.

% --------------------------------------------------------------------
% Function: handle_info/2
% Description: Handling all non call/cast messages
% Returns: {noreply, State}          |
%          {noreply, State, Timeout} |
%          {stop, Reason, State}            (terminate/2 is called)
% --------------------------------------------------------------------
handle_info({unbind, Uid}, State) ->
	?LOG({"logout, on timer msg,  unbind, teacher uid: ", Uid}),
	case table_client_list:select(Uid) of
		[] ->
			%% 老师在规定 的时间 内未登录 ，解除与学生上课的绑定 关系 
			case table_client_list:select_by_teacher_id(Uid) of 
				[] -> 
					ok;
				StudentList -> 
					lists:foreach(fun(Student) -> 
						UserId = table_client_list:get_client(Student, userid),
						?LOG({"unbind, uid: ", UserId}),
						table_client_list:update(UserId, teacher_id, 0)
					end, StudentList),
					ok
			end,
			ok;
		_ -> 
			ok
	end,
    {noreply, State};
handle_info(_Info, State) ->
    {noreply, State}.

% --------------------------------------------------------------------
% Function: terminate/2
% Description: Shutdown the server
% Returns: any (ignored by gen_server)
% --------------------------------------------------------------------
terminate(_Reason, _State) ->
    ok.

% --------------------------------------------------------------------
% Func: code_change/3
% Purpose: Convert process state when code is changed
% Returns: {ok, NewState}
% --------------------------------------------------------------------
code_change(_OldVsn, State, _Extra) ->
    {ok, State}.


% private functions







