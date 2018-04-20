<form name="ff" id="ff" class="form-horizontal ajax_form" action="/course/add" method='post' enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{if isset($role['id'])}}{{$role['id']}}{{/if}}" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
         <h4 class="modal-title">{{if isset($role['id'])}}编辑{{else}}新增{{/if}}课表</h4>
    </div>
    <div class="modal-body">

<!-- BEGIN FORM-->
<div class="control-group">
    <label class="control-label">星期</label>
    <div class="controls">
        <select id="week" name="week" class="span6 m-wrap select2" placeholder="请选择星期...">
            <option {{if isset($role['week']) && $role['week'] == 1}}selected{{/if}} value="1">周一</option>
            <option {{if isset($role['week']) && $role['week'] == 2}}selected{{/if}} value="2">周二</option>
            <option {{if isset($role['week']) && $role['week'] == 3}}selected{{/if}} value="3">周三</option>
            <option {{if isset($role['week']) && $role['week'] == 4}}selected{{/if}} value="4">周四</option>
            <option {{if isset($role['week']) && $role['week'] == 5}}selected{{/if}} value="5">周五</option>
            <option {{if isset($role['week']) && $role['week'] == 6}}selected{{/if}} value="6">周六</option>
            <option {{if isset($role['week']) && $role['week'] == 7}}selected{{/if}} value="7">周日</option>
        </select>
    </div>
</div>

{{if $account_school_id > 0}}
<input type="hidden" name="school_id" value="{{$account_school_id}}">
{{else}}
<div class="control-group">
    <label class="control-label">所在机构</label>
    <div class="controls">
        <!-- <select id="school_id" name="school_id" class="span6 m-wrap select2" placeholder="请选择学校...">
            {{foreach from=$school item=m}}
                <option {{if isset($role['school_id']) && $role['school_id'] == $m['id']}}selected{{/if}} value="{{$m['id']}}">{{$m['name']}}</option>
            {{/foreach}}
        </select> -->
            {{foreach from=$school item=m}}
                {{if isset($school_id) && $school_id == $m['id']}}
                    <input type="text" value="{{$m['name']}}" readonly="true" class="span6 m-wrap" />
                    <input type="hidden" name="school_id" value="{{$m['id']}}">
                {{/if}} 
            {{/foreach}}

    </div>
</div>
{{/if}}

<div class="control-group">
    <label class="control-label">上课时间</label>
    <div class="controls" style="padding-left: 30px;">
        <div class="input-append bootstrap-timepicker-component">
            <input name="begin_at" class="m-wrap m-ctrl-small timepicker-24" type="text" value="{{if isset($role['begin_at']) }}{{date("H:i", $role['begin_at'])}}{{/if}}"  />
            <span class="add-on"><i class="icon-time"></i></span>
        </div>
        至
        <div class="input-append bootstrap-timepicker-component">
            <input value="{{if isset($role['end_at']) }}{{date("H:i", $role['end_at'])}}{{/if}}" name="end_at" class="m-wrap m-ctrl-small timepicker-24" type="text"  />
            <span class="add-on"><i class="icon-time"></i></span>
        </div>
        
    </div>
</div>

<div class="control-group">
    <label class="control-label">课程类型</label>
    <div class="controls">
            <select id="course_type" name="course_type" class="span6 m-wrap select2"  placeholder="请选择课程类型...">
                {{foreach from=$course_type item=m}}
                <option
                    {{if isset($role['course_type']) && in_array($m['id'], $role['course_type'])}}selected{{/if}} value="{{$m['id']}}">{{$m['name']}}
                </option> 
                {{/foreach}}
            </select>
    </div>
</div>

<div class="control-group">
    <label class="control-label">老师</label>
    <div class="controls">
        <select id="teacher_id" name="teacher_id" class="span6 m-wrap select2" placeholder="请选择老师...">
            <option selected value="0">请选老师...</option>
            {{foreach from=$teacher item=t}}
                <option {{if isset($role['teacher_id']) && $role['teacher_id'] == $t['id']}}selected{{/if}} value="{{$t['id']}}">{{$t['name']}}</option>
            {{/foreach}}
        </select>
    </div>
</div>


<!-- <div class="control-group">
    <label class="control-label">上课时间</label>
    <div class="controls">
        <div class="input-append date form_datetime">
            <input size="16" type="text" value="" readonly class="m-wrap">
            <span class="add-on"><i class="icon-calendar"></i></span>
        </div>
    </div>
</div> -->








<div class="control-group">
    <label class="control-label" >是否启用</label>
    <div class="controls">
        <label class="radio">
        <input {{if isset($role['is_enabled']) && $role['is_enabled']=='1'}}checked{{/if}} {{if !isset($role['is_enabled'])}}checked{{/if}}
        type="radio" name="is_enabled" value="1" />
        启用
        </label>
        <label class="radio">
        <input {{if isset($role['is_enabled']) && $role['is_enabled']=='0'}}checked{{/if}} 
            type="radio" name="is_enabled" value="0" />
        禁用
        </label>
    </div>
</div>

<!-- <div class="control-group">
    <label class="control-label">备注</label>
    <div class="controls">
        <input value="{{if isset($role['note'])}}{{$role['note']}}{{/if}}"
             name="note" type="text" placeholder="note" class="m-wrap span6" />
        <span class="help-inline"></span>
    </div>

</div> -->



<!-- END FORM-->


    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button id="btn_add" type="button" class="btn btn-primary blue">保存</button>
    </div>
</form>
