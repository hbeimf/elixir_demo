<form name="ff" id="ff" class="form-horizontal ajax_form" action="/font/add/?curriculum_id={{$curriculum_id}}" method='post' enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{if isset($role['id'])}}{{$role['id']}}{{/if}}" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
         <h4 class="modal-title">{{if isset($role['id'])}}编辑{{else}}新增{{/if}}素材</h4>
    </div>
    <div class="modal-body">

<!-- BEGIN FORM-->
<div class="control-group">
    <label class="control-label">文字</label>
    <div class="controls">
        <input value="{{if isset($role['font'])}}{{$role['font']}}{{/if}}"
            name="font" type="text" placeholder="" class="m-wrap span6" />
        <!-- <span class="help-inline">This is inline help</span> -->
    </div>
</div>
<div class="control-group">
    <label class="control-label">音频说明</label>
    <div class="controls">
        <input value="{{if isset($role['mp3_desc'])}}{{$role['mp3_desc']}}{{/if}}"
            name="mp3_desc" type="text" placeholder="" class="m-wrap span6" />
        <!-- <span class="help-inline">This is inline help</span> -->
    </div>
</div>



<div class="control-group">
    <label class="control-label">上传音频</label>
    <div class="controls" style="padding-left: 30px;">
        <div class="fileupload fileupload-new" data-provides="fileupload">
            <div class="input-append">
                <div class="uneditable-input">
                    <i class="icon-file fileupload-exists"></i> 
                    <span class="fileupload-preview"></span>
                </div>
                <span class="btn btn-file">
                <span class="fileupload-new">选择文件</span>
                <span class="fileupload-exists">修改</span>
                <input name="mp3" value="" type="file" class="default" />
                </span>
                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">移去</a>
            </div>
            <span class="help-inline">{{if isset($role['id'])}}如不需修改，请不要选择{{/if}}</span>
        </div>
    </div>
</div>


<div class="control-group">
    <label class="control-label" >音频属性</label>
    <div class="controls">
        <label class="radio">
        <input {{if isset($role['mp3_type']) && $role['mp3_type']=='1'}}checked{{/if}}{{if !isset($role['mp3_type'])}}checked{{/if}}
        type="radio" name="mp3_type" value="1" />
        背景音乐
        </label>
        <label class="radio">
        <input {{if isset($role['mp3_type']) && $role['mp3_type']=='0'}}checked{{/if}}
            type="radio" name="mp3_type" value="0" />
        教学播放
        </label>
    </div>
</div>

<div class="control-group">
    <label class="control-label" >是否启用</label>
    <div class="controls">
        <label class="radio">
        <input {{if isset($role['is_enabled']) && $role['is_enabled']=='1'}}checked{{/if}}{{if !isset($role['is_enabled'])}}checked{{/if}}
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


<!-- END FORM-->


    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button id="btn_add" type="button" class="btn btn-primary blue">保存</button>
    </div>
</form>
