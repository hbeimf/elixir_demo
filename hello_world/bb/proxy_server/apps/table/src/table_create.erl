-module(table_create).
-compile(export_all).

-include_lib("stdlib/include/qlc.hrl").
%% 定义记录结构

-include("table.hrl").

%% 初始化mnesia表结构
init() ->
    	case mnesia:create_schema([node()]) of
    		ok -> 
			    mnesia:start(),
			    % mnesia:create_table(client_list, [{type, bag}, {attributes,record_info(fields,client_list)}]),
			    mnesia:create_table(client_list, [{attributes,record_info(fields,client_list)}]),

			    ok;
		  _ -> 
		  	mnesia:start()
	 end.



