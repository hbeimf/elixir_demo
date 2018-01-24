-module(table_create).
-compile(export_all).

-include_lib("stdlib/include/qlc.hrl").
%% 定义记录结构

-include("table.hrl").

-define(WAIT_FOR_TABLES, 50000).

%% 初始化mnesia表结构
init() -> 
	IsMasterNode = is_master_node(),
	dynamic_db_init(IsMasterNode).

% 如果是主结点
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
	% mnesia:stop(),
	% mnesia:delete_schema([node()]),
	% mnesia:create_schema([node()]),
	% mnesia:start(),

	MasterNode = get_master_node(),
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
is_master_node() -> 
	case rconf:read_config(node) of
		{role, "master"} ->
			true;
		_ -> 
			false 
	end. 

get_master_node() -> 
	'api_server@127.0.0.1'.
