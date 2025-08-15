head.ready(function () {
$(document).on("click", ".reward", function (e) {
	e.preventDefault();
	var val = $(this).data("options");
	$.ajax({ type: "POST", 
    url: "app.php/bbreaction/index.html", 
    data: $(this).data("options"), 
    dataType: "json", 
    success: function (result) {
		if (result.likes)
		{
			data = $.parseJSON(result.likes);
			$.each(data, function(i, item) {
				 $("#" + i).text(item);
			});
		}
		phpbb.alert(result.info, result.txt, true);
        phpbb.closeDarkenWrapper(3000);
       }
    });
});

$(document).on("click", ".open-ReactionDialog", function () {
	var postid = $(this).data('id');
	var hack = new Date();

	$.ajax({
		url: 'app.php/bbreaction/likers.html?p=' + postid + '&time=' + String(hack.getTime()),
		context: document.getElementById("bbreaction-profile-data"),
		error: function (e, text, ee) {
		},
		success: function (s, x) {
			$(".modal-body #bbreaction-profile-data").html( s );
		}
	});
});

$(document).on("click", ".ReactionPagination", function (e) {
	e.preventDefault();
	
	var url = $(this).attr("href");
	var postid = getURLParameter(url, "p");
	var start = getURLParameter(url, "start");
	var hack = new Date();

	$.ajax({
		url: 'app.php/bbreaction/likers.html?p=' + postid + '&start=' + start + '&time=' + String(hack.getTime()),
		context: document.getElementById("bbreaction-profile-data"),
		error: function (e, text, ee) {
		},
		success: function (s, x) {
			$(".modal-body #bbreaction-profile-data").html( s );
		}
	});
});

function getURLParameter(url, name) {
	return (RegExp(name + "=" + "(.+?)(&|$)").exec(url)||[,null])[1];
}


// toggle the active classes for the bbreaction panel and trigger icon
$('.com-expand-holder').click(function(e){
  e.preventDefault();
  $(this).parent().find(".com-contain, .com-expand-holder").toggleClass('active');
});

// toggle icon stuff
$('.star').click(function() {
 
 var star = $(this);

  if (star.hasClass("starred")) {
    star.removeClass("starred");
    star.addClass("unstarred");
  } else if (star.hasClass("unstarred")) {
    star.removeClass("unstarred");
    star.addClass("starred");
  } else {
    star.addClass("starred");
  }
  
});

});