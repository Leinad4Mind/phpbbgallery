; (function ($, window, document) {
	// do stuff here and use $, window and document safely
	// https://www.phpbb.com/community/viewtopic.php?p=13589106#p13589106


phpbb.addAjaxCallback('close_notice', function(res) {
	if (res.success) {
		phpbb.toggleDisplay('bbpoints_notice', -1);
	}
});

$(document).on("click", ".change_status", function (e) {
	e.preventDefault();
	var val = $(this).data("options");
	$.ajax({ type: "POST", 
    url: val, 
    dataType: "json", 
    success: function (result) {
		 $("#status" + result.id).text(result.status);
		  (result.status == 'Completed') ? $("#status" + result.id).addClass('label-success') : $("#status" + result.id).removeClass('label-success');
		  (result.status == 'Not verified') ? $("#status" + result.id).addClass('label-danger') : $("#status" + result.id).removeClass('label-danger');
      }
    });
});

$(document).on("click", "#sync_membership", function (e) {
	e.preventDefault();
	$("#progressbar").show("slow");
	$('#progressbar').css('display', 'inline-block');
	$('#sync_membership').prop('disabled', true);

	$.ajax({ type: "GET", 
    url: adminurl, 
    dataType: "json", 
    success: function (result) {
		if (result.percent)
		{
			 $("#progress").width(result.percent + '%');
			 $("#percent").text(result.percent + ' %');
		}
		if (result.url)
		{
			adminurl = result.url;
			$('#sync_membership').click(); 
		} else
		{
			$("#pbaranim").css('background', '#A1C969'); 	
		}
       }
    });
});

	$('#jump_to').autocomplete({
		source: function(request, response) {
			$.ajax({
				type: "POST",
				url: $("#jump_to").data("source"),
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
			window.location.href = window.location.href + '&user_id=' + ui.item.value;
		},
		placeholder: 'Enter user ...',
		minLength: 2
	});

})(jQuery, window, document);

