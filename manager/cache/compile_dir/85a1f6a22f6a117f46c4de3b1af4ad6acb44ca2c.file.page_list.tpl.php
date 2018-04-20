<?php /* Smarty version Smarty-3.1.8, created on 2018-04-10 17:18:09
         compiled from "/mnt/web/m.demo.com/application/views/include/page_list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2268904995ac1aafe6b4679-33296869%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '85a1f6a22f6a117f46c4de3b1af4ad6acb44ca2c' => 
    array (
      0 => '/mnt/web/m.demo.com/application/views/include/page_list.tpl',
      1 => 1523351868,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2268904995ac1aafe6b4679-33296869',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5ac1aafe6b9fd2_43091955',
  'variables' => 
  array (
    'count' => 0,
    'page' => 0,
    'totalPage' => 0,
    'pageType' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ac1aafe6b9fd2_43091955')) {function content_5ac1aafe6b9fd2_43091955($_smarty_tpl) {?><!-- 分页 -->
<div class="row-fluid">
	<div class="span3">
		<div class="dataTables_info" id="sample_1_info">
			共<?php echo $_smarty_tpl->tpl_vars['count']->value;?>
条记录， 第<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
页 共<?php echo $_smarty_tpl->tpl_vars['totalPage']->value;?>
页 
		</div>
	</div>
	<div class="span9" id="page_list_id">
		<div class="dataTables_paginate paging_bootstrap pagination">
			<?php if (isset($_smarty_tpl->tpl_vars['pageType']->value)){?>
				<?php echo page(array('current_page'=>$_smarty_tpl->tpl_vars['page']->value,'total_page'=>$_smarty_tpl->tpl_vars['totalPage']->value,'page_type'=>$_smarty_tpl->tpl_vars['pageType']->value),$_smarty_tpl);?>

			<?php }else{ ?>
				<?php echo page(array('current_page'=>$_smarty_tpl->tpl_vars['page']->value,'total_page'=>$_smarty_tpl->tpl_vars['totalPage']->value),$_smarty_tpl);?>

			<?php }?>
			
		</div>
	</div>
</div><?php }} ?>