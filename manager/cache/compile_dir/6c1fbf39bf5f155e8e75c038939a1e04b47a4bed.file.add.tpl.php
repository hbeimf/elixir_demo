<?php /* Smarty version Smarty-3.1.8, created on 2018-04-11 15:47:33
         compiled from "/mnt/web/m.demo.com/application/views/ppt/add.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18823363205ac357528b3354-17507580%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6c1fbf39bf5f155e8e75c038939a1e04b47a4bed' => 
    array (
      0 => '/mnt/web/m.demo.com/application/views/ppt/add.tpl',
      1 => 1523432836,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18823363205ac357528b3354-17507580',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5ac3575290cc61_78590910',
  'variables' => 
  array (
    'curriculum_id' => 0,
    'role' => 0,
    'area11' => 0,
    'area12' => 0,
    'area21' => 0,
    'area22' => 0,
    'area23' => 0,
    'area24' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ac3575290cc61_78590910')) {function content_5ac3575290cc61_78590910($_smarty_tpl) {?><form name="ff" id="ff" class="form-horizontal ajax_form" action="/ppt/add/?curriculum_id=<?php echo $_smarty_tpl->tpl_vars['curriculum_id']->value;?>
" method='post' enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['id'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['id'];?>
<?php }?>" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
         <h4 class="modal-title"><?php if (isset($_smarty_tpl->tpl_vars['role']->value['id'])){?>编辑<?php }else{ ?>新增<?php }?>PPT</h4>
    </div>
    <div class="modal-body">

<!-- BEGIN FORM-->
<div class="control-group">
    <label class="control-label">PPT名称</label>
    <div class="controls">
        <input value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['name'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['name'];?>
<?php }?>"
            name="name" type="text" placeholder="" class="m-wrap span6" />
        <!-- <span class="help-inline">This is inline help</span> -->
    </div>
</div>

<div class="control-group">
    <label class="control-label" >选择模板</label>
    <div class="controls">
        <label class="radio">
        <input <?php if (isset($_smarty_tpl->tpl_vars['role']->value['class_type'])&&$_smarty_tpl->tpl_vars['role']->value['class_type']=='1'){?>checked<?php }?><?php if (!isset($_smarty_tpl->tpl_vars['role']->value['class_type'])){?>checked<?php }?>
        type="radio" name="class_type" value="1" />
        模板1
        </label>
        <label class="radio">
        <input <?php if (isset($_smarty_tpl->tpl_vars['role']->value['class_type'])&&$_smarty_tpl->tpl_vars['role']->value['class_type']=='2'){?>checked<?php }?>
            type="radio" name="class_type" value="2" />
        模板2
        </label>
    </div>
</div>

<div id="tpl_1" class="control-group span10" style="margin-left:100px; height: 400px; display: none;">
    <table style="width: 100%;">
        <tr>
            <td style="border: black solid 1px;">
                    <div style="height: 200px; padding-top: 5px;">
                        <label class="control-label" style="">提示：此部分添加图片</label>
                        <div class="controls">
                            <a data-toggle="modal" data-target="#mod_900" href="/ppt/pic/?area=11&curriculum_id=<?php echo $_smarty_tpl->tpl_vars['curriculum_id']->value;?>
" class="btn green" > 
                            选择图片
                            </a>
                            <br />
                            <?php if (isset($_smarty_tpl->tpl_vars['role']->value['class_type'])&&$_smarty_tpl->tpl_vars['role']->value['class_type']==1&&isset($_smarty_tpl->tpl_vars['area11']->value['dir'])){?>
                                <img id='area_11' style="width: 100px; height: 100px; margin-top: 10px; margin-left: 150px;" src="<?php echo $_smarty_tpl->tpl_vars['area11']->value['dir'];?>
" />
                            <?php }else{ ?>
                                <img id='area_11' style="width: 100px; height: 100px; margin-top: 10px; margin-left: 150px; display: none;" src="" />
                            <?php }?>
                            
                        </div>
                    </div>
            </td>
        </tr>
        <tr>
            <td style="border-left: black solid 1px;border-right: black solid 1px;border-bottom: black solid 1px;">
                <div style="height: 200px; padding-top: 5px;">
                    <label class="control-label" style="">提示：此处添加文字音频</label>
                    <div class="controls">
                        <a data-toggle="modal" data-target="#mod_900" href="/ppt/font/?area=12&curriculum_id=<?php echo $_smarty_tpl->tpl_vars['curriculum_id']->value;?>
" class="btn green" >
                        选择文字音频
                        </a>
                        <br />
                        <div id="area_12_font" style="margin-top: 30px;">
                            <?php if (isset($_smarty_tpl->tpl_vars['role']->value['class_type'])&&$_smarty_tpl->tpl_vars['role']->value['class_type']==1&&isset($_smarty_tpl->tpl_vars['area12']->value['font'])){?>
                            文字: <?php echo $_smarty_tpl->tpl_vars['area12']->value['font'];?>

                            <?php }?>
                        </div>
                        <div id="area_12_mp3" style="margin-top: 10px;">
                             <?php if (isset($_smarty_tpl->tpl_vars['role']->value['class_type'])&&$_smarty_tpl->tpl_vars['role']->value['class_type']==1&&isset($_smarty_tpl->tpl_vars['area12']->value['mp3'])){?>
                            音频: <?php echo $_smarty_tpl->tpl_vars['area12']->value['mp3'];?>

                            <?php }?>
                        </div>

                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>


<div id="tpl_2" class="control-group span10" style=" margin-left:100px; height: 400px; display: none;">
    <table style="width: 100%;">
        <tr>
            <td style="border: black solid 1px; width: 50%;">
                    <div style="height: 200px; padding-top: 5px;">
                    <label class="control-label" style="">提示：此处添加文字音频</label>
                    <div class="controls">
                        <a data-toggle="modal" data-target="#mod_900" href="/ppt/font/?area=21&curriculum_id=<?php echo $_smarty_tpl->tpl_vars['curriculum_id']->value;?>
" class="btn green" >
                        选择文字音频
                        </a>
                        <br />
                        <div id="area_21_font" style="margin-top: 30px;">
                            <?php if (isset($_smarty_tpl->tpl_vars['role']->value['class_type'])&&$_smarty_tpl->tpl_vars['role']->value['class_type']==2&&isset($_smarty_tpl->tpl_vars['area21']->value['font'])){?>
                            文字: <?php echo $_smarty_tpl->tpl_vars['area21']->value['font'];?>

                            <?php }?>
                        </div>
                        <div id="area_21_mp3" style="margin-top: 10px;">
                             <?php if (isset($_smarty_tpl->tpl_vars['role']->value['class_type'])&&$_smarty_tpl->tpl_vars['role']->value['class_type']==2&&isset($_smarty_tpl->tpl_vars['area21']->value['mp3'])){?>
                            音频: <?php echo $_smarty_tpl->tpl_vars['area21']->value['mp3'];?>

                            <?php }?>
                        </div>

                    </div>
                </div>
            </td>
            <td style="border-right: black solid 1px;border-bottom: black solid 1px;border-top: black solid 1px;">
                    <div style="height: 200px; padding-top: 5px;">
                        <label class="control-label" style="">提示：此部分添加图片</label>
                        <div class="controls">
                            <a data-toggle="modal" data-target="#mod_900" href="/ppt/pic/?area=22&curriculum_id=<?php echo $_smarty_tpl->tpl_vars['curriculum_id']->value;?>
" class="btn green" >
                            选择图片
                            </a>
                            <br />
                            <?php if (isset($_smarty_tpl->tpl_vars['role']->value['class_type'])&&$_smarty_tpl->tpl_vars['role']->value['class_type']==2&&isset($_smarty_tpl->tpl_vars['area22']->value['dir'])){?>
                                <img id='area_22' style="width: 100px; height: 100px; margin-top: 10px; margin-left: 150px;" src="<?php echo $_smarty_tpl->tpl_vars['area22']->value['dir'];?>
" />
                            <?php }else{ ?>
                                <img id='area_22' style="width: 100px; height: 100px; margin-top: 10px; margin-left: 150px; display: none;" src="" />
                            <?php }?>
                        </div>
                    </div>
            </td>
        </tr>
        <tr>
           <td style="border-left: black solid 1px;border-bottom: black solid 1px;border-right: black solid 1px;">
                   <div style="height: 200px; padding-top: 5px;">
                    <label class="control-label" style="">提示：此处添加文字音频</label>
                    <div class="controls">
                        <a data-toggle="modal" data-target="#mod_900" href="/ppt/font/?area=23&curriculum_id=<?php echo $_smarty_tpl->tpl_vars['curriculum_id']->value;?>
" class="btn green" >
                        选择文字音频
                        </a>
                        <br />
                        <div id="area_23_font" style="margin-top: 30px;">
                            <?php if (isset($_smarty_tpl->tpl_vars['role']->value['class_type'])&&$_smarty_tpl->tpl_vars['role']->value['class_type']==2&&isset($_smarty_tpl->tpl_vars['area23']->value['font'])){?>
                            文字: <?php echo $_smarty_tpl->tpl_vars['area23']->value['font'];?>

                            <?php }?>
                        </div>
                        <div id="area_23_mp3" style="margin-top: 10px;">
                             <?php if (isset($_smarty_tpl->tpl_vars['role']->value['class_type'])&&$_smarty_tpl->tpl_vars['role']->value['class_type']==2&&isset($_smarty_tpl->tpl_vars['area23']->value['mp3'])){?>
                            音频: <?php echo $_smarty_tpl->tpl_vars['area23']->value['mp3'];?>

                            <?php }?>
                        </div>
                    </div>
                </div>
            </td>
           <td style="border-bottom: black solid 1px;border-right: black solid 1px;">
                    <div style="height: 200px; padding-top: 5px;">
                    <label class="control-label" style="">提示：此处添加文字音频</label>
                    <div class="controls">
                        <a data-toggle="modal" data-target="#mod_900" href="/ppt/font/?area=24&curriculum_id=<?php echo $_smarty_tpl->tpl_vars['curriculum_id']->value;?>
" class="btn green" >
                        选择文字音频
                        </a>
                        <br />
                        <div id="area_24_font" style="margin-top: 30px;">
                            <?php if (isset($_smarty_tpl->tpl_vars['role']->value['class_type'])&&$_smarty_tpl->tpl_vars['role']->value['class_type']==2&&isset($_smarty_tpl->tpl_vars['area24']->value['font'])){?>
                            文字: <?php echo $_smarty_tpl->tpl_vars['area24']->value['font'];?>

                            <?php }?>
                        </div>
                        <div id="area_24_mp3" style="margin-top: 10px;">
                             <?php if (isset($_smarty_tpl->tpl_vars['role']->value['class_type'])&&$_smarty_tpl->tpl_vars['role']->value['class_type']==2&&isset($_smarty_tpl->tpl_vars['area24']->value['mp3'])){?>
                            音频: <?php echo $_smarty_tpl->tpl_vars['area24']->value['mp3'];?>

                            <?php }?>
                        </div>

                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>

<div style="clear:both;"></div>

<div class="control-group">
    <label class="control-label" >是否启用</label>
    <div class="controls">
        <label class="radio">
        <input <?php if (isset($_smarty_tpl->tpl_vars['role']->value['is_enabled'])&&$_smarty_tpl->tpl_vars['role']->value['is_enabled']=='1'){?>checked<?php }?><?php if (!isset($_smarty_tpl->tpl_vars['role']->value['is_enabled'])){?>checked<?php }?> type="radio" name="is_enabled" value="1" />
        启用
        </label>
        <label class="radio">
        <input <?php if (isset($_smarty_tpl->tpl_vars['role']->value['is_enabled'])&&$_smarty_tpl->tpl_vars['role']->value['is_enabled']=='0'){?>checked<?php }?> type="radio" name="is_enabled" value="0" />
        禁用
        </label>
    </div>
</div>


<!-- END FORM-->


    </div>
    <div class="modal-footer">
        
        <input type="hidden" value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['class_type'])&&$_smarty_tpl->tpl_vars['role']->value['class_type']==1&&isset($_smarty_tpl->tpl_vars['area11']->value['id'])){?><?php echo $_smarty_tpl->tpl_vars['area11']->value['id'];?>
<?php }else{ ?>0<?php }?>" id="area_11_id" name="area_11_id" />
        <input type="hidden" value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['class_type'])&&$_smarty_tpl->tpl_vars['role']->value['class_type']==1&&isset($_smarty_tpl->tpl_vars['area12']->value['id'])){?><?php echo $_smarty_tpl->tpl_vars['area12']->value['id'];?>
<?php }else{ ?>0<?php }?>" id="area_12_id" name="area_12_id" />
        <input type="hidden" value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['class_type'])&&$_smarty_tpl->tpl_vars['role']->value['class_type']==2&&isset($_smarty_tpl->tpl_vars['area21']->value['id'])){?><?php echo $_smarty_tpl->tpl_vars['area21']->value['id'];?>
<?php }else{ ?>0<?php }?>" id="area_21_id" name="area_21_id" />
        <input type="hidden" value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['class_type'])&&$_smarty_tpl->tpl_vars['role']->value['class_type']==2&&isset($_smarty_tpl->tpl_vars['area22']->value['id'])){?><?php echo $_smarty_tpl->tpl_vars['area22']->value['id'];?>
<?php }else{ ?>0<?php }?>" id="area_22_id" name="area_22_id" />
        <input type="hidden" value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['class_type'])&&$_smarty_tpl->tpl_vars['role']->value['class_type']==2&&isset($_smarty_tpl->tpl_vars['area23']->value['id'])){?><?php echo $_smarty_tpl->tpl_vars['area23']->value['id'];?>
<?php }else{ ?>0<?php }?>" id="area_23_id" name="area_23_id" />
        <input type="hidden" value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['class_type'])&&$_smarty_tpl->tpl_vars['role']->value['class_type']==2&&isset($_smarty_tpl->tpl_vars['area24']->value['id'])){?><?php echo $_smarty_tpl->tpl_vars['area24']->value['id'];?>
<?php }else{ ?>0<?php }?>" id="area_24_id" name="area_24_id" />


        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button id="btn_add" type="button" class="btn btn-primary blue">保存</button>
    </div>
</form>
<?php }} ?>