head.ready(function () {
$(document).on("click", ".clickme", function (e) {
	e.preventDefault();
	var val = $(this).data("options");
	$.ajax({ type: "POST", 
    url: "app.php/likedd/index.html", 
    data: $(this).data("options"), 
    dataType: "json", 
    success: function (result) {
		if (result.likes)
		{
			val = val.replace('=', '');
			 $("#" + val).text(result.likes);
		}
		phpbb.alert(result.info, result.txt, true);
        phpbb.closeDarkenWrapper(3000);
       }
    });
});

$(document).on("click", ".open-LikersDialog", function () {
	var postid = $(this).data('id');
	var hack = new Date();

	$.ajax({
		url: 'app.php/likedd/likers.html?p=' + postid + '&time=' + String(hack.getTime()),
		context: document.getElementById("profile-data"),
		error: function (e, text, ee) {
		},
		success: function (s, x) {
			$(".modal-body #profile-data").html( s );
		}
	});
});

$(document).on("click", ".LikersPagination", function (e) {
	e.preventDefault();
	
	var url = $(this).attr("href");
	var postid = getURLParameter(url, "p");
	var start = getURLParameter(url, "start");
	var hack = new Date();

	$.ajax({
		url: 'app.php/likedd/likers.html?p=' + postid + '&start=' + start + '&time=' + String(hack.getTime()),
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
});