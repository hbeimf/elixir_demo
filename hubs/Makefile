PROJECT := release_hubs
NODENAME := hubs
VERSION := 0.1.0


all: default_node other_node
	

default_node: 
	rebar3 compile
	rebar3 release
	rebar3 tar
	mkdir ./$(PROJECT)
	tar zxvf ./_build/default/rel/$(NODENAME)/$(NODENAME)-$(VERSION).tar.gz -C ./$(PROJECT)/
	cp ./config/config_master.ini ./$(PROJECT)/config.ini
	tar czvf  $(NODENAME).master.release.tar.gz ./$(PROJECT) 
	# mv ./$(NODENAME).release.tar.gz ./tar/$(NODENAME).master.release.tar.gz
	rm -rf ./$(PROJECT)

other_node:
	rebar3 compile
	rebar3 release
	rebar3 tar
	mkdir ./$(PROJECT)
	tar zxvf ./_build/default/rel/$(NODENAME)/$(NODENAME)-$(VERSION).tar.gz -C ./$(PROJECT)/
	## 主要是配置文件不同
	cp ./config/config_slave.ini ./$(PROJECT)/config.ini
	cp ./config/vm_slave.args ./$(PROJECT)/releases/$(VERSION)/vm.args
	tar czvf  $(NODENAME).slave.release.tar.gz ./$(PROJECT) 
	rm -rf ./$(PROJECT)

run:
	rebar3 shell --name $(NODENAME)@127.0.0.1 --setcookie $(NODENAME)_cookie 

# 请先修改app的版本号再执行make up 
up:
	./rebar3 release
	./rebar3 appup generate --previous_version $(VERSION)
	./rebar3 relup
	./rebar3 tar

