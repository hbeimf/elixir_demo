
// //全局配置
require.config({
    // baseUrl:'/js_src',
    map: {
        '*': {
            'css': '/js/css'
        }
    },
    paths:{
        'jquery':'/js/jquery-1.10.1.min',
        'jquery-migrate':'/js/jquery-migrate-1.2.1.min',
        'jquery-ui':'/js/jquery-ui-1.10.1.custom.min',
        // 'bootstrap':'/js/bootstrap.min',
        'bootstrap':'/js/bootstrap.3.3.7',

        'jquery.slimscroll':'/js/jquery.slimscroll.min',
        'jquery.blockui':'/js/jquery.blockui.min',
        'jquery.cookie':'/js/jquery.cookie.min',
        'jquery.uniform':'/js/jquery.uniform.min',
        'select2':'/js/select2.min',
        'jquery.dataTables':'/js/jquery.dataTables',
        'DT_bootstrap':'/js/DT_bootstrap',
        'app':'/js/app',
        'table-managed':'/js/table-managed',
        'jquery.form':'/js/jquery.form',
        'bootstrap-tree': '/js/bootstrap-tree',
        'ui-tree': '/js/ui-tree',
        'functions' : '/js_src/functions',
        'base': '/js_src/base',
        'form-samples':'/js/form-samples',
        'protobuf':'/js/protobuf.min',
        'moment':'/js/moment',
        'long':'/js/long',
        'base64':'/js/base64',
        'socket.io':'/js/socket.io',
        // 'echarts':'/js/echarts.min'
        'echarts':'/js/echarts',
        'ztree': '/js/ztree/js/jquery.ztree.all',
        'form-components': '/js/form-components',
        'bootstrap-fileupload':'/js/bootstrap-fileupload',
        'bootstrap-datetimepicker':'/js/bootstrap-datetimepicker',
        'bootstrap-datepicker':'/js/bootstrap-datepicker',
        'bootstrap-timepicker': '/js/bootstrap-timepicker',
        'layer':'/js/layer/layer'
    },
    shim: {
        // jQuery
        'jquery-migrate': ['jquery'],
        'jquery.slimscroll': ['jquery'],
        'jquery.uniform': ['jquery'],
        'jquery-ui': ['jquery'],
        'jquery.form': ['jquery'],
        'bootstrap': ['jquery'],
        'select2': ['jquery', 'bootstrap'],
        'DT_bootstrap': ['jquery', 'bootstrap', 'jquery.dataTables'],
        'bootstrap-tree': ['jquery', 'bootstrap'],
        'ui-tree': ['jquery', 'bootstrap'],
        'layer': ['jquery'],
        'base': ['jquery', 'jquery-migrate', 'jquery-ui', 'bootstrap', 'jquery.slimscroll', 'jquery.blockui',
                    'jquery.cookie', 'jquery.uniform', 'select2', 'jquery.dataTables', 'DT_bootstrap', 'layer',
                    'app', 'table-managed', 'jquery.form', 'functions'],
        'functions':['app', 'jquery'],
        'form-samples':['jquery', 'bootstrap'],
        'protobuf':['jquery', 'long'],
        'socket.io':['jquery'],
        'echarts':['jquery'],
        'ztree': [
            'jquery',
            // 'css!/js/ztree/css/zTreeStyle/zTreeStyle.css'
        ],
        'form-components': ['jquery', 'bootstrap-fileupload'],
        // 'form-components': ['jquery'],
        'bootstrap-fileupload':['jquery'],

        'bootstrap-datetimepicker':['jquery'],
        'bootstrap-datepicker':['jquery'],
        'bootstrap-timepicker':['jquery']
    },
    waitSeconds: 100 // ie load modules timeout bug fixed
});



