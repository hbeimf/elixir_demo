-module(redisc).
-compile(export_all).

-include_lib("ws_server/include/log.hrl").

test() -> 
	set(),
	redisc_get().

redisc_get() ->
    redisc_get("foo").
redisc_get(Key) ->
    redisc_call:q(pool_redis, ["GET", Key]).

set() ->
    set("foo", "bar").
set(Key, Val) ->
    redisc_call:q(pool_redis, ["SET", Key, Val]).

get() ->
    redisc:get("foo").
get(Key) ->
    redisc_call:q(pool_redis, ["GET", Key]).
    
hget() -> 
    Hash = "info@341659",
    A = hget(Hash, "gold"),
    B = hgetall(Hash),
    {A, B}.

hget(Hash, Key) -> 
    q(["hget", Hash, Key], 3000).

hgetall(Hash) -> 
    redisc_call:q(pool_redis, ["hgetall", Hash]).
    
hset(Hash, Key, Val) ->
    q(["hset", Hash, Key, Val], 3000). 


show_num() ->
  GameServers = table_game_server_list:select(),
  show_num(GameServers),
  ok.
show_num([]) ->
  ok;
show_num([GameServer|OtherGameServer]) ->
  Max = table_game_server_list:get_client(GameServer, max),
  ServerId = table_game_server_list:get_client(GameServer, server_id),
  ServerType = table_game_server_list:get_client(GameServer, server_type),
  Key = handler_change_game_server:get_key(ServerType, ServerId),
  case redisc:get(Key) of
    {ok, undefined} ->
      ok;
    {ok, Val} ->
      Val1 = glib:to_integer(Val),
      case Val1 > 0 of 
        true ->
          ?LOG([{server_type, ServerType}, {server_id, ServerId}, {max, Max}, {key, Key}, {reply_num, Val}]),
          ok;
        _ ->
          ok
      end,
      ok;
    _ ->
      ok
  end,
  show_num(OtherGameServer).

reset_num() ->
  GameServers = table_game_server_list:select(),
  reset_num(GameServers),
  ok.
reset_num([]) ->
  ok;
reset_num([GameServer|OtherGameServer]) ->
  ServerId = table_game_server_list:get_client(GameServer, server_id),
  ServerType = table_game_server_list:get_client(GameServer, server_type),
  Key = handler_change_game_server:get_key(ServerType, ServerId),
  % ?LOG([{server_type, ServerType}, {server_id, ServerId}, {max, Max}, {key, Key}, {reply,Reply}]),
  redisc:set(Key, 0),
  reset_num(OtherGameServer).



incr() ->
  incr("test_incr").
incr(Key) ->
  q(["incr", Key]).

decr() ->
  decr("test_incr").
decr(Key) ->
  q(["decr", Key]).



q(Command) -> 
    redisc_call:q(pool_redis, Command).
q(Command, Timeout) -> 
    redisc_call:q(pool_redis, Command, Timeout).

