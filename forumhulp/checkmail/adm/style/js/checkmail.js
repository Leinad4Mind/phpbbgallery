; (function ($, window, document) {
	// do stuff here and use $, window and document safely
	// https://www.phpbb.com/community/viewtopic.php?p=13589106#p13589106
'use strict';

	var time = 59;
	function progress() {
		var element = $('#circle');
		element.prop('title', time + ' seconds until refresh');
		//element.html(time);
		if (time === 0) {
			clearInterval(interval);
			element.removeClass("fa-circle-o-notch");
			element.addClass("fa-refresh");
			$.ajax({
				url: window.location.href + "&table=true&t=" + time,
				context: document.getElementById("statistics_table"),
				error: function (e, text, ee) {
					element.css("display", "none");
					if (text == "timeout") {
						$("#LoadErrorTimeout").css("display", "inline-block");
						$("#LoadError").css("display", "block");
					} else {
						$("#LoadPageError").css("display", "inline-block");
						$("#LoadError").css("display", "block");
					}
				},
				success: function (s, x) {
					time = 59;
					element.removeClass("fa-refresh");
					element.addClass("fa-circle-o-notch");
					interval = setInterval(progress, 1000);
					$(this).html(s);
					bindShowClick();
				}
			});
		}
		time--;
	}
	if ($('#circle').length) {var interval = setInterval(progress, 1000);}

	$("a.simpledialog").simpleDialog({
		opacity: 0.1,
		width: '650px',
		closeLabel: '&times;'
	});

	bindShowClick();

	$(document).on("click", ".check_mail", function (e) {
		e.preventDefault();
		var val = $(this).data("options");
		var postid = getURLParameter(val, "u");
		var hack = new Date();
	
		$.ajax({ type: "POST", 
		url: val + '&time=' + String(hack.getTime()), 
		dataType: "json", 
		success: function (result) {
			$('#p' + postid).replaceWith(result);
			bindShowClick();
		  }
		});
	});
	
	function bindShowClick(){
		$('.show').on('mouseover', function () {
			  $(this).find('.msg').css('display', 'block');
		});
	
		$('.show').on('mouseout', function () {
			  $(this).find('.msg').css('display', 'none');
		});
	}
	
	function getURLParameter(url, name) {
		return (RegExp(name + "=" + "(.+?)(&|$)").exec(url)||[,null])[1];
	}
	
})(jQuery, window, document);

