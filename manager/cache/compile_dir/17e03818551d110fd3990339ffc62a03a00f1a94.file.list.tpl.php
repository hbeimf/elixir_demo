<?php /* Smarty version Smarty-3.1.8, created on 2018-04-13 16:45:08
         compiled from "/mnt/web/m.demo.com/application/views/pic/list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9903584335ac1bff05f3a99-47733507%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '17e03818551d110fd3990339ffc62a03a00f1a94' => 
    array (
      0 => '/mnt/web/m.demo.com/application/views/pic/list.tpl',
      1 => 1523606008,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9903584335ac1bff05f3a99-47733507',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5ac1bff062ad74_97931761',
  'variables' => 
  array (
    'params' => 0,
    'has_add_right' => 0,
    'debug' => 0,
    'users' => 0,
    'r' => 0,
    'has_unenable_right' => 0,
    'has_enable_right' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ac1bff062ad74_97931761')) {function content_5ac1bff062ad74_97931761($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['params']->value['curriculum_id']!=''){?>
<?php echo $_smarty_tpl->getSubTemplate ("include/iframe_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }else{ ?>
<?php echo $_smarty_tpl->getSubTemplate ("include/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }?>


<!-- BEGIN PAGE CONTENT-->
<div class="row-fluid">
    <div class="span12">

        <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet-body">
                <div class="clearfix">
                    <?php if ($_smarty_tpl->tpl_vars['has_add_right']->value['flg']){?>
                    <div class="btn-group pull-right">
                        <a data-toggle="modal" data-target="#mod_1200" href="/pic/add/?curriculum_id=<?php echo $_smarty_tpl->tpl_vars['params']->value['curriculum_id'];?>
" class="btn green" >
                        新增 <i class="icon-plus"></i>
                        </a>
                    </div>
                    <?php }?>
                </div>
                <!-- 搜索开始 -->
                <div class="row-fluid">
                    <form>
                        <input type="hidden" name="curriculum_id" value="<?php echo $_smarty_tpl->tpl_vars['params']->value['curriculum_id'];?>
">
                        <input type="hidden" name="debug" value="<?php echo $_smarty_tpl->tpl_vars['debug']->value;?>
">
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


                            <label><button id="btn_search" class="btn blue">查找 <!-- <i class="icon-plus"> --></i></button></label>
                        </div>
                    </form>
                </div>
                <!-- 搜索结束  -->

                <!-- 表开始 -->
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                        <tr>
                            <!-- <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th> -->
                            <th class="hidden-480">ID</th>
                            <th class="hidden-480">名称</th>
                            <th class="hidden-480">图片</th>
                            <th class="hidden-480">是否启用</th>
                            <th class="hidden-480">创建时间</th>
                            <th class="hidden-480">更新时间</th>
                            <th class="hidden-480">编辑</th>
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
                            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['name'];?>
</td>
                            <td><img src="<?php echo $_smarty_tpl->tpl_vars['r']->value['dir'];?>
" style="width:60px; height:60px;" /></td>
                            <td><?php if ($_smarty_tpl->tpl_vars['r']->value['is_enabled']==1){?>启用<?php }else{ ?><font color=red>禁用</font><?php }?></td>

                            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['created_at'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['updated_at'];?>
</td>
                            <td>
                                <?php if ($_smarty_tpl->tpl_vars['has_add_right']->value['flg']){?>
                                <a data-toggle="modal" data-target="#mod_1200" href="/pic/add/id/<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
/?curriculum_id=<?php echo $_smarty_tpl->tpl_vars['r']->value['curriculum_id'];?>
"
                                    class="btn grey">
                                    <i class="fa fa-pencil"></i>编辑
                                </a>
                                <?php }?>

                                <?php if ($_smarty_tpl->tpl_vars['r']->value['is_enabled']==1){?>
                                <?php if ($_smarty_tpl->tpl_vars['has_unenable_right']->value['flg']){?>
                                <a data-link="/pic/unenable/id/<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
/"
                                    class="btn red ajax-delete" data-msg="确认要禁用吗？">
                                    <i class="fa fa-pencil"></i>禁用
                                </a>
                                <?php }?>
                                <?php }else{ ?>
                                <?php if ($_smarty_tpl->tpl_vars['has_enable_right']->value['flg']){?>
                                <a data-link="/pic/enable/id/<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
/"
                                    class="btn green ajax-delete" data-msg="确认要启用吗？">
                                    <i class="fa fa-pencil"></i>启用
                                </a>
                                <?php }?>
                                <?php }?>
                            </td>

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
<?php if ($_smarty_tpl->tpl_vars['params']->value['curriculum_id']!=''){?>
<?php echo $_smarty_tpl->getSubTemplate ("include/iframe_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }else{ ?>
<?php echo $_smarty_tpl->getSubTemplate ("include/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }?>




<?php }} ?>