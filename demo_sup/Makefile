# https://hexdocs.pm/distillery/walkthrough.html#adding-distillery-to-your-project

all:
	mix deps.get
	mix compile
	mix release.init
	mix release

	# MIX_ENV=prod mix release --env=prod