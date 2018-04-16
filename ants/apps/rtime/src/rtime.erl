-module(rtime).
-compile(export_all).


run(CodeList) -> 
	{ok, Pid} = rtime_save_sup:start_child(),
	Cmd = {save, CodeList},
	rtime_save_server:cmd(Pid, Cmd),
	ok.


run() -> 
	GroupCodeList = code(),
	lists:foreach(fun(Group) -> 
		% io:format("mod:~p, line: ~p~n ~p~n", [?MODULE, ?LINE, Group]),
		% get_datas(Group)
		run(Group)	
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

	