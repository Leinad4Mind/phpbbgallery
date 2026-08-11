(function () {
	'use strict';

	var storageKey = 'phpbbgallery.acp.addonSettingsView';
	var legacyLegendStorageKey = 'phpbbgallery.acp.addonSettingsLegend';
	var simpleMode = 'simple';
	var completeMode = 'complete';
	var hiddenMode = 'hidden';

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

	function applyMode(mode) {
		var selectedMode = mode === simpleMode || mode === hiddenMode ? mode : completeMode;
		document.documentElement.setAttribute('data-gallery-addon-view', selectedMode);
		document.querySelectorAll('.gallery-addon-legend').forEach(function (legend) {
			var explanation = legend.querySelector('.gallery-addon-legend__explain');
			var text = legend.getAttribute(selectedMode === simpleMode ? 'data-view-simple-explain' : 'data-view-complete-explain');
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

	function initialize() {
		document.querySelectorAll('.gallery-addon-legend').forEach(addToggle);
		applyMode(readMode());
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initialize);
	} else {
		initialize();
	}

	document.addEventListener('phpbbgallery:addonsettingsready', initialize);
}());
