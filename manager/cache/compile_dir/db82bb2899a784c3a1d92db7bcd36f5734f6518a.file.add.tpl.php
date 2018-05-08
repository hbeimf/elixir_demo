<?php /* Smarty version Smarty-3.1.8, created on 2018-05-08 15:17:31
         compiled from "/erlang/elixir_demo/manager/application/views/schooltype/add.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12805734945af14f0b2c3363-69856204%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'db82bb2899a784c3a1d92db7bcd36f5734f6518a' => 
    array (
      0 => '/erlang/elixir_demo/manager/application/views/schooltype/add.tpl',
      1 => 1524212142,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12805734945af14f0b2c3363-69856204',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'role' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5af14f0b371c65_15308319',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5af14f0b371c65_15308319')) {function content_5af14f0b371c65_15308319($_smarty_tpl) {?><form name="ff" id="ff" class="form-horizontal ajax_form" action="/schooltype/add" method='post' enctype="multipart/form-data">
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