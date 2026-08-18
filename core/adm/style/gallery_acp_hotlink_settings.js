(function () {
	'use strict';

	function initialize() {
		var form = document.getElementById('acp_board');
		var allowFields = form && form.elements['config[allow_hotlinking]'];
		var whitelistField = form && form.elements['config[hotlinking_domains]'];
		var whitelistRow = whitelistField && whitelistField.closest('dl');

		if (!allowFields || !whitelistRow) {
			return;
		}

		function updateWhitelistVisibility() {
			var selected = form.querySelector('input[name="config[allow_hotlinking]"]:checked');
			whitelistRow.hidden = !!selected && selected.value === '1';
		}

		Array.prototype.forEach.call(allowFields, function (field) {
			field.addEventListener('change', updateWhitelistVisibility);
		});
		updateWhitelistVisibility();
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initialize);
	} else {
		initialize();
	}
}());
