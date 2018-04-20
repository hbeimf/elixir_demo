<form name="ff" id="ff" class="form-horizontal ajax_form" action="/teacher/add" method='post' enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{if isset($role['id'])}}{{$role['id']}}{{/if}}" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
         <h4 class="modal-title">{{if isset($role['id'])}}编辑{{else}}新增{{/if}}教师</h4>
    </div>
    <div class="modal-body">

<!-- BEGIN FORM-->
<div class="control-group">
    <label class="control-label"><font color="red">*</font>老师名称</label>
    <div class="controls">
        <input value="{{if isset($role['name'])}}{{$role['name']}}{{/if}}"
            name="name" type="text" placeholder="" class="m-wrap span6" />
        <!-- <span class="help-inline">This is inline help</span> -->
    </div>
</div>
<div class="control-group">
    <label class="control-label"><font color="red">*</font>老师头像</label>
    <div class="controls">
        <div class="span6 fileupload fileupload-new" data-provides="fileupload">
            <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                <img src="{{if isset($role['dir'])}}{{$role['dir']}}{{else}}/image/AAAAAA&amp;text=no+image{{/if}}" alt="" />
            </div>
            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
            <div>
                <span class="btn btn-file"><span class="fileupload-new">选择图像</span>
                <span class="fileupload-exists">变更</span>
                <input name="img" type="file" class="default" /></span>
                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">移除</a>
            </div>
        </div>
        <!-- <span class="label label-important">NOTE!</span>
        <span>
        Attached image thumbnail is
        supported in Latest Firefox, Chrome, Opera, 
        Safari and Internet Explorer 10 only
        </span> -->
    </div>
</div>

{{if $school_id == 0}}
<div class="control-group">
    <label class="control-label"><font color="red">*</font>所在机构</label>
    <div class="controls">
        <select name="school_id" class="span6 m-wrap select2" placeholder="请选择学校...">
            <option value="0">请选择机构...</option>
            {{foreach from=$school item=m}}
                <option {{if isset($role['school_id']) && $role['school_id'] == $m['id']}}selected{{/if}} value="{{$m['id']}}">{{$m['name']}}</option>
            {{/foreach}}
        </select>
    </div>
</div>
{{else}}
<input type="hidden" name="school_id" value="{{$school_id}}" />
{{/if}}

<div class="control-group">
    <label class="control-label"><font color="red">*</font>课程类型</label>
    <div class="controls">
            <select name="course_type[]" class="span6 m-wrap select2" multiple placeholder="请选择课程类型...">
                {{foreach from=$course_type item=m}}
                <option
                    {{if isset($role['course_type']) && in_array($m['id'], $role['course_type'])}}selected{{/if}} value="{{$m['id']}}">{{$m['name']}}
                </option> 
                {{/foreach}}
            </select>
    </div>
</div>

<div class="control-group">
    <label class="control-label"><font color="red">*</font>账号(手机)</label>
    <div class="controls">
        <input value="{{if isset($role['phone'])}}{{$role['phone']}}{{/if}}" 
        {{if isset($role['id'])}}readonly{{/if}}
            name="phone" type="text" placeholder="" class="m-wrap span6" />
        <!-- <span class="help-inline">This is inline help</span> -->
    </div>
</div>

<div class="control-group">
    <label class="control-label">{{if !isset($role['id'])}}<font color="red">*</font>{{/if}}登录密码</label>
    <div class="controls">
        <input value="{{if isset($role['passwd'])}}{{$role['passwd']}}{{/if}}"
             name="passwd" type="password" placeholder="" class="m-wrap span6" />
        <span class="help-inline">{{if isset($role['id'])}}不修改原密码保持为空即可{{/if}}</span>
    </div>

</div>

<div class="control-group">
    <label class="control-label"><font color="red">*</font>Email</label>
    <div class="controls">
        <input value="{{if isset($role['email'])}}{{$role['email']}}{{/if}}"
            name="email" type="text" placeholder="" class="m-wrap span6" />
        <!-- <span class="help-inline">This is inline help</span> -->
    </div>
</div>




<div class="control-group">
    <label class="control-label" >性别</label>
    <div class="controls">
        <label class="radio">
        <input {{if isset($role['gender']) && $role['gender']=='male'}}checked{{/if}}
        type="radio" name="gender" value="male" />
        男
        </label>
        <label class="radio">
        <input {{if isset($role['gender']) && $role['gender']=='female'}}checked{{/if}} {{if !isset($role['gender'])}}checked{{/if}}
            type="radio" name="gender" value="female" />
        女
        </label>

            
    </div>
</div>


<div class="control-group">
    <label class="control-label" >是否启用</label>
    <div class="controls">
        <label class="radio">
        <input {{if isset($role['is_enabled']) && $role['is_enabled']=='1'}}checked{{/if}}
        type="radio" name="is_enabled" value="1" />
        启用
        </label>
        <label class="radio">
        <input {{if isset($role['is_enabled']) && $role['is_enabled']=='0'}}checked{{/if}} {{if !isset($role['is_enabled'])}}checked{{/if}}
            type="radio" name="is_enabled" value="0" />
        禁用
        </label>
    </div>
</div>





<div class="control-group">
    <label class="control-label">备注</label>
    <div class="controls">
        <input value="{{if isset($role['note'])}}{{$role['note']}}{{/if}}"
             name="note" type="text" placeholder="" class="m-wrap span6" />
        <span class="help-inline"></span>
    </div>

</div>



<!-- END FORM-->


    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button id="btn_add" type="button" class="btn btn-primary blue">保存</button>
    </div>
</form>
