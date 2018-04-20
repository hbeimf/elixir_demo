<?php /* Smarty version Smarty-3.1.8, created on 2018-04-03 16:36:48
         compiled from "/mnt/web/m.demo.com/application/views/school/add.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13995134085ac33d205cccb6-14883404%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a191f29e9c9d0f6f32445e693e500cf1ef357331' => 
    array (
      0 => '/mnt/web/m.demo.com/application/views/school/add.tpl',
      1 => 1522641537,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13995134085ac33d205cccb6-14883404',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'role' => 0,
    'school_type' => 0,
    'm' => 0,
    'province' => 0,
    'p' => 0,
    'city' => 0,
    'c' => 0,
    'area' => 0,
    'a' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5ac33d2062b419_79894992',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ac33d2062b419_79894992')) {function content_5ac33d2062b419_79894992($_smarty_tpl) {?><form name="ff" id="ff" class="form-horizontal ajax_form" action="/school/add" method='post' enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['id'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['id'];?>
<?php }?>" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
         <h4 class="modal-title"><?php if (isset($_smarty_tpl->tpl_vars['role']->value['id'])){?>编辑<?php }else{ ?>新增<?php }?>学校/组织</h4>
    </div>
    <div class="modal-body">

<!-- BEGIN FORM-->
<div class="control-group">
    <label class="control-label"><span style="color: red;">*</span>机构名称</label>
    <div class="controls">
        <input value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['name'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['name'];?>
<?php }?>"
            name="name" type="text" placeholder="" class="m-wrap span6" />
        <!-- <span class="help-inline">This is inline help</span> -->
    </div>
</div>

<div class="control-group">
    <label class="control-label">机构类型</label>
    <div class="controls">
        <select name="school_type_id" class="span6 m-wrap select2" placeholder="请选择学校...">
            <!-- <option value="0">请选择学校...</option> -->
            <?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['m']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['school_type']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value){
$_smarty_tpl->tpl_vars['m']->_loop = true;
?>
                <option <?php if (isset($_smarty_tpl->tpl_vars['role']->value['school_type_id'])&&$_smarty_tpl->tpl_vars['role']->value['school_type_id']==$_smarty_tpl->tpl_vars['m']->value['id']){?>selected<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['m']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['m']->value['name'];?>
</option>
            <?php } ?>
        </select>
    </div>
</div>

<div class="control-group">
    <label class="control-label"><span style="color: red;">*</span>联系人姓名</label>
    <div class="controls">
        <input value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['contact_name'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['contact_name'];?>
<?php }?>"
            name="contact_name" type="text" placeholder="" class="m-wrap span6" />
        <!-- <span class="help-inline">This is inline help</span> -->
    </div>
</div>

<div class="control-group">
    <label class="control-label"><span style="color: red;">*</span>手机号</label>
    <div class="controls">
        <input value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['phone'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['phone'];?>
<?php }?>"
            name="phone" type="text" placeholder="" class="m-wrap span6" />
        <!-- <span class="help-inline">This is inline help</span> -->
    </div>
</div>

<div class="control-group">
    <label class="control-label"><span style="color: red;">*</span>邮箱</label>
    <div class="controls">
        <input value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['email'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['email'];?>
<?php }?>"
            name="email" type="text" placeholder="" class="m-wrap span6" />
        <!-- <span class="help-inline">This is inline help</span> -->
    </div>
</div>

<div class="control-group">
    <label class="control-label"><span style="color: red;">*</span>地址</label>
    <div class="controls">
        <select name="province" class="span2 m-wrap select2" placeholder="请选择学校...">
            <option value="0">请选择省...</option>
            <?php  $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['p']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['province']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['p']->key => $_smarty_tpl->tpl_vars['p']->value){
$_smarty_tpl->tpl_vars['p']->_loop = true;
?>
                <option <?php if (isset($_smarty_tpl->tpl_vars['role']->value['province'])&&$_smarty_tpl->tpl_vars['role']->value['province']==$_smarty_tpl->tpl_vars['p']->value['provinceid']){?>selected<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['p']->value['provinceid'];?>
"><?php echo $_smarty_tpl->tpl_vars['p']->value['province'];?>
</option>
            <?php } ?>
        </select>
    
     <select name="city" class="span2 m-wrap select2" placeholder="请选择学校...">
            <option value="0">请选择市...</option>
            <?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['city']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
?>
                <option <?php if (isset($_smarty_tpl->tpl_vars['role']->value['city'])&&$_smarty_tpl->tpl_vars['role']->value['city']==$_smarty_tpl->tpl_vars['c']->value['cityid']){?>selected<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['c']->value['cityid'];?>
"><?php echo $_smarty_tpl->tpl_vars['c']->value['city'];?>
</option>
            <?php } ?>
        </select>
        
        <select name="area" class="span2 m-wrap select2" placeholder="请选择学校...">
            <option value="0">请选择区...</option>
            <?php  $_smarty_tpl->tpl_vars['a'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['a']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['area']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['a']->key => $_smarty_tpl->tpl_vars['a']->value){
$_smarty_tpl->tpl_vars['a']->_loop = true;
?>
                <option <?php if (isset($_smarty_tpl->tpl_vars['role']->value['area'])&&$_smarty_tpl->tpl_vars['role']->value['area']==$_smarty_tpl->tpl_vars['a']->value['areaid']){?>selected<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['a']->value['areaid'];?>
"><?php echo $_smarty_tpl->tpl_vars['a']->value['area'];?>
</option>
            <?php } ?>
        </select>


    </div>
</div>

<div class="control-group">
    <label class="control-label"><span style="color: red;">*</span>详细地址</label>
    <div class="controls">
        <input value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['address'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['address'];?>
<?php }?>"
            name="address" type="text" placeholder="" class="m-wrap span6" />
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

<div class="control-group">
    <label class="control-label">合同文件</label>
    <div class="controls" style="padding-left: 30px;">
        <div class="fileupload fileupload-new" data-provides="fileupload">
            <div class="input-append">
                <div class="uneditable-input">
                    <i class="icon-file fileupload-exists"></i> 
                    <span class="fileupload-preview"></span>
                </div>
                <span class="btn btn-file">
                <span class="fileupload-new">选择合同</span>
                <span class="fileupload-exists">修改</span>
                <input name="contract_file" value="" type="file" class="default" />
                </span>
                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">移去</a>
            </div>
            <span class="help-inline"><?php if (isset($_smarty_tpl->tpl_vars['role']->value['id'])){?>如不需修改合同文件，请不要选择<?php }?></span>
        </div>
    </div>
</div>



<!-- demo 年月日 时分秒 -->
<!-- <div class="control-group">
    <label class="control-label">Default Datetimepicker</label>
    <div class="controls">
        <div class="input-append date form_datetime">
            <input size="16" type="text" value="" readonly class="m-wrap">
            <span class="add-on"><i class="icon-calendar"></i></span>
        </div>
    </div>
</div>  -->

<div class="control-group">
    <label class="control-label"><span style="color: red;">*</span>合同有效期</label>
    <div class="controls" style="padding-left: 30px;">
        <div class="input-append date form_datetime_d">
            <input name="contract_start_time" size="16" type="text" value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['contract_start_time'])){?><?php echo date("Y-m-d",$_smarty_tpl->tpl_vars['role']->value['contract_start_time']);?>
<?php }?>" readonly class="m-wrap">
            <span class="add-on"><i class="icon-calendar"></i></span>
        </div> 至
        <div class="input-append date form_datetime_d">
            <input name="contract_end_time"  size="16" type="text" value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['contract_end_time'])){?><?php echo date("Y-m-d",$_smarty_tpl->tpl_vars['role']->value['contract_end_time']);?>
<?php }?>" readonly class="m-wrap">
            <span class="add-on"><i class="icon-calendar"></i></span>
        </div>
    </div>
</div>

<!-- <div class="control-group">
    <label class="control-label">结束日期</label>
    <div class="controls">
        <div class="input-append date form_datetime_d">
            <input size="16" type="text" value="" readonly class="m-wrap">
            <span class="add-on"><i class="icon-calendar"></i></span>
        </div>
    </div>
</div> -->




<!-- END FORM-->


    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button id="btn_add" type="button" class="btn btn-primary blue">保存</button>
    </div>
</form>


<!-- file:///C:/Users/Administrator/Desktop/doc/ftpm_112_bwx/ftpm_112_bwx/ui_jqueryui.html -->
<!-- file:///C:/Users/Administrator/Desktop/doc/ftpm_112_bwx/ftpm_112_bwx/form_component.html --><?php }} ?>