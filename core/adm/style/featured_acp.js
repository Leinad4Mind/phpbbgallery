(function () {
	'use strict';

	document.addEventListener('DOMContentLoaded', function () {
		var location = document.getElementById('featured_location');
		var position = document.getElementById('featured_position');
		if (!location || !position) {
			return;
		}

		var row = position.closest('dl');
		if (!row) {
			return;
		}

		function updatePositionVisibility() {
			var hidden = location.value === '0';
			row.hidden = hidden;
			row.setAttribute('aria-hidden', hidden ? 'true' : 'false');
		}

		location.addEventListener('change', updatePositionVisibility);
		updatePositionVisibility();
	});
}());
