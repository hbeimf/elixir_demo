<?php /* Smarty version Smarty-3.1.8, created on 2018-04-23 14:49:59
         compiled from "/erlang/elixir_demo/manager/application/views/file/timelist.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12132360085add49e09b0743-88088751%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dfca36736cf9ddf57b08f659f303567c2ddd04f9' => 
    array (
      0 => '/erlang/elixir_demo/manager/application/views/file/timelist.tpl',
      1 => 1524466195,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12132360085add49e09b0743-88088751',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5add49e09d09b9_65154949',
  'variables' => 
  array (
    'params' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5add49e09d09b9_65154949')) {function content_5add49e09d09b9_65154949($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['params']->value['from']=='iframe'){?>
<?php echo $_smarty_tpl->getSubTemplate ("include/iframe_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }else{ ?>
<?php echo $_smarty_tpl->getSubTemplate ("include/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }?>
<input type="text" name="code" value="<?php echo $_smarty_tpl->tpl_vars['params']->value['code'];?>
">

            <!-- BEGIN PAGE CONTAINER-->
            <div class="container-fluid">
                <div id="dashboard">
                    <div class="clearfix"></div>
                    <div class="row-fluid">
                        <div class="span6">
                            <div id="main" style="width: 1200px;height:400px;"></div>
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