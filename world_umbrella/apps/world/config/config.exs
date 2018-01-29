use Mix.Config

config :world, ecto_repos: [World.Repo]

import_config "#{Mix.env}.exs"
