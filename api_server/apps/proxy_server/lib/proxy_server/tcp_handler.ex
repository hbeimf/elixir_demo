defmodule ProxyServer.TcpHandler do
	# See https://hexdocs.pm/elixir/GenServer.html#content
	# https://segmentfault.com/a/1190000007329521

	use GenServer
	# require Logger

	# @on_load :load_check
	# Callbacks

	# * nil
	# * atom
	# * {:global, term}
	# * {:via, module, term}
	# start_link(Ref, Socket, Transport, Opts) ->
	# {ok, proc_lib:spawn_link(?MODULE, init, [{Ref, Socket, Transport, Opts}])}.
	def start_link(ref, socket, transport, opts) do
		## 启动一个命名的进程 ， 进程名称是: Elixir.DemoSup.DemoServer
		# GenServer.start_link(__MODULE__, [], name: __MODULE__)

		## 启动未命名的进程
		GenServer.start_link(__MODULE__, [ref, socket, transport, opts])
	end

	# @callback init(args :: term) ::
	# {:ok, state} |
	# {:ok, state, timeout | :hibernate} |
	# :ignore |
	# {:stop, reason :: any} when state: any
	# init({Ref, Socket, Transport, _Opts = []}) ->
	# ok = ranch:accept_ack(Ref),
	# ok = Transport:setopts(Socket, [{active, once}]),
	# gen_server:enter_loop(?MODULE, [],
	# 	#state{socket=Socket, transport=Transport, data= <<>>, islogin = false, userid=0, token=""},
	# 	?TIMEOUT).
	def init([ref, socket, transport, _opts]) do
		:ok = :ranch.accept_ack(ref)
		:ok = transport.setopts(socket, [{:active, :once}])

		{:ok, [], 1000}
	end


	# @callback handle_info(msg :: :timeout | term, state :: term) ::
	# {:noreply, new_state} |
	# {:noreply, new_state, timeout | :hibernate} |
	# {:stop, reason :: term, new_state} when new_state: term
	def handle_info(:timeout, state) do
		# Logger.debug "timeout"
		{:noreply, state, 1000}
	end


	# @callback handle_call(request :: term, from, state :: term) ::
	# {:reply, reply, new_state} |
	# {:reply, reply, new_state, timeout | :hibernate} |
	# {:noreply, new_state} |
	# {:noreply, new_state, timeout | :hibernate} |
	# {:stop, reason, reply, new_state} |
	# {:stop, reason, new_state} when reply: term, new_state: term, reason: term
	def handle_call(:pop, _from, [h | t]) do
		{:reply, h, t}
	end

	# @callback handle_cast(request :: term, state :: term) ::
	# {:noreply, new_state} |
	# {:noreply, new_state, timeout | :hibernate} |
	# {:stop, reason :: term, new_state} when new_state: term
	def handle_cast({:push, item}, state) do
		{:noreply, [item | state]}
	end


	# @callback terminate(reason, state :: term) ::
	# term when reason: :normal | :shutdown | {:shutdown, term} | term

	# @callback code_change(old_vsn, state :: term, extra :: term) ::
	# {:ok, new_state :: term} |
	# {:error, reason :: term} when old_vsn: term | {:down, term}

	# def load_check do
	# 	Logger.debug "Module #{__MODULE__} is loaded."
	# end
end

