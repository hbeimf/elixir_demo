<?php /* Smarty version Smarty-3.1.8, created on 2018-04-02 13:30:06
         compiled from "/mnt/web/m.demo.com/application/views/course/list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4101873915ac1bfde4a47a4-84092765%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '09da0220d29391997acbc905440adc9a4bac69a0' => 
    array (
      0 => '/mnt/web/m.demo.com/application/views/course/list.tpl',
      1 => 1522641537,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4101873915ac1bfde4a47a4-84092765',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'has_add_right' => 0,
    'params' => 0,
    'school_id' => 0,
    'school' => 0,
    'm' => 0,
    'data' => 0,
    'course_type' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5ac1bfde53b408_06826961',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ac1bfde53b408_06826961')) {function content_5ac1bfde53b408_06826961($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("include/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>



<!-- BEGIN PAGE CONTENT-->
<div class="row-fluid">
    <div class="span12">

        <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet-body">
                <div class="clearfix">
                    <?php if ($_smarty_tpl->tpl_vars['has_add_right']->value['flg']){?>
                        <?php if (isset($_smarty_tpl->tpl_vars['params']->value['school_id'])&&$_smarty_tpl->tpl_vars['params']->value['school_id']>0){?>
                        <div class="btn-group pull-right">
                            <?php if (isset($_smarty_tpl->tpl_vars['params']->value['school_id'])&&$_smarty_tpl->tpl_vars['params']->value['school_id']>0){?>
                            <a data-toggle="modal" data-target="#mod_1200" href="/course/add/school_id/<?php echo $_smarty_tpl->tpl_vars['params']->value['school_id'];?>
" class="btn green" >
                            <?php }else{ ?>
                            <a data-toggle="modal" data-target="#mod_1200" href="/course/add/" class="btn green" >
                            <?php }?>
                            新增 <i class="icon-plus"></i>
                            </a>
                        </div>
                        <?php }?>
                    <?php }?>
                </div>
                <!-- 搜索开始 -->
                <?php if ($_smarty_tpl->tpl_vars['school_id']->value==0){?>
                <div class="row-fluid">
                    <form>
                        <div id="sample_1_length" class="dataTables_length" style="">
                                    <select id="school_id" name="school_id" class="span2" placeholder="请选择学校...">
                                        <option value="0">请选择机构...</option>
                                        <?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['m']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['school']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value){
$_smarty_tpl->tpl_vars['m']->_loop = true;
?>
                                            <option <?php if (isset($_smarty_tpl->tpl_vars['params']->value['school_id'])&&$_smarty_tpl->tpl_vars['params']->value['school_id']==$_smarty_tpl->tpl_vars['m']->value['id']){?>selected<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['m']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['m']->value['name'];?>
</option>
                                        <?php } ?>
                                    </select>
                                    &nbsp;&nbsp;
                                    <button id="btn_search" class="btn blue">查找 <!-- <i class="icon-plus"> --></i></button>
                        </div>
                    </form>
                </div>
                <?php }?>
              
                <!-- 搜索结束  -->

                <!-- 表开始 -->
                <?php if (isset($_smarty_tpl->tpl_vars['params']->value['school_id'])&&$_smarty_tpl->tpl_vars['params']->value['school_id']>0){?>
                <div style="text-align: center;font-size: 18px;">
                    <?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['m']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['school']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value){
$_smarty_tpl->tpl_vars['m']->_loop = true;
?>
                        <?php if (isset($_smarty_tpl->tpl_vars['params']->value['school_id'])&&$_smarty_tpl->tpl_vars['params']->value['school_id']==$_smarty_tpl->tpl_vars['m']->value['id']){?>
                           <?php echo $_smarty_tpl->tpl_vars['m']->value['name'];?>

                        <?php }?> 
                    <?php } ?>

                </div>
                <table class="table table-striped table-bordered table-hover" id="sample_1">
    <thead>
        <tr>
            <!-- <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th> -->
            <th class="hidden-480">星期</th>
            <th class="hidden-480">课程安排</th>
        </tr>
    </thead>
    <tbody>
        <tr class="odd gradeX">
            <td>周一</td>
            <td>
                <?php if (isset($_smarty_tpl->tpl_vars['data']->value[1])){?> 
                    <?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['m']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value[1]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value){
$_smarty_tpl->tpl_vars['m']->_loop = true;
?>
                        <?php if ($_smarty_tpl->tpl_vars['has_add_right']->value['flg']){?>
                            <a data-toggle="modal" data-target="#mod_1200" href="/course/add/id/<?php echo $_smarty_tpl->tpl_vars['m']->value['id'];?>
/school_id/<?php echo $_smarty_tpl->tpl_vars['params']->value['school_id'];?>
">
                                <span class="label label-success label-mini"> <?php echo course_type(array('type'=>$_smarty_tpl->tpl_vars['m']->value['course_type'],'types'=>$_smarty_tpl->tpl_vars['course_type']->value),$_smarty_tpl);?>
 <?php echo date("H:i",$_smarty_tpl->tpl_vars['m']->value['begin_at']);?>
-<?php echo date("H:i",$_smarty_tpl->tpl_vars['m']->value['end_at']);?>
 [<?php echo $_smarty_tpl->tpl_vars['m']->value['teacher_name'];?>
]</span>
                            </a> 
                        <?php }else{ ?>
                            <span class="label label-success label-mini"> <?php echo course_type(array('type'=>$_smarty_tpl->tpl_vars['m']->value['course_type'],'types'=>$_smarty_tpl->tpl_vars['course_type']->value),$_smarty_tpl);?>
 <?php echo date("H:i",$_smarty_tpl->tpl_vars['m']->value['begin_at']);?>
-<?php echo date("H:i",$_smarty_tpl->tpl_vars['m']->value['end_at']);?>
 [<?php echo $_smarty_tpl->tpl_vars['m']->value['teacher_name'];?>
]</span>
                        <?php }?>
                    <?php } ?> 
                <?php }?>
                <!-- <span class="label label-warning label-mini">Pending</span> -->
                <!-- <span class="label label-danger label-mini">Overdue</span> -->
            </td>
        </tr>
        <tr class="odd gradeX">
            <td>周二</td>
            <td>
                <?php if (isset($_smarty_tpl->tpl_vars['data']->value[2])){?> <?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['m']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value[2]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value){
$_smarty_tpl->tpl_vars['m']->_loop = true;
?>
                <?php if ($_smarty_tpl->tpl_vars['has_add_right']->value['flg']){?>
                <a data-toggle="modal" data-target="#mod_1200" href="/course/add/id/<?php echo $_smarty_tpl->tpl_vars['m']->value['id'];?>
/school_id/<?php echo $_smarty_tpl->tpl_vars['params']->value['school_id'];?>
">
                                                <span class="label label-success label-mini"> <?php echo course_type(array('type'=>$_smarty_tpl->tpl_vars['m']->value['course_type'],'types'=>$_smarty_tpl->tpl_vars['course_type']->value),$_smarty_tpl);?>
 <?php echo date("H:i",$_smarty_tpl->tpl_vars['m']->value['begin_at']);?>
-<?php echo date("H:i",$_smarty_tpl->tpl_vars['m']->value['end_at']);?>
 [<?php echo $_smarty_tpl->tpl_vars['m']->value['teacher_name'];?>
]</span>
                                            </a> <?php }else{ ?>
                                            <span class="label label-success label-mini"> <?php echo course_type(array('type'=>$_smarty_tpl->tpl_vars['m']->value['course_type'],'types'=>$_smarty_tpl->tpl_vars['course_type']->value),$_smarty_tpl);?>
 <?php echo date("H:i",$_smarty_tpl->tpl_vars['m']->value['begin_at']);?>
-<?php echo date("H:i",$_smarty_tpl->tpl_vars['m']->value['end_at']);?>
 [<?php echo $_smarty_tpl->tpl_vars['m']->value['teacher_name'];?>
]</span>
                                            <?php }?>
                                            <?php } ?> <?php }?>
            </td>
        </tr>
        <tr class="odd gradeX">
            <td>周三</td>
            <td>
                <?php if (isset($_smarty_tpl->tpl_vars['data']->value[3])){?> <?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['m']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value[3]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value){
$_smarty_tpl->tpl_vars['m']->_loop = true;
?>
                <?php if ($_smarty_tpl->tpl_vars['has_add_right']->value['flg']){?>
                <a data-toggle="modal" data-target="#mod_1200" href="/course/add/id/<?php echo $_smarty_tpl->tpl_vars['m']->value['id'];?>
/school_id/<?php echo $_smarty_tpl->tpl_vars['params']->value['school_id'];?>
">
                                                <span class="label label-success label-mini"> <?php echo course_type(array('type'=>$_smarty_tpl->tpl_vars['m']->value['course_type'],'types'=>$_smarty_tpl->tpl_vars['course_type']->value),$_smarty_tpl);?>
 <?php echo date("H:i",$_smarty_tpl->tpl_vars['m']->value['begin_at']);?>
-<?php echo date("H:i",$_smarty_tpl->tpl_vars['m']->value['end_at']);?>
 [<?php echo $_smarty_tpl->tpl_vars['m']->value['teacher_name'];?>
]</span>
                                            </a> <?php }else{ ?>
                                            <span class="label label-success label-mini"> <?php echo course_type(array('type'=>$_smarty_tpl->tpl_vars['m']->value['course_type'],'types'=>$_smarty_tpl->tpl_vars['course_type']->value),$_smarty_tpl);?>
 <?php echo date("H:i",$_smarty_tpl->tpl_vars['m']->value['begin_at']);?>
-<?php echo date("H:i",$_smarty_tpl->tpl_vars['m']->value['end_at']);?>
 [<?php echo $_smarty_tpl->tpl_vars['m']->value['teacher_name'];?>
]</span>
                                            <?php }?><?php } ?> <?php }?>
            </td>
        </tr>
        <tr class="odd gradeX">
            <td>周四</td>
            <td>
                <?php if (isset($_smarty_tpl->tpl_vars['data']->value[4])){?> <?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['m']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value[4]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value){
$_smarty_tpl->tpl_vars['m']->_loop = true;
?><?php if ($_smarty_tpl->tpl_vars['has_add_right']->value['flg']){?>
                <a data-toggle="modal" data-target="#mod_1200" href="/course/add/id/<?php echo $_smarty_tpl->tpl_vars['m']->value['id'];?>
/school_id/<?php echo $_smarty_tpl->tpl_vars['params']->value['school_id'];?>
">
                                                <span class="label label-success label-mini"> <?php echo course_type(array('type'=>$_smarty_tpl->tpl_vars['m']->value['course_type'],'types'=>$_smarty_tpl->tpl_vars['course_type']->value),$_smarty_tpl);?>
 <?php echo date("H:i",$_smarty_tpl->tpl_vars['m']->value['begin_at']);?>
-<?php echo date("H:i",$_smarty_tpl->tpl_vars['m']->value['end_at']);?>
 [<?php echo $_smarty_tpl->tpl_vars['m']->value['teacher_name'];?>
]</span>
                                            </a> <?php }else{ ?><span class="label label-success label-mini"> <?php echo course_type(array('type'=>$_smarty_tpl->tpl_vars['m']->value['course_type'],'types'=>$_smarty_tpl->tpl_vars['course_type']->value),$_smarty_tpl);?>
 <?php echo date("H:i",$_smarty_tpl->tpl_vars['m']->value['begin_at']);?>
-<?php echo date("H:i",$_smarty_tpl->tpl_vars['m']->value['end_at']);?>
 [<?php echo $_smarty_tpl->tpl_vars['m']->value['teacher_name'];?>
]</span><?php }?><?php } ?> <?php }?>
            </td>
        </tr>
        <tr class="odd gradeX">
            <td>周五</td>
            <td>
                <?php if (isset($_smarty_tpl->tpl_vars['data']->value[5])){?> <?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['m']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value[5]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value){
$_smarty_tpl->tpl_vars['m']->_loop = true;
?><?php if ($_smarty_tpl->tpl_vars['has_add_right']->value['flg']){?>
                <a data-toggle="modal" data-target="#mod_1200" href="/course/add/id/<?php echo $_smarty_tpl->tpl_vars['m']->value['id'];?>
/school_id/<?php echo $_smarty_tpl->tpl_vars['params']->value['school_id'];?>
">
                                                <span class="label label-success label-mini"> <?php echo course_type(array('type'=>$_smarty_tpl->tpl_vars['m']->value['course_type'],'types'=>$_smarty_tpl->tpl_vars['course_type']->value),$_smarty_tpl);?>
 <?php echo date("H:i",$_smarty_tpl->tpl_vars['m']->value['begin_at']);?>
-<?php echo date("H:i",$_smarty_tpl->tpl_vars['m']->value['end_at']);?>
 [<?php echo $_smarty_tpl->tpl_vars['m']->value['teacher_name'];?>
]</span>
                                            </a> <?php }else{ ?><span class="label label-success label-mini"> <?php echo course_type(array('type'=>$_smarty_tpl->tpl_vars['m']->value['course_type'],'types'=>$_smarty_tpl->tpl_vars['course_type']->value),$_smarty_tpl);?>
 <?php echo date("H:i",$_smarty_tpl->tpl_vars['m']->value['begin_at']);?>
-<?php echo date("H:i",$_smarty_tpl->tpl_vars['m']->value['end_at']);?>
 [<?php echo $_smarty_tpl->tpl_vars['m']->value['teacher_name'];?>
]</span><?php }?><?php } ?> <?php }?>
            </td>
        </tr>
        <tr class="odd gradeX">
            <td>周六</td>
            <td>
                <?php if (isset($_smarty_tpl->tpl_vars['data']->value[6])){?> <?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['m']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value[6]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value){
$_smarty_tpl->tpl_vars['m']->_loop = true;
?><?php if ($_smarty_tpl->tpl_vars['has_add_right']->value['flg']){?>
                <a data-toggle="modal" data-target="#mod_1200" href="/course/add/id/<?php echo $_smarty_tpl->tpl_vars['m']->value['id'];?>
/school_id/<?php echo $_smarty_tpl->tpl_vars['params']->value['school_id'];?>
">
                                                <span class="label label-success label-mini"> <?php echo course_type(array('type'=>$_smarty_tpl->tpl_vars['m']->value['course_type'],'types'=>$_smarty_tpl->tpl_vars['course_type']->value),$_smarty_tpl);?>
 <?php echo date("H:i",$_smarty_tpl->tpl_vars['m']->value['begin_at']);?>
-<?php echo date("H:i",$_smarty_tpl->tpl_vars['m']->value['end_at']);?>
 [<?php echo $_smarty_tpl->tpl_vars['m']->value['teacher_name'];?>
]</span>
                                            </a> <?php }else{ ?><span class="label label-success label-mini"> <?php echo course_type(array('type'=>$_smarty_tpl->tpl_vars['m']->value['course_type'],'types'=>$_smarty_tpl->tpl_vars['course_type']->value),$_smarty_tpl);?>
 <?php echo date("H:i",$_smarty_tpl->tpl_vars['m']->value['begin_at']);?>
-<?php echo date("H:i",$_smarty_tpl->tpl_vars['m']->value['end_at']);?>
 [<?php echo $_smarty_tpl->tpl_vars['m']->value['teacher_name'];?>
]</span><?php }?><?php } ?> <?php }?>
            </td>
        </tr>
        <tr class="odd gradeX">
            <td>周日</td>
            <td>
                <?php if (isset($_smarty_tpl->tpl_vars['data']->value[7])){?> <?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['m']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value[7]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value){
$_smarty_tpl->tpl_vars['m']->_loop = true;
?><?php if ($_smarty_tpl->tpl_vars['has_add_right']->value['flg']){?>
                <a data-toggle="modal" data-target="#mod_1200" href="/course/add/id/<?php echo $_smarty_tpl->tpl_vars['m']->value['id'];?>
/school_id/<?php echo $_smarty_tpl->tpl_vars['params']->value['school_id'];?>
">
                                                <span class="label label-success label-mini"> <?php echo course_type(array('type'=>$_smarty_tpl->tpl_vars['m']->value['course_type'],'types'=>$_smarty_tpl->tpl_vars['course_type']->value),$_smarty_tpl);?>
 <?php echo date("H:i",$_smarty_tpl->tpl_vars['m']->value['begin_at']);?>
-<?php echo date("H:i",$_smarty_tpl->tpl_vars['m']->value['end_at']);?>
 [<?php echo $_smarty_tpl->tpl_vars['m']->value['teacher_name'];?>
]</span>
                                            </a> <?php }else{ ?> <span class="label label-success label-mini"> <?php echo course_type(array('type'=>$_smarty_tpl->tpl_vars['m']->value['course_type'],'types'=>$_smarty_tpl->tpl_vars['course_type']->value),$_smarty_tpl);?>
 <?php echo date("H:i",$_smarty_tpl->tpl_vars['m']->value['begin_at']);?>
-<?php echo date("H:i",$_smarty_tpl->tpl_vars['m']->value['end_at']);?>
 [<?php echo $_smarty_tpl->tpl_vars['m']->value['teacher_name'];?>
]</span><?php }?><?php } ?> <?php }?>
            </td>
        </tr>
    </tbody>
</table>
                <?php }?>

                <!-- 分页开始 -->
                <!-- 分页结束 -->
                <!-- 表结束  -->

            </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>

</div>
<!-- END PAGE CONTENT-->

<?php echo $_smarty_tpl->getSubTemplate ("include/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>





<?php }} ?>