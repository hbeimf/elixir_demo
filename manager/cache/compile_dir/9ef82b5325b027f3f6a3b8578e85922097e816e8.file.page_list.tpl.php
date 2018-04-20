<?php /* Smarty version Smarty-3.1.8, created on 2018-04-20 16:22:45
         compiled from "/erlang/elixir_demo/manager/application/views/include/page_list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15092219535ad9a3555bbf87-04878212%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9ef82b5325b027f3f6a3b8578e85922097e816e8' => 
    array (
      0 => '/erlang/elixir_demo/manager/application/views/include/page_list.tpl',
      1 => 1524212142,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15092219535ad9a3555bbf87-04878212',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'count' => 0,
    'page' => 0,
    'totalPage' => 0,
    'pageType' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5ad9a3555c2284_35402593',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ad9a3555c2284_35402593')) {function content_5ad9a3555c2284_35402593($_smarty_tpl) {?><!-- 分页 -->
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