1>
进入源码目录 

$ make
$ cd bin

直接解压 control_center.master.release.tar.gz 到 release_control_center 目录





2> 
修改配置文件 

$ cd release_control_center
$ vim config.ini


配置说明：

[node]
master = control_center@127.0.0.1
slave = control_center_slave@127.0.0.1


[http]
host = "127.0.0.1"

// gwc 服务监听的端口
port = 7788


3>
启动应用

$ ./release_control_center/bin/control_center start
