defmodule DemoSup.Application do
  # See https://github.com/developerworks/distro
  # See https://hexdocs.pm/elixir/Application.html
  # for more information on OTP Applications
  @moduledoc false

  use Application

  def start(_type, _args) do
    import Supervisor.Spec, warn: false
    # List all child processes to be supervised
    children = [
      # Starts a worker by calling: DemoSup.Worker.start_link(arg)
      # {DemoSup.Worker, arg},
      worker(DemoSup.DemoServer, [])
    ]

    # See https://hexdocs.pm/elixir/Supervisor.html
    # for other strategies and supported options
    opts = [strategy: :one_for_one, name: DemoSup.Supervisor]
    Supervisor.start_link(children, opts)
  end
end
