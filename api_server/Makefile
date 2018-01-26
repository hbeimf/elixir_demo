# https://hexdocs.pm/distillery/walkthrough.html#adding-distillery-to-your-project
# https://hexdocs.pm/distillery/getting-started.html

PROJECT := release_api_server
NODENAME := api_server
VERSION := 0.1.0


all: dev prod

run:
	# iex -S mix
	iex --name "$(NODENAME)@127.0.0.1" --cookie "$(NODENAME)_cookie" -S mix

dev:
	mix release --verbose

prod: 
	MIX_ENV=prod mix release --env=prod --verbose
	mkdir $(PROJECT)
	cp ./config.ini ./$(PROJECT)/config.ini
	tar zxvf 	_build/prod/rel/$(NODENAME)/releases/$(VERSION)/$(NODENAME).tar.gz -C ./$(PROJECT)/
	tar czvf  ./$(NODENAME).release.tar.gz ./$(PROJECT) 
	rm -rf ./$(PROJECT)

release_init:
	mix deps.get
	mix compile
	mix release.init