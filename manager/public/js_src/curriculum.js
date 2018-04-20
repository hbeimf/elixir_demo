require([
    'base',
    'form-components',
    'bootstrap-datetimepicker',
    'bootstrap-datepicker'
], function() {
    $(function() {	
    	// 增加课程 
    	var $btn_add_curriculum = $('#btn_add_curriculum');
    	$btn_add_curriculum.click(function(){
    		console.log('add');
    		$.get('/curriculum/add/', function(reply) {
    			console.log(reply);
    			var obj = $.parseJSON(reply);
    			if (obj.code == 200) {
    				alert_refresh(obj.msg);
    			} else {
                                            alert_only(obj.msg)
                                      }
    		});
    	});

    	// 模态框
        var $add1200 = $('#mod_1200');
        var $add900 = $('#mod_900');

        $add1200.on('shown.bs.modal', function(e) {
            FormComponents.init();
            // 切换资源
            var res_type = $('input[name="res_type"]:checked');
            // console.log('res_type: ' + res_type.val());
            show_tpl(res_type.val());
            init_ppt(res_type.val());

            $('input[name="res_type"]').change(function() {
                show_tpl($(this).val());
            });

            function show_tpl(tpl_id) {
                var $div_select_ppt = $('#div_select_ppt');
                var $div_select_music = $('#div_select_music');

                var $div_music_con = $add1200.find('#div_music_con');
                var $tpl_1 = $add1200.find('#tpl_1');
                var $tpl_2 = $add1200.find('#tpl_2');

                if (tpl_id == 1) {
                    $div_select_music.hide();
                    $div_music_con.hide();
                    $div_select_ppt.show();
                } else {
                    $div_select_ppt.hide();
                    $tpl_1.hide();
                    $tpl_2.hide();
                    $div_select_music.show();
                }
            }
        });

        function init_ppt(tpl_id) {
            // console.log(tpl_id);
            if (tpl_id == 1) {
                var ppt_id = $add1200.find('#input_ppt_id').val();
                if (ppt_id > 0) {
                    show_ppt(ppt_id);
                }
                
            } else if (tpl_id == 2) {
                var music_id = $add1200.find('#input_music_id').val();
                if (music_id > 0) {
                    show_music(music_id); 
                }
                
            }
        }

        // 展示被选择的ppt 
        function show_ppt(ppt_id) {

            $.get('/curriculum/pptInfo/?ppt_id='+ppt_id, function(reply){
                // console.log(reply);
                var obj = $.parseJSON(reply);
                if (obj.flg) {
                    var $step_name = $add1200.find("input[name='name']");
                    var $input_ppt_id = $add1200.find('#input_ppt_id');
                    $input_ppt_id.val(ppt_id);
                    $step_name.val(obj.step_name);

                    var $tpl_1 = $add1200.find('#tpl_1');
                    var $tpl_2 = $add1200.find('#tpl_2');
                    if (obj.class_type == 1) {
                        var $area_11_font = $add1200.find('#area_11_font');
                        var $area_11_img = $add1200.find('#area_11_img');
                        var $area_12_font = $add1200.find('#area_12_font');
                        var $area_12_mp3 = $add1200.find('#area_12_mp3');

                        $area_11_font.html(obj.area1.name);
                        $area_11_img.attr('src', obj.area1.img_dir);
                        $area_12_font.html('文字: ' + obj.area2.font);
                        $area_12_mp3.html('音频: ' + obj.area2.mp3);

                        $tpl_2.hide();
                        $tpl_1.show();

                    } else if (obj.class_type == 2) {
                        var $area_21_font = $add1200.find('#area_21_font');
                        var $area_21_mp3 = $add1200.find('#area_21_mp3');
                        var $area_22_font = $add1200.find('#area_22_font');
                        var $area_22_img = $add1200.find('#area_22_img');
                        var $area_23_font = $add1200.find('#area_23_font');
                        var $area_23_mp3 = $add1200.find('#area_23_mp3');
                        var $area_24_font = $add1200.find('#area_24_font');
                        var $area_24_mp3 = $add1200.find('#area_24_mp3');

                        $area_21_font.html('文字: ' + obj.area1.font);
                        $area_21_mp3.html('音频: ' + obj.area1.mp3);
                        $area_22_font.html(obj.area2.name);
                        $area_22_img.attr('src', obj.area2.img_dir);
                        $area_23_font.html('文字: ' + obj.area3.font);
                        $area_23_mp3.html('音频: ' + obj.area3.mp3);
                        $area_24_font.html('文字: ' + obj.area4.font);
                        $area_24_mp3.html('音频: ' + obj.area4.mp3);

                        $tpl_1.hide();
                        $tpl_2.show();
                    }
                } else {
                    alert_only("返回数据有误!!");
                }
            });
        }

        function show_music(music_id){
        	var $div_music_con = $add1200.find('#div_music_con');
            $.get('/curriculum/musicInfo/?music_id='+music_id, function(reply) {
                var obj = $.parseJSON(reply);
                if (obj.flg) {
                    var $step_name = $add1200.find("input[name='name']");
                    var $music_name = $add1200.find('#music_name');
                    var $music_png = $add1200.find('#music_png');
                    var $input_music_id = $add1200.find('#input_music_id');
                    $step_name.val(obj.step_name);
                    $input_music_id.val(music_id);
                    $music_name.html(obj.name);
                    $music_png.attr('src', obj.dir);
                    $div_music_con.show();
                } else {
                    alert_only("返回数据有误！");
                }
            });
        }


        $add900.on('shown.bs.modal', function(e) {
            FormComponents.init();

            var curriculum_id = $(this).find('input[name="curriculum_id"]').val();

            console.log(curriculum_id);

            // music ==========================================
            // 查找乐谱
            var $btn_search_music = $(this).find('#btn_search_music');
	$btn_search_music.live('click', function() {
	    var name = $add900.find('input[name="name"]').val();
	    var page_size = $add900.find('select[name="page_size"]').val();

	    var url = "/curriculum/music/?curriculum_id="+curriculum_id+"&name=" + name + "&page_size=" + page_size;
	    $add900.find('.modal-content').load(url);
	});

	// 确认 乐谱
            var $btn_add_music = $(this).find('#btn_add_music');
            $btn_add_music.live('click', function(){
            		var music_id = 0;
            		$('input[name="music_select"]').each(function() {
	                if ($(this).is(':checked')) {
	                  music_id = $(this).val();
	                }
	              });
            		if (music_id == 0 ) {
            			alert_only("请先选择乐谱");
            		} else {
            			show_music(music_id);
            			$add900.modal('hide');
            		}
            });



            // ppt ============================================
            // 确认 ppt 
            var $btn_add_ppt = $(this).find('#btn_add_ppt');
            $btn_add_ppt.live('click', function(){
            		var ppt_id = 0;
            		$('input[name="ppt_select"]').each(function() {
	                if ($(this).is(':checked')) {
	                  ppt_id = $(this).val();
	                }
	              });
            		if (ppt_id == 0 ) {
            			alert_only("请先选择PPT");
            		} else {
            			show_ppt(ppt_id);
            			$add900.modal('hide');
            		}
            });

            // 查找ppt 
            var $btn_search_ppt = $(this).find('#btn_search_ppt');
	$btn_search_ppt.live('click', function() {
	    var name = $add900.find('input[name="name"]').val();
	    var page_size = $add900.find('select[name="page_size"]').val();

	    var url = "/curriculum/ppt/?curriculum_id="+curriculum_id+"&name=" + name + "&page_size=" + page_size;
	    $add900.find('.modal-content').load(url);
	});

            // //翻页
            $(this).find('.page_modal').live("click", function() {
                var url = $(this).data('href');
                $add900.find('.modal-content').load(url);
            });

        });

        $add900.on("hidden.bs.modal", function() {
            // 解决隐藏modal后再次打开，重复注册事件bug
            $(this).unbind('shown.bs.modal');

            //缓存问题解决，跟bootstrap版本有关系　，
            $(this).removeData("bs.modal");
        });

    });
});