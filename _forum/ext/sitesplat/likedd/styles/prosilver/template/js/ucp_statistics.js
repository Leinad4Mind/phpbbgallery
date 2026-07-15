(function ($, window, document) {
	// do stuff here and use $, window and document safely
	// https://www.phpbb.com/community/viewtopic.php?p=13589106#p13589106
//	if (typeof stats !== 'undefined')
//	{
	$(function () {
		$('#chart').highcharts({
			chart: {
				plotBackgroundColor: null,
				backgroundColor:'rgba(255, 255, 255, 0.1)',
				plotBorderWidth: null,
				plotShadow: false,
				type: 'pie'
			},
			title: {
				text: ''
			},
			credits: {
				enabled: false,
				text: 'sitesplat.com',
				href: 'http://sitesplat.com'
			},
			tooltip: {
				pointFormat: '{series.name}: <b>{point.percentage:.2f}%</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: false,
						format: '<b>{point.name}</b>: {point.percentage:.2f} %',
						style: {
							color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
						}
					}
				}
			},
			series: [{
				name: "",
				colorByPoint: true,
				data: stats
			}]
		});
	});
//	}
})(jQuery, window, document);