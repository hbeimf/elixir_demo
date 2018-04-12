-module(any).
-compile(export_all).

% http://blog.sina.com.cn/s/blog_510844b70102wrvf.html
% http://hq.sinajs.cn/list=sh601006

test() -> 
	get_data(<<"sh601006">>).

get_data(Code) -> 
	Url = lists:concat(["http://hq.sinajs.cn/list=", glib:to_str(Code)]),
	case glib:http_get(Url) of
		<<"">> ->
			ok;
		Body ->
			body(Code, Body)
	end.

body(_Code, Body) -> 
	Str = glib:trim(glib:to_str(Body)),
	[_, List|_] = glib:explode(Str, "="),
	[_|Fileds] = glib:explode(List, ","),
	Fileds.


