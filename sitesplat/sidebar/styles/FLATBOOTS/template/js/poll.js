head.ready(function () {
; (function ($, window, document) {
	// do stuff here and use $, window and document safely
	// https://www.phpbb.com/community/viewtopic.php?p=13589106#p13589106
//	if (typeof stats !== 'undefined')
//	{
	$(function () {
		$('#pollchart').highcharts({
			chart: {
				plotBackgroundColor: null,
				backgroundColor:'rgba(255, 255, 255, 0.0)',
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
				href: 'https://sitesplat.com'
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
                    events: {
                        click: function () {
							$.ajax({ type: "POST", 
							url: sitesplat_board_url + "app.php/sidebar/poll.html", 
							data: {"f" : this.f,
									"t": this.t,
									"v": this.v},
							dataType: "json", 
							success: function (result) {
								if (result.data)
								{
									var pollchart = $('#pollchart').highcharts();
									pollchart.series[0].setData(result.data);
								}
								
								phpbb.alert(result.info, result.txt, true);
								phpbb.closeDarkenWrapper(3000);
							   }
							});
                        }
                    }
                },
					dataLabels: {
						enabled: false,
						format: '<b>{point.name}</b>: {point.percentage:.1f} %',
						style: {
							color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
						}
					}
				}
			},
			series: [{
				name: "votes:",
				colorByPoint: true,
				data: polstats
			}]
		});
	});
//	}
})(jQuery, window, document);
});