<!-- 分页 -->
<div class="row-fluid">
	<div class="span3">
		<div class="dataTables_info" id="sample_1_info">
			共{{$count}}条记录， 第{{$page}}页 共{{$totalPage}}页 
		</div>
	</div>
	<div class="span9" id="page_list_id">
		<div class="dataTables_paginate paging_bootstrap pagination">
			{{if isset($pageType)}}
				{{page current_page=$page total_page=$totalPage page_type=$pageType}}
			{{else}}
				{{page current_page=$page total_page=$totalPage}}
			{{/if}}
			
		</div>
	</div>
</div>