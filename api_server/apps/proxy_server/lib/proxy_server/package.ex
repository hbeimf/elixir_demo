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
		<<len::size(16), protocol_id::size(16), bin::binary>>
	end

	def unpackage() do
		:ok
	end

	# ProxyServer.Package.test()
	def test() do
		package(10001, <<"hello world!">>)
	end

end