//动态异步加载js

require([

],function(){

    $(function () {
        App.init();

        var $confirm = $('#myModal3');
        var $ajax_delete = $('.ajax-delete');
        var $alert_refresh = $('#myModal22');

        // 提示信息modal关闭后reload 当前页面
        $alert_refresh.on("hidden.bs.modal",function(){
            window.location.reload();
        });

        $ajax_delete.click(function(){
            var link = $(this).data('link');
            var msg = ($(this).data('msg') == undefined) ? '确认要删除吗?': $(this).data('msg');
            // console.log(msg);
            // if (msg == undefined) {
            //     msg = '确认要删除吗?';
            // }
            var $obj_modal = $('#myModal2');
            $confirm.find('p').html(msg);
            $confirm.modal({backdrop:false, keyboard:false});

            $confirm.find('#btn_sure').click(function(){
                // console.log(link);
                //删除数据
                $.get(link, function(reply_json){
                    // console.log(reply_json);
                    var reply = $.parseJSON(reply_json);
                    if (reply.code == 200) {
                        alert_refresh(reply.msg);
                    } else {
                        alert_only(reply.msg)
                    }
                });

            });

            $confirm.on("hidden.bs.modal",function(){
                //防止执行两次
                $(this).find('#btn_sure').unbind('click');
            });
        });

        var mod_array = [$('#mod_800'), $('#mod_900'), $('#mod_1000'), $('#mod_1100'), $('#mod_1200')];

        for (var i = 0; i < mod_array.length; i++) {
            mod_array[i].on("shown.bs.modal",function(){
                var $current_modal = $(this);
                $current_modal.find('.select2').select2();

                $current_modal.find('#btn_add').click(function () {
                    var $form = $current_modal.find('.ajax_form');
                    var action = $form.prop('action');

                    console.log(action);

                    var loading;
                    $form.ajaxSubmit({
                        url: action,
                        type: "post",
                        beforeSubmit: function(formData, jqForm, options){
                            console.log('xxyy');
                            //放一朵菊花 
                            loading = layer.load();
                        },
                        success: function (reply_json) {
                            layer.close(loading);
                            console.log(reply_json);
                            var reply = $.parseJSON(reply_json);
                            if (reply.code == 200) {
                                alert_refresh(reply.msg);
                            } else {
                                alert_only(reply.msg)
                            }
                        }
                    });

                });

                // 模态框内删除功能
                $current_modal.find('#btn_delete').click(function () {
                    var link = $(this).data('link');
                    var msg = ($(this).data('msg') == undefined) ? '确认要删除吗?': $(this).data('msg');
                    // console.log(msg);
                    // if (msg == undefined) {
                    //     msg = '确认要删除吗?';
                    // }
                    var $obj_modal = $('#myModal2');
                    $confirm.find('p').html(msg);
                    $confirm.modal({backdrop:false, keyboard:false});

                    $confirm.find('#btn_sure').click(function(){
                        // console.log(link);
                        //删除数据
                        $.get(link, function(reply_json){
                            // console.log(reply_json);
                            var reply = $.parseJSON(reply_json);
                            if (reply.code == 200) {
                                alert_refresh(reply.msg);
                            } else {
                                alert_only(reply.msg)
                            }
                        });

                    });

                    $confirm.on("hidden.bs.modal",function(){
                        //防止执行两次
                        $(this).find('#btn_sure').unbind('click');
                    });
                });

            });


            mod_array[i].on("hidden.bs.modal",function(){
                // 解决隐藏modal后再次打开，重复注册事件bug
                //$(this).unbind('shown.bs.modal');

                //缓存问题解决，跟bootstrap版本有关系　，
                $(this).removeData("bs.modal");
            });

        };

        // http://layer.layui.com/api.html#end
        $('.window-iframe').click(function(){
                var window_id = $(this).data('id');
                var window_title = $(this).data('title');
                var window_link = $(this).data('link');
                var handler =  layer.open({
                      id: window_id
                      ,type: 2 //此处以iframe举例
                      ,title: window_title
                      ,area: ['1300px', '750px']
                      ,shade: 0.5
                      ,offset: [ //为了演示，随机坐标
                       20 
                        ,($(window).width() / 2) - 1300 / 2 
                      ]
                      ,maxmin: true
                      ,content: window_link
                     ,btn: ['关闭'] //只是为了演示
                      ,zIndex: layer.zIndex //重点1
                      ,success: function(layero, index){
                        layer.setTop(layero); //重点2
                      }
                });  
        });

    });
});






