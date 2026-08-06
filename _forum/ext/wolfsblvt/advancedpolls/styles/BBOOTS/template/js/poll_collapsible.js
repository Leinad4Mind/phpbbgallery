/**
 * Collapsible poll controls.
 *
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */
(function () {
	'use strict';

	function storageKey(button) {
		return 'advancedpolls.poll.collapsed.' + button.getAttribute('data-topic-id');
	}

	function storedCollapsed(button) {
		try {
			return window.localStorage.getItem(storageKey(button)) === '1';
		} catch (error) {
			return false;
		}
	}

	function storeCollapsed(button, collapsed) {
		try {
			window.localStorage.setItem(storageKey(button), collapsed ? '1' : '0');
		} catch (error) {
			// Poll collapsing still works when browser storage is unavailable.
		}
	}

	function targets(button) {
		var form = button.closest('.topic_poll');
		var result = [];
		var content;
		var panel;
		var heading;
		var extra;

		if (!form) {
			return result;
		}

		panel = button.closest('.panel-poll');
		if (panel) {
			heading = panel.querySelector('.panel-heading');
			if (heading) {
				Array.prototype.forEach.call(heading.children, function (child) {
					if (child.tagName.toLowerCase() !== 'h3') {
						result.push(child);
					}
				});
			}
			content = panel.querySelector('.panel-body');
			if (content) {
				result.push(content);
			}
			content = panel.querySelector('.panel-footer');
			if (content) {
				result.push(content);
			}
		} else {
			content = button.closest('.content');
			if (content) {
				Array.prototype.forEach.call(content.children, function (child) {
					if (!child.classList.contains('poll-title')) {
						result.push(child);
					}
				});
			}
		}

		extra = document.getElementById('ap-multi-poll');
		if (extra) {
			result.push(extra);
		}

		return result;
	}

	function applyState(button, collapsed, persist) {
		var title = button.getAttribute(collapsed ? 'data-expand-title' : 'data-collapse-title');
		var icon = button.querySelector('.fa');
		var text = button.querySelector('.sr-only');

		targets(button).forEach(function (target) {
			target.hidden = collapsed;
		});
		button.setAttribute('aria-expanded', collapsed ? 'false' : 'true');
		button.setAttribute('title', title);
		if (text) {
			text.textContent = title;
		}
		if (icon) {
			icon.classList.toggle('fa-minus-square', !collapsed);
			icon.classList.toggle('fa-plus-square', collapsed);
		}
		if (persist) {
			storeCollapsed(button, collapsed);
		}
	}

	function initialise() {
		Array.prototype.forEach.call(document.querySelectorAll('.ap-poll-collapse:not([data-ap-ready])'), function (button) {
			button.setAttribute('data-ap-ready', 'true');
			button.hidden = false;
			applyState(button, storedCollapsed(button), false);
			button.addEventListener('click', function () {
				applyState(button, button.getAttribute('aria-expanded') === 'true', true);
			});
		});
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initialise);
	} else {
		initialise();
	}

	if (window.jQuery) {
		window.jQuery(document).on('ajaxComplete', initialise);
	}
}());
