-module(rtime_save_server).

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

% --------------------------------------------------------------------
% External API
% --------------------------------------------------------------------
-export([cmd/2]).
cmd(Pid, Cmd) ->
    gen_server:cast(Pid, {cmd, Cmd}).

% start_link() ->
%     gen_server:start_link({local, ?MODULE}, ?MODULE, [], []).

start_link() ->
    gen_server:start_link(?MODULE, [], []).


% --------------------------------------------------------------------
% Function: init/1
% Description: Initiates the server
% Returns: {ok, State}          |
%          {ok, State, Timeout} |
%          ignore               |
%          {stop, Reason}
% --------------------------------------------------------------------
init([]) ->
	 _TRef = erlang:send_after(1000, self(), save),
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
handle_cast({cmd, {save, CodeList}}, _State) ->
	NewState = CodeList,
	{noreply, NewState};
handle_cast(_Msg, State) ->
    {noreply, State}.

% --------------------------------------------------------------------
% Function: handle_info/2
% Description: Handling all non call/cast messages
% Returns: {noreply, State}          |
%          {noreply, State, Timeout} |
%          {stop, Reason, State}            (terminate/2 is called)
% --------------------------------------------------------------------
handle_info(save, State) ->
    % io:format("update  ================== ~n~p~n", [State]),
    % 计时器，任务自动运行

    % {{_Year, _Mon, _Day},{Hour, Min, Seconds}} = glib:timestamp_to_datetime(glib:time()),

    % io:format("update  ================== ~n~p~n", [Date]),
    % run(Hour, Min, Seconds),

    get_datas(State),
    _TRef = erlang:send_after(500, self(), save),
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


% http://blog.sina.com.cn/s/blog_510844b70102wrvf.html
% http://hq.sinajs.cn/list=sh601006

% http://hq.sinajs.cn/list=s_sh000001,s_sz399001
% http://hq.sinajs.cn/list=sh601003,sh601001
url() -> 
	"http://hq.sinajs.cn/list=".	

get_datas([]) -> 
	ok;
get_datas(List) -> 
	List1 = lists:map(fun(Code) -> 
		glib:to_str(Code)
	end, List),
	S = glib:implode(List1, ","),
	Url = lists:concat([url(), S]),
	% io:format("mod:~p, line: ~p~n ~p~n", [?MODULE, ?LINE, Url]),
	case glib:http_get(Url) of
		<<"">> ->
			ok;
		Body ->
			body(Body)
	end.

body(Body) -> 
	% io:format("mod:~p, line: ~p~n ~p~n", [?MODULE, ?LINE, Body]),
	BodyStr = glib:to_str(Body),
	BodyList = glib:explode(BodyStr, "\n"),

	SqlInsert = "INSERT IGNORE INTO m_history (code, timer, open_price, yesterday_closing_price, current_price, today_top_price, today_bottom_price, original_str, created_at, updated_at) VALUES ",
	
	R = lists:foldl(fun(B, Reply) ->
		% Val = values(B), 
		case values(B) of 
			{ok, Val} ->
				[Val|Reply];
			_ -> 
				Reply
		end
	end, [], BodyList),

	SqlInsert1 = SqlInsert ++ glib:implode(R, ", "),
	io:format("mod:~p, line: ~p~n ~p~n", [?MODULE, ?LINE, SqlInsert1]),

	R1 = mysql_poolboy:query(mysqlc:pool(), SqlInsert1, []),

	io:format("mod:~p, line: ~p~n ~p~n", [?MODULE, ?LINE, R1]),

	ok.

values(Body) ->
	Str = glib:trim(glib:to_str(Body)),
	[V, List|_] = glib:explode(Str, "="),
	% io:format("mod:~p, line: ~p~n ~p~n", [?MODULE, ?LINE, List]),

	case glib:has_str(List, ",") of
		true ->  
			[_|Fileds] = glib:explode(List, ","),
			Code = get_code(V),
			Time = get_time(Fileds),
			TheTime = glib:time(),
			[Today_open_price, Yesterday_closing_price, Current_price, Today_top_price, Today_bottom_price|_] = Fileds,
			{ok, lists:concat(["('",
				glib:to_str(Code),"', '", 
				glib:to_str(Time), "', ",
				glib:to_str(Today_open_price), ", ",
				glib:to_str(Yesterday_closing_price), ", ",
				glib:to_str(Current_price), ", ",
				glib:to_str(Today_top_price), ", ",
				glib:to_str(Today_bottom_price),", '",
				glib:to_str(glib:implode(Fileds, ", ")),"', ",
				TheTime, ", ", 
				TheTime,
				")"])};
		_ -> 
			error
	end.


get_time(FieldList) -> 
	[Y, T|_] = lists:nthtail(erlang:length(FieldList) - 3, FieldList),
	lists:concat([Y, " ", T]).

get_code(Str) -> 
	List = glib:explode(Str, "_"),
	lists:last(List).








