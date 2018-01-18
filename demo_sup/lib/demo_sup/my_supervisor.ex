defmodule DemoSup.MySupervisor do
	use Supervisor
	# https://elixir-lang.org/getting-started/mix-otp/dynamic-supervisor.html
	
	def start_link() do
		Supervisor.start_link(__MODULE__, [], name: __MODULE__)  # 会调用 init 回调
	end

	## DemoSup.MySupervisor.start_child
	def start_child() do 
		Supervisor.start_child(__MODULE__, [])
	end

	def init(_arg) do
		import Supervisor.Spec

		children = [
		 	worker(DemoSup.MyWork, [], restart: :temporary)
		]

		supervise(children, strategy: :simple_one_for_one)
	end
end