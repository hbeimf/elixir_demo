<?php /* Smarty version Smarty-3.1.8, created on 2018-03-26 16:34:27
         compiled from "/web/m.demo.com/application/views/include/footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6872503435a4b61244f7d13-21039542%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ff121956fd6aebe94408ba45cbf467ff48123e14' => 
    array (
      0 => '/web/m.demo.com/application/views/include/footer.tpl',
      1 => 1522053261,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6872503435a4b61244f7d13-21039542',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5a4b6124503660_46589147',
  'variables' => 
  array (
    'APP_ENV' => 0,
    'js' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a4b6124503660_46589147')) {function content_5a4b6124503660_46589147($_smarty_tpl) {?>			<!-- 打印sql 开始　-->
			<?php if ($_smarty_tpl->tpl_vars['APP_ENV']->value=='DEVELOPMENT'){?>
				<div class="row-fluid">
	    			<div class="span12">
	    				<div class="portlet box green">
							<div class="portlet-title">
								<div class="caption"><i class="icon-comments"></i>SQL查询记录</div>
								<div class="actions">
								</div>
							</div>

							<div class="portlet-body fuelux">
								<?php echo queryLog(array(),$_smarty_tpl);?>

							</div>
						</div>
	    			</div>
	    		</div>
    		<?php }?>
    		<!-- 打印sql　结束　-->


			</div>
			<!-- END PAGE CONTAINER-->
		</div>
		<!-- END PAGE -->
	</div>
	<!-- END CONTAINER -->

	<!-- BEGIN FOOTER -->
	<div class="footer">
		<div class="footer-inner">
			2013 &copy; Metronic by keenthemes.Collect from
		</div>
		<div class="footer-tools">
			<span class="go-top">
			<i class="icon-angle-up"></i>
			</span>
		</div>
	</div>

	<?php echo $_smarty_tpl->getSubTemplate ("include/modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


	<script src="/js/require.js" type="text/javascript"></script>
	<script type="text/javascript">
	    require({
	        baseUrl: '/js_src/',
	        config:{}
	    });
	    require(["config"], function () {
	    	require(["<?php if (isset($_smarty_tpl->tpl_vars['js']->value)){?><?php echo $_smarty_tpl->tpl_vars['js']->value;?>
<?php }else{ ?>default_empty<?php }?>"]);
	    });
	</script>


	</body>
<!-- END BODY -->
</html>
<?php }} ?>