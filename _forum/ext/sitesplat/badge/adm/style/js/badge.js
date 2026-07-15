; (function ($, window, document) {
	// do stuff here and use $, window and document safely
	// https://www.phpbb.com/community/viewtopic.php?p=13589106#p13589106
	$( ".fa-refresh" ).click(function() {
		var circle = $(this);
		circle.addClass("fa-spin");
	});

	// blah to do for nifty modal
	// $("#load_home").on("click", function() {
    //    $(".md-content").load("{U_ACTION}&amp;action=details");
    //});
	

})(jQuery, window, document);

phpbb.addAjaxCallback('close_notice', function(res) {
	if (res.success) {
		phpbb.toggleDisplay('badgeaward_notice', -1);
	}
});
