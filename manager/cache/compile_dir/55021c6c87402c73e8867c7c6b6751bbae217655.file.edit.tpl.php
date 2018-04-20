<?php /* Smarty version Smarty-3.1.8, created on 2018-03-29 15:19:45
         compiled from "/web/m.demo.com/application/views/curriculum/edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1268644225a66da1ee8b1f1-99280482%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '55021c6c87402c73e8867c7c6b6751bbae217655' => 
    array (
      0 => '/web/m.demo.com/application/views/curriculum/edit.tpl',
      1 => 1522215608,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1268644225a66da1ee8b1f1-99280482',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5a66da1eeb6328_35961680',
  'variables' => 
  array (
    'role' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a66da1eeb6328_35961680')) {function content_5a66da1eeb6328_35961680($_smarty_tpl) {?><form name="ff" id="ff" class="form-horizontal ajax_form" action="/curriculum/edit" method='post' enctype="multipart/form-data">
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