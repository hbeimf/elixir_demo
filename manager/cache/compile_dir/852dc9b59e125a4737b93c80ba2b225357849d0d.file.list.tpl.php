<?php /* Smarty version Smarty-3.1.8, created on 2018-04-03 15:09:39
         compiled from "/mnt/web/m.demo.com/application/views/school/list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11632757445ac328b3d76501-42947928%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '852dc9b59e125a4737b93c80ba2b225357849d0d' => 
    array (
      0 => '/mnt/web/m.demo.com/application/views/school/list.tpl',
      1 => 1522641537,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11632757445ac328b3d76501-42947928',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'has_add_right' => 0,
    'params' => 0,
    'users' => 0,
    'r' => 0,
    'has_download_right' => 0,
    'has_unenable_right' => 0,
    'has_enable_right' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5ac328b3db4107_40211121',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ac328b3db4107_40211121')) {function content_5ac328b3db4107_40211121($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("include/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>



<!-- BEGIN PAGE CONTENT-->
<div class="row-fluid">
    <div class="span12">

        <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet-body">
                <div class="clearfix">
                    <?php if ($_smarty_tpl->tpl_vars['has_add_right']->value['flg']){?>
                        <div class="btn-group pull-right">
                            <a data-toggle="modal" data-target="#mod_1200" href="/school/add/" class="btn green" >
                            新增 <i class="icon-plus"></i>
                            </a>
                        </div>
                   
                    <?php }?>
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
                            <label>机构名称: <input value="<?php echo $_smarty_tpl->tpl_vars['params']->value['name'];?>
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
                            <th class="hidden-480">机构名称</th>
                            <th class="hidden-480">机构类型</th>
                            <th class="hidden-480">联系人</th>
                            <th class="hidden-480">手机号</th>
                            <th class="hidden-480">邮箱</th>

                            <th class="hidden-480">合同</th>
                            <th class="hidden-480">合同开始时间</th>
                            <th class="hidden-480">合同结束时间</th>
                            
                            <!-- <th class="hidden-480">创建时间</th>
                            <th class="hidden-480">更新时间</th> -->
                            <th class="hidden-480">省</th>
                            <th class="hidden-480">市</th>
                            <th class="hidden-480">区</th>



                            
                            <th class="hidden-480">是否启用</th>
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
                            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['type_name'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['contact_name'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['phone'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['email'];?>
</td>

                            <td>
                                <?php if ($_smarty_tpl->tpl_vars['has_download_right']->value['flg']){?>
                                <a href="/school/download/id/<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
" title="点击下载"><?php echo $_smarty_tpl->tpl_vars['r']->value['contract_name'];?>
</a>
                                <?php }else{ ?>
                                <?php echo $_smarty_tpl->tpl_vars['r']->value['contract_name'];?>

                                <?php }?>
                                
                            </td>

                            <td><?php echo date("Y-m-d H:i:s",$_smarty_tpl->tpl_vars['r']->value['contract_start_time']);?>
</td>
                            <td><?php echo date("Y-m-d H:i:s",$_smarty_tpl->tpl_vars['r']->value['contract_end_time']);?>
</td>
                            
                            
                           <!--  <td><?php echo $_smarty_tpl->tpl_vars['r']->value['created_at'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['updated_at'];?>
</td> -->
                            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['province_name'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['city_name'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['area_name'];?>
</td>

                            <td><?php if ($_smarty_tpl->tpl_vars['r']->value['is_enabled']==1){?>启用<?php }else{ ?><font color=red>禁用</font><?php }?></td>
                            
                            <td>
                                <?php if ($_smarty_tpl->tpl_vars['has_add_right']->value['flg']){?>
                                <a data-toggle="modal" data-target="#mod_1200" href="/school/add/id/<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
/"
                                    class="btn grey">
                                    <i class="fa fa-pencil"></i>编辑
                                </a>
                             
                                <?php }?>

                                <!-- <a data-link="/school/del/id/<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
/"
                                    class="btn red ajax-delete">
                                    <i class="fa fa-pencil"></i>删除
                                </a>
                                 -->
                                  <?php if ($_smarty_tpl->tpl_vars['r']->value['is_enabled']==1){?>
                                <?php if ($_smarty_tpl->tpl_vars['has_unenable_right']->value['flg']){?>
                                <a data-link="/school/unenable/id/<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
/"
                                    class="btn red ajax-delete" data-msg="确认要禁用吗？">
                                    <i class="fa fa-pencil"></i>禁用
                                </a>
                               
                                <?php }?>
                                <?php }else{ ?>
                                    <?php if ($_smarty_tpl->tpl_vars['has_enable_right']->value['flg']){?>
                                    <a data-link="/school/enable/id/<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
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

<?php echo $_smarty_tpl->getSubTemplate ("include/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>





<?php }} ?>