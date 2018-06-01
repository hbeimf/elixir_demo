-module(gap).
-compile(export_all).

-include("head.hrl").



% test() ->
%     go_by_id(<<"435">>).
% go_by_id(Id) ->
%     Sql  = "select id, code_sina as code from m_gp_list_163 where id = ? limit 1",
%     Res = mysql_poolboy:query(mysqlc:pool(), Sql, [Id]),
%     ?LOG(Res),
%     case parse_res(Res) of
%             {ok, []} ->
%                 ok;
%             {ok, List} ->
%                 lists:foreach(fun(Row) ->
%                     {_, Code} = lists:keyfind(<<"code">>, 1, Row),
%                     % ?LOG(Code),
%                     go(Code),
%                     ok
%                 end, List)
%     end,
%     ok.

go() ->
	go(200).
go(Days) ->
	go(Days, 3).
go(Days, Point) ->
	go(<<"sz000963">>, Days, Point).
go(Code, Days, Point) ->
	% ?LOG(Code),
	List = get_list_by_code(Code, Days),
	% ?LOG(List),
	%% 持续波动区间
	% GapGroup = gap(List),
	% print_gap(Code, GapGroup),
	% %% 出现的次数
	% print_point(List, Point),
	% print_point(List, -1 * Point),
	%% 后续进展
	?LOG("============================================================="),
	print_group_point(List, -1 * Point),
	?LOG("+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"),
	print_group_point(List, Point),

	ok.


%% 分组，按点数来分组
print_group_point([], _) ->
	ok;
print_group_point(List, Point) ->
	Gs = lists:foldr(fun(T, Reply) ->
		group_point(T, Reply, Point)
	end, [], List),
	% ?LOG(G),
	lists:foreach(fun(G) -> 
		G1 = lists:reverse(G),
		?LOG(G1),
		ok
	end, lists:reverse(Gs)),
% 	ok;
% print_group_point(List, Point) ->

	ok.

group_point({_, _, P1, _} = T, [], Point) ->
	% case P1 =< Point of 
	% 	true -> 
	% 		[[T]];
	% 	_ -> 
	% 		[]
	% end;
	[[T]];
group_point({_, _, P1, _} = T, Group, Point) when Point < 0 ->
	[LastGroup|OtherGroup] = Group,
	case P1 =< Point of
		false ->
			% case erlang:length(LastGroup) > 10 of 
			% 	true -> 
			% 		Group;
			% 	_ -> 
			% 		[[T|LastGroup]|OtherGroup]
			% end;

			[[T|LastGroup]|OtherGroup];
		_ ->
			[[T]|Group]
	end;
group_point({_, _, P1, _} = T, Group, Point) ->
	[LastGroup|OtherGroup] = Group,
	case P1 >= Point of
		false ->
			% case erlang:length(LastGroup) > 10 of 
			% 	true -> 
			% 		Group;
			% 	_ -> 
			% 		[[T|LastGroup]|OtherGroup]
			% end;

			[[T|LastGroup]|OtherGroup];
		_ ->
			[[T]|Group]
	end.



print_point([], _) ->
	ok;
print_point(List, Val) when Val < 0 ->
	R = lists:foldl(fun({_, _, P}, Reply) ->
		case P < Val of
			true ->
				Reply+1;
			_ ->
				Reply
		end
	end, 0, List),
	?LOG({Val, R}),

	ok;
print_point(List, Val) ->
	R = lists:foldl(fun({_, _, P}, Reply) ->
		case P > Val of
			true ->
				Reply+1;
			_ ->
				Reply
		end
	end, 0, List),
	?LOG({Val, R}),
	ok.



%% 分组，按正或负来分组gap
%%打印连续的gap之和
print_gap(_, []) ->
	ok;
print_gap(_Code, Gaps) ->
	R = lists:foldl(fun(Gap, Reply) ->
		[sum(Gap)|Reply]
	end, [], Gaps),
	?LOG(lists:sort(R)),
	ok.

sum(Gap) ->
	Sum = lists:foldl(fun({_, _, V}, S) ->
		S+V
	end, 0, Gap),
	glib:to_float(glib:three(Sum)).

gap([]) ->
	[];
gap(List) ->
	lists:foldl(fun(T, Gap) ->
		gap(Gap, T)
	end, [], List).

gap([], T) ->
	[[T]];
gap(Gap, {_, _, P} = T) ->
	[LastGap|OtherGap] = Gap,
	[{_, _, P1}|_] = LastGap,
	S = P * P1,
	case S > 0 of
		true ->
			[[T|LastGap]|OtherGap];

		_ ->
			[[T]|Gap]
	end.

get_list_by_code(Code, Days) ->
    % Sql = "select timer, timer_int, close_price as price from m_all where from_code = ? and close_price > 0 order by timer_int desc",
    Sql = "select timer, timer_int, rise_and_fall_percent as p, close_price as price from m_all where from_code = ? and close_price > 0 order by timer_int desc limit ?",

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
        {_, Time} = lists:keyfind(<<"timer">>, 1, L),
        {_, TimeInt} = lists:keyfind(<<"timer_int">>, 1, L),
        {_, RiseAndFallPercent} = lists:keyfind(<<"p">>, 1, L),
        {_, ClosePrice} = lists:keyfind(<<"price">>, 1, L),

        [{Time, TimeInt, RiseAndFallPercent, ClosePrice}|ReplyList]
    end, [], List).


parse_res({ok, KeyList, DataList}) ->
	RowList = lists:foldl(fun(Data, Res) ->
		T = lists:zip(KeyList, Data),
		[T|Res]
	end, [], DataList),
	{ok, RowList};
parse_res(_Error) ->
	{ok, []}.














