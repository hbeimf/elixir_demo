<?php /* Smarty version Smarty-3.1.8, created on 2018-03-26 10:37:35
         compiled from "/web/m.demo.com/application/views/course/add.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4249776665a4eddea59f703-62252150%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '462f9278194bdb0db5752e80e28f42de62e9b666' => 
    array (
      0 => '/web/m.demo.com/application/views/course/add.tpl',
      1 => 1522031815,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4249776665a4eddea59f703-62252150',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5a4eddea6ae990_83269636',
  'variables' => 
  array (
    'role' => 0,
    'account_school_id' => 0,
    'school' => 0,
    'm' => 0,
    'school_id' => 0,
    'course_type' => 0,
    'teacher' => 0,
    't' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a4eddea6ae990_83269636')) {function content_5a4eddea6ae990_83269636($_smarty_tpl) {?><form name="ff" id="ff" class="form-horizontal ajax_form" action="/course/add" method='post' enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['id'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['id'];?>
<?php }?>" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
         <h4 class="modal-title"><?php if (isset($_smarty_tpl->tpl_vars['role']->value['id'])){?>编辑<?php }else{ ?>新增<?php }?>课表</h4>
    </div>
    <div class="modal-body">

<!-- BEGIN FORM-->
<div class="control-group">
    <label class="control-label">星期</label>
    <div class="controls">
        <select id="week" name="week" class="span6 m-wrap select2" placeholder="请选择星期...">
            <option <?php if (isset($_smarty_tpl->tpl_vars['role']->value['week'])&&$_smarty_tpl->tpl_vars['role']->value['week']==1){?>selected<?php }?> value="1">周一</option>
            <option <?php if (isset($_smarty_tpl->tpl_vars['role']->value['week'])&&$_smarty_tpl->tpl_vars['role']->value['week']==2){?>selected<?php }?> value="2">周二</option>
            <option <?php if (isset($_smarty_tpl->tpl_vars['role']->value['week'])&&$_smarty_tpl->tpl_vars['role']->value['week']==3){?>selected<?php }?> value="3">周三</option>
            <option <?php if (isset($_smarty_tpl->tpl_vars['role']->value['week'])&&$_smarty_tpl->tpl_vars['role']->value['week']==4){?>selected<?php }?> value="4">周四</option>
            <option <?php if (isset($_smarty_tpl->tpl_vars['role']->value['week'])&&$_smarty_tpl->tpl_vars['role']->value['week']==5){?>selected<?php }?> value="5">周五</option>
            <option <?php if (isset($_smarty_tpl->tpl_vars['role']->value['week'])&&$_smarty_tpl->tpl_vars['role']->value['week']==6){?>selected<?php }?> value="6">周六</option>
            <option <?php if (isset($_smarty_tpl->tpl_vars['role']->value['week'])&&$_smarty_tpl->tpl_vars['role']->value['week']==7){?>selected<?php }?> value="7">周日</option>
        </select>
    </div>
</div>

<?php if ($_smarty_tpl->tpl_vars['account_school_id']->value>0){?>
<input type="hidden" name="school_id" value="<?php echo $_smarty_tpl->tpl_vars['account_school_id']->value;?>
">
<?php }else{ ?>
<div class="control-group">
    <label class="control-label">所在机构</label>
    <div class="controls">
        <!-- <select id="school_id" name="school_id" class="span6 m-wrap select2" placeholder="请选择学校...">
            <?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['m']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['school']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value){
$_smarty_tpl->tpl_vars['m']->_loop = true;
?>
                <option <?php if (isset($_smarty_tpl->tpl_vars['role']->value['school_id'])&&$_smarty_tpl->tpl_vars['role']->value['school_id']==$_smarty_tpl->tpl_vars['m']->value['id']){?>selected<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['m']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['m']->value['name'];?>
</option>
            <?php } ?>
        </select> -->
            <?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['m']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['school']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value){
$_smarty_tpl->tpl_vars['m']->_loop = true;
?>
                <?php if (isset($_smarty_tpl->tpl_vars['school_id']->value)&&$_smarty_tpl->tpl_vars['school_id']->value==$_smarty_tpl->tpl_vars['m']->value['id']){?>
                    <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['m']->value['name'];?>
" readonly="true" class="span6 m-wrap" />
                    <input type="hidden" name="school_id" value="<?php echo $_smarty_tpl->tpl_vars['m']->value['id'];?>
">
                <?php }?> 
            <?php } ?>

    </div>
</div>
<?php }?>

<div class="control-group">
    <label class="control-label">上课时间</label>
    <div class="controls" style="padding-left: 30px;">
        <div class="input-append bootstrap-timepicker-component">
            <input name="begin_at" class="m-wrap m-ctrl-small timepicker-24" type="text" value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['begin_at'])){?><?php echo date("H:i",$_smarty_tpl->tpl_vars['role']->value['begin_at']);?>
<?php }?>"  />
            <span class="add-on"><i class="icon-time"></i></span>
        </div>
        至
        <div class="input-append bootstrap-timepicker-component">
            <input value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['end_at'])){?><?php echo date("H:i",$_smarty_tpl->tpl_vars['role']->value['end_at']);?>
<?php }?>" name="end_at" class="m-wrap m-ctrl-small timepicker-24" type="text"  />
            <span class="add-on"><i class="icon-time"></i></span>
        </div>
        
    </div>
</div>

<div class="control-group">
    <label class="control-label">课程类型</label>
    <div class="controls">
            <select id="course_type" name="course_type" class="span6 m-wrap select2"  placeholder="请选择课程类型...">
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
    <label class="control-label">老师</label>
    <div class="controls">
        <select id="teacher_id" name="teacher_id" class="span6 m-wrap select2" placeholder="请选择老师...">
            <option selected value="0">请选老师...</option>
            <?php  $_smarty_tpl->tpl_vars['t'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['t']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['teacher']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['t']->key => $_smarty_tpl->tpl_vars['t']->value){
$_smarty_tpl->tpl_vars['t']->_loop = true;
?>
                <option <?php if (isset($_smarty_tpl->tpl_vars['role']->value['teacher_id'])&&$_smarty_tpl->tpl_vars['role']->value['teacher_id']==$_smarty_tpl->tpl_vars['t']->value['id']){?>selected<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['t']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['t']->value['name'];?>
</option>
            <?php } ?>
        </select>
    </div>
</div>


<!-- <div class="control-group">
    <label class="control-label">上课时间</label>
    <div class="controls">
        <div class="input-append date form_datetime">
            <input size="16" type="text" value="" readonly class="m-wrap">
            <span class="add-on"><i class="icon-calendar"></i></span>
        </div>
    </div>
</div> -->








<div class="control-group">
    <label class="control-label" >是否启用</label>
    <div class="controls">
        <label class="radio">
        <input <?php if (isset($_smarty_tpl->tpl_vars['role']->value['is_enabled'])&&$_smarty_tpl->tpl_vars['role']->value['is_enabled']=='1'){?>checked<?php }?> <?php if (!isset($_smarty_tpl->tpl_vars['role']->value['is_enabled'])){?>checked<?php }?>
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

<!-- <div class="control-group">
    <label class="control-label">备注</label>
    <div class="controls">
        <input value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['note'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['note'];?>
<?php }?>"
             name="note" type="text" placeholder="note" class="m-wrap span6" />
        <span class="help-inline"></span>
    </div>

</div> -->



<!-- END FORM-->


    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button id="btn_add" type="button" class="btn btn-primary blue">保存</button>
    </div>
</form>
<?php }} ?>