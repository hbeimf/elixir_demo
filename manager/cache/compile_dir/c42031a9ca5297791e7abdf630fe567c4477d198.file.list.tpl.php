<?php /* Smarty version Smarty-3.1.8, created on 2018-04-20 16:22:53
         compiled from "/erlang/elixir_demo/manager/application/views/teacher/list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15661872845ad9a35d759c63-56630454%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c42031a9ca5297791e7abdf630fe567c4477d198' => 
    array (
      0 => '/erlang/elixir_demo/manager/application/views/teacher/list.tpl',
      1 => 1524212142,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15661872845ad9a35d759c63-56630454',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'has_add_right' => 0,
    'params' => 0,
    'school_id' => 0,
    'users' => 0,
    'r' => 0,
    'course_type' => 0,
    'has_unenable_right' => 0,
    'has_enable_right' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5ad9a35d7a0754_03658998',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ad9a35d7a0754_03658998')) {function content_5ad9a35d7a0754_03658998($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("include/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>



<!-- BEGIN PAGE CONTENT-->
<div class="row-fluid">
    <div class="span12">

        <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet-body">
                
                <div class="clearfix">
                    <?php if ($_smarty_tpl->tpl_vars['has_add_right']->value['flg']){?>
                    <div class="btn-group pull-right">
                        <a data-toggle="modal" data-target="#mod_900" href="/teacher/add/" class="btn green" >
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
                            <label>教师名称: <input value="<?php echo $_smarty_tpl->tpl_vars['params']->value['name'];?>
" name="name" type="text" aria-controls="sample_1" class="m-wrap medium"> &nbsp;&nbsp;</label>
                            <!-- <label>邮箱: <input name="email" type="text" aria-controls="sample_1" class="m-wrap medium"> &nbsp;&nbsp;</label> -->
                            <label>账号(手机): <input value="<?php echo $_smarty_tpl->tpl_vars['params']->value['phone'];?>
" name="phone" type="text" aria-controls="sample_1" class="m-wrap medium"> &nbsp;&nbsp;</label>

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
                            <th class="hidden-480">老师名称</th>
                            <th class="hidden-480">老师头像</th>
                            <th class="hidden-480">二维码</th>


                            <th class="hidden-480">账号(手机)</th>
                            <th class="hidden-480">email</th>
                            <?php if ($_smarty_tpl->tpl_vars['school_id']->value==0){?>
                            <th class="hidden-480">所在机构</th>
                            <?php }?>
                            <th class="hidden-480">课程类型</th>
                            <th class="hidden-480">性别</th>
                            <th class="hidden-480">创建时间</th>
                            <th class="hidden-480">更新时间</th>
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
                            <td><img style="widht:121px;height:121px;" src="<?php echo $_smarty_tpl->tpl_vars['r']->value['dir'];?>
" /></td>
                            <td><img style="widht:121px;height:121px;" src="<?php echo qrcode(array('id'=>$_smarty_tpl->tpl_vars['r']->value['id'],'role'=>'teacher'),$_smarty_tpl);?>
" /></td>

                            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['phone'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['email'];?>
</td>
                            <?php if ($_smarty_tpl->tpl_vars['school_id']->value==0){?>
                            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['school_name'];?>
</td>
                            <?php }?>
                            <td>
                                <?php echo course_type(array('type'=>$_smarty_tpl->tpl_vars['r']->value['course_type'],'types'=>$_smarty_tpl->tpl_vars['course_type']->value),$_smarty_tpl);?>

                            </td>
                            <td>
                                <?php echo gender(array('g'=>$_smarty_tpl->tpl_vars['r']->value['gender']),$_smarty_tpl);?>

                            </td>
                            
                            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['created_at'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['updated_at'];?>
</td>
                            <td><?php if ($_smarty_tpl->tpl_vars['r']->value['is_enabled']==1){?>启用<?php }else{ ?><font color=red>禁用</font><?php }?></td>
                            
                            <td>
                                 <?php if ($_smarty_tpl->tpl_vars['has_add_right']->value['flg']){?>
                                <a data-toggle="modal" data-target="#mod_1200" href="/teacher/add/id/<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
/"
                                    class="btn grey">
                                    <i class="fa fa-pencil"></i>编辑
                                </a>
                                <?php }?>

                                <!-- <a data-link="/school/del/id/<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
/"
                                    class="btn red ajax-delete">
                                    <i class="fa fa-pencil"></i>删除
                                </a> -->
                                <?php if ($_smarty_tpl->tpl_vars['r']->value['is_enabled']==1){?>
                                <?php if ($_smarty_tpl->tpl_vars['has_unenable_right']->value['flg']){?>
                                <a data-link="/teacher/unenable/id/<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
/"
                                    class="btn red ajax-delete" data-msg="确认要禁用吗？">
                                    <i class="fa fa-pencil"></i>禁用
                                </a>
                                <?php }?>
                                <?php }else{ ?>
                                <?php if ($_smarty_tpl->tpl_vars['has_enable_right']->value['flg']){?>
                                <a data-link="/teacher/enable/id/<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
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