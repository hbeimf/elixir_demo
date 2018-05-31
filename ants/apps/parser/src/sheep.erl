-module(sheep).
-compile(export_all).

-include("head.hrl").


test() -> 
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

go(Code) ->
    	% ?LOG(Code),
	P = get_p(Code),
	?LOG({Code, glib:three(P)}),
	% Add = 0.05,
	% case parse_list(List, Add) of 
	%     {error, _} -> 
	%         ok;
	%     ParserRes -> 
	%         % ?LOG(ParserRes),
	%         add_today(ParserRes, Code),
	%         ok
	% end,
	ok.  


get_p(Code) ->
    % Sql = "select timer, timer_int, close_price as price from m_all where from_code = ? and close_price > 0 order by timer_int desc",
    % Sql = "select timer, timer_int, close_price as price, rise_and_fall_percent from m_all where from_code = ? and close_price > 0 order by timer_int desc limit 260",
    Sql = "select rise_and_fall_percent from m_all where from_code = ? and close_price > 0 order by timer_int desc limit 10",

    Res = mysql_poolboy:query(mysqlc:pool(), Sql, [Code]),
    case parse_res(Res) of 
            {ok, []} -> 
                ?LOG("null"),
                0;
            {ok, List} -> 
                    % ?LOG(List),
                    get_list_by_code_tolist(List)
    end.

get_list_by_code_tolist(List) ->
    lists:foldl(fun(L, SumP) ->
        % {_, Time} = lists:keyfind(<<"timer">>, 1, L),
        % {_, TimeInt} = lists:keyfind(<<"timer_int">>, 1, L),
        % {_, ClosePrice} = lists:keyfind(<<"price">>, 1, L),
        {_, RiseAndFallPercent} = lists:keyfind(<<"rise_and_fall_percent">>, 1, L),

        % [{Time, TimeInt, RiseAndFallPercent}|ReplyList]
        SumP + RiseAndFallPercent
    end, 0, List).


parse_res({ok, KeyList, DataList}) -> 
	RowList = lists:foldl(fun(Data, Res) -> 
		T = lists:zip(KeyList, Data),
		[T|Res]
	end, [], DataList),
	{ok, RowList};
parse_res(_Error) ->  
	{ok, []}.	






