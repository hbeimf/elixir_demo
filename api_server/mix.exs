defmodule ApiServer.Mixfile do
  use Mix.Project

  def project do
    [
      apps_path: "apps",
      start_permanent: Mix.env == :prod,
      deps: deps()
    ]
  end

  # Dependencies listed here are available only for this
  # project and cannot be accessed from applications inside
  # the apps folder.
  #
  # Run "mix help deps" for examples and options.
  defp deps do
    [
        {:distillery, "~> 1.5.2", runtime: false}
        # {:mnesia,  path: "/usr/local/erlang/lib/erlang/lib/mnesia-4.13.3", compile: false}
    ]
  end
end
