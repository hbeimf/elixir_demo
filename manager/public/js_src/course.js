require([
    'base',
    'form-components',
    'bootstrap-datetimepicker',
    'bootstrap-datepicker',
    'bootstrap-timepicker'
],function(){
    $(function () {

        $('#school_id').select2();

        var $add = $('#mod_1200');

        $add.on('shown.bs.modal', function (e) {
        	// 上传图片 
        	FormComponents.init();

            // 课程类型变化时，动态更新符合条件的老师，
            $('select[name="course_type"]') .change(function(){
                    // console.log('change');
                    var course_type = $(this).val();
                    var school_id = $('input[name="school_id"]').val();
                    var url = "/course/teachers/course_type/"+course_type+'/school_id/'+school_id;

                     $.get(url, function(data, status){
                            //$('select[name="city"]').html(data).select2();    
                            // console.log(data);
                            var obj = $.parseJSON(data);
                            $('select[name="teacher_id"]').html(obj.teachers).select2();    
  
                      });
              }); 


        	// console.log(jQuery().timepicker);

	// https://www.cnblogs.com/Raymon-Geng/p/5685053.html
	// $('.form_datetime_d').datetimepicker({
 //        		 format: 'yyyy-mm-dd',
	//         	autoclose: true,
	//               todayBtn: true,
	//               startView: 'year',
	// 	minView:'month',
	// 	maxView:'year',
	//               pickerPosition: (App.isRTL() ? "bottom-right" : "bottom-left")
 //               });  

           //     $(this).find('#school_id').select2();
           //     $(this).find('#course_type').select2();
        	  // $(this).find('#teacher_id').select2();
        	  
        });

    });
});


// file:///C:/Users/Administrator/Desktop/doc/ftpm_112_bwx/ftpm_112_bwx/form_component.html



