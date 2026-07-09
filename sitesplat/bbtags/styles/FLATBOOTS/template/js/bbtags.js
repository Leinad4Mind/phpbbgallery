head.ready(function () {
(function($) { // Avoid conflicts with other libraries

"use strict";

$(document).on("click", ".open-bbtagsdialog", function () {
	var hack = new Date();

	$.ajax({
		url: boardurl + 'bbtags/suggest',
		type: 'POST',
		data: "message=" + $("#message").val(),

		error: function (e, text, ee) {
		},
		success: function (s, x) {
		//	$("#bbtags").val( s );
		
			$('#bbtags').tagEditor('addTag', s, true);

		}
	});
});

$('#bbtags').tagEditor({ 
	initialTags: [],
	forceLowercase: true,
	placeholder: bbtagsLangPlaceholder,
	maxTags: maxTags,
	maxLength: 30,
	 autocomplete: {
          delay: 0, position: { collision: 'flip' },
            source: function(request, response) {
                $.ajax({
                    type: "POST",
                    url: boardurl + 'bbtags/auto_complete',
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
					  			value: c
                            }
                        }));
                    }
                });
            },
		}
});

})(jQuery); // Avoid conflicts with other libraries
});