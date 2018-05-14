<?php /* Smarty version Smarty-3.1.8, created on 2018-05-14 18:07:04
         compiled from "/erlang/elixir_demo/manager/application/views/file/timelist.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12132360085add49e09b0743-88088751%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dfca36736cf9ddf57b08f659f303567c2ddd04f9' => 
    array (
      0 => '/erlang/elixir_demo/manager/application/views/file/timelist.tpl',
      1 => 1526292420,
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
    'pre' => 0,
    'next' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5add49e09d09b9_65154949')) {function content_5add49e09d09b9_65154949($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['params']->value['from']=='iframe'){?>
<?php echo $_smarty_tpl->getSubTemplate ("include/iframe_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }else{ ?>
<?php echo $_smarty_tpl->getSubTemplate ("include/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }?>
            <input type="hidden" name="code" value="<?php echo $_smarty_tpl->tpl_vars['params']->value['code'];?>
" readonly="true">
            <button class="btn red btn_search" data-type="1">一周10<!-- <i class="icon-plus"></i> --></button>&nbsp;&nbsp;&nbsp;
            <button class="btn red btn_search" data-type="2">一月22<!-- <i class="icon-plus"></i> --></button>&nbsp;&nbsp;&nbsp;
            <button class="btn red btn_search" data-type="3">半年130<!-- <i class="icon-plus"></i> --></button>&nbsp;&nbsp;&nbsp;
            <button class="btn red btn_search" data-type="4">一年260<!-- <i class="icon-plus"></i> --></button>&nbsp;&nbsp;&nbsp;
            <button class="btn red btn_search" data-type="6">两年520<!-- <i class="icon-plus"></i> --></button>&nbsp;&nbsp;&nbsp;
            <button class="btn red btn_search" data-type="5">全部<!-- <i class="icon-plus"></i> --></button>&nbsp;&nbsp;&nbsp;
            <a class="btn blue" href="/file/timelist/?from=iframe&id=<?php echo $_smarty_tpl->tpl_vars['pre']->value;?>
">Pre</a>&nbsp;&nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['params']->value['id'];?>

            <a class="btn blue" href="/file/timelist/?from=iframe&id=<?php echo $_smarty_tpl->tpl_vars['next']->value;?>
">Next</a>&nbsp;&nbsp;&nbsp;

            <a data-toggle="modal" data-target="#mod_1200" href="/file/addFile/id/<?php echo $_smarty_tpl->tpl_vars['params']->value['id'];?>
/"
                                    class="btn grey">
                                    <i class="fa fa-pencil"></i>编辑
            </a>

            <a data-link="/file/addcategory/id/<?php echo $_smarty_tpl->tpl_vars['params']->value['id'];?>
/"
                                    class="btn grey ajax-delete" data-msg="[ <?php echo $_smarty_tpl->tpl_vars['params']->value['code'];?>
 ] 确认要 [更新] 吗？">
                                    <i class="fa fa-pencil"></i>更新
                                </a>
<a data-link="/file/minuscategory/id/<?php echo $_smarty_tpl->tpl_vars['params']->value['id'];?>
/"
                                    class="btn grey ajax-delete" data-msg="[ <?php echo $_smarty_tpl->tpl_vars['params']->value['code'];?>
 ] 确认要 [init] 吗？">
                                    <i class="fa fa-pencil"></i>init
                                </a>

        <a class="btn blue" href="https://www.baidu.com/s?wd=<?php echo $_smarty_tpl->tpl_vars['params']->value['name'];?>
" target="blank">百度[<?php echo $_smarty_tpl->tpl_vars['params']->value['name'];?>
]</a>&nbsp;&nbsp;&nbsp;
        <a class="btn blue" href="https://www.baidu.com/s?wd=上证指数" target="blank">上证指数</a>&nbsp;&nbsp;&nbsp;


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