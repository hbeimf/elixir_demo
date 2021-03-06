%% -*- coding: utf-8 -*-
%% Automatically generated, do not edit
%% Generated by gpb_compile version 3.26.4

-ifndef(msg_proto).
-define(msg_proto, true).

-define(msg_proto_gpb_version, "3.26.4").

-ifndef('LOGIN_PB_H').
-define('LOGIN_PB_H', true).
-record('Login',
        {user_id                :: integer(),       % = 1, 32 bits
         token                  :: binary() | iolist() % = 2
        }).
-endif.

-ifndef('STARTEVALUATION_PB_H').
-define('STARTEVALUATION_PB_H', true).
-record('StartEvaluation',
        {teacher_id             :: integer(),       % = 1, 32 bits
         curriculum_id          :: integer(),       % = 2, 32 bits
         curriculum_step_id     :: integer(),       % = 3, 32 bits
         music_name             :: binary() | iolist() % = 4
        }).
-endif.

-ifndef('STUDENTID_PB_H').
-define('STUDENTID_PB_H', true).
-record('StudentId',
        {user_id                :: integer()        % = 1, 32 bits
        }).
-endif.

-ifndef('CREATECLASSROOM_PB_H').
-define('CREATECLASSROOM_PB_H', true).
-record('CreateClassroom',
        {teacher_id             :: integer(),       % = 1, 32 bits
         students = []          :: [#'StudentId'{}] % = 2
        }).
-endif.

-ifndef('REPORTEVALUATIONSCOREREPLY_PB_H').
-define('REPORTEVALUATIONSCOREREPLY_PB_H', true).
-record('ReportEvaluationScoreReply',
        {user_id                :: integer(),       % = 1, 32 bits
         score                  :: integer(),       % = 2, 32 bits
         curriculum_id          :: integer(),       % = 3, 32 bits
         curriculum_step_id     :: integer(),       % = 4, 32 bits
         music_name             :: binary() | iolist(), % = 5
         name                   :: binary() | iolist(), % = 6
         url                    :: binary() | iolist() % = 7
        }).
-endif.

-ifndef('GETEVALUATIONREPLY_PB_H').
-define('GETEVALUATIONREPLY_PB_H', true).
-record('GetEvaluationReply',
        {score = []             :: [#'ReportEvaluationScoreReply'{}] % = 1
        }).
-endif.

-ifndef('STUDENTINFO_PB_H').
-define('STUDENTINFO_PB_H', true).
-record('StudentInfo',
        {user_id                :: integer(),       % = 1, 32 bits
         name                   :: binary() | iolist(), % = 2
         url                    :: binary() | iolist() % = 3
        }).
-endif.

-ifndef('GETONLINESTUDENTREPLY_PB_H').
-define('GETONLINESTUDENTREPLY_PB_H', true).
-record('GetOnlineStudentReply',
        {student = []           :: [#'StudentInfo'{}] % = 1
        }).
-endif.

-ifndef('BROADCASTMSGPAYLOAD_PB_H').
-define('BROADCASTMSGPAYLOAD_PB_H', true).
-record('BroadcastMsgPayload',
        {protocol_id            :: integer(),       % = 1, 32 bits
         data                   :: binary() | undefined, % = 2
         data1                  :: binary() | iolist() | undefined % = 3
        }).
-endif.

-ifndef('BROADCASTMSG_PB_H').
-define('BROADCASTMSG_PB_H', true).
-record('BroadcastMsg',
        {teacher_id             :: integer(),       % = 1, 32 bits
         payload                :: #'BroadcastMsgPayload'{} % = 2
        }).
-endif.

-ifndef('GETCLASSONLINESTUDENT_PB_H').
-define('GETCLASSONLINESTUDENT_PB_H', true).
-record('GetClassOnlineStudent',
        {school_id              :: integer(),       % = 1, 32 bits
         teacher_id             :: integer()        % = 2, 32 bits
        }).
-endif.

-ifndef('HEARTBEAT_PB_H').
-define('HEARTBEAT_PB_H', true).
-record('Heartbeat',
        {num                    :: integer()        % = 1, 32 bits
        }).
-endif.

-ifndef('GETCLASSONLINESTUDENTREPLY_PB_H').
-define('GETCLASSONLINESTUDENTREPLY_PB_H', true).
-record('GetClassOnlineStudentReply',
        {student = []           :: [#'StudentInfo'{}] % = 1
        }).
-endif.

-ifndef('GETONLINESTUDENT_PB_H').
-define('GETONLINESTUDENT_PB_H', true).
-record('GetOnlineStudent',
        {school_id              :: integer()        % = 1, 32 bits
        }).
-endif.

-ifndef('CLASSISOVER_PB_H').
-define('CLASSISOVER_PB_H', true).
-record('ClassIsOver',
        {teacher_id             :: integer()        % = 1, 32 bits
        }).
-endif.

-ifndef('STARTEVALUATIONAGAIN_PB_H').
-define('STARTEVALUATIONAGAIN_PB_H', true).
-record('StartEvaluationAgain',
        {evaluation_id          :: integer(),       % = 1, 32 bits
         students = []          :: [#'StudentId'{}] % = 2
        }).
-endif.

-ifndef('LOCKSCREEN_PB_H').
-define('LOCKSCREEN_PB_H', true).
-record('LockScreen',
        {teacher_id             :: integer(),       % = 1, 32 bits
         status                 :: integer()        % = 2, 32 bits
        }).
-endif.

-ifndef('ISGROUPCONTROL_PB_H').
-define('ISGROUPCONTROL_PB_H', true).
-record('IsGroupControl',
        {teacher_id             :: integer(),       % = 1, 32 bits
         status                 :: integer()        % = 2, 32 bits
        }).
-endif.

-ifndef('LOGINREPLY_PB_H').
-define('LOGINREPLY_PB_H', true).
-record('LoginReply',
        {error_type             :: integer(),       % = 1, 32 bits
         msg                    :: binary() | iolist() % = 2
        }).
-endif.

-ifndef('STARTEVALUATIONREPLY_PB_H').
-define('STARTEVALUATIONREPLY_PB_H', true).
-record('StartEvaluationReply',
        {evaluation_id          :: integer()        % = 1, 32 bits
        }).
-endif.

-ifndef('GETEVALUATIONSCORE_PB_H').
-define('GETEVALUATIONSCORE_PB_H', true).
-record('GetEvaluationScore',
        {evaluation_id          :: integer()        % = 1, 32 bits
        }).
-endif.

-ifndef('REPORTEVALUATIONSCORE_PB_H').
-define('REPORTEVALUATIONSCORE_PB_H', true).
-record('ReportEvaluationScore',
        {user_id                :: integer(),       % = 1, 32 bits
         score                  :: integer(),       % = 2, 32 bits
         curriculum_id          :: integer(),       % = 3, 32 bits
         curriculum_step_id     :: integer(),       % = 4, 32 bits
         music_name             :: binary() | iolist() % = 5
        }).
-endif.

-endif.
