use Mix.Config

# Configure your database
config :world, World.Repo,
  adapter: Ecto.Adapters.Postgres,
  username: "postgres",
  password: "postgres",
  database: "world_test",
  hostname: "localhost",
  pool: Ecto.Adapters.SQL.Sandbox
