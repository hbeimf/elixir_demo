require([
    'base'
    // 'echarts'
    // 'bootstrap-tree',
    // 'ui-tree'
],function(){
    // http://echarts.baidu.com/tutorial.html#5%20%E5%88%86%E9%92%9F%E4%B8%8A%E6%89%8B%20ECharts

    require(['echarts'], function(ec) {
            var $myChart = ec.init($('#main')[0]);



// function randomData() {
//     now = new Date(+now + oneDay);
//     value = value + Math.random() * 21 - 10;
//     return {
//         name: now.toString(),
//         value: [
//             [now.getFullYear(), now.getMonth() + 1, now.getDate()].join('/'),
//             Math.round(value)
//         ]
//     }
// }

// var data = [];
// var now = +new Date(1997, 9, 3);
// var oneDay = 24 * 3600 * 1000;
// var value = Math.random() * 1000;
// for (var i = 0; i < 1000; i++) {
//     data.push(randomData());
// }

// console.log(randomData());
	
	var code = $('input[name="code"]').val();
	$.get('/file/json/?code='+code, function(res) {
		// console.log(res);
		var reply = $.parseJSON(res);

		option = {
			    title: {
			         text: reply.name + ' + '+reply.code
			    },
			    tooltip: {
			        trigger: 'axis',
			        formatter: function (params) {
			            // params = params[0];
			            // return params.value[0] + ':' + params.value[1];

			            params = params[0];
		                            // return params.name + ':' + params.value[0] + ':' + params.value[1];
		                            return params.value[0] + ': [ ￥' + params.value[1] + ' ]';
			        },
			        //  formatter: function (params) {
			        //     params = params[0];
			        //     var date = new Date(params.name);
			        //     return date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear() + ' : ' + params.value[1];
			        // },
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

	});
	// var data = [
	// 	{name:"", value:["1998/1/10", 895]},
	// 	{name:"", value:["1998/1/11", 896]},
	// 	{name:"", value:["1998/1/12", 897]}
	// ];

        

     //    $myChart.setOption({
	    //     series: [{
	    //         data: data
	    //     }]
	    // });

    });

});





