<form name="ff" id="ff" class="form-horizontal ajax_form" action="/ppt/add/?curriculum_id={{$curriculum_id}}" method='post' enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{if isset($role['id'])}}{{$role['id']}}{{/if}}" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
         <h4 class="modal-title">{{if isset($role['id'])}}编辑{{else}}新增{{/if}}PPT</h4>
    </div>
    <div class="modal-body">

<!-- BEGIN FORM-->
<div class="control-group">
    <label class="control-label">PPT名称</label>
    <div class="controls">
        <input value="{{if isset($role['name'])}}{{$role['name']}}{{/if}}"
            name="name" type="text" placeholder="" class="m-wrap span6" />
        <!-- <span class="help-inline">This is inline help</span> -->
    </div>
</div>

<div class="control-group">
    <label class="control-label" >选择模板</label>
    <div class="controls">
        <label class="radio">
        <input {{if isset($role['class_type']) && $role['class_type']=='1'}}checked{{/if}}{{if !isset($role['class_type'])}}checked{{/if}}
        type="radio" name="class_type" value="1" />
        模板1
        </label>
        <label class="radio">
        <input {{if isset($role['class_type']) && $role['class_type']=='2'}}checked{{/if}}
            type="radio" name="class_type" value="2" />
        模板2
        </label>
    </div>
</div>

<div id="tpl_1" class="control-group span10" style="margin-left:100px; height: 400px; display: none;">
    <table style="width: 100%;">
        <tr>
            <td style="border: black solid 1px;">
                    <div style="height: 200px; padding-top: 5px;">
                        <label class="control-label" style="">提示：此部分添加图片</label>
                        <div class="controls">
                            <a data-toggle="modal" data-target="#mod_900" href="/ppt/pic/?area=11&curriculum_id={{$curriculum_id}}" class="btn green" > 
                            选择图片
                            </a>
                            <br />
                            {{if isset($role['class_type']) && $role['class_type'] == 1 && isset($area11['dir'])}}
                                <img id='area_11' style="width: 100px; height: 100px; margin-top: 10px; margin-left: 150px;" src="{{$area11['dir']}}" />
                            {{else}}
                                <img id='area_11' style="width: 100px; height: 100px; margin-top: 10px; margin-left: 150px; display: none;" src="" />
                            {{/if}}
                            
                        </div>
                    </div>
            </td>
        </tr>
        <tr>
            <td style="border-left: black solid 1px;border-right: black solid 1px;border-bottom: black solid 1px;">
                <div style="height: 200px; padding-top: 5px;">
                    <label class="control-label" style="">提示：此处添加文字音频</label>
                    <div class="controls">
                        <a data-toggle="modal" data-target="#mod_900" href="/ppt/font/?area=12&curriculum_id={{$curriculum_id}}" class="btn green" >
                        选择文字音频
                        </a>
                        <br />
                        <div id="area_12_font" style="margin-top: 30px;">
                            {{if isset($role['class_type']) && $role['class_type'] == 1 && isset($area12['font'])}}
                            文字: {{$area12['font']}}
                            {{/if}}
                        </div>
                        <div id="area_12_mp3" style="margin-top: 10px;">
                             {{if isset($role['class_type']) && $role['class_type'] == 1 && isset($area12['mp3'])}}
                            音频: {{$area12['mp3']}}
                            {{/if}}
                        </div>

                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>


<div id="tpl_2" class="control-group span10" style=" margin-left:100px; height: 400px; display: none;">
    <table style="width: 100%;">
        <tr>
            <td style="border: black solid 1px; width: 50%;">
                    <div style="height: 200px; padding-top: 5px;">
                    <label class="control-label" style="">提示：此处添加文字音频</label>
                    <div class="controls">
                        <a data-toggle="modal" data-target="#mod_900" href="/ppt/font/?area=21&curriculum_id={{$curriculum_id}}" class="btn green" >
                        选择文字音频
                        </a>
                        <br />
                        <div id="area_21_font" style="margin-top: 30px;">
                            {{if isset($role['class_type']) && $role['class_type'] == 2 && isset($area21['font'])}}
                            文字: {{$area21['font']}}
                            {{/if}}
                        </div>
                        <div id="area_21_mp3" style="margin-top: 10px;">
                             {{if isset($role['class_type']) && $role['class_type'] == 2 && isset($area21['mp3'])}}
                            音频: {{$area21['mp3']}}
                            {{/if}}
                        </div>

                    </div>
                </div>
            </td>
            <td style="border-right: black solid 1px;border-bottom: black solid 1px;border-top: black solid 1px;">
                    <div style="height: 200px; padding-top: 5px;">
                        <label class="control-label" style="">提示：此部分添加图片</label>
                        <div class="controls">
                            <a data-toggle="modal" data-target="#mod_900" href="/ppt/pic/?area=22&curriculum_id={{$curriculum_id}}" class="btn green" >
                            选择图片
                            </a>
                            <br />
                            {{if isset($role['class_type']) && $role['class_type'] == 2 && isset($area22['dir'])}}
                                <img id='area_22' style="width: 100px; height: 100px; margin-top: 10px; margin-left: 150px;" src="{{$area22['dir']}}" />
                            {{else}}
                                <img id='area_22' style="width: 100px; height: 100px; margin-top: 10px; margin-left: 150px; display: none;" src="" />
                            {{/if}}
                        </div>
                    </div>
            </td>
        </tr>
        <tr>
           <td style="border-left: black solid 1px;border-bottom: black solid 1px;border-right: black solid 1px;">
                   <div style="height: 200px; padding-top: 5px;">
                    <label class="control-label" style="">提示：此处添加文字音频</label>
                    <div class="controls">
                        <a data-toggle="modal" data-target="#mod_900" href="/ppt/font/?area=23&curriculum_id={{$curriculum_id}}" class="btn green" >
                        选择文字音频
                        </a>
                        <br />
                        <div id="area_23_font" style="margin-top: 30px;">
                            {{if isset($role['class_type']) && $role['class_type'] == 2 && isset($area23['font'])}}
                            文字: {{$area23['font']}}
                            {{/if}}
                        </div>
                        <div id="area_23_mp3" style="margin-top: 10px;">
                             {{if isset($role['class_type']) && $role['class_type'] == 2 && isset($area23['mp3'])}}
                            音频: {{$area23['mp3']}}
                            {{/if}}
                        </div>
                    </div>
                </div>
            </td>
           <td style="border-bottom: black solid 1px;border-right: black solid 1px;">
                    <div style="height: 200px; padding-top: 5px;">
                    <label class="control-label" style="">提示：此处添加文字音频</label>
                    <div class="controls">
                        <a data-toggle="modal" data-target="#mod_900" href="/ppt/font/?area=24&curriculum_id={{$curriculum_id}}" class="btn green" >
                        选择文字音频
                        </a>
                        <br />
                        <div id="area_24_font" style="margin-top: 30px;">
                            {{if isset($role['class_type']) && $role['class_type'] == 2 && isset($area24['font'])}}
                            文字: {{$area24['font']}}
                            {{/if}}
                        </div>
                        <div id="area_24_mp3" style="margin-top: 10px;">
                             {{if isset($role['class_type']) && $role['class_type'] == 2 && isset($area24['mp3'])}}
                            音频: {{$area24['mp3']}}
                            {{/if}}
                        </div>

                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>

<div style="clear:both;"></div>

<div class="control-group">
    <label class="control-label" >是否启用</label>
    <div class="controls">
        <label class="radio">
        <input {{if isset($role['is_enabled']) && $role['is_enabled']=='1'}}checked{{/if}}{{if !isset($role['is_enabled'])}}checked{{/if}} type="radio" name="is_enabled" value="1" />
        启用
        </label>
        <label class="radio">
        <input {{if isset($role['is_enabled']) && $role['is_enabled']=='0'}}checked{{/if}} type="radio" name="is_enabled" value="0" />
        禁用
        </label>
    </div>
</div>


<!-- END FORM-->


    </div>
    <div class="modal-footer">
        
        <input type="hidden" value="{{if isset($role['class_type']) && $role['class_type'] == 1 && isset($area11['id'])}}{{$area11['id']}}{{else}}0{{/if}}" id="area_11_id" name="area_11_id" />
        <input type="hidden" value="{{if isset($role['class_type']) && $role['class_type'] == 1 && isset($area12['id'])}}{{$area12['id']}}{{else}}0{{/if}}" id="area_12_id" name="area_12_id" />
        <input type="hidden" value="{{if isset($role['class_type']) && $role['class_type'] == 2 && isset($area21['id'])}}{{$area21['id']}}{{else}}0{{/if}}" id="area_21_id" name="area_21_id" />
        <input type="hidden" value="{{if isset($role['class_type']) && $role['class_type'] == 2 && isset($area22['id'])}}{{$area22['id']}}{{else}}0{{/if}}" id="area_22_id" name="area_22_id" />
        <input type="hidden" value="{{if isset($role['class_type']) && $role['class_type'] == 2 && isset($area23['id'])}}{{$area23['id']}}{{else}}0{{/if}}" id="area_23_id" name="area_23_id" />
        <input type="hidden" value="{{if isset($role['class_type']) && $role['class_type'] == 2 && isset($area24['id'])}}{{$area24['id']}}{{else}}0{{/if}}" id="area_24_id" name="area_24_id" />


        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button id="btn_add" type="button" class="btn btn-primary blue">保存</button>
    </div>
</form>
