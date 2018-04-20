<?php /* Smarty version Smarty-3.1.8, created on 2018-04-20 16:27:51
         compiled from "/erlang/elixir_demo/manager/application/views/system/account.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10361160135ad9a4878c6464-58857062%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'df84c86f8dc3e725f9bd2b915ed9ec99e7962c6d' => 
    array (
      0 => '/erlang/elixir_demo/manager/application/views/system/account.tpl',
      1 => 1524212142,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10361160135ad9a4878c6464-58857062',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'params' => 0,
    'users' => 0,
    'r' => 0,
    'roles' => 0,
    'system_menu' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5ad9a487901fd7_60681425',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ad9a487901fd7_60681425')) {function content_5ad9a487901fd7_60681425($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("include/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>



<!-- BEGIN PAGE CONTENT-->
<div class="row-fluid">
    <div class="span12">

        <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet-body">
                <div class="clearfix">
                    <div class="btn-group pull-right">
                        <a data-toggle="modal" data-target="#mod_1200" href="/system/addAccount/" class="btn green" >
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
                            <label>账号名称: <input value="<?php echo $_smarty_tpl->tpl_vars['params']->value['name'];?>
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
                            <th class="hidden-480">昵称</th>
                            <th class="hidden-480">账号名称</th>
                            
                            <th class="hidden-480">角色</th>
                            <th class="hidden-480">所在机构</th>

                            <th class="hidden-480">状态</th>
                            <th class="hidden-480">导航</th>

                            <th class="hidden-480">创建时间</th>

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
                            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['nickname'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['name'];?>
</td>

                            <td><?php echo role_name(array('the_role'=>$_smarty_tpl->tpl_vars['r']->value['role_id'],'all_role'=>$_smarty_tpl->tpl_vars['roles']->value),$_smarty_tpl);?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['school_name'];?>
</td>
                            <td><?php if ($_smarty_tpl->tpl_vars['r']->value['status']=='1'){?>启用<?php }else{ ?><font color="red">禁用</font><?php }?></td>
                            <td><?php echo acount_menu(array('the_role'=>$_smarty_tpl->tpl_vars['r']->value['role_id'],'all_role'=>$_smarty_tpl->tpl_vars['roles']->value,'all_menu'=>$_smarty_tpl->tpl_vars['system_menu']->value),$_smarty_tpl);?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['created_at'];?>
</td>
                            <td>
                                <a data-toggle="modal" data-target="#mod_1200" href="/system/addAccount/id/<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
/"
                                    class="btn grey">
                                    <i class="fa fa-pencil"></i>编辑
                                </a>

                                <!-- <a data-link="/system/delRole/id/<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
/"
                                    class="btn red ajax-delete">
                                    <i class="fa fa-pencil"></i>删除
                                </a> -->

                                <?php if ($_smarty_tpl->tpl_vars['r']->value['status']==1){?>
                                <a data-link="/system/unenableaccount/id/<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
/"
                                    class="btn red ajax-delete" data-msg="确认要禁用吗？">
                                    <i class="fa fa-pencil"></i>禁用
                                </a>
                                <?php }else{ ?>
                                <a data-link="/system/enableaccount/id/<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
/"
                                    class="btn green ajax-delete" data-msg="确认要启用吗？">
                                    <i class="fa fa-pencil"></i>启用
                                </a>
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