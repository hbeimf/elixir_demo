-module(table_create).
-compile(export_all).

-include_lib("stdlib/include/qlc.hrl").
%% 定义记录结构

-include("table.hrl").
-include_lib("ws_server/include/log.hrl").

-define(WAIT_FOR_TABLES, 10000).

%% 初始化mnesia表结构
init() ->
	% % ?LOG1({create_table, node()}),
	% Node = glib:to_str(node()),
	% % ?LOG1({create_table, Node}),

	% [NodeName|_] = glib:explode(Node, "@"),
	% % ?LOG1({create_table, NodeName}),

	CurrentNode = node(),
	MasterNode = get_master_node(),
	?LOG1({CurrentNode, MasterNode}),

	case CurrentNode =:= MasterNode of 
		true -> 
			?LOG1("master node"),

			% MasterNode = get_master_node(),
			% ?LOG1({"slave node", MasterNode}),

			init_master();
		_ ->
			?LOG1("slave node"),
			MasterNode = get_master_node(),
			?LOG1({"slave node", MasterNode}),
			
			net_adm:ping(MasterNode),
			init_slave(),
			ok
	end.


get_master_node() ->
	case  sys_config:get_config(node) of
        {ok, Node} -> 
            {_, {master, Master}, _} = lists:keytake(master, 1, Node),
            Master;
        _ -> 
            ok
    end.


init_slave() ->
	?LOG1({"init_slave"}),
	MasterNode = get_master_node(),
	mnesia:start(),

	case mnesia:change_config(extra_db_nodes, [MasterNode]) of
        {ok, [MasterNode]} ->
        	?LOG1({"init_slave"}),
            Res1 = mnesia:add_table_copy(client_list, node(), ram_copies),
            Res2 = mnesia:add_table_copy(game_server_list, node(), ram_copies),
            Res3 = mnesia:add_table_copy(forbidden_ip, node(), ram_copies),

            ?LOG1({Res1, Res2, Res3}),

            Tables = mnesia:system_info(tables),
            mnesia:wait_for_tables(Tables, ?WAIT_FOR_TABLES);
        Any ->
        	?LOG1({"init_slave", Any}),
            ok
    end,
	ok.


init_master() ->
	case mnesia:create_schema([node()]) of
		ok -> 
		    mnesia:start(),
		    % mnesia:create_table(client_list, [{type, bag}, {attributes,record_info(fields,client_list)}]),
		    mnesia:create_table(client_list, [{attributes,record_info(fields,client_list)}]),
		    mnesia:create_table(game_server_list, [{attributes,record_info(fields,game_server_list)}]),
		    mnesia:create_table(forbidden_ip, [{attributes,record_info(fields,forbidden_ip)}]),
		    ok;
	  _ -> 
	  	mnesia:start()
	 end.



