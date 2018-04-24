require([
    'base'
    // 'echarts'
    // 'bootstrap-tree',
    // 'ui-tree'
],function(){
    // http://echarts.baidu.com/tutorial.html#5%20%E5%88%86%E9%92%9F%E4%B8%8A%E6%89%8B%20ECharts

    require(['echarts'], function(ec) {
            var $myChart = ec.init($('#main')[0]);
	var code = $('input[name="code"]').val();

	function draw(reply) {
		option = {
		    title: {
		         text: reply.name + ' + '+reply.code
		    },
		    tooltip: {
		        trigger: 'axis',
		        formatter: function (params) {
		            params = params[0];
	                            return params.value[0] + ': [ ￥' + params.value[1] + ' ]';
		        },
		        axisPointer: {
		            animation: false
		        }
		    },
		    xAxis: {
		        type: 'time',
		        splitLine: {
		            show: false
		        }
		    },
		    yAxis: {
		        type: 'value',
		        boundaryGap: [0, '100%'],
		        splitLine: {
		            show: false
		        }
		    },
		    series: [{
		        name: '模拟数据',
		        type: 'line',
		        showSymbol: false,
		        hoverAnimation: false,
		        data: reply.data
		    }]
		};
		// 使用刚指定的配置项和数据显示图表。
		$myChart.setOption(option);	
	}


	$.get('/file/json/?code='+code, function(res) {
		var reply = $.parseJSON(res);
		draw(reply);        
	});

	$('.btn_search').click(function(){
		console.log($(this).data('type'));
		var type = $(this).data('type');
		$.get('/file/json/?code='+code+'&type='+type, function(res) {
			var reply = $.parseJSON(res);
			draw(reply);        
		});
	})

    });

});






