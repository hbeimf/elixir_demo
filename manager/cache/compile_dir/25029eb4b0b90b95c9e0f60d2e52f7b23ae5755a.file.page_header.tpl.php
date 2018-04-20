<?php /* Smarty version Smarty-3.1.8, created on 2018-04-12 15:32:53
         compiled from "/mnt/web/m.demo.com/application/views/include/page_header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7745003085ac1aafe696803-28644294%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '25029eb4b0b90b95c9e0f60d2e52f7b23ae5755a' => 
    array (
      0 => '/mnt/web/m.demo.com/application/views/include/page_header.tpl',
      1 => 1523518240,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7745003085ac1aafe696803-28644294',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5ac1aafe6b1ef7_33183013',
  'variables' => 
  array (
    'current_menu' => 0,
    'params' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ac1aafe6b1ef7_33183013')) {function content_5ac1aafe6b1ef7_33183013($_smarty_tpl) {?><div class="row-fluid">
	<div class="span12">
		<!-- BEGIN STYLE CUSTOMIZER -->
		<!-- <div class="color-panel hidden-phone">
			<div class="color-mode-icons icon-color"></div>
			<div class="color-mode-icons icon-color-close"></div>
			<div class="color-mode">
				<p>THEME COLOR</p>
				<ul class="inline">
					<li class="color-black current color-default" data-style="default"></li>
					<li class="color-blue" data-style="blue"></li>
					<li class="color-brown" data-style="brown"></li>
					<li class="color-purple" data-style="purple"></li>
					<li class="color-grey" data-style="grey"></li>
					<li class="color-white color-light" data-style="light"></li>
				</ul>
				<label>
					<span>Layout</span>
					<select class="layout-option m-wrap small">
						<option value="fluid" selected>Fluid</option>
						<option value="boxed">Boxed</option>
					</select>
				</label>
				<label>
					<span>Header</span>
					<select class="header-option m-wrap small">
						<option value="fixed" selected>Fixed</option>
						<option value="default">Default</option>
					</select>
				</label>
				<label>
					<span>Sidebar</span>
					<select class="sidebar-option m-wrap small">
						<option value="fixed">Fixed</option>
						<option value="default" selected>Default</option>
					</select>
				</label>
				<label>
					<span>Footer</span>
					<select class="footer-option m-wrap small">
						<option value="fixed">Fixed</option>
						<option value="default" selected>Default</option>
					</select>
				</label>
			</div>
		</div> -->

		<!-- END BEGIN STYLE CUSTOMIZER -->

		<!-- BEGIN PAGE TITLE & BREADCRUMB-->
		<h3 class="page-title">
			<?php echo $_smarty_tpl->tpl_vars['current_menu']->value['menu_name'];?>
 <!-- <small>managed table samples</small> -->
		</h3>
		<ul class="breadcrumb">
			<li>
				<i class="icon-home"></i>
				<a href="<?php if (isset($_smarty_tpl->tpl_vars['params']->value['curriculum_id'])&&$_smarty_tpl->tpl_vars['params']->value['curriculum_id']!=''){?>javascript:;<?php }else{ ?>/<?php }?>">控制台</a>
				<?php if ($_smarty_tpl->tpl_vars['current_menu']->value['parent_menu_name']!=''){?>
					<i class="icon-angle-right"></i>
				<?php }?>
			</li>
			<li>
				<a href="javascript:;"><?php echo $_smarty_tpl->tpl_vars['current_menu']->value['parent_menu_name'];?>
</a>
				<?php if ($_smarty_tpl->tpl_vars['current_menu']->value['menu_name']!=''){?>
				<i class="icon-angle-right"></i>
				<?php }?>
			</li>
			<li><a href="javascript:;"><?php echo $_smarty_tpl->tpl_vars['current_menu']->value['menu_name'];?>
</a></li>
		</ul>
		<!-- END PAGE TITLE & BREADCRUMB-->
	</div>
</div>
<?php }} ?>