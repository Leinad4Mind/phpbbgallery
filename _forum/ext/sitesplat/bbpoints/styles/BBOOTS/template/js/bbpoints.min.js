head.ready(function () {
function enterUserLang() { 
	return enter_user_lang;
};
; (function ($, window, document) {

    $('#sendclick').click(function(event) {
		event.preventDefault();
		if ($('#transfer_to').val() > 0 && parseInt($('#amount').val()) > 4 && parseInt($('#amount').val()) <= parseInt(userpoints))
		{
			amount = parseInt(userpoints) - parseInt($('#amount').val());
			$('#userbbpoint').text(amount.toFixed(2));
		}
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
		},
		placeholder: enterUserLang,
		minLength: 2
	});
	
})(jQuery, window, document);
});