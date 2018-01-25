-module(sys_config_table).

-compile(export_all).
-define(SYS_CONFIG_TABLE, sys_config_table).
-define(ETS_OPTS,[set, public ,named_table , {keypos,2}, {heir,none}, {write_concurrency,true}, {read_concurrency,false}]).

create_table() -> 
	ets:new(?SYS_CONFIG_TABLE, ?ETS_OPTS).
