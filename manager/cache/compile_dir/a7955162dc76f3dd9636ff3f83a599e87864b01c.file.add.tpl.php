<?php /* Smarty version Smarty-3.1.8, created on 2018-04-20 16:34:02
         compiled from "/erlang/elixir_demo/manager/application/views/pic/add.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8090003735ad9a5fa430c97-20383791%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a7955162dc76f3dd9636ff3f83a599e87864b01c' => 
    array (
      0 => '/erlang/elixir_demo/manager/application/views/pic/add.tpl',
      1 => 1524212142,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8090003735ad9a5fa430c97-20383791',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'curriculum_id' => 0,
    'role' => 0,
    'pic' => 0,
    'system_menu' => 0,
    'm' => 0,
    'mm' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5ad9a5fa46ca70_33886037',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ad9a5fa46ca70_33886037')) {function content_5ad9a5fa46ca70_33886037($_smarty_tpl) {?><form name="ff" id="ff" class="form-horizontal ajax_form" action="/pic/add/?curriculum_id=<?php echo $_smarty_tpl->tpl_vars['curriculum_id']->value;?>
" method='post' enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['id'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['id'];?>
<?php }?>" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
         <h4 class="modal-title"><?php if (isset($_smarty_tpl->tpl_vars['role']->value['id'])){?>编辑<?php }else{ ?>新增<?php }?>图片</h4>
    </div>
    <div class="modal-body">

<!-- BEGIN FORM-->



<div class="control-group">
    <label class="control-label">上传图片</label>
    <div class="controls">
        <div class="span6 fileupload fileupload-new" data-provides="fileupload">
            <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                <img src="<?php if (isset($_smarty_tpl->tpl_vars['pic']->value['dir'])){?><?php echo $_smarty_tpl->tpl_vars['pic']->value['dir'];?>
<?php }else{ ?>/image/AAAAAA&amp;text=no+image<?php }?>" alt="" />
            </div>
            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
            <div>
                <span class="btn btn-file"><span class="fileupload-new">选择图像</span>
                <span class="fileupload-exists">变更</span>
                <input name="img" type="file" class="default" /></span>
                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">移除</a>
            </div>
        </div>
        <!-- <span class="label label-important">NOTE!</span>
        <span>
        Attached image thumbnail is
        supported in Latest Firefox, Chrome, Opera, 
        Safari and Internet Explorer 10 only
        </span> -->
    </div>
</div>

<div class="control-group">
    <label class="control-label">图片名称</label>
    <div class="controls">
        <input value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['name'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['name'];?>
<?php }?>"
            name="name" type="text" placeholder="" class="m-wrap span6" />
        <!-- <span class="help-inline">This is inline help</span> -->
    </div>
</div>




<!-- <div class="control-group">
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
</option>
                        <?php } ?>
                    </optgroup>
                <?php } ?>
            </select>
    </div>
</div> -->


<!-- <div class="control-group">
    <label class="control-label" >是否启用</label>
    <div class="controls">
        <label class="radio">
        <input <?php if (isset($_smarty_tpl->tpl_vars['role']->value['status'])&&$_smarty_tpl->tpl_vars['role']->value['status']=='1'){?>checked<?php }?>
        type="radio" name="status" value="1" />
        启用
        </label>
        <label class="radio">
        <input <?php if (isset($_smarty_tpl->tpl_vars['role']->value['status'])&&$_smarty_tpl->tpl_vars['role']->value['status']=='2'){?>checked<?php }?>
            type="radio" name="status" value="2" />
        禁用
        </label>
    </div>
</div> -->

<div class="control-group">
    <label class="control-label">备注</label>
    <div class="controls">
        <input value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['note'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['note'];?>
<?php }?>"
             name="note" type="text" placeholder="" class="m-wrap span6" />
        <span class="help-inline"></span>
    </div>

</div>
<div class="control-group">
    <label class="control-label" >是否启用</label>
    <div class="controls">
        <label class="radio">
        <input <?php if (isset($_smarty_tpl->tpl_vars['role']->value['is_enabled'])&&$_smarty_tpl->tpl_vars['role']->value['is_enabled']=='1'){?>checked<?php }?><?php if (!isset($_smarty_tpl->tpl_vars['role']->value['is_enabled'])){?>checked<?php }?>
        type="radio" name="is_enabled" value="1" />
        启用
        </label>
        <label class="radio">
        <input <?php if (isset($_smarty_tpl->tpl_vars['role']->value['is_enabled'])&&$_smarty_tpl->tpl_vars['role']->value['is_enabled']=='0'){?>checked<?php }?> 
            type="radio" name="is_enabled" value="0" />
        禁用
        </label>
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