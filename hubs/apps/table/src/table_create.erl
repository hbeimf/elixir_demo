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
			    % Type值为set、ordered_set或bag，默认为set 
			    % bag可以一个key对应多条record，而set和ordered_set只能一个key对应一条record 
			    % Mnesia表中不会出现重复的record（同样的key和content） 
			    mnesia:create_table(proxy_server_list, [{type, bag}, {attributes,record_info(fields,proxy_server_list)}]),
			    
			    % mnesia:create_table(funky, [{disc_copies, [N1, N2]}, {index, [y]}, {type, bag}, {attributes, record_info(fields, funky)}]).  
			    ok;
		  _ -> 
		  	mnesia:start()
	 end;
% 从结点启动
dynamic_db_init(_) ->
	[MasterNode|_] = erlang:nodes(),
	% net_adm:ping(MasterNode),
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