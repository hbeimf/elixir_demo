# https://hexdocs.pm/distillery/walkthrough.html#adding-distillery-to-your-project
# https://hexdocs.pm/distillery/getting-started.html

all: dev prod

run:
	iex -S mix

dev:
	mix release --verbose

prod: 
	MIX_ENV=prod mix release --env=prod --verbose

release_init:
	mix deps.get
	mix compile
	mix release.init