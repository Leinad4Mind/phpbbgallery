(function () {
	'use strict';

	var storageKey = 'phpbbgallery.acp.addonSettingsView';
	var sourceStorageKey = 'phpbbgallery.acp.addonSettingsSources';
	var legacyLegendStorageKey = 'phpbbgallery.acp.addonSettingsLegend';
	var simpleMode = 'simple';
	var completeMode = 'complete';
	var hiddenMode = 'hidden';
	var hiddenSources = [];

	function readMode() {
		var storedMode;

		try {
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

	function readHiddenSources() {
		var storedSources;

		try {
			storedSources = JSON.parse(window.localStorage.getItem(sourceStorageKey) || '[]');
			return Array.isArray(storedSources)
				? storedSources.filter(function (source) {
					return typeof source === 'string' && source !== '';
				})
				: [];
		} catch (error) {
			return [];
		}
	}

	function storeHiddenSources() {
		try {
			window.localStorage.setItem(sourceStorageKey, JSON.stringify(hiddenSources));
		} catch (error) {
			// The filters remain active for this page when storage is unavailable.
		}
	}

	function getSource(element) {
		return element.getAttribute('data-gallery-setting-source')
			|| element.getAttribute('data-gallery-addon')
			|| '';
	}

	function applySourceFilters() {
		document.querySelectorAll('.gallery-addon-setting, .gallery-addon-section').forEach(function (setting) {
			var source = getSource(setting);
			setting.hidden = hiddenSources.indexOf(source) !== -1;
		});
		document.querySelectorAll('[data-gallery-source-toggle]').forEach(function (button) {
			var source = button.getAttribute('data-gallery-source-toggle');
			var active = hiddenSources.indexOf(source) === -1;
			button.classList.toggle('is-source-disabled', !active);
			button.setAttribute('aria-pressed', active ? 'true' : 'false');
		});
	}

	function toggleSource(source) {
		var index = hiddenSources.indexOf(source);

		if (!source) {
			return;
		}
		if (index === -1) {
			hiddenSources.push(source);
		} else {
			hiddenSources.splice(index, 1);
		}
		storeHiddenSources();
		applySourceFilters();
	}

	function bindSourceToggles() {
		document.querySelectorAll('[data-gallery-source-toggle]').forEach(function (button) {
			if (button.getAttribute('data-gallery-source-bound') === 'true') {
				return;
			}
			button.setAttribute('data-gallery-source-bound', 'true');
			button.addEventListener('click', function () {
				toggleSource(button.getAttribute('data-gallery-source-toggle'));
			});
		});
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
		applySourceFilters();
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

	function initialize() {
		document.querySelectorAll('.gallery-addon-legend').forEach(addToggle);
		hiddenSources = readHiddenSources();
		bindSourceToggles();
		applyMode(readMode());
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initialize);
	} else {
		initialize();
	}

	document.addEventListener('phpbbgallery:addonsettingsready', initialize);
}());
