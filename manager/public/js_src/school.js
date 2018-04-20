require([
    'base',
    'form-components',
    'bootstrap-datetimepicker',
    'bootstrap-datepicker'
],function(){
    $(function () {
        var $add = $('#mod_1200');

        $add.on('shown.bs.modal', function (e) {
        	// 上传图片 
        	FormComponents.init();

	// https://www.cnblogs.com/Raymon-Geng/p/5685053.html
	$('.form_datetime_d').datetimepicker({
        		 format: 'yyyy-mm-dd',
	        	autoclose: true,
	              todayBtn: true,
	              startView: 'year',
		minView:'month',
		maxView:'year',
	              pickerPosition: (App.isRTL() ? "bottom-right" : "bottom-left")
               });  

                //地址级联操作

              $('select[name="province"]') .change(function(){
                    var provinceid = $(this).val();
                    var url = "/school/city/provinceid/"+provinceid;
                     $.get(url, function(data,status){
                            //$('select[name="city"]').html(data).select2();    
                            // console.log(data);
                            var obj = $.parseJSON(data);
                            $('select[name="city"]').html(obj.city).select2();    
                            $('select[name="area"]').html(obj.area).select2();    
                      });
              }); 

              $('select[name="city"]') .change(function(){
                    var cityid = $(this).val();
                    var url = "/school/area/cityid/"+cityid;
                    // console.log(url);
                     $.get(url, function(data,status){
                            // console.log(data);
                            $('select[name="area"]').html(data).select2();    
                     });
              }); 
        	  
        });

    });
});


// file:///C:/Users/Administrator/Desktop/doc/ftpm_112_bwx/ftpm_112_bwx/form_component.html



