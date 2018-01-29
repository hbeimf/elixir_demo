use Mix.Config

config :test, ecto_repos: [Test.Repo]

import_config "#{Mix.env}.exs"
