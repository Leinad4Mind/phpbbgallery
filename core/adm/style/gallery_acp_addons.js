(function () {
	'use strict';

	var storageKey = 'phpbbgallery.acp.addonSettingsView';
	var obsoleteSourceStorageKey = 'phpbbgallery.acp.addonSettingsSources';
	var legacyLegendStorageKey = 'phpbbgallery.acp.addonSettingsLegend';
	var simpleMode = 'simple';
	var completeMode = 'complete';
	var hiddenMode = 'hidden';

	function readMode() {
		var storedMode;

		try {
			window.localStorage.removeItem(obsoleteSourceStorageKey);
			if (window.localStorage.getItem(legacyLegendStorageKey) === 'hidden') {
				window.localStorage.removeItem(legacyLegendStorageKey);
				window.localStorage.setItem(storageKey, hiddenMode);
				return hiddenMode;
			}
			window.localStorage.removeItem(legacyLegendStorageKey);
			storedMode = window.localStorage.getItem(storageKey);
			return storedMode === simpleMode || storedMode === hiddenMode ? storedMode : completeMode;
		} catch (error) {
			return completeMode;
		}
	}

	function storeMode(mode) {
		try {
			window.localStorage.setItem(storageKey, mode);
		} catch (error) {
			// The visual preference remains active for this page when storage is unavailable.
		}
	}

	function applyMode(mode) {
		var selectedMode = mode === simpleMode || mode === hiddenMode ? mode : completeMode;
		document.documentElement.setAttribute('data-gallery-addon-view', selectedMode);
		document.querySelectorAll('.gallery-addon-legend').forEach(function (legend) {
			var explanation = legend.querySelector('.gallery-addon-legend__explain');
			var explanationAttribute = selectedMode === simpleMode
				? 'data-view-simple-explain'
				: (selectedMode === hiddenMode ? 'data-view-hidden-explain' : 'data-view-complete-explain');
			var text = legend.getAttribute(explanationAttribute);
			if (explanation && text) {
				explanation.textContent = text;
			}
		});
		document.querySelectorAll('[data-gallery-addon-view-mode]').forEach(function (button) {
			var active = button.getAttribute('data-gallery-addon-view-mode') === selectedMode;
			button.classList.toggle('is-active', active);
			button.setAttribute('aria-pressed', active ? 'true' : 'false');
		});
	}

	function makeButton(mode, label) {
		var button = document.createElement('button');
		button.type = 'button';
		button.className = 'gallery-addon-view-toggle__button';
		button.setAttribute('data-gallery-addon-view-mode', mode);
		button.textContent = label;
		button.addEventListener('click', function () {
			storeMode(mode);
			applyMode(mode);
		});
		return button;
	}

	function addToggle(legend) {
		var title = legend.querySelector('.gallery-addon-legend__title');
		var header;
		var toggle;

		if (!title || legend.querySelector('.gallery-addon-view-toggle')) {
			return;
		}

		header = document.createElement('div');
		header.className = 'gallery-addon-legend__header';
		title.parentNode.insertBefore(header, title);
		header.appendChild(title);

		toggle = document.createElement('div');
		toggle.className = 'gallery-addon-view-toggle';
		toggle.setAttribute('role', 'group');
		toggle.setAttribute('aria-label', title.textContent);
		toggle.appendChild(makeButton(simpleMode, legend.getAttribute('data-view-simple-label')));
		toggle.appendChild(makeButton(completeMode, legend.getAttribute('data-view-complete-label')));
		toggle.appendChild(makeButton(hiddenMode, legend.getAttribute('data-view-hidden-label')));
		header.appendChild(toggle);
	}

	function populateLegendSources(legend) {
		var items = legend.querySelector('.gallery-addon-legend__items');
		var seen = {};
		var sources = [];

		if (!items) {
			items = document.createElement('div');
			items.className = 'gallery-addon-legend__items';
			legend.appendChild(items);
		} else {
			items.textContent = '';
		}

			document.querySelectorAll('.gallery-addon-setting, .gallery-addon-section').forEach(function (row) {
			var source = row.getAttribute('data-gallery-setting-source') || row.getAttribute('data-gallery-addon');
			var badge = row.querySelector('.gallery-addon-badge');
			var kind;
			var priority;
			var tier;

			if (!source || seen[source] || !badge) {
				return;
			}

			seen[source] = true;
			kind = row.getAttribute('data-gallery-setting-kind') || badge.getAttribute('data-gallery-setting-kind');
			tier = row.getAttribute('data-gallery-setting-tier') || badge.getAttribute('data-gallery-setting-tier');
			priority = source === 'new-core' ? 0 : (source === 'updated-core' ? 1 : (kind === 'core' ? 2 : (tier === 'premium' ? 4 : 3)));
			sources.push({
				badge: badge,
				label: badge.textContent.trim().toLocaleLowerCase(),
				order: sources.length,
				priority: priority
			});
		});

		sources.sort(function (left, right) {
			var priorityDifference = left.priority - right.priority;

			if (priorityDifference) {
				return priorityDifference;
			}
			if (left.priority >= 3) {
				return left.label.localeCompare(right.label) || left.order - right.order;
			}
			return left.order - right.order;
		}).forEach(function (source) {
			var clone = source.badge.cloneNode(true);
			clone.removeAttribute('data-gallery-setting-source');
			clone.removeAttribute('data-gallery-setting-kind');
			clone.removeAttribute('data-gallery-setting-tier');
			clone.removeAttribute('data-gallery-addon');
			items.appendChild(clone);
		});

		items.hidden = !items.children.length;
	}

	function initialize() {
		document.querySelectorAll('.gallery-addon-legend').forEach(function (legend) {
			addToggle(legend);
			populateLegendSources(legend);
		});
		applyMode(readMode());
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initialize);
	} else {
		initialize();
	}

	document.addEventListener('phpbbgallery:addonsettingsready', initialize);
}());
