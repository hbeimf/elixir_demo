defmodule Test.Application do
  @moduledoc """
  The Test Application Service.

  The test system business domain lives in this application.

  Exposes API to clients such as the `TestWeb` application
  for use in channels, controllers, and elsewhere.
  """
  use Application

  def start(_type, _args) do
    import Supervisor.Spec, warn: false

    Supervisor.start_link([
      supervisor(Test.Repo, []),
    ], strategy: :one_for_one, name: Test.Supervisor)
  end
end
