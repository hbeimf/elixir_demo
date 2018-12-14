# 1
进入源代码，使后执行
```
$ make
$ cd ./bin  
```

解压 gateway.master.release.tar.gz 解压到  release_gateway

然后修改配置文件 




# 2
修改配置文件
```

$ cd release_gateway
$ vim config.ini 
```

配置说明：
```
[node]
// gw节点编号，注意：不可重复
node_id = 1

master = gw@127.0.0.1
slave = gw_slave@127.0.0.1


[http]
host = "127.0.0.1"
// gw节点监听端口
port = 8899


注意：gw多节点部署时, redis配置必须一致
[redis]
// redis节点ip
host = "127.0.0.1"
// redis节点端口
port = 6379
// redis口令，没有密码此处忽略即可，
;password = "123456"


[control_center]
// gwc连接路径， 处理只用修改 {localhost:7788} 部分，前部的 ws://, 后部的 /websocket 请不要随便修改
host = "ws://localhost:7788/websocket"


[login_api]
// 登录使用的api接口，请账户中心负责人提供即可，
url = "http://14.192.8.251:9004/GwService/getByIdentity?proto="


; 游戏入口配置
[server_type]
// server_type_{ServerType} = "{对应的url路径}"
server_type_1000 = "https://game.wl860.com/hall/"
server_type_1001 = "https://game.wl860.com/fish3d/"
server_type_1002 = "https://game.wl860.com/erba/"
server_type_1003 = "https://game.wl860.com/longhu/"
server_type_1004 = "https://78.wl960.com/gold/"
server_type_1009 = "https://game.wl860.com/t1/DDZ/"
server_type_1012 = "https://game.wl860.com/t1/SG/"
```

# 3
启动节点 
```

$ ./release_gateway/bin/gateway start
```


