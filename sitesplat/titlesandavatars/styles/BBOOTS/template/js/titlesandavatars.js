head.ready(function () {
(function($) { // Avoid conflicts with other libraries

"use strict";

$(document).on("click", ".open-AvatarsDialog", function () {
	var topicid = $(this).data('id');
	var hack = new Date();

	$.ajax({
		url: 'app.php/titlesandavatars/avatars.html?t=' + topicid + '&time=' + String(hack.getTime()),
		context: document.getElementById("profile-data"),
		error: function (e, text, ee) {
		},
		success: function (s, x) {
			$(".modal-body #profile-data").html( s );
		}
	});
});

$(document).on("click", ".AvatarsPagination", function (e) {
	e.preventDefault();
	
	var url = $(this).attr("href");
	var topicid = getURLParameter(url, "t");
	var start = getURLParameter(url, "start");
	var hack = new Date();

	$.ajax({
		url: 'app.php/titlesandavatars/avatars.html?t=' + topicid + '&start=' + start + '&time=' + String(hack.getTime()),
		context: document.getElementById("profile-data"),
		error: function (e, text, ee) {
		},
		success: function (s, x) {
			$(".modal-body #profile-data").html( s );
		}
	});
});

function getURLParameter(url, name) {
	return (RegExp(name + "=" + "(.+?)(&|$)").exec(url)||[,null])[1];
}

})(jQuery); // Avoid conflicts with other libraries
});