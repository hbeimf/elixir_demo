%%
%% Autogenerated by Thrift Compiler (0.9.3)
%%
%% DO NOT EDIT UNLESS YOU ARE SURE THAT YOU KNOW WHAT YOU ARE DOING
%%

-module(example_service_thrift).
-behaviour(thrift_service).


-include("example_service_thrift.hrl").

-export([struct_info/1, function_info/2]).

struct_info(_) -> erlang:error(function_clause).
%%% interface
% hello(This, M)
function_info('hello', params_type) ->
  {struct, [{1, {struct, {'example_types', 'Message'}}}]}
;
function_info('hello', reply_type) ->
  {struct, {'example_types', 'Message'}};
function_info('hello', exceptions) ->
  {struct, []}
;
function_info(_Func, _Info) -> erlang:error(function_clause).
