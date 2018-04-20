<?php /* Smarty version Smarty-3.1.8, created on 2018-04-11 15:26:11
         compiled from "/mnt/web/m.demo.com/application/views/font/add.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20878712485ac32fb6cc0645-21472416%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '507d1bf211ac225df94ad46237733eb617c00486' => 
    array (
      0 => '/mnt/web/m.demo.com/application/views/font/add.tpl',
      1 => 1523431459,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20878712485ac32fb6cc0645-21472416',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5ac32fb6cf1950_93344106',
  'variables' => 
  array (
    'curriculum_id' => 0,
    'role' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ac32fb6cf1950_93344106')) {function content_5ac32fb6cf1950_93344106($_smarty_tpl) {?><form name="ff" id="ff" class="form-horizontal ajax_form" action="/font/add/?curriculum_id=<?php echo $_smarty_tpl->tpl_vars['curriculum_id']->value;?>
" method='post' enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['id'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['id'];?>
<?php }?>" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
         <h4 class="modal-title"><?php if (isset($_smarty_tpl->tpl_vars['role']->value['id'])){?>编辑<?php }else{ ?>新增<?php }?>素材</h4>
    </div>
    <div class="modal-body">

<!-- BEGIN FORM-->
<div class="control-group">
    <label class="control-label">文字</label>
    <div class="controls">
        <input value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['font'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['font'];?>
<?php }?>"
            name="font" type="text" placeholder="" class="m-wrap span6" />
        <!-- <span class="help-inline">This is inline help</span> -->
    </div>
</div>
<div class="control-group">
    <label class="control-label">音频说明</label>
    <div class="controls">
        <input value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['mp3_desc'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['mp3_desc'];?>
<?php }?>"
            name="mp3_desc" type="text" placeholder="" class="m-wrap span6" />
        <!-- <span class="help-inline">This is inline help</span> -->
    </div>
</div>



<div class="control-group">
    <label class="control-label">上传音频</label>
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
    <label class="control-label" >音频属性</label>
    <div class="controls">
        <label class="radio">
        <input <?php if (isset($_smarty_tpl->tpl_vars['role']->value['mp3_type'])&&$_smarty_tpl->tpl_vars['role']->value['mp3_type']=='1'){?>checked<?php }?><?php if (!isset($_smarty_tpl->tpl_vars['role']->value['mp3_type'])){?>checked<?php }?>
        type="radio" name="mp3_type" value="1" />
        背景音乐
        </label>
        <label class="radio">
        <input <?php if (isset($_smarty_tpl->tpl_vars['role']->value['mp3_type'])&&$_smarty_tpl->tpl_vars['role']->value['mp3_type']=='0'){?>checked<?php }?>
            type="radio" name="mp3_type" value="0" />
        教学播放
        </label>
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