defmodule World.Application do
  @moduledoc """
  The World Application Service.

  The world system business domain lives in this application.

  Exposes API to clients such as the `WorldWeb` application
  for use in channels, controllers, and elsewhere.
  """
  use Application

  def start(_type, _args) do
    import Supervisor.Spec, warn: false

    Supervisor.start_link([
      supervisor(World.Repo, []),
    ], strategy: :one_for_one, name: World.Supervisor)
  end
end
