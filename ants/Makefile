PROJECT := release_ants
NODENAME := ants
VERSION := 0.1.0


all: release test
	
test: 
	rebar3 compile
	rebar3 release
	rebar3 tar
	mkdir ./$(PROJECT)
	tar zxvf ./_build/default/rel/$(NODENAME)/$(NODENAME)-$(VERSION).tar.gz -C ./$(PROJECT)/
	cp ./config/config_test.ini ./$(PROJECT)/config.ini
	tar czvf  $(NODENAME).master.test.tar.gz ./$(PROJECT) 
	rm -rf ./$(PROJECT)

release: 
	rebar3 compile
	rebar3 release
	rebar3 tar
	mkdir ./$(PROJECT)
	tar zxvf ./_build/default/rel/$(NODENAME)/$(NODENAME)-$(VERSION).tar.gz -C ./$(PROJECT)/
	cp ./config/config_release.ini ./$(PROJECT)/config.ini
	tar czvf  $(NODENAME).master.release.tar.gz ./$(PROJECT) 
	rm -rf ./$(PROJECT)

clean:
	rm -rf ./$(NODENAME).master.test.tar.gz
	rm -rf ./$(NODENAME).master.release.tar.gz

run:
	rebar3 shell --name $(NODENAME)@127.0.0.1 --setcookie $(NODENAME)_cookie 

# 请先修改app的版本号再执行make up 
up:
	./rebar3 release
	./rebar3 appup generate --previous_version $(VERSION)
	./rebar3 relup
	./rebar3 tar

