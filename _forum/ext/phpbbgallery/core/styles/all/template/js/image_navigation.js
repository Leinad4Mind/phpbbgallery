(function () {
	'use strict';

	if (window.phpbbgalleryImageNavigationLoaded || !window.fetch || !window.DOMParser || !window.history || !window.history.pushState) {
		return;
	}

	var rootSelector = '[data-gallery-image-page]';
	var linkSelector = '[data-gallery-image-navigation]';
	var activeRequest = null;
	var requestSequence = 0;
	window.phpbbgalleryImageNavigationLoaded = true;

	function getRoot() {
		return document.querySelector(rootSelector);
	}

	function isEnabled(root) {
		return root && root.getAttribute('data-ajax-navigation') === '1';
	}

	function setLoading(root, loading) {
		var status = root.querySelector('.phpbbgallery-image-navigation-status');
		root.classList.toggle('is-loading', loading);
		root.setAttribute('aria-busy', loading ? 'true' : 'false');
		if (status) {
			status.textContent = loading ? root.getAttribute('data-loading-label') || '' : '';
		}
	}

	function notifyChange(root, url) {
		var event;
		try {
			event = new CustomEvent('phpbbgallery:imagechange', {detail: {root: root, url: url}});
		} catch (error) {
			event = document.createEvent('CustomEvent');
			event.initCustomEvent('phpbbgallery:imagechange', false, false, {root: root, url: url});
		}
		document.dispatchEvent(event);
	}

	function replaceImagePage(url, pushHistory) {
		var currentRoot = getRoot();
		if (!isEnabled(currentRoot)) {
			window.location.assign(url);
			return;
		}

		var requestId = ++requestSequence;
		if (activeRequest && activeRequest.abort) {
			activeRequest.abort();
		}
		activeRequest = window.AbortController ? new AbortController() : null;
		setLoading(currentRoot, true);

		fetch(url, {
			credentials: 'same-origin',
			headers: {'X-Requested-With': 'XMLHttpRequest'},
			signal: activeRequest ? activeRequest.signal : undefined
		}).then(function (response) {
			if (!response.ok) {
				throw new Error('Unexpected HTTP status ' + response.status);
			}
			return response.text().then(function (html) {
				return {html: html, url: response.url || url};
			});
		}).then(function (result) {
			if (requestId !== requestSequence) {
				return;
			}
			var parsedDocument = new DOMParser().parseFromString(result.html, 'text/html');
			var nextRoot = parsedDocument.querySelector(rootSelector);
			var liveRoot = getRoot();
			if (!nextRoot || !liveRoot || !isEnabled(nextRoot)) {
				throw new Error('Gallery image page was not returned');
			}

			var scrollPosition = window.pageYOffset;
			var importedRoot = document.importNode(nextRoot, true);
			liveRoot.parentNode.replaceChild(importedRoot, liveRoot);
			if (parsedDocument.title) {
				document.title = parsedDocument.title;
			}
			if (pushHistory) {
				history.pushState({phpbbgalleryImageNavigation: true}, '', result.url);
			}
			window.scrollTo(0, scrollPosition);
			notifyChange(importedRoot, result.url);
			activeRequest = null;
		}).catch(function (error) {
			if (requestId !== requestSequence || (error && error.name === 'AbortError')) {
				return;
			}
			var liveRoot = getRoot();
			if (liveRoot) {
				setLoading(liveRoot, false);
			}
			window.location.assign(url);
		});
	}

	function findNavigationLink(target) {
		while (target && target !== document) {
			if (target.matches && target.matches(linkSelector)) {
				return target;
			}
			target = target.parentNode;
		}
		return null;
	}

	document.addEventListener('click', function (event) {
		var link = findNavigationLink(event.target);
		var root = getRoot();
		if (!link || !isEnabled(root) || event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey || link.target) {
			return;
		}
		var targetUrl = new URL(link.href, window.location.href);
		if (targetUrl.origin !== window.location.origin) {
			return;
		}
		event.preventDefault();
		replaceImagePage(targetUrl.href, true);
	});

	document.addEventListener('keydown', function (event) {
		var target = event.target;
		if (event.defaultPrevented || event.metaKey || event.ctrlKey || event.altKey || event.shiftKey || (target && (target.isContentEditable || /^(INPUT|SELECT|TEXTAREA)$/.test(target.tagName)))) {
			return;
		}
		var direction = event.key === 'ArrowLeft' ? 'previous' : (event.key === 'ArrowRight' ? 'next' : '');
		var root = getRoot();
		var link = direction && isEnabled(root) ? root.querySelector('[data-gallery-image-navigation="' + direction + '"]') : null;
		if (link) {
			event.preventDefault();
			replaceImagePage(link.href, true);
		}
	});

	window.addEventListener('popstate', function (event) {
		if (event.state && event.state.phpbbgalleryImageNavigation) {
			replaceImagePage(window.location.href, false);
		}
	});

	if (isEnabled(getRoot())) {
		var currentState = history.state || {};
		currentState.phpbbgalleryImageNavigation = true;
		history.replaceState(currentState, '', window.location.href);
	}
}());
