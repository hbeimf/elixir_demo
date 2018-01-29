use Mix.Config

# Configure your database
config :world, World.Repo,
  adapter: Ecto.Adapters.Postgres,
  username: "postgres",
  password: "postgres",
  database: "world_dev",
  hostname: "localhost",
  pool_size: 10
