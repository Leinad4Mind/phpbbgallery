head.ready(function () {
; (function ($, window, document) {
	// do stuff here and use $, window and document safely
	// https://www.phpbb.com/community/viewtopic.php?p=13589106#p13589106
//	if (typeof stats !== 'undefined')
//	{
	$(function () {
		$('#membershipchart').highcharts({
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
				text: 'goldtuganime.com',
				href: 'https://goldtuganime.com'
			},
			exporting: { enabled: false },
			tooltip: {
				pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: false,
					cursor: 'pointer',
					 point: {
                },
					dataLabels: {
						enabled: false,
						inside: true,
						format: '{point.name}',
						style: {
							color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
						}
					}
				}
			},
			series: [{
				name: "Memberships:",
				colorByPoint: true,
				data: memberstats
			}]
		});
	});
//	}
})(jQuery, window, document);
});