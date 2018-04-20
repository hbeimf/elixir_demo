<?php /* Smarty version Smarty-3.1.8, created on 2018-04-11 11:53:52
         compiled from "/mnt/web/m.demo.com/application/views/file/list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9702423915ac1bfe656c7e3-50433228%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '35319eb5e7ff2684fd606f36939d5ab930b0c34f' => 
    array (
      0 => '/mnt/web/m.demo.com/application/views/file/list.tpl',
      1 => 1523418755,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9702423915ac1bfe656c7e3-50433228',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5ac1bfe6593a80_14815347',
  'variables' => 
  array (
    'params' => 0,
    'users' => 0,
    'r' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ac1bfe6593a80_14815347')) {function content_5ac1bfe6593a80_14815347($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("include/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>



<!-- BEGIN PAGE CONTENT-->
<div class="row-fluid">
    <div class="span12">

        <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet-body">
                <div class="clearfix">
                    <div class="btn-group pull-right">
                        <a data-toggle="modal" data-target="#mod_1200" href="/file/addFile/" class="btn green" >
                        新增 <i class="icon-plus"></i>
                        </a>
                    </div>
                </div>
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
                            <th class="hidden-480">路径</th>
                            <th class="hidden-480">文件是否存在</th>
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
                            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['dir'];?>
</td>
                            <td><?php echo has_file(array('dir'=>$_smarty_tpl->tpl_vars['r']->value['dir']),$_smarty_tpl);?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['created_at'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['updated_at'];?>
</td>
                            <td>
                                <a data-toggle="modal" data-target="#mod_1200" href="/file/addFile/id/<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
/"
                                    class="btn grey">
                                    <i class="fa fa-pencil"></i>编辑
                                </a>

                                <a data-link="/file/delFile/id/<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
/"
                                    class="btn red ajax-delete">
                                    <i class="fa fa-pencil"></i>删除
                                </a>

                               <!--  <a data-link="/curriculum/enable/id/<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
/"
                                    class="btn gray window-layer" data-id="<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
">
                                    <i class="fa fa-pencil"></i>弹层
                                </a> -->

                                <a class="btn gray window-iframe"  
                                data-link="/pic/list" data-id="window_<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
" data-title="<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
-<?php echo $_smarty_tpl->tpl_vars['r']->value['name'];?>
">
                                    <i class="fa fa-pencil"></i>弹窗
                                </a>
                                
                                <a class="btn gray window-iframe"  
                                data-link="/pic/list1" data-id="window_<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
" data-title="<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
-<?php echo $_smarty_tpl->tpl_vars['r']->value['name'];?>
">
                                    <i class="fa fa-pencil"></i>弹窗list demo
                                </a>


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

<?php echo $_smarty_tpl->getSubTemplate ("include/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>





<?php }} ?>