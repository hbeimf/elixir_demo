-ifndef(CMD).
-define(CMD,true).

-define(CMD_LOGIN, 1001).  %% login proxy_server
-define(CMD_LOGIN_REPLY, 1002).  %% 登录回复 
-define(HEART_BEAT, 1003).  %% 心跳 
-define(HEART_BEAT_REPLY, 1004).  %% 心跳回复 

-define(GET_ONLINE_STUDENT, 1005).  %% 获取在线学生
-define(GET_ONLINE_STUDENT_REPLY, 1006).  %% 获取在线学生回复
-define(CREATE_CLASSROOM, 1007). %% 开始广播，老师学生建立临时教室 
-define(CREATE_CLASSROOM_REPLY, 1008). %% 开始广播，老师学生建立临时教室 , 被加入的学生收到这个协议号

-define(DELETE_STUDENT_FROM_CLASSROOM, 1009). %% 删除临时教室里的学生, 比如添加错误的学生
-define(DELETE_STUDENT_FROM_CLASSROOM_REPLY, 1010). %% 删除临时教室里的学生, 比如添加错误的学生,回复 

-define(BROADCAST_MSG, 1011).  %% 教师在教室里广播消息
-define(BROADCAST_MSG_REPLY, 1012). %% 教师在教室里广播消息回复 

-define(START_EVALUATION, 1013). %% 开始测评 
-define(START_EVALUATION_REPLY, 1014). %% 开始测评回复  

-define(REPORT_EVALUATION_SCORE, 1015). %% 学生上报测评分数
-define(REPORT_EVALUATION_SCORE_REPLY, 1016). %% 学生上报测评分数回复  

-define(BROADCAST_OFFLINE, 1017). %% 有人下线了，广播学校内的所有人这个消息

-define(GET_CLASS_ONLINE_STUDENT, 1019).  %% 获取临时教室在线学生
-define(GET_CLASS_ONLINE_STUDENT_REPLY, 1020).  %% 获取临时教室在线学生回复

-define(GET_ONLINE_FREE_STUDENT, 1021).  %% 获取在线学生, {未上课的在线学生}
-define(GET_ONLINE_FREE_STUDENT_REPLY, 1022).  %% 获取在线学生, {未上课的在线学生} 回复 

-define(CLASS_IS_OVER, 1023).  %% 下课
-define(CLASS_IS_OVER_REPLY, 1024).  %% 下课回复 

-define(BROADCAST_MSG_V2_REPLY, 1026). %% 教师在教室里广播消息回复, 创建临时教室加入孩子时的广播消息 

-define(IS_GROUP_CONTROL, 1027). %%  是否群控中

-define(LOCK_SCREEN, 1029). %%  锁屏
-define(LOCK_SCREEN_REPLY, 1030). %%  锁屏回复 

-define(GET_EVALUATION_SCORE, 1031). %%  老师获取学生测评分数列表
-define(GET_EVALUATION_SCORE_REPLY, 1032). %%  老师获取学生测评分数列表回复 

-define(START_EVALUATION_AGAIN, 1033). %% 部分学生重新开始测评 
-define(START_EVALUATION_AGAIN_REPLY, 1034). %% 部分学生重新开始测评 

-endif.