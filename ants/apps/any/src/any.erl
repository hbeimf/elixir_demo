-module(any).
-compile(export_all).

% http://blog.sina.com.cn/s/blog_510844b70102wrvf.html
% http://hq.sinajs.cn/list=sh601006

% http://hq.sinajs.cn/list=s_sh000001,s_sz399001
% http://hq.sinajs.cn/list=sh601003,sh601001
url() -> 
	"http://hq.sinajs.cn/list=".	

% test() -> 
% 	get_data(<<"sh601006">>),
% 	% io:format("mod:~p, line: ~p~n ~p~n", [?MODULE, ?LINE, R]).
% 	ok.

test()->
	% List = [<<"sh601003">>, <<"sh601001">>],
	List = [<<"sz200024">>,<<"sz200025">>,<<"sz200026">>,<<"sz200028">>,<<"sz200029">>,
  <<"sz200030">>,<<"sz200037">>,<<"sz200045">>,<<"sz200053">>,<<"sz200054">>],
	 get_datas(List),
	ok.


run() -> 
	GroupCodeList = code(),
	lists:foreach(fun(Group) -> 
		% io:format("mod:~p, line: ~p~n ~p~n", [?MODULE, ?LINE, Group]),
		get_datas(Group)	
	end, GroupCodeList).

code() -> 
	CodeList = code_list(),
	split_code(CodeList, [], 100).

split_code([], Res, _Size) ->
	Res;
split_code(CodeList, Res, Size) when erlang:length(CodeList) > Size ->
	{List2, List3} = lists:split(Size, CodeList),
	split_code(List3, [List2|Res], Size);
split_code(CodeList, Res, _Size) ->
	[CodeList|Res]. 


code_list() -> 
	Sql = "SELECT code FROM m_gp_list",
	Res = mysql_poolboy:query(mysqlc:pool(), Sql, []),
	case parse_res(Res) of 
		{ok, []} ->
			[];
		{ok, List} -> 
			lists:foldl(fun(L, Reply) ->
				{_, {_, Code}, _} = lists:keytake(<<"code">>, 1, L),
				[Code|Reply]
			end, [], List)
	end. 

parse_res({ok, KeyList, DataList}) -> 
	RowList = lists:foldl(fun(Data, Res) -> 
		T = lists:zip(KeyList, Data),
		[T|Res]
	end, [], DataList),
	{ok, RowList};
parse_res(_Error) ->  
	{ok, []}.	


% split(N, List1) -> {List2, List3}

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
	% lists:foreach(fun(B) -> 
	% 	one_body(B)
	% end, BodyList),

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



% -- 1：”27.55″，今日开盘价；
% -- 2：”27.25″，昨日收盘价；
% -- 3：”26.91″，当前价格；
% -- 4：”27.55″，今日最高价；
% -- 5：”26.20″，今日最低价；


% get_data(Code) -> 
% 	Url = lists:concat([url(), glib:to_str(Code)]),
% 	case glib:http_get(Url) of
% 		<<"">> ->
% 			ok;
% 		Body ->
% 			one_body(Body)
% 	end.

% one_body(Body) -> 
% 	Str = glib:trim(glib:to_str(Body)),
% 	[V, List|_] = glib:explode(Str, "="),
% 	[_|Fileds] = glib:explode(List, ","),
% 	Code = get_code(V),
% 	Time = get_time(Fileds),
% 	[Today_open_price, Yesterday_closing_price, Current_price, Today_top_price, Today_bottom_price|_] = Fileds,

% 	% io:format("mod:~p, line: ~p~n ~p~n", [?MODULE, ?LINE, 
% 	% 	{Code, Time, Today_open_price, Yesterday_closing_price, Current_price, Today_top_price, Today_bottom_price, glib:implode(Fileds, ", ")}]),


% 	% today_open_price
% 	TheTime = glib:time(),
% 	SqlInsert = "INSERT IGNORE INTO m_history (code, timer, open_price, yesterday_closing_price, current_price, today_top_price, today_bottom_price, original_str, created_at, updated_at) VALUES (?,?,?,?,?,?,?,?,?,?)",
% 	ParamsList = [glib:to_binary(Code), 
% 		glib:to_binary(Time), 
% 		glib:to_binary(Today_open_price), 
% 		glib:to_binary(Yesterday_closing_price), 
% 		glib:to_binary(Current_price), 
% 		glib:to_binary(Today_top_price), 
% 		glib:to_binary(Today_bottom_price),
% 		glib:to_binary(glib:implode(Fileds, ", ")),
% 		TheTime, TheTime],
		
% 	R = mysql_poolboy:query(mysqlc:pool(), SqlInsert, ParamsList),

% 	io:format("mod:~p, line: ~p~n ~p~n", [?MODULE, ?LINE, {ParamsList, R}]),

% 	ok.


