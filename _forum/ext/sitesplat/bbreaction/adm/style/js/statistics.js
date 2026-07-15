; (function ($, window, document) {
	// do stuff here and use $, window and document safely
	// https://www.phpbb.com/community/viewtopic.php?p=13589106#p13589106
	if (typeof stats !== 'undefined')
	{
		$(function () {
			$('#chart').highcharts({
				chart: {
					type: 'column'
				},
				title: {
					text: ''
				},
				subtitle: {
					text: title
				},
				xAxis: {
					categories: dates,
					labels: {
						enabled: labelenabled
					}
				},
				yAxis: {
					min: 0,
					title: {
						text: ytitle
					}
				},
				credits: {
					enabled: false,
					text: 'sitesplat.com',
					href: '//sitesplat.com'
				},
				legend: {
					enabled: false,
				},
				tooltip: {
					headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
					pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
						'<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
					footerFormat: '</table>',
					shared: true,
					useHTML: true
				},
				plotOptions: {
					column: {
						pointPadding: 0.2,
						borderWidth: 0
					},
					series: {
	             }, 
				},
				series: stats,
				lang: {
				   forumKey: 'Forum overview',
				   topicKey: 'Topic overview',
				   messageKey: 'Messages overview',
				   userKey: 'User overview'
				},
				exporting: {
					buttons: {
						forumButton: {
							enabled: btnena,
							x: -40,
							onclick: function () {
    							$.ajax({
									url: window.location.href + "?t=0&table=true",
									type:'get',
									dataType: "json",
								
									success : function (s, x) {
										var chart = $('#chart').highcharts();
										
										chart.setTitle(null, { text: s.title[0].title });
										$('#table_title').text(s.title[0].descr + s.title[0].title);
										for (var i = 0; i < s.series[0].length; i++)
										{
											chart.series[i].setData(s.series[0][i].data, false);
										}
										chart.xAxis[0].setCategories(s.categories, true);
									}
								});
							},				
							symbol: 'circle',
							 _titleKey: "forumKey"
						},
						
						topicButton: {
							enabled: btnena,
							x: -65,
							onclick: function () {
								$.ajax({
									url: window.location.href + "?t=1&table=true",
									type:'get',
									dataType: "json",
								
									success : function (s, x) {
										var chart = $('#chart').highcharts();
										
										chart.setTitle(null, { text: s.title[0].title });
										$('#table_title').text(s.title[0].descr + s.title[0].title);
										for (var i = 0; i < s.series[0].length; i++)
										{
											chart.series[i].setData(s.series[0][i].data, false);
										}
										chart.xAxis[0].setCategories(s.categories, true);
									}
								});
							},
							symbol: 'circle',
							 _titleKey: "topicKey"
						},
					
						messageButton: {
							enabled: btnena,
							x: -90,
							onclick: function () {
								$.ajax({
									url: window.location.href + "?t=2&table=true",
									type:'get',
									dataType: "json",

									success : function (s, x) {
										var chart = $('#chart').highcharts();
										chart.setTitle(null, { text: s.title[0].title });
										$('#table_title').text(s.title[0].descr + s.title[0].title);
										
										for (var i = 0; i < s.series[0].length; i++)
										{
											chart.series[i].setData(s.series[0][i].data, false);
										}
										chart.xAxis[0].setCategories(s.categories, true);
									}
								});
							},
							symbol: 'circle',
							_titleKey: 'messageKey',
						},
						
						userButton: {
							enabled: btnena,
							x: -115,
							onclick: function () {
								$.ajax({
									url: window.location.href + "?t=3&table=true",
									type:'get',
									dataType: "json",

									success : function (s, x) {
										var chart = $('#chart').highcharts();
										chart.setTitle(null, { text: s.title[0].title });
										$('#table_title').text(s.title[0].descr + s.title[0].title);
										
										for (var i = 0; i < s.series[0].length; i++)
										{
											chart.series[i].setData(s.series[0][i].data, false);
										}
										chart.xAxis[0].setCategories(s.categories, true);
									}
								});
							},
							symbol: 'circle',
							_titleKey: 'userKey',
						}

					}
				}				
			});
		});	
	}
})(jQuery, window, document);
