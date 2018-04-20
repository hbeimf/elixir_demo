<?php /* Smarty version Smarty-3.1.8, created on 2018-04-10 17:18:09
         compiled from "/mnt/web/m.demo.com/application/views/include/header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19782679365ac1aafe6842f9-44008097%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7ac5f964988a8fada23a708e81a1b254f7be4dee' => 
    array (
      0 => '/mnt/web/m.demo.com/application/views/include/header.tpl',
      1 => 1523351868,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19782679365ac1aafe6842f9-44008097',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5ac1aafe686530_39883842',
  'variables' => 
  array (
    'nickname' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ac1aafe686530_39883842')) {function content_5ac1aafe686530_39883842($_smarty_tpl) {?><!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	<meta charset="utf-8" />
	<meta name="renderer" content="webkit">
	<title>管理后台</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	<link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>
	<link href="/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
	<link href="/css/style-metro.css" rel="stylesheet" type="text/css"/>
	<link href="/css/style.css" rel="stylesheet" type="text/css"/>
	<link href="/css/style-responsive.css" rel="stylesheet" type="text/css"/>
	<link href="/css/default.css" rel="stylesheet" type="text/css" id="style_color"/>
	<link href="/css/uniform.default.css" rel="stylesheet" type="text/css"/>
	<!-- END GLOBAL MANDATORY STYLES -->
	<!-- BEGIN PAGE LEVEL STYLES -->
	<link rel="stylesheet" type="text/css" href="/css/select2_metro.css" />
	<!-- END PAGE LEVEL SCRIPTS -->
	<link rel="stylesheet" href="/css/DT_bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="/css/bootstrap-tree.css" />

	<!-- BEGIN PAGE LEVEL STYLES -->
	<link rel="stylesheet" type="text/css" href="/css/bootstrap-fileupload.css" />
	<!-- <link rel="stylesheet" type="text/css" href="/css/jquery.gritter.css" /> -->
	<!-- <link rel="stylesheet" type="text/css" href="/css/chosen.css" /> -->
	<!-- <link rel="stylesheet" type="text/css" href="/css/select2_metro.css" /> -->
	<!-- <link rel="stylesheet" type="text/css" href="/css/jquery.tagsinput.css" /> -->
	<!-- <link rel="stylesheet" type="text/css" href="/css/clockface.css" /> -->
	<!-- <link rel="stylesheet" type="text/css" href="/css/bootstrap-wysihtml5.css" /> -->
	<link rel="stylesheet" type="text/css" href="/css/datepicker.css" />
	<link rel="stylesheet" type="text/css" href="/css/timepicker.css" />
	<!-- <link rel="stylesheet" type="text/css" href="/css/colorpicker.css" /> -->
	<!-- <link rel="stylesheet" type="text/css" href="/css/bootstrap-toggle-buttons.css" /> -->
	<!-- <link rel="stylesheet" type="text/css" href="/css/daterangepicker.css" /> -->
	<link rel="stylesheet" type="text/css" href="/css/datetimepicker.css" />
	<!-- <link rel="stylesheet" type="text/css" href="/css/multi-select-metro.css" /> -->
	<!-- <link href="/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/> -->
	<!-- END PAGE LEVEL STYLES -->

	<link rel="stylesheet" type="text/css" href="/js/layer/theme/default/layer.css" />
	
	<link rel="shortcut icon" href="/image/favicon.ico" />

</head>
<!-- END HEAD -->

<!-- BEGIN BODY -->
<body class="page-header-fixed">
	<!-- BEGIN HEADER -->
	<div class="header navbar navbar-inverse navbar-fixed-top">
		<!-- BEGIN TOP NAVIGATION BAR -->
		<div class="navbar-inner">
			<div class="container-fluid">
				<!-- BEGIN LOGO -->
				<a class="brand" href="/">
				<img src="/image/logo.png" alt="logo" />
				</a>
				<!-- END LOGO -->
				<!-- BEGIN RESPONSIVE MENU TOGGLER -->
				<a href="javascript:;" class="btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
				<img src="/image/menu-toggler.png" alt="" />
				</a>
				<!-- END RESPONSIVE MENU TOGGLER -->
				<!-- BEGIN TOP NAVIGATION MENU -->
				<ul class="nav pull-right">
					<!-- BEGIN NOTIFICATION DROPDOWN -->

					<!-- END TODO DROPDOWN -->
					<!-- BEGIN USER LOGIN DROPDOWN -->
					<li class="dropdown user">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<!-- <img alt="" src="/image/avatar1_small.jpg" /> -->
						<span class="username"><?php echo $_smarty_tpl->tpl_vars['nickname']->value;?>
</span>
						<i class="icon-angle-down"></i>
						</a>
						<ul class="dropdown-menu">
							<!-- <li><a href="extra_profile.html"><i class="icon-user"></i> My Profile</a></li>
							<li><a href="page_calendar.html"><i class="icon-calendar"></i> My Calendar</a></li>
							<li><a href="inbox.html"><i class="icon-envelope"></i> My Inbox(3)</a></li> -->
							<!-- <li><a href="/system/changePassword/"><i class="icon-tasks"></i>修改密码</a></li> -->
							<!-- <li class="divider"></li> -->
							<!-- <li><a href="extra_lock.html"><i class="icon-lock"></i> Lock Screen</a></li> -->
							<li><a href="/index/logout/"><i class="icon-key"></i>退出</a></li>
						</ul>
					</li>
					<!-- END USER LOGIN DROPDOWN -->
				</ul>
				<!-- END TOP NAVIGATION MENU -->
			</div>
		</div>
		<!-- END TOP NAVIGATION BAR -->
	</div>

	<!-- END HEADER -->

	<!-- BEGIN CONTAINER -->
	<div class="page-container row-fluid">
		<!-- BEGIN SIDEBAR -->
		<div class="page-sidebar nav-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->
	        <?php echo $_smarty_tpl->getSubTemplate ("include/menu1.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

	        <!-- END SIDEBAR MENU -->
		</div>
		<!-- END SIDEBAR -->
		<!-- BEGIN PAGE -->
		<div class="page-content">
			<!-- BEGIN PAGE CONTAINER-->
			<div class="container-fluid">
				<!-- BEGIN PAGE HEADER-->
				<?php echo $_smarty_tpl->getSubTemplate ("include/page_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

				<!-- END PAGE HEADER-->





<?php }} ?>