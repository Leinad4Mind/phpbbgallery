(function () {
	'use strict';

	if (window.phpbbgalleryIpPrivacyLoaded) {
		return;
	}

	window.phpbbgalleryIpPrivacyLoaded = true;

	var storageKey = 'phpbbgallery.ipVisibility';
	var visibleClass = 'gallery-ip-visible';

	function storedVisibility() {
		try {
			return window.localStorage.getItem(storageKey) === 'visible';
		} catch (error) {
			return false;
		}
	}

	function storeVisibility(visible) {
		try {
			window.localStorage.setItem(storageKey, visible ? 'visible' : 'hidden');
		} catch (error) {
			// Storage can be unavailable in private or restricted browser contexts.
		}
	}

	function syncButtons(visible, root) {
		var scope = root && root.querySelectorAll ? root : document;
		Array.prototype.forEach.call(scope.querySelectorAll('[data-gallery-ip-toggle]'), function (button) {
			var label = button.getAttribute(visible ? 'data-gallery-ip-hide-label' : 'data-gallery-ip-show-label');
			button.setAttribute('aria-pressed', visible ? 'true' : 'false');
			button.setAttribute('aria-label', label);
			button.setAttribute('title', label);
		});
	}

	function applyVisibility(visible) {
		document.documentElement.classList.toggle(visibleClass, visible);
		syncButtons(visible, document);
	}

	applyVisibility(storedVisibility());

	document.addEventListener('click', function (event) {
		var button = event.target.closest('[data-gallery-ip-toggle]');
		if (!button) {
			return;
		}

		event.preventDefault();
		var visible = !document.documentElement.classList.contains(visibleClass);
		applyVisibility(visible);
		storeVisibility(visible);
	});

	document.addEventListener('phpbbgallery:imagechange', function (event) {
		var root = event.detail && event.detail.root ? event.detail.root : document;
		syncButtons(document.documentElement.classList.contains(visibleClass), root);
	});
}());
