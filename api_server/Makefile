# https://hexdocs.pm/distillery/walkthrough.html#adding-distillery-to-your-project

all: dev prod
	# MIX_ENV=prod mix release --env=prod

dev:
	mix release --verbose

prod: 
	MIX_ENV=prod mix release --env=prod --verbose

release_init:
	mix deps.get
	mix compile
	mix release.init