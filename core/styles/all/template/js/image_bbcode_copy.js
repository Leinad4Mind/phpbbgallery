(function () {
	'use strict';

	function fallbackCopy(value) {
		var textarea = document.createElement('textarea');
		textarea.value = value;
		textarea.setAttribute('readonly', 'readonly');
		textarea.style.position = 'fixed';
		textarea.style.opacity = '0';
		document.body.appendChild(textarea);
		textarea.select();
		var copied = document.execCommand('copy');
		document.body.removeChild(textarea);

		return copied ? Promise.resolve() : Promise.reject(new Error('Copy failed'));
	}

	function copy(value) {
		if (navigator.clipboard && window.isSecureContext) {
			return navigator.clipboard.writeText(value).catch(function () {
				return fallbackCopy(value);
			});
		}

		return fallbackCopy(value);
	}

	function showCopied(button) {
		var icon = button.querySelector('.fa');
		var copiedLabel = button.getAttribute('data-copied-label');
		var originalLabel = button.getAttribute('data-copy-label');
		window.clearTimeout(button.galleryCopyTimer);
		button.classList.add('is-copied');
		button.setAttribute('aria-label', copiedLabel);
		button.setAttribute('title', copiedLabel);
		if (icon) {
			icon.classList.remove('fa-clipboard');
			icon.classList.add('fa-check');
		}
		button.galleryCopyTimer = window.setTimeout(function () {
			button.classList.remove('is-copied');
			button.setAttribute('aria-label', originalLabel);
			button.setAttribute('title', originalLabel);
			if (icon) {
				icon.classList.remove('fa-check');
				icon.classList.add('fa-clipboard');
			}
		}, 1800);
	}

	document.addEventListener('click', function (event) {
		var target = event.target;
		if (!target || typeof target.closest !== 'function') {
			return;
		}

		var button = target.closest('[data-gallery-copy-bbcode]');
		if (!button) {
			return;
		}

		event.preventDefault();
		copy(button.getAttribute('data-gallery-copy-bbcode')).then(function () {
			showCopied(button);
		}).catch(function () {
			button.focus();
		});
	});
}());
