%%
%% Autogenerated by Thrift Compiler (0.9.3)
%%
%% DO NOT EDIT UNLESS YOU ARE SURE THAT YOU KNOW WHAT YOU ARE DOING
%%

-module(hello_thrift).
-behaviour(thrift_service).


-include("hello_thrift.hrl").

-export([struct_info/1, function_info/2]).

struct_info(_) -> erlang:error(function_clause).
%%% interface
% say(This, Name)
function_info('say', params_type) ->
  {struct, [{1, string}]}
;
function_info('say', reply_type) ->
  string;
function_info('say', exceptions) ->
  {struct, []}
;
function_info(_Func, _Info) -> erlang:error(function_clause).

