(function () {
	'use strict';

	var previousFocus = null;

	function openDialog(button) {
		var dialog = document.getElementById(button.getAttribute('data-gallery-operation-help-open'));
		var close;

		if (!dialog) {
			return;
		}

		previousFocus = button;
		if (typeof dialog.showModal === 'function') {
			dialog.showModal();
		} else {
			dialog.setAttribute('open', 'open');
		}

		close = dialog.querySelector('[data-gallery-operation-help-close]');
		if (close) {
			close.focus();
		}
	}

	function closeDialog(dialog) {
		if (!dialog) {
			return;
		}

		if (typeof dialog.close === 'function') {
			dialog.close();
		} else {
			dialog.removeAttribute('open');
		}

		if (previousFocus) {
			previousFocus.focus();
		}
	}

	document.addEventListener('click', function (event) {
		var opener = event.target.closest('[data-gallery-operation-help-open]');
		var closer;

		if (opener) {
			openDialog(opener);
			return;
		}

		closer = event.target.closest('[data-gallery-operation-help-close]');
		if (closer) {
			closeDialog(closer.closest('dialog'));
			return;
		}

		if (event.target.matches('.gallery-operation-help-dialog')) {
			closeDialog(event.target);
		}
	});

	document.addEventListener('keydown', function (event) {
		var dialog;

		if (event.key !== 'Escape') {
			return;
		}

		dialog = document.querySelector('.gallery-operation-help-dialog[open]');
		if (dialog && typeof dialog.close !== 'function') {
			closeDialog(dialog);
		}
	});
}());
