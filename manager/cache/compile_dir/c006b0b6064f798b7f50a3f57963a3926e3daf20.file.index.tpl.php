<?php /* Smarty version Smarty-3.1.8, created on 2018-04-11 14:27:20
         compiled from "/mnt/web/m.demo.com/application/views/system/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18343647725acdaac8e864a7-10714158%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c006b0b6064f798b7f50a3f57963a3926e3daf20' => 
    array (
      0 => '/mnt/web/m.demo.com/application/views/system/index.tpl',
      1 => 1522641537,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18343647725acdaac8e864a7-10714158',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'system_menu' => 0,
    'm' => 0,
    'mm' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5acdaac9158668_08517499',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5acdaac9158668_08517499')) {function content_5acdaac9158668_08517499($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("include/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<!-- BEGIN PAGE CONTENT-->
<div class="row-fluid">
	<div class="span6">
		<div class="portlet box grey">
			<div class="portlet-title">
				<div class="caption"><i class="icon-comments"></i>导航</div>
				<div class="actions">
					<a data-toggle="modal" data-target="#mod_900" href="/system/addMenu/" id="add_menu" class="btn red">增加</a>
					<a href="javascript:;" id="tree_1_collapse" class="btn green">收起</a>
					<a href="javascript:;" id="tree_1_expand" class="btn yellow">展开</a>
				</div>
			</div>

			<div class="portlet-body fuelux">
				<ul class="tree" id="tree_1">
					<li>
						<a href="#" data-role="branch" class="tree-toggle" data-toggle="branch" data-value="Bootstrap_Tree">
						导航
						</a>
						<ul class="branch in">
							<?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['m']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['system_menu']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value){
$_smarty_tpl->tpl_vars['m']->_loop = true;
?>
								<li>
									<a href="" class="tree-toggle closed parent_menu" data-toggle="branch" data-value="Bootstrap_Tree" >
										<span id="<?php echo $_smarty_tpl->tpl_vars['m']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['m']->value['menu_name'];?>
 ++<?php if ($_smarty_tpl->tpl_vars['m']->value['status']!=1){?>[<font color=red>禁用</font>]<?php }?></span>
									</a>
										<ul class="branch">
											<?php  $_smarty_tpl->tpl_vars['mm'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['mm']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['m']->value['child']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['mm']->key => $_smarty_tpl->tpl_vars['mm']->value){
$_smarty_tpl->tpl_vars['mm']->_loop = true;
?>
											<li>
												<a data-toggle="modal" data-target="#mod_900" href="/system/addMenu/id/<?php echo $_smarty_tpl->tpl_vars['mm']->value['id'];?>
" data-role="leaf">
													<i class="icon-plus"></i><?php echo $_smarty_tpl->tpl_vars['mm']->value['menu_name'];?>

													[<?php if ($_smarty_tpl->tpl_vars['mm']->value['type']=='1'){?>导航<?php }else{ ?><font color=green>功能</font><?php }?>]
													<?php if ($_smarty_tpl->tpl_vars['mm']->value['status']!=1){?>[<font color=red>禁用</font>]<?php }?>
												</a>
											</li>
											<?php } ?>
										</ul>
								</li>
							<?php } ?>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>

<!-- END PAGE CONTENT-->

<?php echo $_smarty_tpl->getSubTemplate ("include/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>





<?php }} ?>