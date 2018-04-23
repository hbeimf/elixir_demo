<?php /* Smarty version Smarty-3.1.8, created on 2018-04-23 10:38:33
         compiled from "/erlang/elixir_demo/manager/application/views/file/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:489619675add449de405f2-97416804%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1d948d9f6ed64a41411f5c633496c11467b1fc16' => 
    array (
      0 => '/erlang/elixir_demo/manager/application/views/file/index.tpl',
      1 => 1524450965,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '489619675add449de405f2-97416804',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5add449de8eec9_51516451',
  'variables' => 
  array (
    'params' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5add449de8eec9_51516451')) {function content_5add449de8eec9_51516451($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['params']->value['from']=='iframe'){?>
<?php echo $_smarty_tpl->getSubTemplate ("include/iframe_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }else{ ?>
<?php echo $_smarty_tpl->getSubTemplate ("include/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }?>
            <!-- BEGIN PAGE CONTAINER-->
            <div class="container-fluid">
                <div id="dashboard">
                    <div class="clearfix"></div>
                    <div class="row-fluid">
                        <div class="span6">
                            <div id="main" style="width: 600px;height:400px;"></div>
                        </div>
                        <div class="span6">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- END PAGE CONTAINER-->
<?php if ($_smarty_tpl->tpl_vars['params']->value['from']=='iframe'){?>
<?php echo $_smarty_tpl->getSubTemplate ("include/iframe_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }else{ ?>
<?php echo $_smarty_tpl->getSubTemplate ("include/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }?><?php }} ?>