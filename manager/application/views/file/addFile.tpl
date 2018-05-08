<form name="ff" id="ff" class="form-horizontal ajax_form" action="/file/addFile" method='post' enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{if isset($role['id'])}}{{$role['id']}}{{/if}}" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
         <h4 class="modal-title">{{if isset($role['id'])}}编辑{{else}}新增{{/if}}素材</h4>
    </div>
    <div class="modal-body">

<div class="control-group">
    <label class="control-label"><span style="color: red;">*</span>机构名称</label>
    <div class="controls">
        <input value="{{if isset($role['name_sina'])}}{{$role['name_sina']}}{{/if}}"
            name="name" type="text" placeholder="" class="m-wrap span6" />
        <!-- <span class="help-inline">This is inline help</span> -->
    </div>
</div>

<div class="control-group">
    <label class="control-label">类型</label>
    <div class="controls">
        <select name="category" class="span6 m-wrap select2" placeholder="请选择学校...">
            <option value="0">请选择类型...</option>
            {{foreach from=$school_type item=m}}
                <option {{if isset($role['category']) && $role['category'] == $m['id']}}selected{{/if}} value="{{$m['id']}}">{{$m['name']}}</option>
            {{/foreach}}
        </select>
    </div>
</div>

<!-- END FORM-->

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button id="btn_add" type="button" class="btn btn-primary blue">保存</button>
    </div>
</form>
