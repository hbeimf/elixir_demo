PROJECT := release_control_center
NODENAME := control_center
VERSION := 0.1.0

all: release_master release_slave gen_release

test: release_master release_slave gen_test
	
release_slave: 
	rebar3 compile
	rebar3 release
	rebar3 tar
	mkdir ./$(PROJECT)_slave
	tar zxvf ./_build/default/rel/$(NODENAME)/$(NODENAME)-$(VERSION).tar.gz -C ./$(PROJECT)_slave/
	cp ./config/config_test.ini ./$(PROJECT)_slave/config.ini
	cp ./config/vm_slave.args ./$(PROJECT)_slave/releases/$(VERSION)/vm.args
	tar czvf  ./bin/$(NODENAME).slave.tar.gz ./$(PROJECT)_slave 
	rm -rf ./$(PROJECT)_slave

release_master: 
	rebar3 compile
	rebar3 release
	rebar3 tar
	mkdir ./$(PROJECT)_master
	tar zxvf ./_build/default/rel/$(NODENAME)/$(NODENAME)-$(VERSION).tar.gz -C ./$(PROJECT)_master/
	cp ./config/config_release.ini ./$(PROJECT)_master/config.ini
	cp ./config/vm_master.args ./$(PROJECT)_master/releases/$(VERSION)/vm.args
	tar czvf  ./bin/$(NODENAME).master.tar.gz ./$(PROJECT)_master 
	rm -rf ./$(PROJECT)_master

clean:
	rm -rf ./bin/$(NODENAME).master.slave.tar.gz
	rm -rf ./bin/$(NODENAME).master.release.tar.gz

gen_test:
	cd generate && python gen_test.py

gen_release:
	cd generate && python gen_release.py
	
run: 
	rebar3 shell --name $(NODENAME)_master@127.0.0.1 --setcookie $(NODENAME)_cookie 

