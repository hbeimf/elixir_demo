{{include file="include/header.tpl"}}


<!-- BEGIN PAGE CONTENT-->
<div class="row-fluid">
    <div class="span12">

        <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet-body">
                
                <div class="clearfix">
                    {{if $has_add_right['flg']}}
                    <div class="btn-group pull-right">
                        <a data-toggle="modal" data-target="#mod_900" href="/teacher/add/" class="btn green" >
                        新增 <i class="icon-plus"></i>
                        </a>
                    </div>
                    {{/if}}
                </div>

                <!-- 搜索开始 -->
                <div class="row-fluid">
                    <form>
                        <div id="sample_1_length" class="dataTables_length">
                            <label>每页显示:
                                <select size="1" name="page_size" aria-controls="sample_1" class="m-wrap small">
                                    <option value="10" {{if $params['page_size'] == 10}}selected="selected"{{/if}}>10</option>
                                    <option value="15" {{if $params['page_size'] == 15}}selected="selected"{{/if}}>15</option>
                                    <option value="20" {{if $params['page_size'] == 20}}selected="selected"{{/if}}>20</option>
                                    <!-- <option value="-1">All</option> -->
                                </select>
                                &nbsp;&nbsp;
                            </label>
                            <label>教师名称: <input value="{{$params['name']}}" name="name" type="text" aria-controls="sample_1" class="m-wrap medium"> &nbsp;&nbsp;</label>
                            <!-- <label>邮箱: <input name="email" type="text" aria-controls="sample_1" class="m-wrap medium"> &nbsp;&nbsp;</label> -->
                            <label>账号(手机): <input value="{{$params['phone']}}" name="phone" type="text" aria-controls="sample_1" class="m-wrap medium"> &nbsp;&nbsp;</label>

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
                            <th class="hidden-480">老师名称</th>
                            <th class="hidden-480">老师头像</th>
                            <th class="hidden-480">二维码</th>


                            <th class="hidden-480">账号(手机)</th>
                            <th class="hidden-480">email</th>
                            {{if $school_id == 0}}
                            <th class="hidden-480">所在机构</th>
                            {{/if}}
                            <th class="hidden-480">课程类型</th>
                            <th class="hidden-480">性别</th>
                            <th class="hidden-480">创建时间</th>
                            <th class="hidden-480">更新时间</th>
                            <th class="hidden-480">是否启用</th>
                            <th class="hidden-480">编辑</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{foreach from=$users item=r}}
                        <tr class="odd gradeX">
                            <!-- <td><input type="checkbox" class="checkboxes" value="{{$r['id']}}" /></td> -->
                            <td>{{$r['id']}}</td>
                            <td>{{$r['name']}}</td>
                            <td><img style="widht:121px;height:121px;" src="{{$r['dir']}}" /></td>
                            <td><img style="widht:121px;height:121px;" src="{{qrcode id=$r['id'] role='teacher'}}" /></td>

                            <td>{{$r['phone']}}</td>
                            <td>{{$r['email']}}</td>
                            {{if $school_id == 0}}
                            <td>{{$r['school_name']}}</td>
                            {{/if}}
                            <td>
                                {{course_type type=$r['course_type'] types=$course_type}}
                            </td>
                            <td>
                                {{gender g=$r['gender']}}
                            </td>
                            
                            <td>{{$r['created_at']}}</td>
                            <td>{{$r['updated_at']}}</td>
                            <td>{{if $r['is_enabled']==1}}启用{{else}}<font color=red>禁用</font>{{/if}}</td>
                            
                            <td>
                                 {{if $has_add_right['flg']}}
                                <a data-toggle="modal" data-target="#mod_1200" href="/teacher/add/id/{{$r['id']}}/"
                                    class="btn grey">
                                    <i class="fa fa-pencil"></i>编辑
                                </a>
                                {{/if}}

                                <!-- <a data-link="/school/del/id/{{$r['id']}}/"
                                    class="btn red ajax-delete">
                                    <i class="fa fa-pencil"></i>删除
                                </a> -->
                                {{if $r['is_enabled'] == 1}}
                                {{if $has_unenable_right['flg']}}
                                <a data-link="/teacher/unenable/id/{{$r['id']}}/"
                                    class="btn red ajax-delete" data-msg="确认要禁用吗？">
                                    <i class="fa fa-pencil"></i>禁用
                                </a>
                                {{/if}}
                                {{else}}
                                {{if $has_enable_right['flg']}}
                                <a data-link="/teacher/enable/id/{{$r['id']}}/"
                                    class="btn green ajax-delete" data-msg="确认要启用吗？">
                                    <i class="fa fa-pencil"></i>启用
                                </a>
                                {{/if}}
                                {{/if}}
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




