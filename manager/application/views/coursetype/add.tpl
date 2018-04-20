<form name="ff" id="ff" class="form-horizontal ajax_form" action="/coursetype/add" method='post' enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{if isset($role['id'])}}{{$role['id']}}{{/if}}" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
         <h4 class="modal-title">{{if isset($role['id'])}}编辑{{else}}新增{{/if}}学校/组织</h4>
    </div>
    <div class="modal-body">

<!-- BEGIN FORM-->
<div class="control-group">

    <label class="control-label">课程类型</label>

    <div class="controls">

        <input value="{{if isset($role['name'])}}{{$role['name']}}{{/if}}"
            name="name" type="text" placeholder="name" class="m-wrap span6" />

        <!-- <span class="help-inline">This is inline help</span> -->

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
             name="note" type="text" placeholder="note" class="m-wrap span6" />
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
