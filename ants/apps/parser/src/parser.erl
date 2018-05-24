-module(parser).
-compile(export_all).

-include("head.hrl").
% parse:go().


% CREATE TABLE `m_today` (
%   `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
%   `code` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'code',
%   `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
%   `category` set('normal','c300','c50') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'normal' COMMENT 'normal:普通，c300:沪深300, c50:上证50',
%   PRIMARY KEY (`id`)
% ) ENGINE=InnoDB AUTO_INCREMENT=2858 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='股票列表'

% CREATE TABLE `m_today` (
%   `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
%   `code` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'code',
%   `timer` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '字符串时间',
%   `timer_int` int(11) NOT NULL DEFAULT '0' COMMENT '时间截',
%   `price` float(10,3) NOT NULL DEFAULT '0.000' COMMENT '收盘价',
%   `current_relative_price` int(11) NOT NULL DEFAULT '0' COMMENT '当前相对价位',
%   `history_relative_price` varchar(800) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '历史相对价位',
%   PRIMARY KEY (`id`),
%   UNIQUE KEY `code_time` (`code`,`timer`)
% ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='m_today';


parse_list([], _) ->
    {error, "empty list"};
parse_list(List, Add) ->
    % ?LOG(<<"parse list">>),
    L1 = lists:keysort(3, List),
    % ?LOG(<<"parse list sort">>),
    [{_,_, First}|_] = L1,
    { _,_, Last} = lists:last(L1),
    % ?LOG({<<"first last: ">>, First, Last}),
    Cut = cut(First, Last, Add),

    L2 = lists:keysort(2, List),
    Current = lists:last(L2),
    % ?LOG(Current),
    {Current, current(Current, Cut), cut_list(Cut, List)}.


current({ _,_, Price} =  Current, [{N, Start, End}|T]) ->
    case Price >= Start andalso Price < End of
        true -> 
            N;
        _ -> 
            current(Current, T)
    end. 

cut_list(Cut, List) ->
    lists:foldl(fun({N, Start, End}, Res) ->
        [{N, Start, End, get_num(Start, End, List)}|Res]
    end, [], Cut).

get_num(Start, End, List) ->
    % ?LOG({Start, End}),
    lists:foldl(fun({ _, _, P}, N) ->
        case P >= Start andalso P < End of
            true ->
                N + 1;
            _ ->
                N
        end
    end, 0, List).

cut(Start, End, Add) ->
    cut(Start, End, 1, [], Add).

cut(Start, End, N, Reply, Add) ->
    case Start < End of
        true ->
            Start1 = Start + Start * Add,
            cut(Start1, End, N+1, [{N, three(Start), three(Start1)}|Reply], Add);
        _ ->
            Reply
    end.

% 精确到小数点后3位
three(Num) ->
    list_to_float(hd(io_lib:format("~.3f",[Num]))).


%  ==============================================================================

go_by_id() -> 
    go_by_id(<<"2296">>).
go_by_id(Id) ->
    Sql  = "select id, code_sina as code from m_gp_list_163 where id = ? limit 1",
    Res = mysql_poolboy:query(mysqlc:pool(), Sql, [Id]),
    ?LOG(Res),
    case parse_res(Res) of 
            {ok, []} -> 
                ok;
            {ok, List} ->
                lists:foreach(fun(Row) -> 
                    {_, Code} = lists:keyfind(<<"code">>, 1, Row),
                    % ?LOG(Code),
                    go(Code),
                    ok
                end, List)
    end, 
    ok.


go() -> 
    % go("sh601229").
    Sql  = "select * from m_gp_list",
    Res = mysql_poolboy:query(mysqlc:pool(), Sql, []),
    case parse_res(Res) of 
            {ok, []} -> 
                ok;
            {ok, List} ->
                lists:foreach(fun(Row) -> 
                    {_, Code} = lists:keyfind(<<"code">>, 1, Row),
                    % ?LOG(Code),
                    go(Code),
                    ok
                end, List)
    end, 
    ok.
go(Code) ->
    ?LOG(Code),
    % Sql = "SELECT code,name FROM m_gp_list where code = ?",
    % % Rows = mysql:get_assoc(Sql),
    % Res = mysql_poolboy:query(mysqlc:pool(), Sql, [FromCode]),
    % % ?LOG(Res),
    % case parse_res(Res) of 
    %         {ok, []} -> 
    %             ok;
    %         {ok, [Row]} -> 
    %                 {_, Code} = lists:keyfind(<<"code">>, 1, Row),
    %                 ?LOG(Code),
                    % <<_Head:16, C/binary>> = Code,
                    List = get_list_by_code(Code),
                    % ?LOG(List),
                    Add = 0.05,
                    case parse_list(List, Add) of 
                        {error, _} -> 
                            ok;
                        ParserRes -> 
                            % ?LOG(ParserRes),
                            add_today(ParserRes, Code),
                            ok
                    end,
                    ok.  
    % end,
    % % end, Rows),
    % ok.

% `code` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'code',
%   `timer` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '字符串时间',
%   `timer_int` int(11) NOT NULL DEFAULT '0' COMMENT '时间截',
%   `price` float(10,3) NOT NULL DEFAULT '0.000' COMMENT '收盘价',
%   `current_relative_price` int(11) NOT NULL DEFAULT '0' COMMENT '当前相对价位',
%   `history_relative_price` varchar(800) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '历史相对价位',


add_today({{Timer,_, Price}, CurrentRelativePrice , HistoryRelativePrice}, Code) -> 
    ?LOG({<<"add:">>, Code, Timer}),

    L = get_today_status(Code),
    {_, Open_price} = lists:keyfind(<<"open_price">>, 1, L),
    {_, Yesterday_close_price} = lists:keyfind(<<"yesterday_close_price">>, 1, L),
    {_, Close_price} = lists:keyfind(<<"close_price">>, 1, L),
    {_, Today_top_price} = lists:keyfind(<<"today_top_price">>, 1, L),
    {_, Today_bottom_price} = lists:keyfind(<<"today_bottom_price">>, 1, L),
    {_, Rise_and_fall_num} = lists:keyfind(<<"rise_and_fall_num">>, 1, L),
    {_, Rise_and_fall_percent} = lists:keyfind(<<"rise_and_fall_percent">>, 1, L),
    {_, Turnover_rate} = lists:keyfind(<<"turnover_rate">>, 1, L),
    {_, Volume} = lists:keyfind(<<"volume">>, 1, L),
    {_, Transaction_amount} = lists:keyfind(<<"transaction_amount">>, 1, L),

    History = lists:foldl(fun({Id, Start, End, Num}, Res) -> 
        [[{<<"id">>, Id}, {<<"start">>, Start}, {<<"end">>, End}, {<<"num">>, Num}]|Res]
    end, [], HistoryRelativePrice),
    % Sql = "replace into m_today (code, timer, timer_int, price, current_relative_price, history_relative_price) values (?, ?, ?, ?, ?, ?)",
    % Res = mysql_poolboy:query(mysqlc:pool(), Sql, [Code, Timer, 0, Price, CurrentRelativePrice, jsx:encode(History)]),
    Sql = "replace into m_today (code, timer, timer_int, price, current_relative_price, history_relative_price, open_price, yesterday_close_price, close_price, today_top_price, today_bottom_price, rise_and_fall_num, rise_and_fall_percent, turnover_rate, volume, transaction_amount) values (?, ?, ?, ?, ?, ?,  ?, ?, ?, ?, ?,  ?, ?, ?, ?, ?)",
    
    ?LOG({Open_price, Yesterday_close_price, Close_price, Today_top_price, Today_bottom_price, Rise_and_fall_num, Rise_and_fall_percent, Turnover_rate, Volume, Transaction_amount}),
    Res = mysql_poolboy:query(mysqlc:pool(), Sql, [Code, Timer, 0, Price, CurrentRelativePrice, jsx:encode(History), Open_price, Yesterday_close_price, Close_price, Today_top_price, Today_bottom_price, Rise_and_fall_num, Rise_and_fall_percent, Turnover_rate, Volume, Transaction_amount]),

    ?LOG(Res),
    % ?LOG(HistoryRelativePrice),
    ok.

% CREATE TABLE `m_today` (
%   `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
%   `code` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'code',
%   `timer` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '字符串时间',
%   `timer_int` int(11) NOT NULL DEFAULT '0' COMMENT '时间截',
%   `price` float(10,3) NOT NULL DEFAULT '0.000' COMMENT '收盘价',
%   `current_relative_price` int(11) NOT NULL DEFAULT '0' COMMENT '当前相对价位',
%   `history_relative_price` text COLLATE utf8_unicode_ci COMMENT '历史相对价位',
%   `open_price` float(10,3) NOT NULL DEFAULT '0.000' COMMENT '今日开盘价',
%   `yesterday_close_price` float(10,3) NOT NULL DEFAULT '0.000' COMMENT '昨日收盘价',
%   `close_price` float(10,3) NOT NULL DEFAULT '0.000' COMMENT '当前价格',
%   `today_top_price` float(10,3) NOT NULL DEFAULT '0.000' COMMENT '今日最高价',
%   `today_bottom_price` float(10,3) NOT NULL DEFAULT '0.000' COMMENT '今日最低价',
%   `rise_and_fall_num` float(10,3) NOT NULL DEFAULT '0.000' COMMENT '涨跌额',
%   `rise_and_fall_percent` float(10,4) NOT NULL DEFAULT '0.0000' COMMENT '涨跌幅',
%   `turnover_rate` float(10,4) NOT NULL DEFAULT '0.0000' COMMENT '换手率',
%   `volume` float(10,3) NOT NULL DEFAULT '0.000' COMMENT '成交量',
%   `transaction_amount` float(10,3) NOT NULL DEFAULT '0.000' COMMENT '成交金额',
%   PRIMARY KEY (`id`),
%   UNIQUE KEY `index_from_code` (`code`)
% ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='m_today'

% CREATE UNIQUE INDEX index_from_code ON m_all (from_code);

get_today_status(Code) ->
     Sql = "select * from m_all where from_code = ? and close_price > 0 order by timer_int desc limit 1",
    Res = mysql_poolboy:query(mysqlc:pool(), Sql, [Code]),
    case parse_res(Res) of 
            {ok, []} -> 
                ?LOG("null"),
                [];
            {ok, [L|_]} -> 
                    % ?LOG(List),
                    L
    end.     


get_list_by_code(Code) ->
    % Sql = "select timer, timer_int, close_price as price from m_all where from_code = ? and close_price > 0 order by timer_int desc",
    Sql = "select timer, timer_int, close_price as price from m_all where from_code = ? and close_price > 0 order by timer_int desc limit 260",

    Res = mysql_poolboy:query(mysqlc:pool(), Sql, [Code]),
    case parse_res(Res) of 
            {ok, []} -> 
                ?LOG("null"),
                [];
            {ok, List} -> 
                    % ?LOG(List),
                    get_list_by_code_tolist(List)
    end.

get_list_by_code_tolist(List) ->
    lists:foldl(fun(L, ReplyList) ->
        {_, Time} = lists:keyfind(<<"timer">>, 1, L),
        {_, TimeInt} = lists:keyfind(<<"timer_int">>, 1, L),
        {_, ClosePrice} = lists:keyfind(<<"price">>, 1, L),

        [{Time, TimeInt, ClosePrice}|ReplyList]
    end, [], List).


parse_res({ok, KeyList, DataList}) -> 
	RowList = lists:foldl(fun(Data, Res) -> 
		T = lists:zip(KeyList, Data),
		[T|Res]
	end, [], DataList),
	{ok, RowList};
parse_res(_Error) ->  
	{ok, []}.	