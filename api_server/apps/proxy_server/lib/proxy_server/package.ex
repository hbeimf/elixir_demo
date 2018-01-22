defmodule ProxyServer.Package do


	# ProxyServer.Package.package()
	# protocol_id  : 协议号  uint
	# bin : 有效载荷 
	def package(protocol_id, bin) do
		len = 4 + byte_size(bin)
		# unsigned-little-integer
		# 如何表达小端字节序列
		# https://hexdocs.pm/elixir/Kernel.SpecialForms.html#%3C%3C%3E%3E/1
		# <<102::integer-native, rest::binary>>
		# <<102::native-integer, rest::binary>>
		# <<102::unsigned-big-integer, rest::binary>>
		# <<102::unsigned-big-integer-size(8), rest::binary>>
		# <<102::unsigned-big-integer-8, rest::binary>>
		# <<102::8-integer-big-unsigned, rest::binary>>
		# <<102, rest::binary>>
		<<len::unsigned-little-integer-size(16), protocol_id::unsigned-little-integer-size(16), bin::binary>>
	end

	def unpackage(bin) when byte_size(bin) >= 2 do 
		:io.format("binary: ~p~n", [bin])
		:ok
	end
	def unpackage(_bin) do
		{:ok, :waitmore}
	end

	# unpackage(PackageBin) when erlang:byte_size(PackageBin) >= 2 ->
	# 	% io:format("parse package =========~n~n"),
	# 	case parse_head(PackageBin) of
	# 		{ok, PackageLen} ->	
	# 			parse_body(PackageLen, PackageBin);
	# 		Any -> 
	# 			Any
	# 	end;
	# unpackage(_) ->
	# 	{ok, waitmore}. 

	# parse_head(<<PackageLen:?USHORT ,_/binary>> ) ->
	# 	% io:format("parse head ======: ~p ~n~n", [PackageLen]), 
	# 	{ok, PackageLen};
	# parse_head(_) ->
	# 	error.

	# parse_body(PackageLen, _ ) when PackageLen > 9000 ->
	# 	error; 
	# parse_body(PackageLen, PackageBin) ->
	# 	% io:format("parse body -----------~n~n"),
	# 	case PackageBin of 
	# 		<<RightPackage:PackageLen/binary,NextPageckage/binary>> ->
	# 			<<_Len:?USHORT, Type:?USHORT, DataBin/binary>> = RightPackage,
	# 			% tcp_controller:action(Type, DataBin),
	# 			% unpackage(NextPageckage);
	# 			{ok, {Type, DataBin}, NextPageckage};
	# 		_ -> {ok, waitmore}
	# 	end.




	# ProxyServer.Package.test()
	def test() do
		package(10001, <<"hello world!">>)
	end

end