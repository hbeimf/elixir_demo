-module(gg).
-compile(export_all).

-include("head.hrl").

go() ->
	go(200).
go(Days) ->
	go(Days, 3).
go(Days, Point) ->
	go(<<"sz000963">>, Days, Point).
go(Code, Days, Point) ->
	List = get_list_by_code(Code, Days),
	Groups = make_group(List),
	print_group(Groups),
	ok.

print_group([]) -> 
	ok;
print_group(Groups) -> 
	lists:foreach(fun(G) -> 
		G1 = lists:reverse(G),
		?LOG(G1),
		ok
	end, lists:reverse(Groups)),
	ok.

make_group([]) -> 
	[];
make_group(MapList) ->
	lists:foldr(fun(Map, Reply) -> 
		#{
			<<"close_price">> := Close_price,
			<<"rise_and_fall_percent">> := Rise_and_fall_percent,
			<<"timer">> := Timer,
			<<"timer_int">> := Timer_int,
			<<"today_bottom_price">> := Today_bottom_price,
			<<"today_top_price">> := Today_top_price,
			<<"yesterday_close_price">> := Yesterday_close_price
		} = Map,

		case group_check(Today_bottom_price, Today_top_price, Yesterday_close_price) of 
			{true, Abs} ->
				Map1 = Map#{ <<"abs">> => Abs },
				[[Map1]|Reply];
			{_, Abs} -> 
				Map1 = Map#{ <<"abs">> => Abs },
				case Reply of 
					[] -> 
						[[Map1]|Reply];
					_ -> 	
						[LastGroup|OtherGroup] = Reply,
						[[Map1|LastGroup]|OtherGroup]
				end
		end
	end, [], MapList).

group_check(Today_bottom_price, Today_top_price, Yesterday_close_price) ->
	Abs1 = (Today_bottom_price - Yesterday_close_price) / Yesterday_close_price,
	Abs2 = (Today_top_price - Yesterday_close_price) / Yesterday_close_price,
	Abs = Abs2 - Abs1,
	case Abs > 0.06 of 
		true -> 
			{true, Abs};
		_ -> 
			{false, Abs}
	end.

get_list_by_code(Code, Days) ->
    Sql = "select 
    		timer, timer_int, rise_and_fall_percent, yesterday_close_price, close_price, today_top_price, today_bottom_price
    	from 
    		m_all 
    	where 
    		from_code = ? and close_price > 0 order by timer_int desc limit ?",

    Res = mysql_poolboy:query(mysqlc:pool(), Sql, [Code, Days]),
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
        % {_, Time} = lists:keyfind(<<"timer">>, 1, L),
        % {_, TimeInt} = lists:keyfind(<<"timer_int">>, 1, L),
        % {_, RiseAndFallPercent} = lists:keyfind(<<"p">>, 1, L),
        % {_, ClosePrice} = lists:keyfind(<<"price">>, 1, L),

        MapRow = maps:from_list(L),
        [MapRow|ReplyList]
    end, [], List).


parse_res({ok, KeyList, DataList}) ->
	RowList = lists:foldl(fun(Data, Res) ->
		T = lists:zip(KeyList, Data),
		[T|Res]
	end, [], DataList),
	{ok, RowList};
parse_res(_Error) ->
	{ok, []}.














