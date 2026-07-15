head.ready(function () {
	'use strict';
	jQuery(function($) {
		$('#email').multiple_emails({
			position: 'top',
			separator: ' ',
			checkDupEmail: true
		});
	});
});
