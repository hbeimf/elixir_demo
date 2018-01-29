# This file is responsible for configuring your application
# and its dependencies with the aid of the Mix.Config module.
#
# This configuration file is loaded before any dependency and
# is restricted to this project.
use Mix.Config

# General application configuration
config :test_web,
  namespace: TestWeb,
  ecto_repos: [Test.Repo]

# Configures the endpoint
config :test_web, TestWeb.Endpoint,
  url: [host: "localhost"],
  secret_key_base: "AFc4TLgQ+a9Ni9jjIkS8qhag1qViAFQ0AWZ9CSpmkoy7TtTbJcLithBzseHZNKy+",
  render_errors: [view: TestWeb.ErrorView, accepts: ~w(html json)],
  pubsub: [name: TestWeb.PubSub,
           adapter: Phoenix.PubSub.PG2]

# Configures Elixir's Logger
config :logger, :console,
  format: "$time $metadata[$level] $message\n",
  metadata: [:request_id]

config :test_web, :generators,
  context_app: :test

# Import environment specific config. This must remain at the bottom
# of this file so it overrides the configuration defined above.
import_config "#{Mix.env}.exs"
