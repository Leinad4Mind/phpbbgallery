(function () {
	'use strict';

	var validTargets = ['mark', 'unmark', 'delete'];

	function updateCheckbox(input, checked) {
		if (input.disabled) {
			return;
		}

		input.checked = checked;
		if (window.jQuery && window.jQuery.fn && typeof window.jQuery.fn.iCheck === 'function') {
			window.jQuery(input).iCheck(checked ? 'check' : 'uncheck');
		}
	}

	function updateTarget(form, target, checked) {
		if (validTargets.indexOf(target) === -1) {
			return;
		}

		var inputs = form.querySelectorAll('input[name="' + target + '[]"]');
		Array.prototype.forEach.call(inputs, function (input) {
			updateCheckbox(input, checked);
		});
	}

	document.addEventListener('click', function (event) {
		var control = event.target.closest('[data-notification-action]');
		if (!control) {
			return;
		}

		var form = control.closest('form');
		var target = control.getAttribute('data-notification-target');
		if (!form || validTargets.indexOf(target) === -1) {
			return;
		}

		event.preventDefault();
		var checked = control.getAttribute('data-notification-checked') === 'true';
		if (checked && control.getAttribute('data-notification-exclusive') === 'true') {
			validTargets.forEach(function (otherTarget) {
				if (otherTarget !== target) {
					updateTarget(form, otherTarget, false);
				}
			});
		}

		updateTarget(form, target, checked);
		var submit = form.querySelector('input[type="submit"][name="submit"]');
		var submitLabel = control.getAttribute('data-submit-label');
		if (submit && submitLabel) {
			submit.value = submitLabel;
		}
	});
}());
