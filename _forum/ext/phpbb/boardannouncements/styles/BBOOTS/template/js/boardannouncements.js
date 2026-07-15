// Add an AJAX callback function
head.ready(function () {
phpbb.addAjaxCallback('close_announcement', function(res) {
	if (res.success) {
		phpbb.toggleDisplay('phpbb_announcement', -1);
	}
});
});