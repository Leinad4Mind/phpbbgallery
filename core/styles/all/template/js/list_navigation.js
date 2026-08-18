(function () {
	'use strict';

	if (!window.fetch || !window.DOMParser || !window.history || !window.history.pushState) {
		return;
	}

	var sectionSelector = '[data-gallery-list-section]';
	var activeRequest = null;

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

	function replaceSection(currentSection, nextSection) {
		var replacement = document.importNode(nextSection, true);
		currentSection.replaceWith(replacement);
		replacement.dispatchEvent(new window.CustomEvent('phpbbgallery:list-updated', {
			bubbles: true
		}));

		return replacement;
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
		section.setAttribute('aria-busy', 'true');

		return requestPage(url).then(function (nextDocument) {
			var nextSection = findSection(nextDocument, name);
			if (!nextSection) {
				throw new Error('Gallery list section is missing');
			}

			var replacement = replaceSection(section, nextSection);
			document.title = nextDocument.title || document.title;
			if (updateHistory) {
				window.history.pushState({phpbbgalleryList: true}, '', url.href);
			}

		}).catch(function (error) {
			if (error.name === 'AbortError') {
				return;
			}

			window.location.assign(url.href);
		});
	}

	function refreshVisibleSections() {
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
		}).catch(function (error) {
			if (error.name !== 'AbortError') {
				window.location.reload();
			}
		});
	}

	document.addEventListener('click', function (event) {
		if (event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) {
			return;
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

		event.preventDefault();
		navigateSection(section, url, true);
	});

	window.addEventListener('popstate', function () {
		if (document.querySelector(sectionSelector)) {
			refreshVisibleSections();
		}
	});
}());
