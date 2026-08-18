(function () {
	'use strict';

	function bindBooleanDependency(form, controllerKey, dependentKey, visibleValue) {
		var controllers = form.elements['config[' + controllerKey + ']'];
		var dependent = form.elements['config[' + dependentKey + ']'];
		var row = dependent && dependent.closest('dl');

		if (!controllers || !row) {
			return;
		}

		function updateVisibility() {
			var selected = form.querySelector('input[name="config[' + controllerKey + ']"]:checked');
			row.hidden = !selected || selected.value !== visibleValue;
		}

		Array.prototype.forEach.call(controllers, function (field) {
			field.addEventListener('change', updateVisibility);
		});
		updateVisibility();
	}

	function initialize() {
		var form = document.getElementById('acp_board');

		if (!form) {
			return;
		}

		bindBooleanDependency(form, 'allow_hotlinking', 'hotlinking_domains', '0');
		bindBooleanDependency(form, 'allow_rates', 'max_rating', '1');
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initialize);
	} else {
		initialize();
	}
}());
