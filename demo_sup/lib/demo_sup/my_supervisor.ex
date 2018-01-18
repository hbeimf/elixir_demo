defmodule DemoSup.MySupervisor do
  use Supervisor

  def start_link() do
    	Supervisor.start_link(__MODULE__, [])  # 会调用 init 回调
  end

  def init(_arg) do
  	import Supervisor.Spec

	children = [
	 	worker(DemoSup.UnnameServer, [], restart: :temporary)
	]

    	supervise(children, strategy: :simple_one_for_one)
  end
end