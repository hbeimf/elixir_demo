<?php /* Smarty version Smarty-3.1.8, created on 2018-05-08 15:38:39
         compiled from "/erlang/elixir_demo/manager/application/views/file/addFile.tpl" */ ?>
<?php /*%%SmartyHeaderCode:502335665ad9d8fc33ca22-16561097%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '77e0824ea92c642557c2fa4c575f406eb2457eff' => 
    array (
      0 => '/erlang/elixir_demo/manager/application/views/file/addFile.tpl',
      1 => 1525765116,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '502335665ad9d8fc33ca22-16561097',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5ad9d8fc35ec33_71063055',
  'variables' => 
  array (
    'role' => 0,
    'school_type' => 0,
    'm' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ad9d8fc35ec33_71063055')) {function content_5ad9d8fc35ec33_71063055($_smarty_tpl) {?><form name="ff" id="ff" class="form-horizontal ajax_form" action="/file/addFile" method='post' enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['id'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['id'];?>
<?php }?>" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
         <h4 class="modal-title"><?php if (isset($_smarty_tpl->tpl_vars['role']->value['id'])){?>编辑<?php }else{ ?>新增<?php }?>素材</h4>
    </div>
    <div class="modal-body">

<div class="control-group">
    <label class="control-label"><span style="color: red;">*</span>机构名称</label>
    <div class="controls">
        <input value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['name_sina'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['name_sina'];?>
<?php }?>"
            name="name" type="text" placeholder="" class="m-wrap span6" />
        <!-- <span class="help-inline">This is inline help</span> -->
    </div>
</div>

<div class="control-group">
    <label class="control-label">类型</label>
    <div class="controls">
        <select name="category" class="span6 m-wrap select2" placeholder="请选择学校...">
            <option value="0">请选择类型...</option>
            <?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['m']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['school_type']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value){
$_smarty_tpl->tpl_vars['m']->_loop = true;
?>
                <option <?php if (isset($_smarty_tpl->tpl_vars['role']->value['category'])&&$_smarty_tpl->tpl_vars['role']->value['category']==$_smarty_tpl->tpl_vars['m']->value['id']){?>selected<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['m']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['m']->value['name'];?>
</option>
            <?php } ?>
        </select>
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