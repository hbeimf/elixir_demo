PROJECT := release_hubs
NODENAME := hubs
VERSION := 0.1.0


all: master
	

master: 
	rebar3 compile
	rebar3 release
	rebar3 tar
	mkdir ./tar/$(PROJECT)
	cp ./config/config_master.ini ./tar/$(PROJECT)/config.ini
	tar zxvf ./_build/default/rel/$(NODENAME)/$(NODENAME)-$(VERSION).tar.gz -C ./tar/$(PROJECT)/
	tar czvf  ./$(NODENAME).release.tar.gz ./tar/$(PROJECT) 
	rm -rf ./tar/$(PROJECT)

run:
	rebar3 shell --name $(NODENAME)@127.0.0.1 --setcookie $(NODENAME)_cookie 

# 请先修改app的版本号再执行make up 
up:
	./rebar3 release
	./rebar3 appup generate --previous_version $(VERSION)
	./rebar3 relup
	./rebar3 tar

