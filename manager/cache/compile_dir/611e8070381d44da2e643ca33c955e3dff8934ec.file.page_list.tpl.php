<?php /* Smarty version Smarty-3.1.8, created on 2018-03-28 13:40:14
         compiled from "/web/m.demo.com/application/views/include/page_list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9579478615a4b612667f791-34664081%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '611e8070381d44da2e643ca33c955e3dff8934ec' => 
    array (
      0 => '/web/m.demo.com/application/views/include/page_list.tpl',
      1 => 1522215608,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9579478615a4b612667f791-34664081',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5a4b6126688e87_39821472',
  'variables' => 
  array (
    'count' => 0,
    'page' => 0,
    'totalPage' => 0,
    'pageType' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a4b6126688e87_39821472')) {function content_5a4b6126688e87_39821472($_smarty_tpl) {?><!-- 分页 -->
<div class="row-fluid">
	<div class="span6">
		<div class="dataTables_info" id="sample_1_info">
			共<?php echo $_smarty_tpl->tpl_vars['count']->value;?>
条记录， 第<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
页 共<?php echo $_smarty_tpl->tpl_vars['totalPage']->value;?>
页 
		</div>
	</div>
	<div class="span6" id="page_list_id">
		<div class="dataTables_paginate paging_bootstrap pagination">
			<?php if (isset($_smarty_tpl->tpl_vars['pageType']->value)){?>
				<?php echo page(array('current_page'=>$_smarty_tpl->tpl_vars['page']->value,'total_page'=>$_smarty_tpl->tpl_vars['totalPage']->value,'page_type'=>$_smarty_tpl->tpl_vars['pageType']->value),$_smarty_tpl);?>

			<?php }else{ ?>
				<?php echo page(array('current_page'=>$_smarty_tpl->tpl_vars['page']->value,'total_page'=>$_smarty_tpl->tpl_vars['totalPage']->value),$_smarty_tpl);?>

			<?php }?>
			
		</div>
	</div>
</div><?php }} ?>