<?php /* Smarty version Smarty-3.1.8, created on 2018-04-23 10:30:56
         compiled from "/erlang/elixir_demo/manager/application/views/system/addMenu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7567054085add4560809120-30763894%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a5e83fb69da53da48ef3392318935347aa58efad' => 
    array (
      0 => '/erlang/elixir_demo/manager/application/views/system/addMenu.tpl',
      1 => 1524212142,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7567054085add4560809120-30763894',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'menu' => 0,
    'system_menu' => 0,
    'm' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5add4560890e74_78294692',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5add4560890e74_78294692')) {function content_5add4560890e74_78294692($_smarty_tpl) {?><form name="ff" id="ff" class="form-horizontal ajax_form" action="/system/addMenu" method='post'>
    <input value="<?php if (isset($_smarty_tpl->tpl_vars['menu']->value['id'])){?><?php echo $_smarty_tpl->tpl_vars['menu']->value['id'];?>
<?php }?>"
        name="id" type="hidden" />

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
         <h4 class="modal-title"><?php if (isset($_smarty_tpl->tpl_vars['menu']->value['id'])){?>编辑<?php }else{ ?>新增<?php }?>导航</h4>
    </div>
    <div class="modal-body">

        <!-- BEGIN FORM-->
        <div class="control-group">
            <label class="control-label">导航名称</label>
            <div class="controls">
                <input value="<?php if (isset($_smarty_tpl->tpl_vars['menu']->value['menu_name'])){?><?php echo $_smarty_tpl->tpl_vars['menu']->value['menu_name'];?>
<?php }?>"
                name="menu_name" type="text" placeholder="请输入导航名称..." class="m-wrap span4" />
                <!-- <span class="help-inline">This is inline help</span> -->
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">上级导航</label>
            <div class="controls">
                <select name="parent_id" class="span6 select2" placeholder="请选择导航...">
                    <option value="0">顶级导航</option>
                    <?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['m']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['system_menu']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value){
$_smarty_tpl->tpl_vars['m']->_loop = true;
?>
                        <option <?php if (isset($_smarty_tpl->tpl_vars['menu']->value['parent_id'])&&$_smarty_tpl->tpl_vars['menu']->value['parent_id']==$_smarty_tpl->tpl_vars['m']->value['id']){?>selected<?php }?>
                        value="<?php echo $_smarty_tpl->tpl_vars['m']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['m']->value['menu_name'];?>
 </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Controller</label>
            <div class="controls">
                <input value="<?php if (isset($_smarty_tpl->tpl_vars['menu']->value['controller'])){?><?php echo $_smarty_tpl->tpl_vars['menu']->value['controller'];?>
<?php }?>"
                name="controller" type="text"
                placeholder="请输入 Controller..." class="m-wrap span6" <?php if (isset($_smarty_tpl->tpl_vars['menu']->value['id'])){?>readonly<?php }?> />
                <span class="help-inline"></span>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Action</label>
            <div class="controls">
                <input value="<?php if (isset($_smarty_tpl->tpl_vars['menu']->value['action'])){?><?php echo $_smarty_tpl->tpl_vars['menu']->value['action'];?>
<?php }?>"
                    name="actions" type="text"
                    placeholder="请输入 Action..." class="m-wrap span6" <?php if (isset($_smarty_tpl->tpl_vars['menu']->value['id'])){?>readonly<?php }?> />
                <span class="help-inline"></span>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" >是否启用</label>
            <div class="controls">
                <label class="radio">
                <input <?php if (isset($_smarty_tpl->tpl_vars['menu']->value['status'])&&$_smarty_tpl->tpl_vars['menu']->value['status']=='1'){?>checked<?php }?>
                    type="radio" name="status" value="1" />
                启用
                </label>
                <label class="radio">
                <input <?php if (isset($_smarty_tpl->tpl_vars['menu']->value['status'])&&$_smarty_tpl->tpl_vars['menu']->value['status']=='2'){?>checked<?php }?>
                    <?php if (!isset($_smarty_tpl->tpl_vars['menu']->value['status'])){?>checked<?php }?>
                type="radio" name="status" value="2" />
                禁用
                </label>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" >类别</label>
            <div class="controls">
                <label class="radio">
                <input <?php if (isset($_smarty_tpl->tpl_vars['menu']->value['type'])&&$_smarty_tpl->tpl_vars['menu']->value['type']=='1'){?>checked<?php }?>
                    type="radio" name="type" value="1" />
                导航
                </label>
                <label class="radio">
                <input <?php if (isset($_smarty_tpl->tpl_vars['menu']->value['type'])&&$_smarty_tpl->tpl_vars['menu']->value['type']=='2'){?>checked<?php }?> <?php if (!isset($_smarty_tpl->tpl_vars['menu']->value['type'])){?>checked<?php }?>
                    type="radio" name="type" value="2" />
                功能
                </label>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">备注</label>
            <div class="controls">
                <input
                    value="<?php if (isset($_smarty_tpl->tpl_vars['menu']->value['note'])){?><?php echo $_smarty_tpl->tpl_vars['menu']->value['note'];?>
<?php }?>"
                 name="note" type="text" placeholder="请输入备注..." class="m-wrap span6" />
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