defmodule DemoSup.StackServer do
	# See https://hexdocs.pm/elixir/GenServer.html#content

	use GenServer

	# Callbacks

	def handle_call(:pop, _from, [h | t]) do
		{:reply, h, t}
	end

	def handle_cast({:push, item}, state) do
		{:noreply, [item | state]}
	end
end

# Start the server
# {:ok, pid} = GenServer.start_link(DemoSup.StackServer, [:hello])

# This is the client
# GenServer.call(pid, :pop)
#=> :hello

# GenServer.cast(pid, {:push, :world})
#=> :ok

# GenServer.call(pid, :pop)
#=> :world