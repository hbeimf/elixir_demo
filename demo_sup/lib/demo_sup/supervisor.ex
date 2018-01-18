defmodule DemoSup.Supervisor do
  use Supervisor

  def start_link(arg) do
    Supervisor.start_link(__MODULE__, arg)  # 会调用 init 回调
  end

  def init(arg) do
    children = [
      # worker(MyWorker, [arg], restart: :temporary)
      worker(DemoSup.StackServer, [arg], restart: :temporary)

    ]

    supervise(children, strategy: :simple_one_for_one)
  end
end

