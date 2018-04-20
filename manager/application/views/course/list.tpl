{{include file="include/header.tpl"}}


<!-- BEGIN PAGE CONTENT-->
<div class="row-fluid">
    <div class="span12">

        <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet-body">
                <div class="clearfix">
                    {{if $has_add_right['flg']}}
                        {{if isset($params['school_id']) && $params['school_id'] > 0}}
                        <div class="btn-group pull-right">
                            {{if isset($params['school_id']) && $params['school_id'] > 0}}
                            <a data-toggle="modal" data-target="#mod_1200" href="/course/add/school_id/{{$params['school_id']}}" class="btn green" >
                            {{else}}
                            <a data-toggle="modal" data-target="#mod_1200" href="/course/add/" class="btn green" >
                            {{/if}}
                            新增 <i class="icon-plus"></i>
                            </a>
                        </div>
                        {{/if}}
                    {{/if}}
                </div>
                <!-- 搜索开始 -->
                {{if $school_id == 0}}
                <div class="row-fluid">
                    <form>
                        <div id="sample_1_length" class="dataTables_length" style="">
                                    <select id="school_id" name="school_id" class="span2" placeholder="请选择学校...">
                                        <option value="0">请选择机构...</option>
                                        {{foreach from=$school item=m}}
                                            <option {{if isset($params['school_id']) && $params['school_id'] == $m['id']}}selected{{/if}} value="{{$m['id']}}">{{$m['name']}}</option>
                                        {{/foreach}}
                                    </select>
                                    &nbsp;&nbsp;
                                    <button id="btn_search" class="btn blue">查找 <!-- <i class="icon-plus"> --></i></button>
                        </div>
                    </form>
                </div>
                {{/if}}
              
                <!-- 搜索结束  -->

                <!-- 表开始 -->
                {{if isset($params['school_id']) && $params['school_id'] > 0}}
                <div style="text-align: center;font-size: 18px;">
                    {{foreach from=$school item=m}}
                        {{if isset($params['school_id']) && $params['school_id'] == $m['id']}}
                           {{$m['name']}}
                        {{/if}} 
                    {{/foreach}}

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
                {{if isset($data[1])}} 
                    {{foreach from=$data[1] item=m}}
                        {{if $has_add_right['flg']}}
                            <a data-toggle="modal" data-target="#mod_1200" href="/course/add/id/{{$m['id']}}/school_id/{{$params['school_id']}}">
                                <span class="label label-success label-mini"> {{course_type type=$m['course_type'] types=$course_type}} {{date("H:i", $m['begin_at'])}}-{{date("H:i", $m['end_at'])}} [{{$m['teacher_name']}}]</span>
                            </a> 
                        {{else}}
                            <span class="label label-success label-mini"> {{course_type type=$m['course_type'] types=$course_type}} {{date("H:i", $m['begin_at'])}}-{{date("H:i", $m['end_at'])}} [{{$m['teacher_name']}}]</span>
                        {{/if}}
                    {{/foreach}} 
                {{/if}}
                <!-- <span class="label label-warning label-mini">Pending</span> -->
                <!-- <span class="label label-danger label-mini">Overdue</span> -->
            </td>
        </tr>
        <tr class="odd gradeX">
            <td>周二</td>
            <td>
                {{if isset($data[2])}} {{foreach from=$data[2] item=m}}
                {{if $has_add_right['flg']}}
                <a data-toggle="modal" data-target="#mod_1200" href="/course/add/id/{{$m['id']}}/school_id/{{$params['school_id']}}">
                                                <span class="label label-success label-mini"> {{course_type type=$m['course_type'] types=$course_type}} {{date("H:i", $m['begin_at'])}}-{{date("H:i", $m['end_at'])}} [{{$m['teacher_name']}}]</span>
                                            </a> {{else}}
                                            <span class="label label-success label-mini"> {{course_type type=$m['course_type'] types=$course_type}} {{date("H:i", $m['begin_at'])}}-{{date("H:i", $m['end_at'])}} [{{$m['teacher_name']}}]</span>
                                            {{/if}}
                                            {{/foreach}} {{/if}}
            </td>
        </tr>
        <tr class="odd gradeX">
            <td>周三</td>
            <td>
                {{if isset($data[3])}} {{foreach from=$data[3] item=m}}
                {{if $has_add_right['flg']}}
                <a data-toggle="modal" data-target="#mod_1200" href="/course/add/id/{{$m['id']}}/school_id/{{$params['school_id']}}">
                                                <span class="label label-success label-mini"> {{course_type type=$m['course_type'] types=$course_type}} {{date("H:i", $m['begin_at'])}}-{{date("H:i", $m['end_at'])}} [{{$m['teacher_name']}}]</span>
                                            </a> {{else}}
                                            <span class="label label-success label-mini"> {{course_type type=$m['course_type'] types=$course_type}} {{date("H:i", $m['begin_at'])}}-{{date("H:i", $m['end_at'])}} [{{$m['teacher_name']}}]</span>
                                            {{/if}}{{/foreach}} {{/if}}
            </td>
        </tr>
        <tr class="odd gradeX">
            <td>周四</td>
            <td>
                {{if isset($data[4])}} {{foreach from=$data[4] item=m}}{{if $has_add_right['flg']}}
                <a data-toggle="modal" data-target="#mod_1200" href="/course/add/id/{{$m['id']}}/school_id/{{$params['school_id']}}">
                                                <span class="label label-success label-mini"> {{course_type type=$m['course_type'] types=$course_type}} {{date("H:i", $m['begin_at'])}}-{{date("H:i", $m['end_at'])}} [{{$m['teacher_name']}}]</span>
                                            </a> {{else}}<span class="label label-success label-mini"> {{course_type type=$m['course_type'] types=$course_type}} {{date("H:i", $m['begin_at'])}}-{{date("H:i", $m['end_at'])}} [{{$m['teacher_name']}}]</span>{{/if}}{{/foreach}} {{/if}}
            </td>
        </tr>
        <tr class="odd gradeX">
            <td>周五</td>
            <td>
                {{if isset($data[5])}} {{foreach from=$data[5] item=m}}{{if $has_add_right['flg']}}
                <a data-toggle="modal" data-target="#mod_1200" href="/course/add/id/{{$m['id']}}/school_id/{{$params['school_id']}}">
                                                <span class="label label-success label-mini"> {{course_type type=$m['course_type'] types=$course_type}} {{date("H:i", $m['begin_at'])}}-{{date("H:i", $m['end_at'])}} [{{$m['teacher_name']}}]</span>
                                            </a> {{else}}<span class="label label-success label-mini"> {{course_type type=$m['course_type'] types=$course_type}} {{date("H:i", $m['begin_at'])}}-{{date("H:i", $m['end_at'])}} [{{$m['teacher_name']}}]</span>{{/if}}{{/foreach}} {{/if}}
            </td>
        </tr>
        <tr class="odd gradeX">
            <td>周六</td>
            <td>
                {{if isset($data[6])}} {{foreach from=$data[6] item=m}}{{if $has_add_right['flg']}}
                <a data-toggle="modal" data-target="#mod_1200" href="/course/add/id/{{$m['id']}}/school_id/{{$params['school_id']}}">
                                                <span class="label label-success label-mini"> {{course_type type=$m['course_type'] types=$course_type}} {{date("H:i", $m['begin_at'])}}-{{date("H:i", $m['end_at'])}} [{{$m['teacher_name']}}]</span>
                                            </a> {{else}}<span class="label label-success label-mini"> {{course_type type=$m['course_type'] types=$course_type}} {{date("H:i", $m['begin_at'])}}-{{date("H:i", $m['end_at'])}} [{{$m['teacher_name']}}]</span>{{/if}}{{/foreach}} {{/if}}
            </td>
        </tr>
        <tr class="odd gradeX">
            <td>周日</td>
            <td>
                {{if isset($data[7])}} {{foreach from=$data[7] item=m}}{{if $has_add_right['flg']}}
                <a data-toggle="modal" data-target="#mod_1200" href="/course/add/id/{{$m['id']}}/school_id/{{$params['school_id']}}">
                                                <span class="label label-success label-mini"> {{course_type type=$m['course_type'] types=$course_type}} {{date("H:i", $m['begin_at'])}}-{{date("H:i", $m['end_at'])}} [{{$m['teacher_name']}}]</span>
                                            </a> {{else}} <span class="label label-success label-mini"> {{course_type type=$m['course_type'] types=$course_type}} {{date("H:i", $m['begin_at'])}}-{{date("H:i", $m['end_at'])}} [{{$m['teacher_name']}}]</span>{{/if}}{{/foreach}} {{/if}}
            </td>
        </tr>
    </tbody>
</table>
                {{/if}}

                <!-- 分页开始 -->
                <!-- 分页结束 -->
                <!-- 表结束  -->

            </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>

</div>
<!-- END PAGE CONTENT-->

{{include file="include/footer.tpl"}}




