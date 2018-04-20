<?php /* Smarty version Smarty-3.1.8, created on 2018-03-15 13:35:32
         compiled from "/web/m.demo.com/application/views/ppt/font.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12409490395a5d59829abdf8-26441605%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '73b331edb16bda64d943019c4a3fc13b585fb6b2' => 
    array (
      0 => '/web/m.demo.com/application/views/ppt/font.tpl',
      1 => 1521092125,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12409490395a5d59829abdf8-26441605',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5a5d5982a120b9_81100643',
  'variables' => 
  array (
    'role' => 0,
    'params' => 0,
    'users' => 0,
    'r' => 0,
    'area' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a5d5982a120b9_81100643')) {function content_5a5d5982a120b9_81100643($_smarty_tpl) {?><form name="ff" id="ff" class="form-horizontal ajax_form" action="/pic/add" method='post' enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php if (isset($_smarty_tpl->tpl_vars['role']->value['id'])){?><?php echo $_smarty_tpl->tpl_vars['role']->value['id'];?>
<?php }?>" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
         <h4 class="modal-title">文字音频列表</h4>
    </div>
    <div class="modal-body">

<!-- BEGIN FORM-->
<!-- BEGIN PAGE CONTENT-->
<div class="row-fluid">
    <div class="span12">

        <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet-body">
                
                <!-- 搜索开始 -->
                <div class="row-fluid">
                    <form>
                        <div id="sample_1_length" class="dataTables_length">
                            <label>每页显示:
                                <select size="1" name="page_size" aria-controls="sample_1" class="m-wrap small">
                                    <option value="10" <?php if ($_smarty_tpl->tpl_vars['params']->value['page_size']==10){?>selected="selected"<?php }?>>10</option>
                                    <option value="15" <?php if ($_smarty_tpl->tpl_vars['params']->value['page_size']==15){?>selected="selected"<?php }?>>15</option>
                                    <option value="20" <?php if ($_smarty_tpl->tpl_vars['params']->value['page_size']==20){?>selected="selected"<?php }?>>20</option>
                                    <!-- <option value="-1">All</option> -->
                                </select>
                                &nbsp;&nbsp;
                            </label>
                            <label>名称: <input value="<?php echo $_smarty_tpl->tpl_vars['params']->value['name'];?>
" name="name" type="text" aria-controls="sample_1" class="m-wrap medium"> &nbsp;&nbsp;</label>
                            <!-- <label>邮箱: <input name="email" type="text" aria-controls="sample_1" class="m-wrap medium"> &nbsp;&nbsp;</label> -->
                            <label><button id="btn_search_font" type="button" class="btn btn-primary blue">查找</button></label>
                        </div>
                    </form>
                </div>
                <!-- 搜索结束  -->

                <!-- 表开始 -->
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                        <tr>
                            <!-- <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th> -->
                            <th style="width:8px;"></th>
                            <th class="hidden-480">ID</th>
                            <th class="hidden-480">文字</th>
                            <th class="hidden-480">音频</th>
                            <th class="hidden-480">音频属性</th>

                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['users']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
$_smarty_tpl->tpl_vars['r']->_loop = true;
?>
                        <tr class="odd gradeX">
                            <!-- <td><input type="checkbox" class="checkboxes" value="<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
" /></td> -->
                            <td><input name="font_select" type="radio" class="radio" value="<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
" data-font="<?php echo $_smarty_tpl->tpl_vars['r']->value['font'];?>
" data-mp3="<?php echo $_smarty_tpl->tpl_vars['r']->value['name'];?>
" /></td>
                            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['font'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['name'];?>
</td>
                            <td><?php if ($_smarty_tpl->tpl_vars['r']->value['mp3_type']==1){?><font color="green">背景音乐</font><?php }else{ ?>教学播放<?php }?></td>
                        </tr>
                        <?php } ?>

                    </tbody>
                </table>

                <!-- 分页开始 -->
                <?php echo $_smarty_tpl->getSubTemplate ("include/page_list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

                <!-- 分页结束 -->
                <!-- 表结束  -->

            </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>

</div>
<!-- END PAGE CONTENT-->


<!-- END FORM-->


    </div>
    <div class="modal-footer">
        <input type="hidden" name="area" value="<?php echo $_smarty_tpl->tpl_vars['area']->value;?>
">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button id="btn_add_font" type="button" class="btn btn-primary blue">确定</button>
    </div>
</form>
<?php }} ?>