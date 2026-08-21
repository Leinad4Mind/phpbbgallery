(function () {
	'use strict';

	var selector = '[data-gallery-scrolling-title]';
	var resizeTimer = 0;

	function availableWidth(title) {
		var styles = window.getComputedStyle(title);
		var padding = parseFloat(styles.paddingLeft || 0) + parseFloat(styles.paddingRight || 0);

		return Math.max(0, title.clientWidth - padding);
	}

	function configureTitle(title) {
		var text = title.querySelector('.gallery-scrolling-title-text');
		var content;

		if (!text) {
			return;
		}

		title.classList.remove('is-overflowing');
		title.style.removeProperty('--gallery-title-overflow');
		title.style.removeProperty('--gallery-title-scroll-duration');

		content = text.querySelector('a') || text;
		var overflow = Math.ceil(Math.max(text.scrollWidth, content.scrollWidth) - availableWidth(title));

		if (overflow > 2) {
			title.classList.add('is-overflowing');
			title.style.setProperty('--gallery-title-overflow', overflow + 'px');
			title.style.setProperty('--gallery-title-scroll-duration', Math.max(4, Math.min(12, 2.5 + overflow / 35)) + 's');

			if (!title.querySelector('a, button, input, select, textarea') && !title.hasAttribute('tabindex')) {
				title.setAttribute('tabindex', '0');
				title.setAttribute('data-gallery-added-tabindex', 'true');
			}
		} else if (title.getAttribute('data-gallery-added-tabindex') === 'true') {
			title.removeAttribute('tabindex');
			title.removeAttribute('data-gallery-added-tabindex');
		}
	}

	function configureAll(root) {
		Array.prototype.forEach.call((root || document).querySelectorAll(selector), configureTitle);
	}

	function titleFromTarget(target) {
		return target && target.closest ? target.closest(selector) : null;
	}

	function initialise() {
		configureAll(document);

		document.addEventListener('mouseover', function (event) {
			var title = titleFromTarget(event.target);

			if (title) {
				configureTitle(title);
			}
		});

		document.addEventListener('focusin', function (event) {
			var title = titleFromTarget(event.target);

			if (title) {
				configureTitle(title);
			}
		});

		window.addEventListener('resize', function () {
			window.clearTimeout(resizeTimer);
			resizeTimer = window.setTimeout(function () {
				configureAll(document);
			}, 120);
		});
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initialise);
	} else {
		initialise();
	}
})();
