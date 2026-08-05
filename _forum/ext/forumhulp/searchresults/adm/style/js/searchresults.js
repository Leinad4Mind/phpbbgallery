(function ($, document) {
	'use strict';

	$(function () {
		$('a.simpledialog').simpleDialog({
			opacity: 0.1,
			width: '650px',
			closeLabel: '&times;'
		});
	});

	document.addEventListener('click', function (event) {
		var action = event.target.closest('[data-mark-action]');
		var checkboxes;
		var checked;

		if (!action) {
			return;
		}

		event.preventDefault();
		checked = action.getAttribute('data-mark-action') === 'all';
		checkboxes = document.querySelectorAll('#acp_referrers input[name="mark[]"]');
		checkboxes.forEach(function (checkbox) {
			checkbox.checked = checked;
		});
	});
})(jQuery, document);
