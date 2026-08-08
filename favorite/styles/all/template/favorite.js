(function () {
	'use strict';

	function findToggle(element) {
		while (element && element !== document) {
			if (element.nodeType === 1 && element.hasAttribute('data-gallery-favorite-ajax')) {
				return element;
			}
			element = element.parentNode;
		}
		return null;
	}

	function setBusy(toggle, busy) {
		toggle.setAttribute('aria-busy', busy ? 'true' : 'false');
		toggle.setAttribute('aria-disabled', busy ? 'true' : 'false');
		toggle.classList.toggle('is-loading', busy);
	}

	function updateIcon(toggle, favorited) {
		var icon = toggle.querySelector('.gallery-favorite-icon, .icon');
		if (!icon) {
			return;
		}

		if (icon.classList.contains('fa-heart') || icon.classList.contains('fa-heart-o')) {
			icon.classList.toggle('fa-heart', favorited);
			icon.classList.toggle('fa-heart-o', !favorited);
			var action = toggle.parentNode;
			if (action && action.classList.contains('gallery-favorite-action')) {
				action.classList.toggle('is-favorited', favorited);
			}
			return;
		}

		icon.classList.toggle('fa-star', favorited);
		icon.classList.toggle('fa-star-o', !favorited);
	}

	function updateToggle(toggle) {
		var currentUrl = toggle.getAttribute('href');
		var nextUrl = toggle.getAttribute('data-toggle-url');
		var currentText = toggle.getAttribute('data-original-title')
			|| toggle.getAttribute('title')
			|| '';
		var nextText = toggle.getAttribute('data-toggle-text') || '';
		var favorited = toggle.getAttribute('data-favorited') !== '1';

		toggle.setAttribute('href', nextUrl);
		toggle.setAttribute('data-toggle-url', currentUrl);
		toggle.setAttribute('data-favorited', favorited ? '1' : '0');
		toggle.setAttribute('title', nextText);
		if (toggle.hasAttribute('data-original-title')) {
			toggle.setAttribute('data-original-title', nextText);
		}
		toggle.setAttribute('data-toggle-text', currentText);

		var accessibleText = toggle.querySelector('.sr-only');
		if (accessibleText) {
			accessibleText.textContent = nextText;
		}
		updateIcon(toggle, favorited);
	}

	function showError(payload) {
		var errorContainer = document.getElementById('darkenwrapper');
		var title = payload && payload.MESSAGE_TITLE
			? payload.MESSAGE_TITLE
			: (errorContainer ? errorContainer.getAttribute('data-ajax-error-title') : '');
		var message = payload && (payload.message || payload.MESSAGE_TEXT)
			? (payload.message || payload.MESSAGE_TEXT)
			: (errorContainer ? errorContainer.getAttribute('data-ajax-error-text') : '');

		if (window.phpbb && typeof window.phpbb.alert === 'function') {
			window.phpbb.alert(title, message);
			return;
		}
		if (message) {
			window.alert(message);
		}
	}

	function requestToggle(toggle) {
		var request = new XMLHttpRequest();
		var finished = false;

		function finish(success, payload) {
			if (finished) {
				return;
			}
			finished = true;
			if (success) {
				updateToggle(toggle);
			} else {
				showError(payload);
			}
			setBusy(toggle, false);
		}

		request.open('GET', toggle.getAttribute('href'), true);
		request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		request.setRequestHeader('Accept', 'application/json');
		request.withCredentials = true;

		request.onreadystatechange = function () {
			if (request.readyState !== 4) {
				return;
			}

			var payload = null;
			try {
				payload = JSON.parse(request.responseText);
			} catch (error) {
				payload = null;
			}

			finish(request.status >= 200 && request.status < 300 && payload && !payload.S_CONFIRM_ACTION, payload);
		};
		request.onerror = function () {
			finish(false, null);
		};
		request.send();
	}

	document.addEventListener('click', function (event) {
		var toggle = findToggle(event.target);
		if (!toggle) {
			return;
		}

		event.preventDefault();
		if (toggle.getAttribute('aria-busy') === 'true') {
			return;
		}
		setBusy(toggle, true);
		requestToggle(toggle);
	});
}());
