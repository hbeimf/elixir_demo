#!/usr/bin/python
# -*- coding: UTF-8 -*-

import tarfile
import os

class Generate:
	master_ip = {"ip":"127.0.0.1", "port":9988}

	slave_ips = [
		{"ip":"127.0.0.1", "port":8899},
		{"ip":"127.0.0.1", "port":8900}
	]

	redis_host = "127.0.0.1"
	redis_port = 6379
	redis_possword = "123456" 

	# 连接控制中心的路径
	gwc = "ws://127.0.0.1:7788/websocket"

	# 登录api
	login_api = "http://14.192.8.251:9004/GwService/getByIdentity?proto="


	##　config =======================================================
	# 主节点
	master_node = "gw_master@%s"
	# master_port = 9988
	# 从节点
	slave_node = "gw_slave%d@%s"
	# slave_port_start = 8898
	# cookie
	cookie = "gateway_cookie"
	##　config =======================================================
	def get_master(self):
		return self.master_node % self.master_ip["ip"]

	def get_ips(self):
		# print self.master_ip
		# print self.slave_ips
		self.slave_ips.insert(0, self.master_ip)
		return self.slave_ips

	def untar(self, fname, dirs):
	    t = tarfile.open(fname)
	    t.extractall(path = dirs) 


	def put_config(self, index, ip, port):
		print index
		dir = "./release_gateway_slave/releases/0.1.0/vm.args"
		print dir 

		if index == 1 :
			node_name = self.master_node % ip
			# port = self.master_port
		else:
			node_name = self.slave_node % (index, ip)
			# port = self.slave_port_start + index

		# print node_name
		# exit()

		config = '''-name %s

-setcookie %s

+K true
+A30

+swt low 
+sbwt none 
+P 1000000 
-smp enable 
+S 16 
+sub true
		''' % (node_name, self.cookie)

		print config

		fo = open(dir, "w")
		fo.write( config )
		fo.close()

		dir1 = "./release_gateway_slave/config.ini"
		print dir1

		# port = self.slave_port_start + index

		node_id = index

		config1 = '''[node]
node_id = %d
master = %s

[http]
host = "%s"
port = %d


[redis]
host = "%s"
port = %d
;password = "%s"


[control_center]
host = "%s"


[login_api]
url = "%s"


; 游戏入口配置
[server_type]
server_type_1000 = "https://game.wl860.com/hall/"
server_type_1001 = "https://game.wl860.com/fish3d/"
server_type_1002 = "https://game.wl860.com/erba/"
server_type_1003 = "https://game.wl860.com/longhu/"
server_type_1004 = "https://78.wl960.com/gold/"
server_type_1005 = "https://78.wl960.com/domino/"
server_type_1006 = "https://78.wl960.com/niuniu/"
server_type_1009 = "https://game.wl860.com/t1/DDZ/"
server_type_1012 = "https://game.wl860.com/t1/SG/"
server_type_1013 = "https://game.wl860.com/t1/PDK/"
		''' % (node_id, self.get_master(), ip, port, self.redis_host, self.redis_port, self.redis_possword, self.gwc, self.login_api)

		print config1

		fo1 = open(dir1, "w")
		fo1.write( config1 )
		fo1.close()

		if index == 1:
			print "generate master"
			os.mkdir( './release_gateway_master_%s_p%d' % (ip, port))
			os.system("cp ./release_gateway_slave/* ./release_gateway_master_%s_p%d -R" % (ip, port) )
			os.system("tar czvf gateway.master.%s.p%d.tar.gz ./release_gateway_master_%s_p%d" % (ip, port, ip, port) )
			os.system("rm -rf ./release_gateway_master_%s_p%d" % (ip,port))
		else:
			print "generate slave"
			os.mkdir( './release_gateway_slave%d_%s_p%d' % (index, ip, port) )
			os.system("cp ./release_gateway_slave/* ./release_gateway_slave%d_%s_p%d -R" % (index, ip, port))
			os.system("tar czvf gateway.slave%d.%s.p%d.tar.gz ./release_gateway_slave%d_%s_p%d" % (index, ip, port, index, ip, port) )
			os.system("rm -rf ./release_gateway_slave%d_%s_p%d" % (index,ip, port))

	def pre_clear(self):
		os.system("rm -rf ./*.tar.gz")
		os.system("rm -rf ./release*")

	def clear(self):
		os.system("rm -rf ./release*")

	def gen(self):
		ips = self.get_ips()
		for i in range(len(ips)):
	 		print("序号：%s   值：%s" % (i + 1, ips[i]))
	 		self.put_config(i+1, ips[i]["ip"], ips[i]["port"])


if __name__ == "__main__":
	gen = Generate()
	gen.pre_clear()
	file_name = "../bin/gateway.slave.tar.gz"
	gen.untar(file_name, ".")
 	gen.gen()
	gen.clear()

