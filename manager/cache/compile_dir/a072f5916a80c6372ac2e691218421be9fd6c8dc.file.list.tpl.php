<?php /* Smarty version Smarty-3.1.8, created on 2018-03-28 13:40:19
         compiled from "/web/m.demo.com/application/views/curriculum/list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:719687595a5f1218d491e9-97477089%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a072f5916a80c6372ac2e691218421be9fd6c8dc' => 
    array (
      0 => '/web/m.demo.com/application/views/curriculum/list.tpl',
      1 => 1522215608,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '719687595a5f1218d491e9-97477089',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5a5f1218da6032_34880738',
  'variables' => 
  array (
    'has_add_right' => 0,
    'params' => 0,
    'users' => 0,
    'r' => 0,
    'has_edit_right' => 0,
    'has_addstep_right' => 0,
    's' => 0,
    'has_showstep_right' => 0,
    'has_unenable_right' => 0,
    'has_enable_right' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a5f1218da6032_34880738')) {function content_5a5f1218da6032_34880738($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("include/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<!-- BEGIN PAGE CONTENT-->
<div class="row-fluid">
    <div class="span12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet-body">
            <div class="clearfix">
                <?php if ($_smarty_tpl->tpl_vars['has_add_right']->value['flg']){?>
                <div class="btn-group pull-right">
                         <button id="btn_add_curriculum" type="button" class="btn btn-primary green">新增<i class="icon-plus"></i></button>
                </div>
                <?php }?>
            </div>
            <!-- 搜索开始 -->
            <div class="row-fluid">
                <form>
                    <div id="sample_1_length" class="dataTables_length">
                        <label>每页显示:
                            <select size="1" name="page_size" aria-controls="sample_1" class="m-wrap small">
                                <option value="10" <?php if ($_smarty_tpl->tpl_vars['params']->value['page_size']==10){?>selected="selected" <?php }?>>10</option>
                                <option value="15" <?php if ($_smarty_tpl->tpl_vars['params']->value['page_size']==15){?>selected="selected" <?php }?>>15</option>
                                <option value="20" <?php if ($_smarty_tpl->tpl_vars['params']->value['page_size']==20){?>selected="selected" <?php }?>>20</option>
                                <!-- <option value="-1">All</option> -->
                            </select>
                            &nbsp;&nbsp;
                        </label>
                        <label>名称:
                            <input value="<?php echo $_smarty_tpl->tpl_vars['params']->value['name'];?>
" name="name" type="text" aria-controls="sample_1" class="m-wrap medium"> &nbsp;&nbsp;</label>
                        <!-- <label>邮箱: <input name="email" type="text" aria-controls="sample_1" class="m-wrap medium"> &nbsp;&nbsp;</label> -->
                        <label>
                            <button id="btn_search" class="btn blue">查找
                                <!-- <i class="icon-plus"> --></i>
                            </button>
                        </label>
                    </div>
                </form>
            </div>
            <!-- 搜索结束  -->
            <!-- 表开始 -->
            <table class="table table-striped table-bordered table-hover" id="sample_1">
                <thead>
                    <tr>
                        <th style="width:8px;">NO</th>
                        <th style="width:15%;" class="hidden-480">课程名称</th>
                        <th class="hidden-480">课程步骤</th>
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
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['order_by'];?>
</td>
                        <td>
                            <?php if ($_smarty_tpl->tpl_vars['has_edit_right']->value['flg']){?>
                            <a data-toggle="modal" data-target="#mod_1200" href="/curriculum/edit/?curriculum_id=<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['r']->value['name'];?>
</a>
                            <?php }else{ ?>
                            <?php echo $_smarty_tpl->tpl_vars['r']->value['name'];?>

                            <?php }?>
                        </td>
                        <td>
                              <?php  $_smarty_tpl->tpl_vars['s'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['s']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['r']->value['steps']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['s']->key => $_smarty_tpl->tpl_vars['s']->value){
$_smarty_tpl->tpl_vars['s']->_loop = true;
?> 
                                <?php if ($_smarty_tpl->tpl_vars['has_addstep_right']->value['flg']){?>
                                    <a data-toggle="modal" data-target="#mod_1200" href="/curriculum/addstep/?curriculum_id=<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
&step_id=<?php echo $_smarty_tpl->tpl_vars['s']->value['id'];?>
">
                                        <span class="label label-success label-mini"><?php echo $_smarty_tpl->tpl_vars['s']->value['name'];?>
</span>
                                    </a>
                                <?php }else{ ?>
                                    <?php if ($_smarty_tpl->tpl_vars['has_showstep_right']->value['flg']){?>
                                    <a data-toggle="modal" data-target="#mod_1200" href="/curriculum/showstep/?curriculum_id=<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
&step_id=<?php echo $_smarty_tpl->tpl_vars['s']->value['id'];?>
">
                                        <span class="label label-success label-mini"><?php echo $_smarty_tpl->tpl_vars['s']->value['name'];?>
</span>
                                    </a>
                                    <?php }?>
                                <?php }?>
                              <?php } ?>         
                              <?php if ($_smarty_tpl->tpl_vars['has_addstep_right']->value['flg']){?>
                                <a data-toggle="modal" data-target="#mod_1200" href="/curriculum/addstep/?curriculum_id=<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
" class="btn white"><i class="icon-plus"></i></a>
                              <?php }?>
                        </td>
                        <td>
                                <?php if ($_smarty_tpl->tpl_vars['r']->value['is_enabled']==1){?>
                                <?php if ($_smarty_tpl->tpl_vars['has_unenable_right']->value['flg']){?>
                                <a data-link="/curriculum/unenable/id/<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
/"
                                    class="btn red ajax-delete" data-msg="确认要禁用吗？">
                                    <i class="fa fa-pencil"></i>禁用
                                </a>
                                <?php }?>
                                <?php }else{ ?>
                                <?php if ($_smarty_tpl->tpl_vars['has_enable_right']->value['flg']){?>
                                <a data-link="/curriculum/enable/id/<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
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