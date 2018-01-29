-module(table_create).
-compile(export_all).

-include_lib("stdlib/include/qlc.hrl").
%% 定义记录结构

-include("table.hrl").

-define(WAIT_FOR_TABLES, 50000).

%% 初始化mnesia表结构
init() -> 
	dynamic_db_init(is_first_node()).

% 如果是第一个启动的节点
dynamic_db_init(true) ->
	mnesia:stop(),
	mnesia:delete_schema([node()]),
    	case mnesia:create_schema([node()]) of
    		ok -> 
			    mnesia:start(),
			    mnesia:create_table(client_list, [{attributes,record_info(fields,client_list)}]),
			    mnesia:create_table(proxy_server_list, [{attributes,record_info(fields,proxy_server_list)}]),
			    
			    ok;
		  _ -> 
		  	mnesia:start()
	 end;
% 从结点启动
dynamic_db_init(_) ->
	[MasterNode|_] = erlang:nodes(),
	net_adm:ping(MasterNode),
	case mnesia:change_config(extra_db_nodes, [MasterNode]) of
	    {ok, [MasterNode]} ->
	        % 复制 表
	        mnesia:add_table_copy(client_list, node(), ram_copies),
	        mnesia:add_table_copy(proxy_server_list, node(), ram_copies),

	        Tables = mnesia:system_info(tables),
	        mnesia:wait_for_tables(Tables, ?WAIT_FOR_TABLES);
	    _ ->
	        ok
	end.


% private function  =======================================
% table_create:is_first_node().
is_first_node() -> 
	case erlang:length(erlang:nodes()) > 0 of 
		true -> 
			false;
		_ -> 
			{ok, NodeList} = sys_config:get_config(node),
			lists:foreach(fun({_, Node}) -> 
				net_adm:ping(Node)
			end, NodeList),
			case erlang:length(erlang:nodes()) > 0 of 
				true -> 
					false;
				_ -> 
					true
			end
	end.


% is_master_node() -> 
% 	true.
	% case sys_config:get_config(node) of
	% 	{ok, Node} -> 
	% 		{_, {role, Role}, _} = lists:keytake(role, 1, Node),
	% 		case Role of 
	% 			"master" -> 
	% 				true;
	% 			_ -> 
	% 				false
	% 		end; 
	% 	_ -> 
	% 		false 
	% end. 



% get_master_node() -> 
% 	'api_server@127.0.0.1'.
