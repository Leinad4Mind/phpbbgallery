; (function ($, window, document) {
	// do stuff here and use $, window and document safely
	// https://www.phpbb.com/community/viewtopic.php?p=13589106#p13589106

	$('.compose').click(function() {
		if (this.value > 0)
		{
			$("#mailrows").hide("fast");
			$("#compose_man").show("slow");
			$("#submit").val("Send Newsletter");
		} else 
		{
			$("#mailrows").show("fast");
			$("#compose_man").hide("slow");
			$("#submit").val('Save');
		}
	});

	$('#viewsubscribers').click(function() {
		$("#compose_man").hide("fast");
		$('#compose').prop('checked', true);
		$("#mailrows").hide("fast");
		$("#newsrow").toggle("slow");
		$("#userrow").toggle("slow");
		if ($("#legend").text() === 'Subscribers')
		{
			$("#legend").text('Last newsletters');
			$("#viewsubscribers").prop('title', 'View subscribers');
		} else
		{
			$("#legend").text('Subscribers');
			$("#viewsubscribers").prop('title', 'View newsletters');
		}
		$("#mailrows").show("slow");
	});
	
	
})(jQuery, window, document);
