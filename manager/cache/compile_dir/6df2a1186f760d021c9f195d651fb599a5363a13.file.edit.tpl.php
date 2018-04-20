<?php /* Smarty version Smarty-3.1.8, created on 2018-04-03 18:36:41
         compiled from "/mnt/web/m.demo.com/application/views/curriculum/edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3908997425ac359392d5da3-09658317%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6df2a1186f760d021c9f195d651fb599a5363a13' => 
    array (
      0 => '/mnt/web/m.demo.com/application/views/curriculum/edit.tpl',
      1 => 1522641537,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3908997425ac359392d5da3-09658317',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'role' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5ac359392f7524_39983223',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ac359392f7524_39983223')) {function content_5ac359392f7524_39983223($_smarty_tpl) {?><form name="ff" id="ff" class="form-horizontal ajax_form" action="/curriculum/edit" method='post' enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['id'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['id'];?>
<?php }?>" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
         <h4 class="modal-title"><?php if (isset($_smarty_tpl->tpl_vars['role']->value['id'])){?>编辑<?php }else{ ?>新增<?php }?>课程</h4>
    </div>
    <div class="modal-body">

<!-- BEGIN FORM-->
<div class="control-group">
    <label class="control-label">课程名称</label>
    <div class="controls">
        <input value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['name'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['name'];?>
<?php }?>"
            name="name" type="text" placeholder="name" class="m-wrap span6" />
    </div>
</div>

<div class="control-group">
    <label class="control-label">排序</label>
    <div class="controls">
        <input value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['order_by'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['order_by'];?>
<?php }?>"
            name="order_by" type="text" placeholder="order_by" class="m-wrap span6" />
    </div>
</div>


<!-- END FORM-->


    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button id="btn_add" type="button" class="btn btn-primary blue">保存</button>
    </div>
</form>
<?php }} ?>