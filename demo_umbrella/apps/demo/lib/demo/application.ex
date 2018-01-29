defmodule Demo.Application do
  @moduledoc """
  The Demo Application Service.

  The demo system business domain lives in this application.

  Exposes API to clients such as the `DemoWeb` application
  for use in channels, controllers, and elsewhere.
  """
  use Application

  def start(_type, _args) do
    import Supervisor.Spec, warn: false

    Supervisor.start_link([
      supervisor(Demo.Repo, []),
    ], strategy: :one_for_one, name: Demo.Supervisor)
  end
end
