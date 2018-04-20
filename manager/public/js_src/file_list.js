require([
    'base',
    'form-components',
     'bootstrap-datetimepicker',
    'bootstrap-datepicker'
],function(){
    $(function () {
        // =======================================
        // doc 
        // http://layer.layui.com/test/more.html
        // $('.window-layer').click(function(){
        //     var id = $(this).data('id');
        //     console.log(id);
        //     //多窗口模式，层叠置顶
        //     // var width = $(window).width();
        //     // console.log('width: '+ width);

        //     var handler =  layer.open({
        //       // type: 2 //此处以iframe举例
        //       type: 1 //此处以iframe举例

        //       ,title: '当你选择该窗体时，即会在最顶端'
        //       // ,area: ['390px', '330px']
        //       ,area: ['1200px', '530px']

        //       ,shade: 0.2
        //       // ,offset: [ //为了演示，随机坐标
        //       //   Math.random()*($(window).height()-300)
        //       //   ,Math.random()*($(window).width()-390)
        //       // ]
        //       ,offset: [ //为了演示，随机坐标
        //        100
        //         ,($(window).width() / 2) - 1200 / 2
        //       ]
              
        //       ,maxmin: true
        //       // ,content: '/curriculum/ppt/'
        //       ,content: '/pic/list'

        //       // ,btn: ['继续弹出', '全部关闭'] //只是为了演示
        //       ,btn: ['关闭'] //只是为了演示

        //       // ,yes: function(){
        //       //   $(that).click(); //此处只是为了演示，实际使用可以剔除
        //       // }
        //       ,btn2: function(){
        //         // layer.closeAll();
        //         layer.close(handler);

        //       }
              
        //       ,zIndex: layer.zIndex //重点1
        //       ,success: function(layero){
        //         layer.setTop(layero); //重点2
        //       }
        //     });
        // });

        // 缓存层对象 
        // // http://layer.layui.com/api.html#end
        // $('.window-iframe').click(function(){
        //         // layer.closeAll();
        //         var window_id = $(this).data('id');
        //         var window_title = $(this).data('title');
        //         var window_link = $(this).data('link');
        //         // var $that = $(this);

        //         var handler =  layer.open({
        //               id: window_id
        //               ,type: 2 //此处以iframe举例
        //               ,title: window_title
        //               ,area: ['1300px', '750px']
        //               ,shade: 0.5
        //               ,offset: [ //为了演示，随机坐标
        //                20 
        //                 ,($(window).width() / 2) - 1300 / 2 
        //               ]
        //               ,maxmin: true
        //               ,content: window_link
        //              ,btn: ['关闭'] //只是为了演示
        //               ,zIndex: layer.zIndex //重点1
        //               ,success: function(layero, index){
        //                 // console.log('ss: '+layero);
        //                 layer.setTop(layero); //重点2
        //                 // layer.full(index);
        //               }
        //               // ,end: function () {
        //               //       // console.log('cc');
        //               //       // 释放窗口句柄
        //               //       // $that.data('handler', '0');
        //               // }
        //               // ,restore: function(layero) {
        //               //   // console.log('restore: ' + layero);
        //               //   layer.setTop(layero); //重点2
        //               // }
        //         });
        //             // layer.full(handler);
        //             // layer.restore(handler);
        //             // console.log(handler);
            
        // });
        // =======================================
        var $add = $('#mod_1200');

        $add.on('shown.bs.modal', function (e) {
        	FormComponents.init();
            // console.log('fff');            
        });

    });
});






