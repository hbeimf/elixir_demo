use Mix.Config

# Configure your database
config :demo, Demo.Repo,
  adapter: Ecto.Adapters.Postgres,
  username: "postgres",
  password: "postgres",
  database: "demo_test",
  hostname: "localhost",
  pool: Ecto.Adapters.SQL.Sandbox
