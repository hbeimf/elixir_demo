<?php /* Smarty version Smarty-3.1.8, created on 2018-03-22 10:30:10
         compiled from "/web/m.demo.com/application/views/schooltype/add.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8897631825a4b65817c8ad7-43229275%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fd7c07bd89aff8c52e6a8f0f89d9943855245c5e' => 
    array (
      0 => '/web/m.demo.com/application/views/schooltype/add.tpl',
      1 => 1521685807,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8897631825a4b65817c8ad7-43229275',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5a4b6581818ad6_64818009',
  'variables' => 
  array (
    'role' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a4b6581818ad6_64818009')) {function content_5a4b6581818ad6_64818009($_smarty_tpl) {?><form name="ff" id="ff" class="form-horizontal ajax_form" action="/schooltype/add" method='post' enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['id'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['id'];?>
<?php }?>" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
         <h4 class="modal-title"><?php if (isset($_smarty_tpl->tpl_vars['role']->value['id'])){?>编辑<?php }else{ ?>新增<?php }?>学校/组织类型</h4>
    </div>
    <div class="modal-body">

<!-- BEGIN FORM-->
<div class="control-group">

    <label class="control-label">类型名称</label>

    <div class="controls">

        <input value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['name'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['name'];?>
<?php }?>"
            name="name" type="text" placeholder="" class="m-wrap span6" />

        <!-- <span class="help-inline">This is inline help</span> -->

    </div>

</div>





<div class="control-group">
    <label class="control-label" >是否启用</label>
    <div class="controls">
        <label class="radio">
        <input <?php if (isset($_smarty_tpl->tpl_vars['role']->value['is_enabled'])&&$_smarty_tpl->tpl_vars['role']->value['is_enabled']=='1'){?>checked<?php }?>
        type="radio" name="is_enabled" value="1" />
        启用
        </label>
        <label class="radio">
        <input <?php if (isset($_smarty_tpl->tpl_vars['role']->value['is_enabled'])&&$_smarty_tpl->tpl_vars['role']->value['is_enabled']=='0'){?>checked<?php }?> <?php if (!isset($_smarty_tpl->tpl_vars['role']->value['is_enabled'])){?>checked<?php }?>
            type="radio" name="is_enabled" value="0" />
        禁用
        </label>
    </div>
</div>

<div class="control-group">
    <label class="control-label">备注</label>
    <div class="controls">
        <input value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['note'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['note'];?>
<?php }?>"
             name="note" type="text" placeholder="" class="m-wrap span6" />
        <span class="help-inline"></span>
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