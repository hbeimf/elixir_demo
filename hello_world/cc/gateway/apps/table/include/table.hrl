%% 定义记录结构


-record(client_list, {
	uid=0, %%  客户端  uid
	pid_front=0, %%  客户端连接代理的 pid
	pid_backend=0,  %%  连接游戏服的 pid
	server_type="", %%   连接游戏服type
	server_id=0, %%  连接游戏服 id
	cache_bin = ""  %% 缓存二进制数据
}).


% message ServerInfo{
%     string serverType = 1; //服务器类型
%     string serverID = 2;    //服务器ID
%     string serverURI = 3;   //内网地址 ws://://192.168.1.1:8000   h      http://192.168.1.1:8000/interface
   
%     int max = 4;        //最大承载用户数
% }

-record(game_server_list, {
	server_id=0, %%  游戏服id
	server_type=0, %%  游戏服类型
	server_uri="",  %%  游戏服地址
	max=0 %%   游戏服最多能容纳多少链接 
	
}).


%% 被禁用 ip 
-record(forbidden_ip, {
	name,
	ip
}).

