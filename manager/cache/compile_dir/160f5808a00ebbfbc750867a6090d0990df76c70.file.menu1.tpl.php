<?php /* Smarty version Smarty-3.1.8, created on 2018-01-02 18:38:28
         compiled from "/web/m.demo.com/application/views/include/menu1.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16884254455a4b61244bb846-37748233%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '160f5808a00ebbfbc750867a6090d0990df76c70' => 
    array (
      0 => '/web/m.demo.com/application/views/include/menu1.tpl',
      1 => 1514889414,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16884254455a4b61244bb846-37748233',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'current_menu' => 0,
    'system_menu' => 0,
    'm' => 0,
    'menu_right' => 0,
    'mm' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5a4b61244e79c6_97164709',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a4b61244e79c6_97164709')) {function content_5a4b61244e79c6_97164709($_smarty_tpl) {?><!-- BEGIN SIDEBAR MENU -->

<ul class="page-sidebar-menu">

    <li>
        <div class="sidebar-toggler hidden-phone"></div>
    </li>

    <li>
        <!-- <form class="sidebar-search">
            <div class="input-box">
                <a href="javascript:;" class="remove"></a>
                <input type="text" placeholder="Search..." />
                <input type="button" class="submit" value=" " />
            </div>
        </form> -->
    </li>

    <li class="start <?php if ($_smarty_tpl->tpl_vars['current_menu']->value['id']==0){?>active<?php }?>">
        <a href="/">
            <i class="icon-home"></i>
            <span class="title">控制台</span>
            <span class="selected"></span>
        </a>
    </li>

    <?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['m']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['system_menu']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value){
$_smarty_tpl->tpl_vars['m']->_loop = true;
?>
        <?php if (in_array($_smarty_tpl->tpl_vars['m']->value['id'],$_smarty_tpl->tpl_vars['menu_right']->value)&&$_smarty_tpl->tpl_vars['m']->value['status']=='1'){?>
            <li class="<?php if ($_smarty_tpl->tpl_vars['current_menu']->value['parent_id']==$_smarty_tpl->tpl_vars['m']->value['id']){?>active<?php }?>">
                <a href="javascript:;">
                    <i class="icon-th"></i>
                    <span class="title"><?php echo $_smarty_tpl->tpl_vars['m']->value['menu_name'];?>
</span>
                    <span class="selected"></span>
                    <span class="arrow open"></span>
                </a>
                <ul class="sub-menu">
                    <?php  $_smarty_tpl->tpl_vars['mm'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['mm']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['m']->value['child']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['mm']->key => $_smarty_tpl->tpl_vars['mm']->value){
$_smarty_tpl->tpl_vars['mm']->_loop = true;
?>
                        <?php if ($_smarty_tpl->tpl_vars['mm']->value['type']=='1'&&in_array($_smarty_tpl->tpl_vars['mm']->value['id'],$_smarty_tpl->tpl_vars['menu_right']->value)&&$_smarty_tpl->tpl_vars['mm']->value['status']=='1'){?>
                            <li class="<?php if ($_smarty_tpl->tpl_vars['current_menu']->value['id']==$_smarty_tpl->tpl_vars['mm']->value['id']){?>active<?php }?>">
                                <a href="/<?php echo $_smarty_tpl->tpl_vars['mm']->value['controller'];?>
/<?php echo $_smarty_tpl->tpl_vars['mm']->value['action'];?>
"><?php echo $_smarty_tpl->tpl_vars['mm']->value['menu_name'];?>
</a>
                            </li>
                        <?php }?>
                    <?php } ?>
                </ul>
            </li>
        <?php }?>
    <?php } ?>

</ul>

<!-- END SIDEBAR MENU -->
<?php }} ?>