<form name="ff" id="ff" class="form-horizontal ajax_form" action="/system/addaccount" method='post'>
    <input type="hidden" name="id" value="{{if isset($account['id'])}}{{$account['id']}}{{/if}}" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
         <h4 class="modal-title">{{if isset($account['id'])}}编辑{{else}}新增{{/if}}账号</h4>
    </div>
    <div class="modal-body">

<!-- BEGIN FORM-->
<div class="control-group">
    <label class="control-label">昵称</label>
    <div class="controls">
        <input value="{{if isset($account['nickname'])}}{{$account['nickname']}}{{/if}}"
            name="nickname" type="text" placeholder="请输入昵称..." class="m-wrap span6" />
        <!-- <span class="help-inline">This is inline help</span> -->
    </div>
</div>

<div class="control-group">
    <label class="control-label">账号</label>
    <div class="controls">
        <input value="{{if isset($account['account_name'])}}{{$account['account_name']}}{{/if}}"
            name="account_name" type="text" placeholder="small" class="m-wrap span6" />
        <span class="help-inline"></span>
    </div>
</div>

<div class="control-group">
    <label class="control-label">密码</label>
    <div class="controls">
        <input value=""
            name="passwd" type="password" placeholder="small" class="m-wrap span6" />
        <span class="help-inline">修改时不填为不修改</span>
    </div>
</div>


<div class="control-group">
    <label class="control-label">角色</label>
    <div class="controls">
            <select name="role_id[]" class="span6 m-wrap select2" multiple placeholder="请选择角色...">
                {{foreach from=$roles item=r}}
                            <option
                                {{if isset($account['role_id']) && in_array($r['id'], $account['role_id'])}}selected{{/if}}
                            value="{{$r['id']}}">{{$r['role_name']}}</option>

                {{/foreach}}
            </select>
    </div>
</div>

{{if isset($account['id'])}}
<div class="control-group">
    <label class="control-label">所在机构</label>
    <div class="controls">
        <input value="{{foreach from=$school item=m}}{{if isset($account['school_id']) && $account['school_id'] == $m['id']}}{{$m['name']}}{{/if}}{{/foreach}}"
            name="school_id" type="text" placeholder="" class="m-wrap span6" readonly="true" />
        <span class="help-inline">此项出错后影响太大，暂时不支持编辑</span>
    </div>
</div>
{{else}}
<div class="control-group">
    <label class="control-label">所在机构</label>
    <div class="controls">
        <select name="school_id" class="span6 m-wrap select2" placeholder="请选择学校...">
            <option value="0">请选择机构...</option>
            {{foreach from=$school item=m}}
                <option {{if isset($account['school_id']) && $account['school_id'] == $m['id']}}selected{{/if}} value="{{$m['id']}}">{{$m['name']}}</option>
            {{/foreach}}
        </select>
        <span class="help-inline">公司管理人员不用选择</span>
    </div>
</div>
{{/if}}


<div class="control-group">
    <label class="control-label">Email</label>
    <div class="controls">
        <input value="{{if isset($account['email'])}}{{$account['email']}}{{/if}}"
            name="email" type="text" placeholder="small" class="m-wrap span6" />
        <span class="help-inline"></span>
    </div>
</div>

<div class="control-group">
    <label class="control-label">电话</label>
    <div class="controls">
        <input value="{{if isset($account['phone'])}}{{$account['phone']}}{{/if}}"
            name="phone" type="text" placeholder="small" class="m-wrap span6" />
        <span class="help-inline"></span>
    </div>
</div>


<div class="control-group">
    <label class="control-label" >是否启用</label>
    <div class="controls">
        <label class="radio">
        <input {{if isset($account['status']) && $account['status']=='1'}}checked{{/if}}{{if !isset($account['status'])}}checked{{/if}}
        type="radio" name="status" value="1" />
        启用
        </label>
        <label class="radio">
        <input {{if isset($account['status']) && $account['status']=='2'}}checked{{/if}}
            type="radio" name="status" value="2" />
        禁用
        </label>
    </div>
</div>

<div class="control-group">
    <label class="control-label">备注</label>
    <div class="controls">
        <input value="{{if isset($account['note'])}}{{$account['note']}}{{/if}}"
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
