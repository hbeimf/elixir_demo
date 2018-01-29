use Mix.Config

# Configure your database
config :hello, Hello.Repo,
  adapter: Ecto.Adapters.Postgres,
  username: "postgres",
  password: "postgres",
  database: "hello_dev",
  hostname: "localhost",
  pool_size: 10
