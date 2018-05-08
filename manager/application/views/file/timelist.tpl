{{if $params['from'] == 'iframe'}}
{{include file="include/iframe_header.tpl"}}
{{else}}
{{include file="include/header.tpl"}}
{{/if}}
            <input type="text" name="code" value="{{$params['code']}}" readonly="true">
            <button class="btn red btn_search" data-type="1">一周10<!-- <i class="icon-plus"></i> --></button>&nbsp;&nbsp;&nbsp;
            <button class="btn red btn_search" data-type="2">一月22<!-- <i class="icon-plus"></i> --></button>&nbsp;&nbsp;&nbsp;
            <button class="btn red btn_search" data-type="3">半年130<!-- <i class="icon-plus"></i> --></button>&nbsp;&nbsp;&nbsp;
            <button class="btn red btn_search" data-type="4">一年260<!-- <i class="icon-plus"></i> --></button>&nbsp;&nbsp;&nbsp;
            <button class="btn red btn_search" data-type="6">两年520<!-- <i class="icon-plus"></i> --></button>&nbsp;&nbsp;&nbsp;
            <button class="btn red btn_search" data-type="5">全部<!-- <i class="icon-plus"></i> --></button>&nbsp;&nbsp;&nbsp;
            <a class="btn red" href="/file/timelist/?from=iframe&id={{$next}}">Next</a>&nbsp;&nbsp;&nbsp;{{$params['id']}}

            <a data-toggle="modal" data-target="#mod_1200" href="/file/addFile/id/{{$params['id']}}/"
                                    class="btn grey">
                                    <i class="fa fa-pencil"></i>编辑
            </a>


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