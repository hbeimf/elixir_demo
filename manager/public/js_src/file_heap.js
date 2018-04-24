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
	$.get('/file/headjson/?code='+code, function(res) {
		console.log(res);
		var reply = $.parseJSON(res);
		console.log(reply);
		option = {
			    title: {
			        text: reply.title_text,
			        subtext: reply.title_subtext
			    },
			    tooltip: {
			        trigger: 'axis',
			        axisPointer: {
			            type: 'shadow'
			        }
			    },
			    legend: {
			        // data: ['2011年', '2012年']
			        data: reply.legend_data

			    },
			    grid: {
			        left: '3%',
			        right: '4%',
			        bottom: '3%',
			        containLabel: true
			    },
			    xAxis: {
			        type: 'value',
			        boundaryGap: [0, 0.01]
			    },
			    yAxis: {
			        type: 'category',
			        data: reply.yAxis_data
			    },
			    series: [
			        // {
			        //     name: '2011年',
			        //     type: 'bar',
			        //     data: [18203, 23489, 29034, 104970, 131744, 630230]
			        // },
			        {
			            name: reply.series.name,
			            type: 'bar',
			            data: reply.series.data
			        }
			    ]
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






