PROJECT := release_hubs
NODENAME := hubs
VERSION := 0.1.0


all:
	rebar3 compile
	rebar3 release
	rebar3 tar
	mkdir $(PROJECT)
	cp ./config.ini ./$(PROJECT)/config.ini
	tar zxvf ./_build/default/rel/$(NODENAME)/$(NODENAME)-$(VERSION).tar.gz -C ./$(PROJECT)/
	tar czvf  ./$(NODENAME).release.tar.gz ./$(PROJECT) 
	rm -rf ./$(PROJECT)

run:
	rebar3 shell --name $(NODENAME)@127.0.0.1 --setcookie $(NODENAME)_cookie 

# 请先修改app的版本号再执行make up 
up:
	./rebar3 release
	./rebar3 appup generate --previous_version $(VERSION)
	./rebar3 relup
	./rebar3 tar

