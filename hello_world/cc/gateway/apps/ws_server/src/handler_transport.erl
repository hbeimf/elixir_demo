% handler_transport.erl

-module(handler_transport).
-compile(export_all).

-include("log.hrl").

% test() -> 
% 	Package = <<"">>,
% 	action(Package).

% 换服逻辑
action(Payload, State = #state_client{uid = Uid}) -> 
	?LOG({transport, Payload, State}),

	case table_client_list:select(Uid) of 
		[] -> 
			ok;
		[Client|_] ->
			?LOG({Client}),
			Pid_backend = table_client_list:get_client(Client, pid_backend),
			?LOG(Pid_backend),
			case erlang:is_pid(Pid_backend) andalso glib:is_pid_alive(Pid_backend) of 
				true -> 
					?LOG(transport),
					Pid_backend ! {transport, Payload};
				_ -> 
					?LOG({pid_backend, halt}),
					ok
			end
	end,
	ok.







