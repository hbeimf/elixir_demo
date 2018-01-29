-module(glib).
-compile(export_all).



% glib:uid().
uid() -> 
	esnowflake:generate_id().	








