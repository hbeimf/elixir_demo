defmodule DemoSup.DemoServer do
	# See https://hexdocs.pm/elixir/GenServer.html#content

	use GenServer
	require Logger

	@on_load :load_check
	# Callbacks

	def start_link do
		GenServer.start_link(__MODULE__, [], name: {:global, __MODULE__})
	end

	def init([]) do
		{:ok, [], 1000}
	end

	def handle_info(:timeout, state) do
		# Logger.debug "timeout"
		{:noreply, state, 1000}
	end

	def handle_call(:pop, _from, [h | t]) do
		{:reply, h, t}
	end

	def handle_cast({:push, item}, state) do
		{:noreply, [item | state]}
	end

	def load_check do
		Logger.debug "Module #{__MODULE__} is loaded."
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