use Mix.Config

config :hello, ecto_repos: [Hello.Repo]

import_config "#{Mix.env}.exs"
