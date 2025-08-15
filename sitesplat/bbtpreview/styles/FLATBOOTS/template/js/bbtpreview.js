head.ready(function () {
(function($) { // Avoid conflicts with other libraries

"use strict";

$(document).on("click", ".open-bbtpreview", function (event) {
 event.preventDefault();
	var topicid = $(this).data('id');
	var hack = new Date();
	var in_bbtag = $(location).attr("href").indexOf('bbtag');
	in_bbtag  = (in_bbtag > 0) ? '&b=1': '';

	$.ajax({
		url: sitesplat_board_url + 'app.php/bbtpreview/topic.html?t=' + topicid + in_bbtag + '&time=' + String(hack.getTime()),
		context: document.getElementById("BBTPreviewProfile"),
		error: function (e, text, ee) {
	//		console.log('error');
		},
		success: function (s, x) {
			$(".modal-header #modal-title").html( s.subject );
			$(".modal-header #starttime").html( s.starttime );
			$(".modal-subheader #author").html( s.author );
			$(".modal-subheader #author_rank").html( s.author_rank );
			$(".modal-body #BBTPreviewContent").html( s.message );
			$(".modal-footer #url").attr("href", s.url.replace(/\&amp;/g, '&'));
			$(".modal-body #messages").html( s.messages );
			$(".modal-body #views").html( s.views );
			$(".modal-body #attachments").html( s.attachments );
			$(".modal-body #topictime").html( s.topictime );
		}
	});
});

})(jQuery); // Avoid conflicts with other libraries
});