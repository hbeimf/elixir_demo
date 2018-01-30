%% 定义记录结构


-record(client_list, {
	userid=0, %%  客户端  uid
	proxy_id=0, %%  客户端连接代理的 id 
	token="" %%   客户端登录token
}).



-record(proxy_server_list, {
	id=0,  %% 代理 id
	ip=0, %% 代理ip
	port=0, %% 代理端口
	pid=0 %% 代理连接 pid
}).


