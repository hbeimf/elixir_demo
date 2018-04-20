<?php /* Smarty version Smarty-3.1.8, created on 2018-03-29 14:08:07
         compiled from "/web/m.demo.com/application/views/music/add.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13989083835a585943048cc3-87625221%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2cc7b498e4cd53a7d98b2197880752e42f8ac617' => 
    array (
      0 => '/web/m.demo.com/application/views/music/add.tpl',
      1 => 1522215608,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13989083835a585943048cc3-87625221',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5a5859430cf4c6_84541118',
  'variables' => 
  array (
    'role' => 0,
    'tutorial' => 0,
    'm' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a5859430cf4c6_84541118')) {function content_5a5859430cf4c6_84541118($_smarty_tpl) {?><form name="ff" id="ff" class="form-horizontal ajax_form" action="/music/add" method='post' enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['id'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['id'];?>
<?php }?>" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
         <h4 class="modal-title"><?php if (isset($_smarty_tpl->tpl_vars['role']->value['id'])){?>编辑<?php }else{ ?>新增<?php }?>乐谱</h4>
    </div>
    <div class="modal-body">

<!-- BEGIN FORM-->

<div class="control-group">
    <label class="control-label">教材名称</label>
    <div class="controls">
        <select name="tutorial_id" class="span6 m-wrap select2" placeholder="请选择学校...">
            <option value="0">请选择教材...</option>
            <?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['m']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['tutorial']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value){
$_smarty_tpl->tpl_vars['m']->_loop = true;
?>
                <option <?php if (isset($_smarty_tpl->tpl_vars['role']->value['tutorial_id'])&&$_smarty_tpl->tpl_vars['role']->value['tutorial_id']==$_smarty_tpl->tpl_vars['m']->value['id']){?>selected<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['m']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['m']->value['name'];?>
</option>
            <?php } ?>
        </select>
    </div>
</div>

<div class="control-group">
    <label class="control-label">乐谱名称</label>
    <div class="controls">
        <input value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['name'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['name'];?>
<?php }?>"
            name="name" type="text" placeholder="" class="m-wrap span6" />
        <!-- <span class="help-inline">This is inline help</span> -->
    </div>
</div>

<div class="control-group">
    <label class="control-label">上传PNG</label>
    <div class="controls" style="padding-left: 30px;">
        <div class="fileupload fileupload-new" data-provides="fileupload">
            <div class="input-append">
                <div class="uneditable-input">
                    <i class="icon-file fileupload-exists"></i> 
                    <span class="fileupload-preview"></span>
                </div>
                <span class="btn btn-file">
                <span class="fileupload-new">选择文件</span>
                <span class="fileupload-exists">修改</span>
                <input name="png" value="" type="file" class="default" />
                </span>
                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">移去</a>
            </div>
            <span class="help-inline"><?php if (isset($_smarty_tpl->tpl_vars['role']->value['id'])){?>如不需修改，请不要选择<?php }?></span>
        </div>
    </div>
</div>

<div class="control-group">
    <label class="control-label">上传XML</label>
    <div class="controls" style="padding-left: 30px;">
        <div class="fileupload fileupload-new" data-provides="fileupload">
            <div class="input-append">
                <div class="uneditable-input">
                    <i class="icon-file fileupload-exists"></i> 
                    <span class="fileupload-preview"></span>
                </div>
                <span class="btn btn-file">
                <span class="fileupload-new">选择文件</span>
                <span class="fileupload-exists">修改</span>
                <input name="xml" value="" type="file" class="default" />
                </span>
                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">移去</a>
            </div>
            <span class="help-inline"><?php if (isset($_smarty_tpl->tpl_vars['role']->value['id'])){?>如不需修改，请不要选择<?php }?></span>
        </div>
    </div>
</div>
<div class="control-group">
    <label class="control-label">伴奏MP3</label>
    <div class="controls" style="padding-left: 30px;">
        <div class="fileupload fileupload-new" data-provides="fileupload">
            <div class="input-append">
                <div class="uneditable-input">
                    <i class="icon-file fileupload-exists"></i> 
                    <span class="fileupload-preview"></span>
                </div>
                <span class="btn btn-file">
                <span class="fileupload-new">选择文件</span>
                <span class="fileupload-exists">修改</span>
                <input name="mp3" value="" type="file" class="default" />
                </span>
                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">移去</a>
            </div>
            <span class="help-inline"><?php if (isset($_smarty_tpl->tpl_vars['role']->value['id'])){?>如不需修改，请不要选择<?php }?></span>
        </div>
    </div>
</div>
<div class="control-group">
    <label class="control-label">示范MP3</label>
    <div class="controls" style="padding-left: 30px;">
        <div class="fileupload fileupload-new" data-provides="fileupload">
            <div class="input-append">
                <div class="uneditable-input">
                    <i class="icon-file fileupload-exists"></i> 
                    <span class="fileupload-preview"></span>
                </div>
                <span class="btn btn-file">
                <span class="fileupload-new">选择文件</span>
                <span class="fileupload-exists">修改</span>
                <input name="mp3_demo" value="" type="file" class="default" />
                </span>
                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">移去</a>
            </div>
            <span class="help-inline"><?php if (isset($_smarty_tpl->tpl_vars['role']->value['id'])){?>如不需修改，请不要选择<?php }?></span>
        </div>
    </div>
</div>

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
<!-- END FORM-->


    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button id="btn_add" type="button" class="btn btn-primary blue">保存</button>
    </div>
</form>
<?php }} ?>