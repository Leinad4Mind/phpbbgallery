; (function ($, window, document) {
	// do stuff here and use $, window and document safely
	// https://www.phpbb.com/community/viewtopic.php?p=13589106#p13589106
'use strict';

	$('input[type=checkbox]').tzCheckbox({labels:['Enable','Disable']});

	$("a.simpledialog").simpleDialog({
		opacity: 0.1,
		width: '650px',
		closeLabel: '&times;'
	});
	
    function update_users() {
        $.ajax({
            type: "GET",
            url: adminurl,
            dataType: "json",
            success: function (result) {
            if (result.percent)
			{
				 $("#progress").animate({width:result.percent + '%'}, 5000);
				 $("#percent").text(result.percent + ' %');
			}
			if (result.url)
			{
				adminurl = result.url;
				update_users();
			} else
			{
				$("#progress").animate({width:100 + '%'}, 2000);
				var explode = function(){
				  $("#pbaranim").css('background', '#A1C969'); 
				};
				setTimeout(explode, 1500);
			}			
            },
            error: function () {
                alert("fail");
            }
        });
    }
    $("#sync_users").click(function (e) {
        e.preventDefault();
		$("#progressbar").show("slow");
		$("#progress").animate({width:10 + '%'}, 5000);
		$('#progressbar').css('display', 'inline-block');
		$('#sync_users').prop('disabled', true);
		update_users();
    });

})(jQuery, window, document);
