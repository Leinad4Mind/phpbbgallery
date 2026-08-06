(function ($, document, navigator) {
	'use strict';

	function showCopied(text) {
		var message = document.getElementById('clipboardmsg');

		if (message) {
			message.textContent = text;
		}
	}

	function fallbackCopy(text) {
		var input = document.createElement('textarea');

		input.value = text;
		input.setAttribute('readonly', '');
		input.className = 'uploadimage-copy-helper';
		document.body.appendChild(input);
		input.select();
		document.execCommand('copy');
		input.remove();
		showCopied(text);
	}

	$(function () {
		$('a.simpledialog').simpleDialog({
			opacity: 0.1,
			width: '650px',
			closeLabel: '&times;'
		});
	});

	document.addEventListener('click', function (event) {
		var button = event.target.closest('[data-copy-target]');
		var target;
		var text;

		if (!button) {
			return;
		}

		target = document.getElementById(button.getAttribute('data-copy-target'));
		if (!target) {
			return;
		}

		text = target.textContent;
		if (navigator.clipboard && window.isSecureContext) {
			navigator.clipboard.writeText(text).then(function () {
				showCopied(text);
			}).catch(function () {
				fallbackCopy(text);
			});
			return;
		}

		fallbackCopy(text);
	});
})(jQuery, document, navigator);
