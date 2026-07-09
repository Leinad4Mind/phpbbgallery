; (function ($, window, document) {

	$(".clickopen").click(function()
	{
		$("#comment").show("slow");
		$("#transfer").show("slow");
	});

	$(".clickclose").click(function()
	{
		$("#comment").hide("slow");
		$("#transfer").hide("slow");
	});

	$(".clickstatsopen").click(function()
	{
		$("#bar_stats").show("slow");
		$("#bbpoints_stats").show("slow");
	});

	$(".clickstatsclose").click(function()
	{
		$("#bar_stats").hide("slow");
		$("#bbpoints_stats").hide("slow");
		$('#radio_bar_stats').prop('checked', true);
		$('#radio_bbpoints_stats').prop('checked', true);
	});

	$('#group_id').on('change', function() {
		if (this.value > 0)
		{
			$(".comments").show("slow");
		} else 
		{
			$(".comments").hide("slow");
		}
	});

	$(document).on("click", "#sync_points", function (e) {
		e.preventDefault();
		$("#progressbar").show("slow");
		$('#progressbar').css('display', 'inline-block');
		$('#sync_points').prop('disabled', true);
	
		$.ajax({ type: "GET", 
		url: adminurl, 
		dataType: "json", 
		success: function (result) {
			if (result.percent)
			{
				 $("#progress").width(result.percent + '%');
				 $("#percent").text(result.percent + ' %');
				 $( "#progress" ).addClass( "done done-transition" );
					// if (result.percent > 48)
					// {
					//	 $("#percent").css('color', '#fff'); 
					//}
			}
			if (result.url)
			{
				adminurl = result.url;
				$('#sync_points').click(); 
			}else
			{
				$("#pbaranim").css('background', '#A1C969'); 	
			}
		   }
		});
	});

	$('#transfer_to').autocomplete({
		source: function(request, response) {
			
					$.ajax({
						type: "POST",
						url: boardurl + 'bbpoints/search_user',
						dataType: "json",
						data: {
							term: request.term
						},
						error: function(xhr, textStatus, errorThrown) {
							alert('Error: ' + xhr.responseText);
						},
						success: function(data) {
							response($.map(data, function(c) {
								return {
									value: c.value,
									label: c.label,
								};
							}));
						}
					});
				},
		select: function(event, ui) { 
			event.preventDefault(); 
			$(this).val(ui.item.label); 
			$("#transfer_id_to").val(ui.item.value);
			$(".comments").show("slow");
		},
		placeholder: 'Enter user ...',
		minLength: 2
	});

})(jQuery, window, document);
