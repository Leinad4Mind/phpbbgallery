$(document).ready(function() {

'use strict';

    $("#datepicker").datepicker({minDate: 2});

    $("#alternate").click(function() {
    	$("#datepicker").focus();
	});

    $("#datepicker").change(function() {
		var title = $("#alternate").data('title');
        $("#alternate").html(title + ': ' + $("#datepicker").val());
		$("#future_chk").prop('checked', true);
       });
});
