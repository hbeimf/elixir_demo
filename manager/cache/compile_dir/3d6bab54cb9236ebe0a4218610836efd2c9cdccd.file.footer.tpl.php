<?php /* Smarty version Smarty-3.1.8, created on 2018-04-20 16:22:21
         compiled from "/erlang/elixir_demo/manager/application/views/include/footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3210647945ad9a33d388ca7-26167354%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3d6bab54cb9236ebe0a4218610836efd2c9cdccd' => 
    array (
      0 => '/erlang/elixir_demo/manager/application/views/include/footer.tpl',
      1 => 1524212142,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3210647945ad9a33d388ca7-26167354',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'APP_ENV' => 0,
    'debug' => 0,
    'js' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5ad9a33d38f355_08796972',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ad9a33d38f355_08796972')) {function content_5ad9a33d38f355_08796972($_smarty_tpl) {?>			<!-- 打印sql 开始　-->
			<?php if ($_smarty_tpl->tpl_vars['APP_ENV']->value=='DEVELOPMENT'||$_smarty_tpl->tpl_vars['debug']->value=='yes'){?>
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