<form name="ff" id="ff" class="form-horizontal ajax_form" action="/school/add" method='post' enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{if isset($role['id'])}}{{$role['id']}}{{/if}}" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
         <h4 class="modal-title">{{if isset($role['id'])}}编辑{{else}}新增{{/if}}学校/组织</h4>
    </div>
    <div class="modal-body">

<!-- BEGIN FORM-->
<div class="control-group">
    <label class="control-label"><span style="color: red;">*</span>机构名称</label>
    <div class="controls">
        <input value="{{if isset($role['name'])}}{{$role['name']}}{{/if}}"
            name="name" type="text" placeholder="" class="m-wrap span6" />
        <!-- <span class="help-inline">This is inline help</span> -->
    </div>
</div>

<div class="control-group">
    <label class="control-label">机构类型</label>
    <div class="controls">
        <select name="school_type_id" class="span6 m-wrap select2" placeholder="请选择学校...">
            <!-- <option value="0">请选择学校...</option> -->
            {{foreach from=$school_type item=m}}
                <option {{if isset($role['school_type_id']) && $role['school_type_id'] == $m['id']}}selected{{/if}} value="{{$m['id']}}">{{$m['name']}}</option>
            {{/foreach}}
        </select>
    </div>
</div>

<div class="control-group">
    <label class="control-label"><span style="color: red;">*</span>联系人姓名</label>
    <div class="controls">
        <input value="{{if isset($role['contact_name'])}}{{$role['contact_name']}}{{/if}}"
            name="contact_name" type="text" placeholder="" class="m-wrap span6" />
        <!-- <span class="help-inline">This is inline help</span> -->
    </div>
</div>

<div class="control-group">
    <label class="control-label"><span style="color: red;">*</span>手机号</label>
    <div class="controls">
        <input value="{{if isset($role['phone'])}}{{$role['phone']}}{{/if}}"
            name="phone" type="text" placeholder="" class="m-wrap span6" />
        <!-- <span class="help-inline">This is inline help</span> -->
    </div>
</div>

<div class="control-group">
    <label class="control-label"><span style="color: red;">*</span>邮箱</label>
    <div class="controls">
        <input value="{{if isset($role['email'])}}{{$role['email']}}{{/if}}"
            name="email" type="text" placeholder="" class="m-wrap span6" />
        <!-- <span class="help-inline">This is inline help</span> -->
    </div>
</div>

<div class="control-group">
    <label class="control-label"><span style="color: red;">*</span>地址</label>
    <div class="controls">
        <select name="province" class="span2 m-wrap select2" placeholder="请选择学校...">
            <option value="0">请选择省...</option>
            {{foreach from=$province item=p}}
                <option {{if isset($role['province']) && $role['province'] == $p['provinceid']}}selected{{/if}} value="{{$p['provinceid']}}">{{$p['province']}}</option>
            {{/foreach}}
        </select>
    
     <select name="city" class="span2 m-wrap select2" placeholder="请选择学校...">
            <option value="0">请选择市...</option>
            {{foreach from=$city item=c}}
                <option {{if isset($role['city']) && $role['city'] == $c['cityid']}}selected{{/if}} value="{{$c['cityid']}}">{{$c['city']}}</option>
            {{/foreach}}
        </select>
        
        <select name="area" class="span2 m-wrap select2" placeholder="请选择学校...">
            <option value="0">请选择区...</option>
            {{foreach from=$area item=a}}
                <option {{if isset($role['area']) && $role['area'] == $a['areaid']}}selected{{/if}} value="{{$a['areaid']}}">{{$a['area']}}</option>
            {{/foreach}}
        </select>


    </div>
</div>

<div class="control-group">
    <label class="control-label"><span style="color: red;">*</span>详细地址</label>
    <div class="controls">
        <input value="{{if isset($role['address'])}}{{$role['address']}}{{/if}}"
            name="address" type="text" placeholder="" class="m-wrap span6" />
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
             name="note" type="text" placeholder="" class="m-wrap span6" />
        <span class="help-inline"></span>
    </div>

</div>

<div class="control-group">
    <label class="control-label">合同文件</label>
    <div class="controls" style="padding-left: 30px;">
        <div class="fileupload fileupload-new" data-provides="fileupload">
            <div class="input-append">
                <div class="uneditable-input">
                    <i class="icon-file fileupload-exists"></i> 
                    <span class="fileupload-preview"></span>
                </div>
                <span class="btn btn-file">
                <span class="fileupload-new">选择合同</span>
                <span class="fileupload-exists">修改</span>
                <input name="contract_file" value="" type="file" class="default" />
                </span>
                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">移去</a>
            </div>
            <span class="help-inline">{{if isset($role['id'])}}如不需修改合同文件，请不要选择{{/if}}</span>
        </div>
    </div>
</div>



<!-- demo 年月日 时分秒 -->
<!-- <div class="control-group">
    <label class="control-label">Default Datetimepicker</label>
    <div class="controls">
        <div class="input-append date form_datetime">
            <input size="16" type="text" value="" readonly class="m-wrap">
            <span class="add-on"><i class="icon-calendar"></i></span>
        </div>
    </div>
</div>  -->

<div class="control-group">
    <label class="control-label"><span style="color: red;">*</span>合同有效期</label>
    <div class="controls" style="padding-left: 30px;">
        <div class="input-append date form_datetime_d">
            <input name="contract_start_time" size="16" type="text" value="{{if isset($role['contract_start_time'])}}{{date("Y-m-d",$role['contract_start_time'])}}{{/if}}" readonly class="m-wrap">
            <span class="add-on"><i class="icon-calendar"></i></span>
        </div> 至
        <div class="input-append date form_datetime_d">
            <input name="contract_end_time"  size="16" type="text" value="{{if isset($role['contract_end_time'])}}{{date("Y-m-d", $role['contract_end_time'])}}{{/if}}" readonly class="m-wrap">
            <span class="add-on"><i class="icon-calendar"></i></span>
        </div>
    </div>
</div>

<!-- <div class="control-group">
    <label class="control-label">结束日期</label>
    <div class="controls">
        <div class="input-append date form_datetime_d">
            <input size="16" type="text" value="" readonly class="m-wrap">
            <span class="add-on"><i class="icon-calendar"></i></span>
        </div>
    </div>
</div> -->




<!-- END FORM-->


    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button id="btn_add" type="button" class="btn btn-primary blue">保存</button>
    </div>
</form>


<!-- file:///C:/Users/Administrator/Desktop/doc/ftpm_112_bwx/ftpm_112_bwx/ui_jqueryui.html -->
<!-- file:///C:/Users/Administrator/Desktop/doc/ftpm_112_bwx/ftpm_112_bwx/form_component.html -->