(function () {
	'use strict';

	var sectionSelector = '[data-gallery-list-section]';
	var activeRequest = null;
	var storageKey = 'phpbbgallery.listScrollPosition';
	var ajaxSupported = !!(
		window.fetch &&
		window.DOMParser &&
		window.AbortController &&
		window.history &&
		window.history.pushState
	);

	function escapeAttribute(value) {
		return String(value).replace(/\\/g, '\\\\').replace(/"/g, '\\"');
	}

	function findSection(documentRoot, name) {
		return documentRoot.querySelector(
			'[data-gallery-list-section="' + escapeAttribute(name) + '"]'
		);
	}

	function parsePage(markup) {
		return new window.DOMParser().parseFromString(markup, 'text/html');
	}

	function getScrollPosition() {
		return {
			x: window.pageXOffset || document.documentElement.scrollLeft || 0,
			y: window.pageYOffset || document.documentElement.scrollTop || 0
		};
	}

	function restoreScrollPosition(position) {
		if (!position) {
			return;
		}

		var restore = function () {
			window.scrollTo(position.x, position.y);
		};

		restore();
		if (window.requestAnimationFrame) {
			window.requestAnimationFrame(restore);
		}
	}

	function comparableUrl(url) {
		var comparable = new URL(url.href, window.location.href);
		comparable.hash = '';
		return comparable.href;
	}

	function rememberFullPageNavigation(url, position) {
		try {
			window.sessionStorage.setItem(storageKey, JSON.stringify({
				url: comparableUrl(url),
				x: position.x,
				y: position.y,
				created: Date.now()
			}));
		} catch (error) {
			// Storage can be unavailable in restricted browser modes; normal navigation remains usable.
		}
	}

	function restoreFullPageNavigation() {
		var stored;
		try {
			stored = JSON.parse(window.sessionStorage.getItem(storageKey) || 'null');
		} catch (error) {
			stored = null;
		}

		if (!stored) {
			return;
		}

		var expired = !stored.created || Date.now() - Number(stored.created) > 600000;
		if (expired || stored.url !== comparableUrl(new URL(window.location.href))) {
			try {
				window.sessionStorage.removeItem(storageKey);
			} catch (error) {
				// Ignore unavailable storage.
			}
			return;
		}

		try {
			window.sessionStorage.removeItem(storageKey);
		} catch (error) {
			// Ignore unavailable storage.
		}

		var position = {
			x: Number(stored.x) || 0,
			y: Number(stored.y) || 0
		};
		restoreScrollPosition(position);
		window.addEventListener('load', function () {
			restoreScrollPosition(position);
		}, {once: true});
	}

	function listHistoryState(position, currentState) {
		var state = {};
		if (currentState && typeof currentState === 'object') {
			Object.keys(currentState).forEach(function (key) {
				state[key] = currentState[key];
			});
		}

		state.phpbbgalleryList = true;
		state.phpbbgalleryScrollX = position.x;
		state.phpbbgalleryScrollY = position.y;
		return state;
	}

	function stateScrollPosition(state) {
		if (!state || !state.phpbbgalleryList) {
			return null;
		}

		return {
			x: Number(state.phpbbgalleryScrollX) || 0,
			y: Number(state.phpbbgalleryScrollY) || 0
		};
	}

	function replaceSection(currentSection, nextSection) {
		var replacement = document.importNode(nextSection, true);
		currentSection.replaceWith(replacement);
		initializeNativePageJumps(replacement);
		replacement.dispatchEvent(new window.CustomEvent('phpbbgallery:list-updated', {
			bubbles: true
		}));

		return replacement;
	}

	function initializeNativePageJumps(root) {
		if (!window.phpbb || typeof window.phpbb.registerDropdown !== 'function' || typeof window.$ !== 'function') {
			return;
		}

		Array.prototype.forEach.call(root.querySelectorAll('.gallery-page-jump .dropdown-trigger'), function (trigger) {
			var toggle = window.$(trigger);
			if (toggle.data('dropdown-options')) {
				return;
			}

			var dropdown = trigger.parentElement.querySelector('.dropdown');
			if (dropdown) {
				window.phpbb.registerDropdown(toggle, window.$(dropdown), {
					direction: 'auto',
					verticalDirection: 'auto'
				});
			}
		});
	}

	function requestPage(url) {
		if (activeRequest) {
			activeRequest.abort();
		}

		activeRequest = new window.AbortController();

		return window.fetch(url.href, {
			credentials: 'same-origin',
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			},
			signal: activeRequest.signal
		}).then(function (response) {
			if (!response.ok) {
				throw new Error('Gallery list request failed');
			}

			var contentType = response.headers.get('content-type') || '';
			if (contentType.indexOf('text/html') === -1) {
				throw new Error('Gallery list response was not HTML');
			}

			return response.text();
		}).then(parsePage);
	}

	function navigateSection(section, url, updateHistory) {
		var name = section.getAttribute('data-gallery-list-section');
		var scrollPosition = getScrollPosition();
		section.setAttribute('aria-busy', 'true');

		return requestPage(url).then(function (nextDocument) {
			var nextSection = findSection(nextDocument, name);
			if (!nextSection) {
				throw new Error('Gallery list section is missing');
			}

			var replacement = replaceSection(section, nextSection);
			document.title = nextDocument.title || document.title;
			if (updateHistory) {
				window.history.replaceState(listHistoryState(scrollPosition, window.history.state), '', window.location.href);
				window.history.pushState(listHistoryState(scrollPosition), '', url.href);
			}
			restoreScrollPosition(scrollPosition);

		}).catch(function (error) {
			if (error.name === 'AbortError') {
				return;
			}

			rememberFullPageNavigation(url, scrollPosition);
			window.location.assign(url.href);
		});
	}

	function refreshVisibleSections(scrollPosition) {
		var url = new URL(window.location.href);
		var currentSections = Array.prototype.slice.call(document.querySelectorAll(sectionSelector));
		currentSections.forEach(function (section) {
			section.setAttribute('aria-busy', 'true');
		});

		requestPage(url).then(function (nextDocument) {
			currentSections.forEach(function (section) {
				var name = section.getAttribute('data-gallery-list-section');
				var nextSection = findSection(nextDocument, name);
				if (nextSection) {
					replaceSection(section, nextSection);
				}
			});
			document.title = nextDocument.title || document.title;
			restoreScrollPosition(scrollPosition);
		}).catch(function (error) {
			if (error.name !== 'AbortError') {
				window.location.reload();
			}
		});
	}

	function closePageJumps(except) {
		Array.prototype.forEach.call(document.querySelectorAll('[data-gallery-page-jump-form]'), function (form) {
			if (form === except) {
				return;
			}

			var container = form.closest('.gallery-page-jump');
			var toggle = container ? container.querySelector('[data-gallery-page-jump-toggle]') : null;
			if (toggle) {
				form.hidden = true;
				toggle.setAttribute('aria-expanded', 'false');
			}
		});
	}

	function pageJumpUrl(form) {
		var input = form.querySelector('input[type=number]');
		var totalPages = Math.max(1, Number(input.max) || 1);
		var page = Math.min(totalPages, Math.max(1, Number(input.value) || 1));
		var replacement = page;

		input.value = page;
		if (form.getAttribute('data-page-mode') === 'offset') {
			replacement = (page - 1) * Math.max(1, Number(form.getAttribute('data-per-page')) || 1);
		}

		var template = form.getAttribute('data-url-template') || '';
		var token = form.getAttribute('data-url-token') || '';
		if (!template || !token || template.indexOf(token) === -1) {
			return null;
		}

		return new URL(template.replace(token, String(replacement)), window.location.href);
	}

	function followPagination(form, url) {
		var section = form.closest(sectionSelector);
		var scrollPosition = getScrollPosition();
		if (!section || section.getAttribute('data-gallery-ajax-navigation') !== '1' || !ajaxSupported) {
			rememberFullPageNavigation(url, scrollPosition);
			window.location.assign(url.href);
			return;
		}

		navigateSection(section, url, true);
	}

	document.addEventListener('click', function (event) {
		if (event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) {
			return;
		}

		var jumpToggle = event.target.closest('[data-gallery-page-jump-toggle]');
		if (jumpToggle) {
			event.preventDefault();
			var jumpForm = jumpToggle.parentElement.querySelector('[data-gallery-page-jump-form]');
			var open = jumpForm.hidden;
			closePageJumps(open ? jumpForm : null);
			jumpForm.hidden = !open;
			jumpToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
			if (open) {
				jumpForm.querySelector('input[type=number]').focus();
			}
			return;
		}

		if (event.target.closest('.gallery-page-jump .dropdown-trigger')) {
			return;
		}

		if (!event.target.closest('.gallery-page-jump')) {
			closePageJumps(null);
		}

		var link = event.target.closest('.gallery-paginated-list .pagination a[href]');
		if (!link || link.target || link.hasAttribute('download')) {
			return;
		}

		var section = link.closest(sectionSelector);
		if (!section) {
			return;
		}

		var url = new URL(link.href, window.location.href);
		if (url.origin !== window.location.origin) {
			return;
		}

		var ajaxEnabled = section.getAttribute('data-gallery-ajax-navigation') === '1';
		if (!ajaxEnabled || !ajaxSupported) {
			rememberFullPageNavigation(url, getScrollPosition());
			return;
		}

		event.preventDefault();
		navigateSection(section, url, true);
	});

	document.addEventListener('submit', function (event) {
		var form = event.target.closest('[data-gallery-page-jump-form]');
		if (!form) {
			return;
		}

		event.preventDefault();
		var url = pageJumpUrl(form);
		if (url && url.origin === window.location.origin) {
			closePageJumps(null);
			followPagination(form, url);
		}
	});

	window.addEventListener('popstate', function (event) {
		if (ajaxSupported && document.querySelector(sectionSelector)) {
			refreshVisibleSections(stateScrollPosition(event.state) || getScrollPosition());
		}
	});

	restoreFullPageNavigation();
}());
