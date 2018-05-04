{{include file="include/header.tpl"}}


<!-- BEGIN PAGE CONTENT-->
<div class="row-fluid">
    <div class="span12">

        <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet-body">
                <div class="clearfix">
                    <div class="btn-group pull-right">
                        <a data-toggle="modal" data-target="#mod_1200" href="/file/addFile/" class="btn green" >
                        新增 <i class="icon-plus"></i>
                        </a>
                    </div>
                </div>
                <!-- 搜索开始 -->
                <div class="row-fluid">
                    <form>
                        <div id="sample_1_length" class="dataTables_length">
                            <label>每页显示:
                                <select name="page_size"  class="small">
                                    <option value="10" {{if $params['page_size'] == 10}}selected="selected"{{/if}}>10</option>
                                    <option value="15" {{if $params['page_size'] == 15}}selected="selected"{{/if}}>15</option>
                                    <option value="20" {{if $params['page_size'] == 20}}selected="selected"{{/if}}>20</option>
                                    <!-- <option value="-1">All</option> -->
                                </select>
                                &nbsp;&nbsp;
                            </label>
                            <label>namesina: <input value="{{$params['namesina']}}" name="namesina" type="text" aria-controls="sample_1" class="m-wrap medium"> &nbsp;&nbsp;</label>
                            <label>codesina: <input value="{{$params['codesina']}}" name="codesina" type="text" aria-controls="sample_1" class="m-wrap medium"> &nbsp;&nbsp;</label>

                            <label>name163: <input value="{{$params['name']}}" name="name" type="text" aria-controls="sample_1" class="m-wrap medium"> &nbsp;&nbsp;</label>
                            <label>code163: <input value="{{$params['code']}}" name="code" type="text" aria-controls="sample_1" class="m-wrap medium"> &nbsp;&nbsp;</label>
                            <label>category: <input {{if $params['category'] == 1}}checked{{/if}} value="1" name="category" type="checkbox" aria-controls="sample_1" class="m-wrap"> &nbsp;&nbsp;</label>

                            <!-- <label>邮箱: <input name="email" type="text" aria-controls="sample_1" class="m-wrap medium"> &nbsp;&nbsp;</label> -->


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
                            <th class="hidden-480">codesina</th>
                            <th class="hidden-480">namesina</th>
                            <th class="hidden-480">code163</th>
                            <th class="hidden-480">name163</th>
                            <th class="hidden-480">{{order_link order_field="cid" order_by=$params['order_by'] title="cid"}}</th>
                            <th class="hidden-480">{{order_link order_field="category" order_by=$params['order_by'] title="category"}}</th>

                            <th class="hidden-480">time</th>


                            <th class="hidden-480">编辑</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{foreach from=$users item=r}}
                        <tr class="odd gradeX">
                            <!-- <td><input type="checkbox" class="checkboxes" value="{{$r['id']}}" /></td> -->
                            <td>{{$r['id']}}</td>
                            <td>{{$r['code_sina']}}</td>
                            <td><a href="https://www.baidu.com/s?wd={{$r['name_sina']}}" target="blank">{{$r['name_sina']}}</a></td>
                            <td>{{$r['code_163']}}</td>
                            <td><a href="https://www.baidu.com/s?wd={{$r['name_163']}}" target="blank">{{$r['name_163']}}</a></td>
                            <td>{{$r['hid']}}</td>
                            <td>{{$r['category']}}</td>

                            <td>{{$r['timer']}}</td>

                            <td>
                                <a data-toggle="modal" data-target="#mod_1200" href="/file/addFile/id/{{$r['id']}}/"
                                    class="btn grey">
                                    <i class="fa fa-pencil"></i>编辑
                                </a>

                                <a data-link="/file/addcategory/id/{{$r['id']}}/"
                                    class="btn red ajax-delete" data-msg="[ {{$r['name_sina']}} ] 确认要 [++关注] 吗？">
                                    <i class="fa fa-pencil"></i>+关注
                                </a>
                                <a data-link="/file/minuscategory/id/{{$r['id']}}/"
                                    class="btn red ajax-delete" data-msg="[ {{$r['name_sina']}} ] 确认要 [--关注] 吗？">
                                    <i class="fa fa-pencil"></i>-关注
                                </a>

                            
                               <!--  <a data-link="/curriculum/enable/id/{{$r['id']}}/"
                                    class="btn gray window-layer" data-id="{{$r['id']}}">
                                    <i class="fa fa-pencil"></i>弹层
                                </a> -->

                                <a class="btn gray window-iframe"  
                                data-link="/file/heap/?from=iframe&code={{$r['code_sina']}}" data-id="window_{{$r['id']}}" data-title="堆积图demo">
                                    <i class="fa fa-pencil"></i>堆积图弹窗
                                </a>

                                <a class="btn gray window-iframe"  
                                data-link="/file/timelist/?from=iframe&code={{$r['code_sina']}}" data-id="window_{{$r['id']}}" data-title="线状统计图demo">
                                    <i class="fa fa-pencil"></i>线状统计弹窗
                                </a>

                                <a class="btn gray window-iframe"  
                                data-link="/file/index/?from=iframe" data-id="window_{{$r['id']}}" data-title="柱状统计图demo">
                                    <i class="fa fa-pencil"></i>柱状统计弹窗
                                </a>

                                <a class="btn gray window-iframe"  
                                data-link="/pic/list" data-id="window_{{$r['id']}}" data-title="{{$r['id']}}">
                                    <i class="fa fa-pencil"></i>弹窗list demo
                                </a>


                            </td>

                        </tr>
                        {{/foreach}}

                    </tbody>
                </table>

                <!-- 分页开始 -->
                {{include file="include/page_list.tpl"}}
                <!-- 分页结束 -->
                <!-- 表结束  -->

            </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>

</div>
<!-- END PAGE CONTENT-->

{{include file="include/footer.tpl"}}




