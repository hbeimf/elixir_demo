defmodule ProxyServer.Package do

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

	# ProxyServer.Package.package()
	# protocol_id  : 协议号  uint
	# bin : 有效载荷 
	def package(protocol_id, bin) do
		len = 4 + byte_size(bin)

		<<len::unsigned-little-integer-size(16), protocol_id::unsigned-little-integer-size(16), bin::binary>>
	end

	def unpackage(bin) when byte_size(bin) >= 2 do 
		:io.format("binary: ~p~n", [bin])
		case parse_head(bin) do
			{:ok, package_len} ->
				parse_body(package_len, bin)
			any -> 
				any
		end
	end
	def unpackage(_bin) do
		{:ok, :waitmore}
	end

	def parse_head(<<package_len::unsigned-little-integer-size(16), _::binary>>) do
		{:ok, package_len}
	end
	def parse_head(_)
		:error

	def parse_body(package_len, _) when package_len > 9000 do
		:error
	end
	def parse_body(package_len, bin) do
		case bin do
			<<right_package::binary-size(package_len), next_package::binary>> ->
				<<_::unsigned-little-integer-size(16), protocol_id::unsigned-little-integer-size(16), data_bin::binary>> = right_package 
				{:ok, {protocol_id, data_bin}, next_package}
			_ -> 
				{:ok, :waitmore}
		end
	end

	# ProxyServer.Package.test()
	def test() do
		package(10001, <<"hello world!">>)
	end

end