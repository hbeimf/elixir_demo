<form name="ff" id="ff" class="form-horizontal ajax_form" action="/ppt/pic/" method='post' enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{if isset($role['id'])}}{{$role['id']}}{{/if}}" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
         <h4 class="modal-title">乐谱列表</h4>
    </div>
    <div class="modal-body">

<!-- BEGIN FORM-->

<!-- BEGIN PAGE CONTENT-->
<div class="row-fluid">
    <div class="span12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet-body">

            <!-- 搜索开始 -->
            <div class="row-fluid">
                <form>
                    <div id="sample_1_length" class="dataTables_length">
                        <label>每页显示:
                            <select size="1" name="page_size" aria-controls="sample_1" class="m-wrap small">
                                <option value="10" {{if $params[ 'page_size']==10}}selected="selected" {{/if}}>10</option>
                                <option value="15" {{if $params[ 'page_size']==15}}selected="selected" {{/if}}>15</option>
                                <option value="20" {{if $params[ 'page_size']==20}}selected="selected" {{/if}}>20</option>
                                <!-- <option value="-1">All</option> -->
                            </select>
                            &nbsp;&nbsp;
                        </label>
                        <label>xml名称:
                            <input value="{{$params['name']}}" name="name" type="text" aria-controls="sample_1" class="m-wrap medium"> &nbsp;&nbsp;</label>
                        <!-- <label>邮箱: <input name="email" type="text" aria-controls="sample_1" class="m-wrap medium"> &nbsp;&nbsp;</label> -->
                        <label><button id="btn_search_music" type="button" class="btn btn-primary blue">查找</button></label>
                    </div>
                </form>
            </div>
            <!-- 搜索结束  -->
            <!-- 表开始 -->
            <table class="table table-striped table-bordered table-hover" id="sample_1">
                <thead>
                    <tr>
                       <th style="width:8px;"></th>
                        <th class="hidden-480">ID</th>
                        <th class="hidden-480">教材名称</th>
                        <th class="hidden-480">乐谱名称</th>
                        <th class="hidden-480">XML</th>
                        <th class="hidden-480">伴奏MP3</th>
                        <th class="hidden-480">示范MP3</th>
                    </tr>
                </thead>
                <tbody>
                    {{foreach from=$users item=r}}
                    <tr class="odd gradeX">
                        <td><input name="music_select" type="radio" class="radio" value="{{$r['id']}}" data-name="{{$r['name']}}" /></td>
                        <td>{{$r['id']}}</td>
                        <td>{{$r['t_name']}}</td>
                        <td>{{$r['name']}}</td>
                        
                        <td>{{$r['xml_name']}}</td>
                        <td>{{$r['mp3_name']}}</td>
                        <td>{{$r['mp3_demo_name']}}</td>
                     </tr>
                    {{/foreach}}
                </tbody>
            </table>
            <!-- 分页开始 -->
            {{include file="include/page_list.tpl"}}
            <!-- 分页结束 -->
            <!-- 表结束  -->
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<!-- END PAGE CONTENT-->

<!-- END FORM-->


    </div>
    <div class="modal-footer">
        <input type="hidden" name="curriculum_id" id="curriculum_id" value="{{$params['curriculum_id']}}" />
        
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button id="btn_add_music" type="button" class="btn btn-primary blue">确定</button>
    </div>
</form>
