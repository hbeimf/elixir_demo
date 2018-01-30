-module(glib).
-compile(export_all).

% -export([package/2, unpackage/1, test/0]).

% -define( UINT, 32/unsigned-little-integer).
% -define( INT, 32/signed-little-integer).
-define( USHORT, 16/unsigned-little-integer).
% -define( SHORT, 16/signed-little-integer).
% -define( UBYTE, 8/unsigned-little-integer).
% -define( BYTE, 8/signed-little-integer).
	
unpackage(PackageBin) when erlang:byte_size(PackageBin) >= 2 ->
	% io:format("parse package =========~n~n"),
	case parse_head(PackageBin) of
		{ok, PackageLen} ->	
			parse_body(PackageLen, PackageBin);
		Any -> 
			Any
	end;
unpackage(_) ->
	{ok, waitmore}. 

parse_head(<<PackageLen:?USHORT ,_/binary>> ) ->
	% io:format("parse head ======: ~p ~n~n", [PackageLen]), 
	{ok, PackageLen};
parse_head(_) ->
	error.

parse_body(PackageLen, _ ) when PackageLen > 9000 ->
	error; 
parse_body(PackageLen, PackageBin) ->
	% io:format("parse body -----------~n~n"),
	case PackageBin of 
		<<RightPackage:PackageLen/binary,NextPageckage/binary>> ->
			<<_Len:?USHORT, Cmd:?USHORT, DataBin/binary>> = RightPackage,
			% tcp_controller:action(Cmd, DataBin),
			% unpackage(NextPageckage);
			{ok, {Cmd, DataBin}, NextPageckage};
		_ -> {ok, waitmore}
	end.

package(Cmd, DataBin) ->
	Len = byte_size(DataBin)+4,
	<<Len:?USHORT, Cmd:?USHORT, DataBin/binary>>.


test() -> 
	B = package(123, <<"hello world!">>),
	unpackage(B).


% glib:uid().
uid() -> 
	esnowflake:generate_id().


