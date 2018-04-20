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

            var $img = $(this).find("input[name='img']");
            var $name = $(this).find("input[name='name']");

           $img.on('change', function(e) {

           	var name = e.currentTarget.files[0].name;
           	var type = e.currentTarget.files[0].type;
           	// console.log(name);
           	// console.log(type);
           	var types = type.split('/');
           	// console.log(types);
           	// console.log(types[1]);


           	$name.val(name.replace('.'+types[1], ''));
           });   
        });

    });
});






