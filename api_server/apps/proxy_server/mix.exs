defmodule ProxyServer.Mixfile do
  use Mix.Project

  def project do
    [
      app: :proxy_server,
      version: "0.1.0",
      build_path: "../../_build",
      config_path: "../../config/config.exs",
      deps_path: "../../deps",
      lockfile: "../../mix.lock",
      elixir: "~> 1.5",
      start_permanent: Mix.env == :prod,
      deps: deps()
    ]
  end

  # Run "mix help compile.app" to learn about applications.
  def application do
    [
      extra_applications: [:logger],
      mod: {ProxyServer.Application, []}
    ]
  end

  # Run "mix help deps" to learn about dependencies.
  defp deps do
    [
      # {:dep_from_hexpm, "~> 0.3.0"},
      # {:dep_from_git, git: "https://github.com/elixir-lang/my_dep.git", tag: "0.1.0"},
      # {:sibling_app_in_umbrella, in_umbrella: true},
      {:ranch, "~> 1.3.2"},
      # {:mysqlc, in_umbrella: true},
      # {:redisc, in_umbrella: true},
      {:mysqlc, path: "../../erlang_apps/mysqlc"},
      {:redisc, path: "../../erlang_apps/redisc"},
      {:rconf, path: "../../erlang_apps/rconf"},
      {:table, path: "../../erlang_apps/table"}
      # {:sync, "~> 0.1.3"}
    ]
  end
end
