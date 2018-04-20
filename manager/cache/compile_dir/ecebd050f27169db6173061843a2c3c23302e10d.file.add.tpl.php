<?php /* Smarty version Smarty-3.1.8, created on 2018-03-30 12:32:51
         compiled from "/web/m.demo.com/application/views/teacher/add.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17421607295a5301b3e1a119-58370430%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ecebd050f27169db6173061843a2c3c23302e10d' => 
    array (
      0 => '/web/m.demo.com/application/views/teacher/add.tpl',
      1 => 1522215608,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17421607295a5301b3e1a119-58370430',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5a5301b3ed7598_28760368',
  'variables' => 
  array (
    'role' => 0,
    'school_id' => 0,
    'school' => 0,
    'm' => 0,
    'course_type' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a5301b3ed7598_28760368')) {function content_5a5301b3ed7598_28760368($_smarty_tpl) {?><form name="ff" id="ff" class="form-horizontal ajax_form" action="/teacher/add" method='post' enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['id'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['id'];?>
<?php }?>" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
         <h4 class="modal-title"><?php if (isset($_smarty_tpl->tpl_vars['role']->value['id'])){?>编辑<?php }else{ ?>新增<?php }?>教师</h4>
    </div>
    <div class="modal-body">

<!-- BEGIN FORM-->
<div class="control-group">
    <label class="control-label"><font color="red">*</font>老师名称</label>
    <div class="controls">
        <input value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['name'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['name'];?>
<?php }?>"
            name="name" type="text" placeholder="" class="m-wrap span6" />
        <!-- <span class="help-inline">This is inline help</span> -->
    </div>
</div>
<div class="control-group">
    <label class="control-label"><font color="red">*</font>老师头像</label>
    <div class="controls">
        <div class="span6 fileupload fileupload-new" data-provides="fileupload">
            <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                <img src="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['dir'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['dir'];?>
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

<?php if ($_smarty_tpl->tpl_vars['school_id']->value==0){?>
<div class="control-group">
    <label class="control-label"><font color="red">*</font>所在机构</label>
    <div class="controls">
        <select name="school_id" class="span6 m-wrap select2" placeholder="请选择学校...">
            <option value="0">请选择机构...</option>
            <?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['m']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['school']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value){
$_smarty_tpl->tpl_vars['m']->_loop = true;
?>
                <option <?php if (isset($_smarty_tpl->tpl_vars['role']->value['school_id'])&&$_smarty_tpl->tpl_vars['role']->value['school_id']==$_smarty_tpl->tpl_vars['m']->value['id']){?>selected<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['m']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['m']->value['name'];?>
</option>
            <?php } ?>
        </select>
    </div>
</div>
<?php }else{ ?>
<input type="hidden" name="school_id" value="<?php echo $_smarty_tpl->tpl_vars['school_id']->value;?>
" />
<?php }?>

<div class="control-group">
    <label class="control-label"><font color="red">*</font>课程类型</label>
    <div class="controls">
            <select name="course_type[]" class="span6 m-wrap select2" multiple placeholder="请选择课程类型...">
                <?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['m']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['course_type']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value){
$_smarty_tpl->tpl_vars['m']->_loop = true;
?>
                <option
                    <?php if (isset($_smarty_tpl->tpl_vars['role']->value['course_type'])&&in_array($_smarty_tpl->tpl_vars['m']->value['id'],$_smarty_tpl->tpl_vars['role']->value['course_type'])){?>selected<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['m']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['m']->value['name'];?>

                </option> 
                <?php } ?>
            </select>
    </div>
</div>

<div class="control-group">
    <label class="control-label"><font color="red">*</font>账号(手机)</label>
    <div class="controls">
        <input value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['phone'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['phone'];?>
<?php }?>" 
        <?php if (isset($_smarty_tpl->tpl_vars['role']->value['id'])){?>readonly<?php }?>
            name="phone" type="text" placeholder="" class="m-wrap span6" />
        <!-- <span class="help-inline">This is inline help</span> -->
    </div>
</div>

<div class="control-group">
    <label class="control-label"><?php if (!isset($_smarty_tpl->tpl_vars['role']->value['id'])){?><font color="red">*</font><?php }?>登录密码</label>
    <div class="controls">
        <input value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['passwd'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['passwd'];?>
<?php }?>"
             name="passwd" type="password" placeholder="" class="m-wrap span6" />
        <span class="help-inline"><?php if (isset($_smarty_tpl->tpl_vars['role']->value['id'])){?>不修改原密码保持为空即可<?php }?></span>
    </div>

</div>

<div class="control-group">
    <label class="control-label"><font color="red">*</font>Email</label>
    <div class="controls">
        <input value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['email'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['email'];?>
<?php }?>"
            name="email" type="text" placeholder="" class="m-wrap span6" />
        <!-- <span class="help-inline">This is inline help</span> -->
    </div>
</div>




<div class="control-group">
    <label class="control-label" >性别</label>
    <div class="controls">
        <label class="radio">
        <input <?php if (isset($_smarty_tpl->tpl_vars['role']->value['gender'])&&$_smarty_tpl->tpl_vars['role']->value['gender']=='male'){?>checked<?php }?>
        type="radio" name="gender" value="male" />
        男
        </label>
        <label class="radio">
        <input <?php if (isset($_smarty_tpl->tpl_vars['role']->value['gender'])&&$_smarty_tpl->tpl_vars['role']->value['gender']=='female'){?>checked<?php }?> <?php if (!isset($_smarty_tpl->tpl_vars['role']->value['gender'])){?>checked<?php }?>
            type="radio" name="gender" value="female" />
        女
        </label>

            
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