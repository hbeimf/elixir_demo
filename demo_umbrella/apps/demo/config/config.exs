use Mix.Config

config :demo, ecto_repos: [Demo.Repo]

import_config "#{Mix.env}.exs"
