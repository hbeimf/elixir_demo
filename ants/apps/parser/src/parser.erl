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
    L1 = lists:keysort(3, List),

    [{_, _, First}|_] = L1,
    {_, _, Last} = lists:last(L1),

    Cut = cut(First, Last, Add),

    L2 = lists:keysort(1, List),
    Current = lists:last(L2),
    ?LOG(Current),
    {Current, current(Current, Cut), cut_list(Cut, List)}.


current({_, _, Price} =  Current, [{N, Start, End}|T]) ->
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
    lists:foldl(fun({_, _, P}, N) ->
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

go() -> 
    go("sh601229").
go(FromCode) ->
    Sql = "SELECT code,name FROM m_gp_list where code = ?",
    % Rows = mysql:get_assoc(Sql),
    Res = mysql_poolboy:query(mysqlc:pool(), Sql, [FromCode]),
    case parse_res(Res) of 
            {ok, []} -> 
                ok;
            {ok, [Row]} -> 
                    {_, Code} = lists:keyfind(<<"code">>, 1, Row),
                    ?LOG(Code),
                    <<_Head:16, C/binary>> = Code,
                    List = get_list_by_code(C),
                    % ?LOG(List),
                    Add = 0.05,
                    ParserRes = parse_list(List, Add),
                    ?LOG(ParserRes),
                    % add_today(ParserRes),
                    ok
    end,
    % end, Rows),
    ok.


% add_today({{TimerInt, Timer, Price}, CurrentRelativePrice , HistoryRelativePrice}) -> 

%     ok.




get_list_by_code(Code) ->
    Sql = "select timer,timer_int, price from m_all where code = ?",
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

        [{TimeInt, Time, ClosePrice}|ReplyList]
    end, [], List).


parse_res({ok, KeyList, DataList}) -> 
	RowList = lists:foldl(fun(Data, Res) -> 
		T = lists:zip(KeyList, Data),
		[T|Res]
	end, [], DataList),
	{ok, RowList};
parse_res(_Error) ->  
	{ok, []}.	