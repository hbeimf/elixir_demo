<form name="ff" id="ff" class="form-horizontal ajax_form" action="/curriculum/edit" method='post' enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{if isset($role['id'])}}{{$role['id']}}{{/if}}" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
         <h4 class="modal-title">{{if isset($role['id'])}}编辑{{else}}新增{{/if}}课程</h4>
    </div>
    <div class="modal-body">

<!-- BEGIN FORM-->
<div class="control-group">
    <label class="control-label">课程名称</label>
    <div class="controls">
        <input value="{{if isset($role['name'])}}{{$role['name']}}{{/if}}"
            name="name" type="text" placeholder="name" class="m-wrap span6" />
    </div>
</div>

<div class="control-group">
    <label class="control-label">排序</label>
    <div class="controls">
        <input value="{{if isset($role['order_by'])}}{{$role['order_by']}}{{/if}}"
            name="order_by" type="text" placeholder="order_by" class="m-wrap span6" />
    </div>
</div>


<!-- END FORM-->


    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button id="btn_add" type="button" class="btn btn-primary blue">保存</button>
    </div>
</form>
