<?php /* Smarty version Smarty-3.1.8, created on 2018-04-20 16:22:21
         compiled from "/erlang/elixir_demo/manager/application/views/include/page_header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2379957255ad9a33d37cf16-11725675%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b58df27146456a31638dffd3285b70f7995d501a' => 
    array (
      0 => '/erlang/elixir_demo/manager/application/views/include/page_header.tpl',
      1 => 1524212142,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2379957255ad9a33d37cf16-11725675',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'current_menu' => 0,
    'params' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5ad9a33d386441_15411412',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ad9a33d386441_15411412')) {function content_5ad9a33d386441_15411412($_smarty_tpl) {?><div class="row-fluid">
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