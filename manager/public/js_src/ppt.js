require([
  'base',
  'form-components',
  'bootstrap-datetimepicker',
  'bootstrap-datepicker'
], function() {
  $(function() {
    var $add = $('#mod_1200');
    var $add900 = $('#mod_900');

    $add.on('shown.bs.modal', function(e) {
      FormComponents.init();
      // 切换模板
      var tpl_type = $('input[name="class_type"]:checked');
      console.log('tpl_type: ' + tpl_type.val());
      show_tpl(tpl_type.val());

      $('input[name="class_type"]').change(function() {
        show_tpl($(this).val());
      });

      function show_tpl(tpl_id) {
        var $tpl1 = $('#tpl_1');
        var $tpl2 = $('#tpl_2');
        if (tpl_id == 1) {
          $tpl2.hide();
          $tpl1.show();
        } else {
          $tpl1.hide();
          $tpl2.show();
        }
      }
    });

    // var area_id = 0;

    function set_val(key, val) {
      console.log('key:' + key + ', val:' + val);
      $add.find(key).val(val);
    };

    function set_src(key, src) {
      console.log('key:' + key + ', src:' + src);
      $add.find(key).attr('src', src).show();
    };

    function set_html(key, html) {
      console.log('key:' + key + ', html:' + html);
      $add.find(key).html(html);
    };


    $add900.on('shown.bs.modal', function(e) {
      FormComponents.init();

      var area_id = $(this).find('input[name="area"]').val();
      var curriculum_id = $(this).find('input[name="curriculum_id"]').val();
      console.log('area_id: ' + area_id);
      console.log('curriculum_id: ' + curriculum_id);

      //  // 选择图片 
      var $btn_add_img = $(this).find('#btn_add_img');
      var img_id = 0;
      var img_url = '';
      //     $add900.delegate('#btn_add_img', 'click', function() {
      //         $('input[name="img_select"]').each(function(){
      //           if ($(this).is(':checked')) {
      //             img_id = $(this).val(); 
      //             img_url = $(this).data('img');
      //           }
      //         });
      //              // $('input[name="img_select":checked]');

      //         if (img_id > 0) {
      //           // $add.find('input[name="name"]').val(img_id);
      //           $add.find('#area_'+area_id).attr('src', img_url).show();
      //           //$add.find('#area_'+area_id+'_id').val(img_id);
      //                     console.log('img_id: ' + img_id);
      //                     $add.find('#area_'+area_id+'_id').val(img_id);

      //           $add900.modal('hide');
      //         } else {
      //           alert_only("请先选择图片");
      //         } 
      //     });

      $btn_add_img.live("click", function() {
        var area_id = $add900.find('input[name="area"]').val();
        console.log('area_id: ' + area_id);

        $('input[name="img_select"]').each(function() {
          if ($(this).is(':checked')) {
            img_id = $(this).val();
            img_url = $(this).data('img');
          }
        });
        // $('input[name="img_select":checked]');

        if (img_id > 0) {
          // $add.find('input[name="name"]').val(img_id);
          // $add.find('#area_'+area_id).attr('src', img_url).show();
          // $add.find('#area_'+area_id+'_id').val(img_id);
          set_src('#area_' + area_id, img_url);
          set_val('#area_' + area_id + '_id', img_id);

          // console.log('img_id: ' + img_id);
          // $add.find('#area_'+area_id+'_id').val(img_id);
          img_id = 0;
          img_url = "";
          $add900.modal('hide');
        } else {
          alert_only("请先选择图片");
        }
      });

      // 查找图片 
      var $btn_search_img = $(this).find('#btn_search_img');

      $btn_search_img.live('click', function() {
        var name = $add900.find('input[name="name"]').val();
        var page_size = $add900.find('select[name="page_size"]').val();

        var url = "/ppt/pic/?area=" + area_id + "&curriculum_id="+curriculum_id+"&name=" + name + "&page_size=" + page_size;
        $add900.find('.modal-content').load(url);
      });

      // 选择文字音频 
      var $btn_add_font = $(this).find('#btn_add_font');
      var font_id = 0;
      var font = "";
      var mp3 = "";
      $btn_add_font.live("click", function() {
        var area_id = $add900.find('input[name="area"]').val();
        console.log('area_id: ' + area_id);

        $('input[name="font_select"]').each(function() {
          if ($(this).is(':checked')) {
            font_id = $(this).val();
            font = $(this).data('font');
            mp3 = $(this).data('mp3');
          }
        });

        if (font_id > 0) {
          // $add.find('input[name="name"]').val(font_id);
          // $add.find('#area_'+area_id+'_font').html('文字: '+font);
          // $add.find('#area_'+area_id+'_mp3').html('音频: ' +mp3);
          //             console.log('font_id: '+ font_id);
          // $add.find('#area_'+area_id+'_id').val(font_id);
          set_html('#area_' + area_id + '_font', '文字: ' + font);
          set_html('#area_' + area_id + '_mp3', '音频: ' + mp3);
          set_val('#area_' + area_id + '_id', font_id);

          font_id = 0;
          $add900.modal('hide');
        } else {
          alert_only("请先选择文字音频");
        }
      });

      // 查找文字音频 
      var $btn_search_font = $(this).find('#btn_search_font');
      $btn_search_font.live('click', function() {
        var name = $add900.find('input[name="name"]').val();
        var page_size = $add900.find('select[name="page_size"]').val();

        var url = "/ppt/font/?area=" + area_id + "&curriculum_id="+curriculum_id+ "&name=" + name + "&page_size=" + page_size;
        $add900.find('.modal-content').load(url);
      });

      //翻页
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