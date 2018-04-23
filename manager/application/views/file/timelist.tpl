{{if $params['from'] == 'iframe'}}
{{include file="include/iframe_header.tpl"}}
{{else}}
{{include file="include/header.tpl"}}
{{/if}}
            <!-- BEGIN PAGE CONTAINER-->
            <div class="container-fluid">
                <div id="dashboard">
                    <div class="clearfix"></div>
                    <div class="row-fluid">
                        <div class="span6">
                            <div id="main" style="width: 1200px;height:400px;"></div>
                        </div>
                        <div class="span6">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- END PAGE CONTAINER-->
{{if $params['from'] == 'iframe'}}
{{include file="include/iframe_footer.tpl"}}
{{else}}
{{include file="include/footer.tpl"}}
{{/if}}