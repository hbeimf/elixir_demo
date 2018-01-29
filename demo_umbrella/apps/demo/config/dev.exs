use Mix.Config

# Configure your database
config :demo, Demo.Repo,
  adapter: Ecto.Adapters.Postgres,
  username: "postgres",
  password: "postgres",
  database: "demo_dev",
  hostname: "localhost",
  pool_size: 10
