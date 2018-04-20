<?php /* Smarty version Smarty-3.1.8, created on 2018-04-03 14:38:22
         compiled from "/mnt/web/m.demo.com/application/views/system/addAccount.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3350098985ac3215e6f80c1-48722062%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '02a45213cbd1a6d562d60815e2c1972df7b72f50' => 
    array (
      0 => '/mnt/web/m.demo.com/application/views/system/addAccount.tpl',
      1 => 1522641537,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3350098985ac3215e6f80c1-48722062',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'account' => 0,
    'roles' => 0,
    'r' => 0,
    'school' => 0,
    'm' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5ac3215e73bab7_86750941',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ac3215e73bab7_86750941')) {function content_5ac3215e73bab7_86750941($_smarty_tpl) {?><form name="ff" id="ff" class="form-horizontal ajax_form" action="/system/addaccount" method='post'>
    <input type="hidden" name="id" value="<?php if (isset($_smarty_tpl->tpl_vars['account']->value['id'])){?><?php echo $_smarty_tpl->tpl_vars['account']->value['id'];?>
<?php }?>" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
         <h4 class="modal-title"><?php if (isset($_smarty_tpl->tpl_vars['account']->value['id'])){?>编辑<?php }else{ ?>新增<?php }?>账号</h4>
    </div>
    <div class="modal-body">

<!-- BEGIN FORM-->
<div class="control-group">
    <label class="control-label">昵称</label>
    <div class="controls">
        <input value="<?php if (isset($_smarty_tpl->tpl_vars['account']->value['nickname'])){?><?php echo $_smarty_tpl->tpl_vars['account']->value['nickname'];?>
<?php }?>"
            name="nickname" type="text" placeholder="请输入昵称..." class="m-wrap span6" />
        <!-- <span class="help-inline">This is inline help</span> -->
    </div>
</div>

<div class="control-group">
    <label class="control-label">账号</label>
    <div class="controls">
        <input value="<?php if (isset($_smarty_tpl->tpl_vars['account']->value['account_name'])){?><?php echo $_smarty_tpl->tpl_vars['account']->value['account_name'];?>
<?php }?>"
            name="account_name" type="text" placeholder="small" class="m-wrap span6" />
        <span class="help-inline"></span>
    </div>
</div>

<div class="control-group">
    <label class="control-label">密码</label>
    <div class="controls">
        <input value=""
            name="passwd" type="password" placeholder="small" class="m-wrap span6" />
        <span class="help-inline">修改时不填为不修改</span>
    </div>
</div>


<div class="control-group">
    <label class="control-label">角色</label>
    <div class="controls">
            <select name="role_id[]" class="span6 m-wrap select2" multiple placeholder="请选择角色...">
                <?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['roles']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
$_smarty_tpl->tpl_vars['r']->_loop = true;
?>
                            <option
                                <?php if (isset($_smarty_tpl->tpl_vars['account']->value['role_id'])&&in_array($_smarty_tpl->tpl_vars['r']->value['id'],$_smarty_tpl->tpl_vars['account']->value['role_id'])){?>selected<?php }?>
                            value="<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['r']->value['role_name'];?>
</option>

                <?php } ?>
            </select>
    </div>
</div>

<?php if (isset($_smarty_tpl->tpl_vars['account']->value['id'])){?>
<div class="control-group">
    <label class="control-label">所在机构</label>
    <div class="controls">
        <input value="<?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['m']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['school']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value){
$_smarty_tpl->tpl_vars['m']->_loop = true;
?><?php if (isset($_smarty_tpl->tpl_vars['account']->value['school_id'])&&$_smarty_tpl->tpl_vars['account']->value['school_id']==$_smarty_tpl->tpl_vars['m']->value['id']){?><?php echo $_smarty_tpl->tpl_vars['m']->value['name'];?>
<?php }?><?php } ?>"
            name="school_id" type="text" placeholder="" class="m-wrap span6" readonly="true" />
        <span class="help-inline">此项出错后影响太大，暂时不支持编辑</span>
    </div>
</div>
<?php }else{ ?>
<div class="control-group">
    <label class="control-label">所在机构</label>
    <div class="controls">
        <select name="school_id" class="span6 m-wrap select2" placeholder="请选择学校...">
            <option value="0">请选择机构...</option>
            <?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['m']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['school']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value){
$_smarty_tpl->tpl_vars['m']->_loop = true;
?>
                <option <?php if (isset($_smarty_tpl->tpl_vars['account']->value['school_id'])&&$_smarty_tpl->tpl_vars['account']->value['school_id']==$_smarty_tpl->tpl_vars['m']->value['id']){?>selected<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['m']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['m']->value['name'];?>
</option>
            <?php } ?>
        </select>
        <span class="help-inline">公司管理人员不用选择</span>
    </div>
</div>
<?php }?>


<div class="control-group">
    <label class="control-label">Email</label>
    <div class="controls">
        <input value="<?php if (isset($_smarty_tpl->tpl_vars['account']->value['email'])){?><?php echo $_smarty_tpl->tpl_vars['account']->value['email'];?>
<?php }?>"
            name="email" type="text" placeholder="small" class="m-wrap span6" />
        <span class="help-inline"></span>
    </div>
</div>

<div class="control-group">
    <label class="control-label">电话</label>
    <div class="controls">
        <input value="<?php if (isset($_smarty_tpl->tpl_vars['account']->value['phone'])){?><?php echo $_smarty_tpl->tpl_vars['account']->value['phone'];?>
<?php }?>"
            name="phone" type="text" placeholder="small" class="m-wrap span6" />
        <span class="help-inline"></span>
    </div>
</div>


<div class="control-group">
    <label class="control-label" >是否启用</label>
    <div class="controls">
        <label class="radio">
        <input <?php if (isset($_smarty_tpl->tpl_vars['account']->value['status'])&&$_smarty_tpl->tpl_vars['account']->value['status']=='1'){?>checked<?php }?><?php if (!isset($_smarty_tpl->tpl_vars['account']->value['status'])){?>checked<?php }?>
        type="radio" name="status" value="1" />
        启用
        </label>
        <label class="radio">
        <input <?php if (isset($_smarty_tpl->tpl_vars['account']->value['status'])&&$_smarty_tpl->tpl_vars['account']->value['status']=='2'){?>checked<?php }?>
            type="radio" name="status" value="2" />
        禁用
        </label>
    </div>
</div>

<div class="control-group">
    <label class="control-label">备注</label>
    <div class="controls">
        <input value="<?php if (isset($_smarty_tpl->tpl_vars['account']->value['note'])){?><?php echo $_smarty_tpl->tpl_vars['account']->value['note'];?>
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