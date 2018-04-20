<?php /* Smarty version Smarty-3.1.8, created on 2018-04-10 17:58:27
         compiled from "/mnt/web/m.demo.com/application/views/file/addFile.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17184661805ac209d3c24196-44015162%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '58a25f3229120440f5f233f75df2e6c9ef34dcec' => 
    array (
      0 => '/mnt/web/m.demo.com/application/views/file/addFile.tpl',
      1 => 1523351868,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17184661805ac209d3c24196-44015162',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5ac209d3c4ca30_34726924',
  'variables' => 
  array (
    'role' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ac209d3c4ca30_34726924')) {function content_5ac209d3c4ca30_34726924($_smarty_tpl) {?><form name="ff" id="ff" class="form-horizontal ajax_form" action="/file/addFile" method='post' enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['id'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['id'];?>
<?php }?>" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
         <h4 class="modal-title"><?php if (isset($_smarty_tpl->tpl_vars['role']->value['id'])){?>编辑<?php }else{ ?>新增<?php }?>素材</h4>
    </div>
    <div class="modal-body">



<div class="control-group">
    <label class="control-label">图片</label>
    <div class="controls">
        <div class="span6 fileupload fileupload-new" data-provides="fileupload">
            <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                <img src="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['dir'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['dir'];?>
<?php }else{ ?>/image/AAAAAA&amp;text=no+image<?php }?>" alt="" />
            </div>
            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
            <div>
                <span class="btn btn-file"><span class="fileupload-new">Select image</span>
                <span class="fileupload-exists">Change</span>
                <input name="img" type="file" class="default" /></span>
                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
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






<!-- END FORM-->


    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button id="btn_add" type="button" class="btn btn-primary blue">保存</button>
    </div>
</form>
<?php }} ?>