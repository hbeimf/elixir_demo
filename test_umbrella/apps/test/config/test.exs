use Mix.Config

# Configure your database
config :test, Test.Repo,
  adapter: Ecto.Adapters.Postgres,
  username: "postgres",
  password: "postgres",
  database: "test_test",
  hostname: "localhost",
  pool: Ecto.Adapters.SQL.Sandbox
