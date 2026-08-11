(function () {
	'use strict';

	var storageKey = 'phpbbgallery.acp.addonSettingsView';
	var legendStorageKey = 'phpbbgallery.acp.addonSettingsLegend';
	var simpleMode = 'simple';
	var completeMode = 'complete';

	function readMode() {
		try {
			return window.localStorage.getItem(storageKey) === simpleMode ? simpleMode : completeMode;
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

	function isLegendVisible() {
		try {
			return window.localStorage.getItem(legendStorageKey) !== 'hidden';
		} catch (error) {
			return true;
		}
	}

	function storeLegendVisibility(visible) {
		try {
			window.localStorage.setItem(legendStorageKey, visible ? 'visible' : 'hidden');
		} catch (error) {
			// The visual preference remains active for this page when storage is unavailable.
		}
	}

	function applyLegendVisibility(visible) {
		document.querySelectorAll('.gallery-addon-legend').forEach(function (legend) {
			legend.classList.toggle('is-collapsed', !visible);
		});
	}

	function applyMode(mode) {
		var selectedMode = mode === simpleMode ? simpleMode : completeMode;
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
		var controls;
		var toggle;
		var closeButton;
		var showButton;

		if (!title || legend.querySelector('.gallery-addon-view-toggle')) {
			return;
		}

		header = document.createElement('div');
		header.className = 'gallery-addon-legend__header';
		title.parentNode.insertBefore(header, title);
		header.appendChild(title);
		controls = document.createElement('div');
		controls.className = 'gallery-addon-legend__controls';
		header.appendChild(controls);

		toggle = document.createElement('div');
		toggle.className = 'gallery-addon-view-toggle';
		toggle.setAttribute('role', 'group');
		toggle.setAttribute('aria-label', title.textContent);
		toggle.appendChild(makeButton(simpleMode, legend.getAttribute('data-view-simple-label')));
		toggle.appendChild(makeButton(completeMode, legend.getAttribute('data-view-complete-label')));
		controls.appendChild(toggle);

		closeButton = document.createElement('button');
		closeButton.type = 'button';
		closeButton.className = 'gallery-addon-legend__close';
		closeButton.setAttribute('aria-label', legend.getAttribute('data-close-label'));
		closeButton.setAttribute('title', legend.getAttribute('data-close-label'));
		closeButton.textContent = '\u00d7';
		closeButton.addEventListener('click', function () {
			storeLegendVisibility(false);
			applyLegendVisibility(false);
		});
		controls.appendChild(closeButton);

		showButton = document.createElement('button');
		showButton.type = 'button';
		showButton.className = 'gallery-addon-legend__show';
		showButton.textContent = legend.getAttribute('data-show-label');
		showButton.addEventListener('click', function () {
			storeLegendVisibility(true);
			applyLegendVisibility(true);
		});
		legend.appendChild(showButton);
	}

	function initialize() {
		document.querySelectorAll('.gallery-addon-legend').forEach(addToggle);
		applyMode(readMode());
		applyLegendVisibility(isLegendVisible());
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initialize);
	} else {
		initialize();
	}

	document.addEventListener('phpbbgallery:addonsettingsready', initialize);
}());
