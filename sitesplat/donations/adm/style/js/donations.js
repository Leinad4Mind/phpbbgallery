$(document).ready(function() {

'use strict';

	$('#btnAdd').click(function() {
		var num		= $('.clonedInput').length -1;
		var newNum	= num + 1;

		var newElem = $('#input' + num).clone().attr('id', 'input' + newNum);
		$('#input' + num).after(newElem);
		$('#input' + newNum + ' :input').each(function(){
			$(this).attr('name', $(this).attr('name').replace(/\d+/, newNum));
			$(this).val('');
		});

		// business rule: you can only add 10 donations
		if (newNum == 9)
		{
			$('#btnAdd').prop("disabled", true);
		}
	});

	$('#btnDel').click(function() {
		var num	= $('.clonedInput').length -1;
		$('#input' + num).remove();
		$('#btnAdd').prop("disabled", false);
		if (num -1 == 0)
		{
			$('#btnDel').attr('disabled','disabled');
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
			 $("#donationtotal").text(result.total);
			 (result.status == 'Completed') ? $("#status" + result.id).addClass('text-success') : $("#status" + result.id).removeClass('text-success');
		  }
		});
	});

});
