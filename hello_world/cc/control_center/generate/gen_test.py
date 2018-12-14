#!/usr/bin/python
# -*- coding: UTF-8 -*-

import tarfile
import os

class Generate:
	master_ip = {"ip":"192.168.1.188", "port":7788}

	slave_ips = [
		{"ip":"192.168.1.188", "port":8877},
		{"ip":"192.168.1.188", "port":8878}

	]


	##　config =======================================================
	# 主节点
	master_node = "gwc_master@%s"
	# master_port = 9988
	# 从节点
	slave_node = "gwc_slave%d@%s"
	# slave_port_start = 8898
	# cookie
	cookie = "gwc_cookie"
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
		dir = "./release_control_center_slave/releases/0.1.0/vm.args"
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

		dir1 = "./release_control_center_slave/config.ini"
		print dir1

		# port = self.slave_port_start + index

		node_id = index

		config1 = '''[node]
master = %s

[http]
host = "%s"
port = %d
		''' % (self.get_master(), ip, port)

		print config1

		fo1 = open(dir1, "w")
		fo1.write( config1 )
		fo1.close()

		if index == 1:
			print "generate master"
			os.mkdir( './release_gwc_master_%s_p%d' % (ip, port))
			os.system("cp ./release_control_center_slave/* ./release_gwc_master_%s_p%d -R" % (ip, port) )
			os.system("tar czvf gwc.master.%s.p%d.tar.gz ./release_gwc_master_%s_p%d" % (ip, port, ip, port) )
			os.system("rm -rf ./release_gwc_master_%s_p%d" % (ip,port))
		else:
			print "generate slave"
			os.mkdir( './release_gwc_slave%d_%s_p%d' % (index, ip, port) )
			os.system("cp ./release_control_center_slave/* ./release_gwc_slave%d_%s_p%d -R" % (index, ip, port))
			os.system("tar czvf gwc.slave%d.%s.p%d.tar.gz ./release_gwc_slave%d_%s_p%d" % (index, ip, port, index, ip, port) )
			os.system("rm -rf ./release_gwc_slave%d_%s_p%d" % (index,ip, port))

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
	file_name = "../bin/control_center.slave.tar.gz"
	gen.untar(file_name, ".")
 	gen.gen()
	gen.clear()

