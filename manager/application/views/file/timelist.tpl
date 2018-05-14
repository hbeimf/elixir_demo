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
            <a class="btn blue" href="/file/timelist/?from=iframe&id={{$pre}}">Pre</a>&nbsp;&nbsp;&nbsp;{{$params['id']}}
            <a class="btn blue" href="/file/timelist/?from=iframe&id={{$next}}">Next</a>&nbsp;&nbsp;&nbsp;

            <a data-toggle="modal" data-target="#mod_1200" href="/file/addFile/id/{{$params['id']}}/"
                                    class="btn grey">
                                    <i class="fa fa-pencil"></i>编辑
            </a>

            <a data-link="/file/addcategory/id/{{$params['id']}}/"
                                    class="btn grey ajax-delete" data-msg="[ {{$params['code']}} ] 确认要 [更新] 吗？">
                                    <i class="fa fa-pencil"></i>更新
                                </a>
<a data-link="/file/minuscategory/id/{{$params['id']}}/"
                                    class="btn grey ajax-delete" data-msg="[ {{$params['code']}} ] 确认要 [init] 吗？">
                                    <i class="fa fa-pencil"></i>init
                                </a>

        <a class="btn blue" href="https://www.baidu.com/s?wd={{{{$params['name']}}}}" target="blank">百度</a>&nbsp;&nbsp;&nbsp;
        <a class="btn blue" href="https://www.baidu.com/s?wd=上证指数" target="blank">上证指数</a>&nbsp;&nbsp;&nbsp;


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