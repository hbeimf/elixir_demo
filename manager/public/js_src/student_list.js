require([
    'base',
    'form-components',
     'bootstrap-datetimepicker',
    'bootstrap-datepicker'
],function(){
    $(function () {
        var $add = $('#mod_1200');

        $add.on('shown.bs.modal', function (e) {
        	FormComponents.init();
            // console.log('fff');       
		$(this).find('#school_id').change(function(){
			// console.log($(this).val());
                                       var school_id = $(this).val();
                                       if (school_id > 0) {
                                                var url = "/student/classes/school_id/"+school_id;
                                                $.get(url, function(data,status){
                                                    $('select[name="class_id"]').html(data).select2();    
                                                });
                                       }
		});      
        });

    });
});






