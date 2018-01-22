defmodule ProxyServer.Package do


	# ProxyServer.Package.package()
	# protocol_id  : 协议号  uint
	# bin : 有效载荷 
	def package(protocol_id, bin) do
		:io.format("~p~n", [{protocol_id, bin}])
		:ok
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

	def unpackage() do
		:ok
	end

	# ProxyServer.Package.test()
	def test() do
		package(10001, <<"hello world!">>)
	end

end