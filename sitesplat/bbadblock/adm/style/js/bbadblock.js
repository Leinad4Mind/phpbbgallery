phpbb.addAjaxCallback('close_notice', function(res) {
	if (res.success) {
		phpbb.toggleDisplay('bbadblock_notice', -1);
	}
});