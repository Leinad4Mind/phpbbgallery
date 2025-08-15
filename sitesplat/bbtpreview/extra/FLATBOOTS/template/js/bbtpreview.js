head.ready(function () {
(function($) { // Avoid conflicts with other libraries

"use strict";

$(document).on("click", ".open-bbtpreview", function (event) {
 event.preventDefault();
	var topicid = $(this).data('id');
	var hack = new Date();

	$.ajax({
		url: boardurl + 'app.php/bbtpreview/topic.html?t=' + topicid + '&time=' + String(hack.getTime()),
		context: document.getElementById("profile-data"),
		error: function (e, text, ee) {
		},
		success: function (s, x) {
			$(".modal-header #modal-title").html( s.subject );
			$(".modal-header #starttime").html( s.starttime );
			$(".modal-header #author").html( s.author );
			$(".modal-header #author_rank").html( s.author_rank );
			$(".modal-body #profile-data").html( s.message );
			$(".modal-footer #url").attr("href", s.url);
			$(".modal-body #messages").html( s.messages );
			$(".modal-body #views").html( s.views );
			$(".modal-body #attachments").html( s.attachments );
			$(".modal-body #topictime").html( s.topictime );
		}
	});
});

})(jQuery); // Avoid conflicts with other libraries
});