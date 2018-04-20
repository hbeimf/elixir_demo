<?php /* Smarty version Smarty-3.1.8, created on 2018-04-11 16:37:37
         compiled from "/mnt/web/m.demo.com/application/views/curriculum/add.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2176929685ac32551d2a544-68481909%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9fcdabc3b3150b746b90df6ac305bb1e1347b860' => 
    array (
      0 => '/mnt/web/m.demo.com/application/views/curriculum/add.tpl',
      1 => 1523435833,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2176929685ac32551d2a544-68481909',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5ac32551d559c4_77339301',
  'variables' => 
  array (
    'curriculum_id' => 0,
    'role' => 0,
    'step_id' => 0,
    'show_flg' => 0,
    'has_delete_right' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ac32551d559c4_77339301')) {function content_5ac32551d559c4_77339301($_smarty_tpl) {?><form name="ff" id="ff" class="form-horizontal ajax_form" action="/curriculum/addstep/?curriculum_id=<?php echo $_smarty_tpl->tpl_vars['curriculum_id']->value;?>
" method='post' enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
         <h4 class="modal-title"><?php if (isset($_smarty_tpl->tpl_vars['role']->value['id'])){?>编辑<?php }else{ ?>新增<?php }?>课程</h4>
    </div>
    <div class="modal-body">

<!-- BEGIN FORM-->
<div class="control-group">
    <label class="control-label">步骤名称</label>
    <div class="controls">
        <input value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['name'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['name'];?>
<?php }?>"
            name="name" type="text" placeholder="" class="m-wrap span6" />
        <!-- <span class="help-inline">This is inline help</span> -->
    </div>
</div>

<div class="control-group">
    <label class="control-label" >资源类型</label>
    <div class="controls">
        <label class="radio">
        <input <?php if (isset($_smarty_tpl->tpl_vars['role']->value['res_type'])&&$_smarty_tpl->tpl_vars['role']->value['res_type']=='1'){?>checked<?php }?><?php if (!isset($_smarty_tpl->tpl_vars['role']->value['res_type'])){?>checked<?php }?>
        type="radio" name="res_type" value="1" />
        PPT
        </label>
        <label class="radio">
        <input <?php if (isset($_smarty_tpl->tpl_vars['role']->value['res_type'])&&$_smarty_tpl->tpl_vars['role']->value['res_type']=='2'){?>checked<?php }?>
            type="radio" name="res_type" value="2" />
        乐谱
        </label>
    </div>
</div>

<div id="div_select_ppt" class="control-group" style="display: none;">
    <label class="control-label">选择PPT</label>
    <div class="controls" style="padding-left: 25px;">
        	<a data-toggle="modal" data-target="#mod_900" href="/curriculum/ppt/?curriculum_id=<?php echo $_smarty_tpl->tpl_vars['curriculum_id']->value;?>
" class="btn black" >选择PPT</a>
    </div>
</div>

<div id="div_select_music" class="control-group" style="display: none;">
    <label class="control-label">选择乐谱</label>
    <div class="controls" style="padding-left: 25px;">
        	<a data-toggle="modal" data-target="#mod_900" href="/curriculum/music/?curriculum_id=<?php echo $_smarty_tpl->tpl_vars['curriculum_id']->value;?>
" class="btn black" >选择乐谱</a>
    </div>
    <!-- <div class="controls" id="div_select_music_content" style="padding-left:25px;margin-top: 20px;">
	    <table style="width: 100%;">
	        <tr>
	            <td>乐谱名称:  xxxxxxxxxxxxxxx</td> 
	        </tr>
	       <tr>
	           <td><img style="widht:100%;" src="http://yx.pmdaniu.com/237/44039/357db737edee6aeed296cbdbe514ff24/images/%E8%AF%BE%E7%A8%8B%E7%AE%A1%E7%90%86/%E4%B9%90%E8%B0%B1%E5%B1%95%E7%A4%BA%E5%9B%BE_u7301.png"></td> 
	        </tr>
	         
	    </table>
     </div> -->
</div>


<div id="div_music_con" class="control-group span10" style="margin-left:100px; height: 400px; display:none;">
    <table style="width: 100%;">
        <tr>
            <td id="music_name" style="text-align: center;">
                    乐谱名称:  xxxxxxxxxxxxxxx
            </td>
        </tr>
        <tr>
            <td>
                <div style="height: 200px; padding-top: 5px;">
                    	<img id="music_png" style="widht:100%;" src="">
                </div>
            </td>
        </tr>
    </table>
</div>





<div id="tpl_1" class="control-group span10" style="margin-left:100px; height: 400px; display: none;">
    <table style="width: 100%;">
        <tr>
            <td style="border: black solid 1px; ">

                <div style="height: 200px; padding-top: 5px; padding-left: 20px;">
                    <div id="area_11_font" style="margin-top: 10px; ">
                                    文字: 提示：此处添加文字音频
                    </div>
                    <div style="margin-top: 10px;">
                        <img id='area_11_img' style="width: 100px; height: 100px; margin-top: 10px;" src="/upload/201801/19/4b111001ee630322aecfe1eace465a1e.png" />
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td style="border-left: black solid 1px;border-right: black solid 1px;border-bottom: black solid 1px;">

                <div style="height: 200px; padding-top: 5px; padding-left: 20px;">

                            <div id="area_12_font" style="margin-top: 10px;">
                                文字: 提示：此处添加文字音频
                            </div>
                            <div id="area_12_mp3" style="margin-top: 10px;">
                                音频: 此处添加文字音频
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
                    <div style="height: 200px; padding-top: 5px; padding-left: 20px;">

                            <div id="area_21_font" style="margin-top: 10px;">
                                文字: 提示：此处添加文字音频
                            </div>
                            <div id="area_21_mp3" style="margin-top: 10px;">
                                音频: 此处添加文字音频
                            </div>
                    </div>
            </td>
            <td style="border-right: black solid 1px;border-bottom: black solid 1px;border-top: black solid 1px;">
                    <div style="height: 200px; padding-top: 5px; padding-left: 20px;">
                            <div id="area_22_font" style="margin-top: 10px;">
                                文字: 提示：此处添加文字音频
                            </div>
                            <div style="margin-top: 10px;">
                                <img id='area_22_img' style="width: 100px; height: 100px; margin-top: 10px;" src="/upload/201801/19/4b111001ee630322aecfe1eace465a1e.png" />
                            </div>
                    </div>
            </td>
        </tr>
        <tr>
           <td style="border-left: black solid 1px;border-bottom: black solid 1px;border-right: black solid 1px;">
                   <div style="height: 200px; padding-top: 5px; padding-left: 20px;">

                            <div id="area_23_font" style="margin-top: 10px;">
                                文字: 提示：此处添加文字音频
                            </div>
                            <div id="area_23_mp3" style="margin-top: 10px;">
                                音频: 此处添加文字音频
                            </div>
                    </div>
            </td>
           <td style="border-bottom: black solid 1px;border-right: black solid 1px;">
                    <div style="height: 200px; padding-top: 5px; padding-left: 20px;">

                            <div id="area_24_font" style="margin-top: 10px;">
                                文字: 提示：此处添加文字音频
                            </div>
                            <div id="area_24_mp3" style="margin-top: 10px;">
                                音频: 此处添加文字音频
                            </div>
                    </div>
            </td>
        </tr>
    </table>
</div>




<!-- END FORM-->

    </div>
    <div class="modal-footer">
        <input type="hidden" name="music_id" id="input_music_id" value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['music_id'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['music_id'];?>
<?php }else{ ?>0<?php }?>" />
        <input type="hidden" name="ppt_id" id="input_ppt_id" value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['ppt_id'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['ppt_id'];?>
<?php }else{ ?>0<?php }?>" />
        <input type="hidden" name="curriculum_step_id" id="curriculum_step_id" value="<?php echo $_smarty_tpl->tpl_vars['step_id']->value;?>
" />

        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <?php if (!isset($_smarty_tpl->tpl_vars['show_flg']->value)){?>

        <?php if ($_smarty_tpl->tpl_vars['has_delete_right']->value['flg']){?>
        <button id="btn_delete" type="button" class="btn btn-primary red" data-link="/curriculum/delete/?step_id=<?php echo $_smarty_tpl->tpl_vars['step_id']->value;?>
">删除</button>
        <?php }?>
        <button id="btn_add" type="button" class="btn btn-primary blue">保存</button>
        <?php }?>
    </div>
</form>
<?php }} ?>