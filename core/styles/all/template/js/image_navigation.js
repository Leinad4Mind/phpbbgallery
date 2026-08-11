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

	function activateAjaxControls(root) {
		if (!window.jQuery || !window.phpbb || typeof window.phpbb.ajaxify !== 'function') {
			return;
		}

		window.jQuery(root).find('[data-ajax]').each(function () {
			var control = window.jQuery(this);
			var callback = control.attr('data-ajax');
			var filter = control.attr('data-filter');
			if (callback === 'false') {
				return;
			}
			window.phpbb.ajaxify({
				selector: this,
				refresh: control.attr('data-refresh') !== undefined,
				filter: filter !== undefined && typeof window.phpbb.getFunctionByName === 'function' ? window.phpbb.getFunctionByName(filter) : null,
				callback: callback !== 'true' ? callback : null
			});
		});
	}

	function activateDropdownControls(root) {
		if (!window.jQuery || !window.phpbb || typeof window.phpbb.registerDropdown !== 'function') {
			return;
		}

		window.jQuery(root).find('.dropdown-container').each(function () {
			var container = window.jQuery(this);
			var trigger = container.find('.dropdown-trigger:first');
			var dropdown = container.find('.dropdown:first');
			var options = {
				direction: 'auto',
				verticalDirection: 'auto'
			};

			if (!trigger.length || !dropdown.length || trigger.data('dropdown-options')) {
				return;
			}
			if (container.hasClass('dropdown-up')) {
				options.verticalDirection = 'up';
			} else if (container.hasClass('dropdown-down')) {
				options.verticalDirection = 'down';
			}
			if (container.hasClass('dropdown-left')) {
				options.direction = 'left';
			} else if (container.hasClass('dropdown-right')) {
				options.direction = 'right';
			}

			window.phpbb.registerDropdown(trigger, dropdown, options);
		});
	}

	function reportEnhancementError(error) {
		if (window.console && typeof window.console.error === 'function') {
			window.console.error('Gallery image navigation enhancement failed', error);
		}
	}

	function revealRoot(root) {
		if (typeof window.requestAnimationFrame !== 'function') {
			return;
		}
		root.classList.add('is-entering');
		window.requestAnimationFrame(function () {
			window.requestAnimationFrame(function () {
				root.classList.remove('is-entering');
			});
		});
	}

	function replaceImagePage(url, pushHistory) {
		var currentRoot = getRoot();
		if (!isEnabled(currentRoot)) {
			window.location.assign(url);
			return;
		}

		var requestId = ++requestSequence;
		var pageReplaced = false;
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
			pageReplaced = true;
			if (parsedDocument.title) {
				document.title = parsedDocument.title;
			}
			if (pushHistory) {
				history.pushState({phpbbgalleryImageNavigation: true}, '', result.url);
			}
			window.scrollTo(0, scrollPosition);
			revealRoot(importedRoot);
			try {
				activateAjaxControls(importedRoot);
				activateDropdownControls(importedRoot);
				notifyChange(importedRoot, result.url);
			} catch (error) {
				reportEnhancementError(error);
			}
			activeRequest = null;
		}).catch(function (error) {
			if (requestId !== requestSequence || (error && error.name === 'AbortError')) {
				return;
			}
			var liveRoot = getRoot();
			if (liveRoot) {
				setLoading(liveRoot, false);
			}
			activeRequest = null;
			if (!pageReplaced) {
				window.location.assign(url);
			} else {
				reportEnhancementError(error);
			}
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
