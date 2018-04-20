<form name="ff" id="ff" class="form-horizontal ajax_form" action="/classes/add" method='post' enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{if isset($role['id'])}}{{$role['id']}}{{/if}}" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
         <h4 class="modal-title">{{if isset($role['id'])}}编辑{{else}}新增{{/if}}班级</h4>
    </div>
    <div class="modal-body">

<!-- BEGIN FORM-->
<div class="control-group">
    <label class="control-label">班级名称</label>
    <div class="controls">
        <input value="{{if isset($role['name'])}}{{$role['name']}}{{/if}}"
            name="name" type="text" placeholder="" class="m-wrap span6" />
        <!-- <span class="help-inline">This is inline help</span> -->
    </div>
</div>

{{if $school_id > 0}}
<input type="hidden" value="{{$school_id}}" name="school_id" />
{{else}}
<div class="control-group">
    <label class="control-label">所在机构</label>
    <div class="controls">
        <select name="school_id" class="span6 m-wrap select2" placeholder="请选择学校...">
            <option value="0">请选择机构...</option>
            {{foreach from=$school item=m}}
                <option {{if isset($role['school_id']) && $role['school_id'] == $m['id']}}selected{{/if}} value="{{$m['id']}}">{{$m['name']}}</option>
            {{/foreach}}
        </select>
    </div>
</div>
{{/if}}


<div class="control-group">
    <label class="control-label">班级logo</label>
    <div class="controls">
        <div class="span6 fileupload fileupload-new" data-provides="fileupload">
            <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                <img src="{{if isset($role['dir'])}}{{$role['dir']}}{{else}}/image/AAAAAA&amp;text=no+image{{/if}}" alt="" />
            </div>
            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
            <div>
                <span class="btn btn-file"><span class="fileupload-new">选择图片</span>
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




<!-- <div class="control-group">
    <label class="control-label">访问导航权限</label>
    <div class="controls">
            <select name="menu_ids[]" class="span6 m-wrap select2" multiple placeholder="请选择导航...">
                {{foreach from=$system_menu item=m}}
                    <optgroup label="{{$m['menu_name']}}">
                        {{foreach from=$m['child'] item=mm}}
                            <option
                                {{if isset($role['menu_ids']) && in_array($mm['id'], $role['menu_ids'])}}selected{{/if}}
                            value="{{$mm['id']}}">{{$mm['menu_name']}}</option>
                        {{/foreach}}
                    </optgroup>
                {{/foreach}}
            </select>
    </div>
</div> -->


<!-- <div class="control-group">
    <label class="control-label" >是否启用</label>
    <div class="controls">
        <label class="radio">
        <input {{if isset($role['status']) && $role['status']=='1'}}checked{{/if}}
        type="radio" name="status" value="1" />
        启用
        </label>
        <label class="radio">
        <input {{if isset($role['status']) && $role['status']=='2'}}checked{{/if}}
            type="radio" name="status" value="2" />
        禁用
        </label>
    </div>
</div> -->

<div class="control-group">
    <label class="control-label">备注</label>
    <div class="controls">
        <input value="{{if isset($role['desc'])}}{{$role['desc']}}{{/if}}"
             name="desc" type="text" placeholder="" class="m-wrap span6" />
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
