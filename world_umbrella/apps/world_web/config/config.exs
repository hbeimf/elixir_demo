# This file is responsible for configuring your application
# and its dependencies with the aid of the Mix.Config module.
#
# This configuration file is loaded before any dependency and
# is restricted to this project.
use Mix.Config

# General application configuration
config :world_web,
  namespace: WorldWeb,
  ecto_repos: [World.Repo]

# Configures the endpoint
config :world_web, WorldWeb.Endpoint,
  url: [host: "localhost"],
  secret_key_base: "SbqjlKQwRWjqSvEcNhoEcWMr1LCYimG8YrVvhqJ4/Z3LP5NG/3L2PhPrjKW6j91I",
  render_errors: [view: WorldWeb.ErrorView, accepts: ~w(html json)],
  pubsub: [name: WorldWeb.PubSub,
           adapter: Phoenix.PubSub.PG2]

# Configures Elixir's Logger
config :logger, :console,
  format: "$time $metadata[$level] $message\n",
  metadata: [:request_id]

config :world_web, :generators,
  context_app: :world

# Import environment specific config. This must remain at the bottom
# of this file so it overrides the configuration defined above.
import_config "#{Mix.env}.exs"
