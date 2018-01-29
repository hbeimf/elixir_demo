-module(ctrl_handler).
%% API.
-export([action/3]).

-include_lib("state.hrl").



% 未匹配的消息直接忽略
action(_Type, _DataBin, _State) ->
	% P = tcp_package:package(Type+1, DataBin),
	% self() ! {tcp_send, P},
	% io:format("~n ================================= ~ntype:~p, bin: ~p ~n ", [Type, DataBin]). 
	ok.


% =============================================================
% private function ================================================
% =============================================================

