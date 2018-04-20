{{include file="include/header.tpl"}}
<!-- BEGIN PAGE CONTENT-->
<div class="row-fluid">
    <div class="span12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet-body">
            <div class="clearfix">
                {{if $has_add_right['flg']}}
                <div class="btn-group pull-right">
                         <button id="btn_add_curriculum" type="button" class="btn btn-primary green">新增<i class="icon-plus"></i></button>
                </div>
                {{/if}}
            </div>
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
                        <label>名称:
                            <input value="{{$params['name']}}" name="name" type="text" aria-controls="sample_1" class="m-wrap medium"> &nbsp;&nbsp;</label>
                        <!-- <label>邮箱: <input name="email" type="text" aria-controls="sample_1" class="m-wrap medium"> &nbsp;&nbsp;</label> -->
                        <label>
                            <button id="btn_search" class="btn blue">查找
                                <!-- <i class="icon-plus"> --></i>
                            </button>
                        </label>
                    </div>
                </form>
            </div>
            <!-- 搜索结束  -->
            <!-- 表开始 -->
            <table class="table table-striped table-bordered table-hover" id="sample_1">
                <thead>
                    <tr>
                        <th style="width:8px;">NO</th>
                        <th style="width:15%;" class="hidden-480">课程名称</th>
                        <th class="hidden-480">课程步骤</th>
                        <th class="hidden-480">编辑</th>
                    </tr>
                </thead>
                <tbody>
                     {{foreach from=$users item=r}}
                    <tr class="odd gradeX">
                        <td>{{$r['order_by']}}</td>
                        <td>
                            {{if $has_edit_right['flg']}}
                            <a data-toggle="modal" data-target="#mod_1200" href="/curriculum/edit/?curriculum_id={{$r['id']}}">{{$r['name']|htmlspecialchars}}</a>
                            {{else}}
                            {{$r['name']|htmlspecialchars}}
                            {{/if}}
                        </td>
                        <td>
                              {{foreach from=$r['steps'] item=s}} 
                                {{if $has_addstep_right['flg']}}
                                    <a data-toggle="modal" data-target="#mod_1200" href="/curriculum/addstep/?curriculum_id={{$r['id']}}&step_id={{$s['id']}}">
                                        <span class="label label-success label-mini">{{$s['name']}}</span>
                                    </a>
                                {{else}}
                                    {{if $has_showstep_right['flg']}}
                                    <a data-toggle="modal" data-target="#mod_1200" href="/curriculum/showstep/?curriculum_id={{$r['id']}}&step_id={{$s['id']}}">
                                        <span class="label label-success label-mini">{{$s['name']}}</span>
                                    </a>
                                    {{/if}}
                                {{/if}}
                              {{/foreach}}         
                              {{if $has_addstep_right['flg']}}
                                <a data-toggle="modal" data-target="#mod_1200" href="/curriculum/addstep/?curriculum_id={{$r['id']}}" class="btn white"><i class="icon-plus"></i></a>
                              {{/if}}
                        </td>
                        <td style="width: 40%;">
                                {{if $r['is_enabled'] == 1}}
                                {{if $has_unenable_right['flg']}}
                                <a data-link="/curriculum/unenable/id/{{$r['id']}}/"
                                    class="btn red ajax-delete" data-msg="确认要禁用吗？">
                                    <i class="fa fa-pencil"></i>禁用
                                </a>
                                {{/if}}
                                {{else}}
                                {{if $has_enable_right['flg']}}
                                <a data-link="/curriculum/enable/id/{{$r['id']}}/"
                                    class="btn green ajax-delete" data-msg="确认要启用吗？">
                                    <i class="fa fa-pencil"></i>启用
                                </a>
                                {{/if}}
                                {{/if}}

                                {{if $has_pic_right['flg']}}
                                <a class="btn gray window-iframe"  
                                data-link="/pic/list/?curriculum_id={{$r['id']}}&debug={{$debug}}" data-id="pic_{{$r['id']}}" data-title="{{$r['id']}}-{{$r['name']}}">
                                    <i class="fa fa-pencil"></i>图片管理
                                </a>
                                {{/if}}

                                {{if $has_font_right['flg']}}
                               <a class="btn gray window-iframe"  
                                data-link="/font/list/?curriculum_id={{$r['id']}}&debug={{$debug}}" data-id="font_{{$r['id']}}" data-title="{{$r['id']}}-{{$r['name']}}">
                                    <i class="fa fa-pencil"></i>文字音频
                                </a>
                                {{/if}}

                                {{if $has_music_right['flg']}}
                                <a class="btn gray window-iframe"  
                                data-link="/music/list/?curriculum_id={{$r['id']}}&debug={{$debug}}" data-id="music_{{$r['id']}}" data-title="{{$r['id']}}-{{$r['name']}}">
                                    <i class="fa fa-pencil"></i>乐谱管理
                                </a>
                                {{/if}}

                                {{if $has_ppt_right['flg']}}
                                <a class="btn gray window-iframe"  
                                data-link="/ppt/list/?curriculum_id={{$r['id']}}&debug={{$debug}}" data-id="music_{{$r['id']}}" data-title="{{$r['id']}}-{{$r['name']}}">
                                    <i class="fa fa-pencil"></i>PPT管理
                                </a>
                                {{/if}}
                                 
                            </td>
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
{{include file="include/footer.tpl"}}