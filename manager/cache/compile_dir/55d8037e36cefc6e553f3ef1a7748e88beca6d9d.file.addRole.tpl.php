<?php /* Smarty version Smarty-3.1.8, created on 2018-04-23 10:32:18
         compiled from "/erlang/elixir_demo/manager/application/views/system/addRole.tpl" */ ?>
<?php /*%%SmartyHeaderCode:224442425add45b27061e9-74143908%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '55d8037e36cefc6e553f3ef1a7748e88beca6d9d' => 
    array (
      0 => '/erlang/elixir_demo/manager/application/views/system/addRole.tpl',
      1 => 1524212142,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '224442425add45b27061e9-74143908',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'role' => 0,
    'system_menu' => 0,
    'm' => 0,
    'mm' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5add45b275dda5_33656916',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5add45b275dda5_33656916')) {function content_5add45b275dda5_33656916($_smarty_tpl) {?><form name="ff" id="ff" class="form-horizontal ajax_form" action="/system/addRole" method='post'>
    <input type="hidden" name="id" value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['id'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['id'];?>
<?php }?>" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
         <h4 class="modal-title"><?php if (isset($_smarty_tpl->tpl_vars['role']->value['id'])){?>编辑<?php }else{ ?>新增<?php }?>角色</h4>
    </div>
    <div class="modal-body">

<!-- BEGIN FORM-->
<div class="control-group">

    <label class="control-label">角色名称</label>

    <div class="controls">

        <input value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['role_name'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['role_name'];?>
<?php }?>"
            name="role_name" type="text" placeholder="small" class="m-wrap span6" <?php if (isset($_smarty_tpl->tpl_vars['role']->value['id'])){?>readonly<?php }?>  />

        <!-- <span class="help-inline">This is inline help</span> -->

    </div>

</div>

<div class="control-group">
    <label class="control-label">访问导航权限</label>
    <div class="controls">
            <select name="menu_ids[]" class="span6 m-wrap select2" multiple placeholder="请选择导航...">
                <?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['m']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['system_menu']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value){
$_smarty_tpl->tpl_vars['m']->_loop = true;
?>
                    <optgroup label="<?php echo $_smarty_tpl->tpl_vars['m']->value['menu_name'];?>
">
                        <?php  $_smarty_tpl->tpl_vars['mm'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['mm']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['m']->value['child']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['mm']->key => $_smarty_tpl->tpl_vars['mm']->value){
$_smarty_tpl->tpl_vars['mm']->_loop = true;
?>
                            <option
                                <?php if (isset($_smarty_tpl->tpl_vars['role']->value['menu_ids'])&&in_array($_smarty_tpl->tpl_vars['mm']->value['id'],$_smarty_tpl->tpl_vars['role']->value['menu_ids'])){?>selected<?php }?>
                            value="<?php echo $_smarty_tpl->tpl_vars['mm']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['mm']->value['menu_name'];?>
-<?php echo $_smarty_tpl->tpl_vars['mm']->value['controller'];?>
/<?php echo $_smarty_tpl->tpl_vars['mm']->value['action'];?>
</option>
                        <?php } ?>
                    </optgroup>
                <?php } ?>
            </select>
    </div>
</div>


<div class="control-group">
    <label class="control-label" >是否启用</label>
    <div class="controls">
        <label class="radio">
        <input <?php if (isset($_smarty_tpl->tpl_vars['role']->value['status'])&&$_smarty_tpl->tpl_vars['role']->value['status']=='1'){?>checked<?php }?><?php if (!isset($_smarty_tpl->tpl_vars['role']->value['status'])){?>checked<?php }?>
        type="radio" name="status" value="1" />
        启用
        </label>
        <label class="radio">
        <input <?php if (isset($_smarty_tpl->tpl_vars['role']->value['status'])&&$_smarty_tpl->tpl_vars['role']->value['status']=='2'){?>checked<?php }?>
            type="radio" name="status" value="2" />
        禁用
        </label>
    </div>
</div>

<div class="control-group">
    <label class="control-label">备注</label>
    <div class="controls">
        <input value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['note'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['note'];?>
<?php }?>"
             name="note" type="text" placeholder="note" class="m-wrap span6" />
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