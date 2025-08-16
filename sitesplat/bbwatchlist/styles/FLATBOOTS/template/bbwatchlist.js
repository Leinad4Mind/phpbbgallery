head.ready(function() {
	'use strict';

	phpbb.addAjaxCallback('remove_keyword', function() {
		$(this).parent().parent().remove();

		// Reload page if there is no keyword left. It will display nice
		// information about it.
		if ($('#bbwatchlist_keywords tr').length < 2)
		{
			window.location.reload();
		}
	});

	phpbb.addAjaxCallback('add_keyword', function(res) {
		if (res.success) {
			$('<tr id="k' + res.ID + '"></tr>')
				.append('<td>' + $('[name="keyword"]').val() + '</td>')
				.append('<td>' + $('[name="search_type"]:checked').parent().next().html() + '</td>')
				.append('<td><a id="kd' + res.ID + '" href="' + res.U_DELETE + '"><i class="fa fa-trash"></i></a></td>')
				.appendTo('#bbwatchlist_keywords');

			phpbb.ajaxify({
				selector: '#kd' + res.ID,
				refresh: false,
				callback: 'remove_keyword'
			});
		}
	});
});
