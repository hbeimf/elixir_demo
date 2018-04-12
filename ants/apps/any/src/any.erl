-module(any).
-compile(export_all).

% http://blog.sina.com.cn/s/blog_510844b70102wrvf.html
% http://hq.sinajs.cn/list=sh601006

% http://hq.sinajs.cn/list=s_sh000001,s_sz399001
% http://hq.sinajs.cn/list=sh601003,sh601001
url() -> 
	"http://hq.sinajs.cn/list=".	

test() -> 
	get_data(<<"sh601006">>),
	% io:format("mod:~p, line: ~p~n ~p~n", [?MODULE, ?LINE, R]).
	ok.

test1()->
	List = [<<"sh601003">>, <<"sh601001">>],
	 get_datas(List),
	ok.




get_datas([]) -> 
	ok;
get_datas(List) -> 
	List1 = lists:map(fun(Code) -> 
		glib:to_str(Code)
	end, List),
	S = glib:implode(List1, ","),
	Url = lists:concat([url(), S]),
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
	lists:foreach(fun(B) -> 
		one_body(B)
	end, BodyList),
	ok.

% -- 1：”27.55″，今日开盘价；
% -- 2：”27.25″，昨日收盘价；
% -- 3：”26.91″，当前价格；
% -- 4：”27.55″，今日最高价；
% -- 5：”26.20″，今日最低价；

% CREATE TABLE `m_history` (
%   `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
%   `code` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'code',
%   `timer` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '字符串时间',
%   ` today_open_price` float(10,4) NOT NULL DEFAULT '0.0000' COMMENT '今日开盘价',
%   `yesterday_closing_price` float(10,4) NOT NULL DEFAULT '0.0000' COMMENT '昨日收盘价',
%   ` current_price` float(10,4) NOT NULL DEFAULT '0.0000' COMMENT '当前价格',
%   ` today_top_price` float(10,4) NOT NULL DEFAULT '0.0000' COMMENT '今日最高价',
%   ` today_bottom_price` float(10,4) NOT NULL DEFAULT '0.0000' COMMENT '今日最低价',
%   `original_str` varchar(300) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '原始内容',
%   `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
%   `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
%   PRIMARY KEY (`id`),
%   UNIQUE KEY `code_time` (`code`,`timer`)
% ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='history'
% today_open_price

get_data(Code) -> 
	Url = lists:concat([url(), glib:to_str(Code)]),
	case glib:http_get(Url) of
		<<"">> ->
			ok;
		Body ->
			one_body(Body)
	end.

one_body(Body) -> 
	Str = glib:trim(glib:to_str(Body)),
	[V, List|_] = glib:explode(Str, "="),
	[_|Fileds] = glib:explode(List, ","),
	Code = get_code(V),
	Time = get_time(Fileds),
	[Today_open_price, Yesterday_closing_price, Current_price, Today_top_price, Today_bottom_price|_] = Fileds,

	% io:format("mod:~p, line: ~p~n ~p~n", [?MODULE, ?LINE, 
	% 	{Code, Time, Today_open_price, Yesterday_closing_price, Current_price, Today_top_price, Today_bottom_price, glib:implode(Fileds, ", ")}]),


	% today_open_price
	TheTime = glib:time(),
	SqlInsert = "INSERT IGNORE INTO m_history (code, timer, open_price, yesterday_closing_price, current_price, today_top_price, today_bottom_price, original_str, created_at, updated_at) VALUES (?,?,?,?,?,?,?,?,?,?)",
	ParamsList = [glib:to_binary(Code), 
		glib:to_binary(Time), 
		glib:to_binary(Today_open_price), 
		glib:to_binary(Yesterday_closing_price), 
		glib:to_binary(Current_price), 
		glib:to_binary(Today_top_price), 
		glib:to_binary(Today_bottom_price),
		glib:to_binary(glib:implode(Fileds, ", ")),
		TheTime, TheTime],
		
	R = mysql_poolboy:query(mysqlc:pool(), SqlInsert, ParamsList),

	io:format("mod:~p, line: ~p~n ~p~n", [?MODULE, ?LINE, {ParamsList, R}]),

	ok.

get_time(FieldList) -> 
	[Y, T|_] = lists:nthtail(erlang:length(FieldList) - 3, FieldList),
	lists:concat([Y, " ", T]).

get_code(Str) -> 
	List = glib:explode(Str, "_"),
	lists:last(List).

