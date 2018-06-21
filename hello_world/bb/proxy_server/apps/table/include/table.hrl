%% 定义记录结构


% -record(client_list, {
% 	userid=0,
% 	proxy_id=0,
% 	logtime=0, 
% 	token="",
% 	ip="",
% 	pid=0,
% 	scene_id=0
% }).


-record(client_list, {
	userid=0, %%  客户端  uid
	proxy_id=0, %%  客户端连接代理的 id
	logtime=0,  %%  客户端登录时间 
	token="", %%   客户端登录token
	ip="", %%  客户端 ip
	scene_id=0, %%  客户端 场景 id
	teacher_id=0, %%  客户端 对应的 老师 id 
	school_id=0, %% 所在学校 id 
	role_id=0, %% 角色 id
	pid=0 %% 客户端连接的进程 pid
}).

