<?php /* Smarty version Smarty-3.1.8, created on 2018-05-04 18:34:26
         compiled from "/erlang/elixir_demo/manager/application/views/file/list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15393593695ad9a3555752a8-38803636%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '578be90481b19282f7d26dca9d268d9ea4d6bc2f' => 
    array (
      0 => '/erlang/elixir_demo/manager/application/views/file/list.tpl',
      1 => 1525430064,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15393593695ad9a3555752a8-38803636',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5ad9a3555b6ee0_74357882',
  'variables' => 
  array (
    'params' => 0,
    'users' => 0,
    'r' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ad9a3555b6ee0_74357882')) {function content_5ad9a3555b6ee0_74357882($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("include/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>



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
                                <select name="page_size"  class="small">
                                    <option value="10" <?php if ($_smarty_tpl->tpl_vars['params']->value['page_size']==10){?>selected="selected"<?php }?>>10</option>
                                    <option value="15" <?php if ($_smarty_tpl->tpl_vars['params']->value['page_size']==15){?>selected="selected"<?php }?>>15</option>
                                    <option value="20" <?php if ($_smarty_tpl->tpl_vars['params']->value['page_size']==20){?>selected="selected"<?php }?>>20</option>
                                    <!-- <option value="-1">All</option> -->
                                </select>
                                &nbsp;&nbsp;
                            </label>
                            <label>名称sina: <input value="<?php echo $_smarty_tpl->tpl_vars['params']->value['namesina'];?>
" name="namesina" type="text" aria-controls="sample_1" class="m-wrap medium"> &nbsp;&nbsp;</label>
                            <label>codesina: <input value="<?php echo $_smarty_tpl->tpl_vars['params']->value['codesina'];?>
" name="codesina" type="text" aria-controls="sample_1" class="m-wrap medium"> &nbsp;&nbsp;</label>

                            <label>名称163: <input value="<?php echo $_smarty_tpl->tpl_vars['params']->value['name'];?>
" name="name" type="text" aria-controls="sample_1" class="m-wrap medium"> &nbsp;&nbsp;</label>
                            <label>code163: <input value="<?php echo $_smarty_tpl->tpl_vars['params']->value['code'];?>
" name="code" type="text" aria-controls="sample_1" class="m-wrap medium"> &nbsp;&nbsp;</label>
                            <label>关注: <input <?php if ($_smarty_tpl->tpl_vars['params']->value['category']==1){?>checked<?php }?> value="1" name="category" type="checkbox" aria-controls="sample_1" class="m-wrap"> &nbsp;&nbsp;</label>

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
                            <th class="hidden-480">codesina</th>
                            <th class="hidden-480">名称sina</th>
                            <th class="hidden-480">code163</th>
                            <th class="hidden-480">名称163</th>
                            <th class="hidden-480"><?php echo order_link(array('order_field'=>"cid",'order_by'=>$_smarty_tpl->tpl_vars['params']->value['order_by'],'title'=>"cid"),$_smarty_tpl);?>
</th>
                            <th class="hidden-480"><?php echo order_link(array('order_field'=>"category",'order_by'=>$_smarty_tpl->tpl_vars['params']->value['order_by'],'title'=>"关注"),$_smarty_tpl);?>
</th>


                            <th class="hidden-480">价格</th>
                            <th class="hidden-480">time</th>


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
                            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['code_sina'];?>
</td>
                            <td><a href="https://www.baidu.com/s?wd=<?php echo $_smarty_tpl->tpl_vars['r']->value['name_sina'];?>
" target="blank"><?php echo $_smarty_tpl->tpl_vars['r']->value['name_sina'];?>
</a></td>
                            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['code_163'];?>
</td>
                            <td><a href="https://www.baidu.com/s?wd=<?php echo $_smarty_tpl->tpl_vars['r']->value['name_163'];?>
" target="blank"><?php echo $_smarty_tpl->tpl_vars['r']->value['name_163'];?>
</a></td>
                            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['hid'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['category'];?>
</td>

                            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['price'];?>
￥</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['timer'];?>
</td>

                            <td>
                                <a data-toggle="modal" data-target="#mod_1200" href="/file/addFile/id/<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
/"
                                    class="btn grey">
                                    <i class="fa fa-pencil"></i>编辑
                                </a>

                                <a data-link="/file/addcategory/id/<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
/"
                                    class="btn red ajax-delete" data-msg="[ <?php echo $_smarty_tpl->tpl_vars['r']->value['name_sina'];?>
 ] 确认要 [++关注] 吗？">
                                    <i class="fa fa-pencil"></i>+关注
                                </a>
                                <a data-link="/file/minuscategory/id/<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
/"
                                    class="btn red ajax-delete" data-msg="[ <?php echo $_smarty_tpl->tpl_vars['r']->value['name_sina'];?>
 ] 确认要 [--关注] 吗？">
                                    <i class="fa fa-pencil"></i>-关注
                                </a>

                            
                               <!--  <a data-link="/curriculum/enable/id/<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
/"
                                    class="btn gray window-layer" data-id="<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
">
                                    <i class="fa fa-pencil"></i>弹层
                                </a> -->

                                <a class="btn gray window-iframe"  
                                data-link="/file/heap/?from=iframe&code=<?php echo $_smarty_tpl->tpl_vars['r']->value['code_sina'];?>
" data-id="window_<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
" data-title="堆积图demo">
                                    <i class="fa fa-pencil"></i>堆积图弹窗
                                </a>

                                <a class="btn gray window-iframe"  
                                data-link="/file/timelist/?from=iframe&code=<?php echo $_smarty_tpl->tpl_vars['r']->value['code_sina'];?>
" data-id="window_<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
" data-title="线状统计图demo">
                                    <i class="fa fa-pencil"></i>线状统计弹窗
                                </a>

                                <a class="btn gray window-iframe"  
                                data-link="/file/index/?from=iframe" data-id="window_<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
" data-title="柱状统计图demo">
                                    <i class="fa fa-pencil"></i>柱状统计弹窗
                                </a>

                                <a class="btn gray window-iframe"  
                                data-link="/pic/list" data-id="window_<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
" data-title="<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
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