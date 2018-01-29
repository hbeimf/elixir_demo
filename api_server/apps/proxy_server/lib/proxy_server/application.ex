defmodule ProxyServer.Application do
  # See https://hexdocs.pm/elixir/Application.html
  # for more information on OTP Applications
  @moduledoc false

  use Application

  def start(_type, _args) do
    # {ok, _} = ranch:start_listener(proxy_server, 10, ranch_tcp, [{port, Port}], tcp_handler, []),

    {:ok, config} = :sys_config.get_config(:tcp)
    # :io.format("~p~n", [config])
    {_, {:port, port}, _} = :lists.keytake(:port, 1, config)
    # :io.format("~p~n", [port])
    {:ok, _} = :ranch.start_listener(:proxy_server, 10, :ranch_tcp, [{:port, port}], ProxyServer.TcpHandler, [])


    # List all child processes to be supervised
    children = [
      # Starts a worker by calling: ProxyServer.Worker.start_link(arg)
      # {ProxyServer.Worker, arg},
    ]

    # See https://hexdocs.pm/elixir/Supervisor.html
    # for other strategies and supported options
    opts = [strategy: :one_for_one, name: ProxyServer.Supervisor]
    Supervisor.start_link(children, opts)
  end
end
