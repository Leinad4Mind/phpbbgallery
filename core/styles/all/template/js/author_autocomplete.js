(function () {
	'use strict';

	if (window.phpbbgalleryAuthorAutocompleteLoaded) {
		return;
	}
	window.phpbbgalleryAuthorAutocompleteLoaded = true;

	var instance = 0;

	function initialize(input) {
		if (input.dataset.galleryAuthorReady === '1' || !input.dataset.autocompleteUrl) {
			return;
		}
		input.dataset.galleryAuthorReady = '1';

		var container = input.closest('.input-group') || input.parentElement;
		var row = container.closest('dl');
		var suggestions = document.createElement('ul');
		var searchTimer = 0;
		var requestNumber = 0;
		var activeIndex = -1;
		var listId = 'gallery-author-suggestions-' + (++instance);

		container.classList.add('gallery-author-autocomplete');
		suggestions.id = listId;
		suggestions.className = 'gallery-author-suggestions';
		suggestions.setAttribute('role', 'listbox');
		suggestions.hidden = true;
		container.appendChild(suggestions);
		input.autocomplete = 'off';
		input.setAttribute('role', 'combobox');
		input.setAttribute('aria-autocomplete', 'list');
		input.setAttribute('aria-controls', listId);
		input.setAttribute('aria-expanded', 'false');

		function options() {
			return Array.prototype.slice.call(suggestions.querySelectorAll('[role=option]'));
		}

		function setActive(index) {
			var items = options();
			items.forEach(function (item) {
				item.classList.remove('is-active');
				item.setAttribute('aria-selected', 'false');
			});
			if (!items.length) {
				activeIndex = -1;
				input.removeAttribute('aria-activedescendant');
				return;
			}
			activeIndex = (index + items.length) % items.length;
			items[activeIndex].classList.add('is-active');
			items[activeIndex].setAttribute('aria-selected', 'true');
			input.setAttribute('aria-activedescendant', items[activeIndex].id);
			items[activeIndex].scrollIntoView({block: 'nearest'});
		}

		function close() {
			suggestions.hidden = true;
			suggestions.textContent = '';
			container.classList.remove('is-open');
			if (row) {
				row.classList.remove('gallery-autocomplete-row-open');
			}
			activeIndex = -1;
			input.setAttribute('aria-expanded', 'false');
			input.removeAttribute('aria-activedescendant');
		}

		function choose(value) {
			input.value = value;
			close();
			input.focus();
			input.dispatchEvent(new Event('change', {bubbles: true}));
		}

		function show(items) {
			close();
			items.slice(0, 10).forEach(function (item, index) {
				var value = String(item.value || item.label || '').trim();
				if (!value) {
					return;
				}
				var option = document.createElement('li');
				var button = document.createElement('button');
				option.id = listId + '-' + index;
				option.setAttribute('role', 'option');
				option.setAttribute('aria-selected', 'false');
				button.type = 'button';
				button.textContent = item.label || value;
				button.addEventListener('mousedown', function (event) {
					event.preventDefault();
					choose(value);
				});
				option.appendChild(button);
				suggestions.appendChild(option);
			});
			if (suggestions.children.length) {
				suggestions.hidden = false;
				container.classList.add('is-open');
				if (row) {
					row.classList.add('gallery-autocomplete-row-open');
				}
				input.setAttribute('aria-expanded', 'true');
			}
		}

		input.addEventListener('input', function () {
			var term = input.value.trim();
			var currentRequest = ++requestNumber;
			window.clearTimeout(searchTimer);
			if (term.length < 2 || term.indexOf('*') !== -1) {
				close();
				return;
			}
			searchTimer = window.setTimeout(function () {
				var url = new URL(input.dataset.autocompleteUrl, window.location.href);
				url.searchParams.set('term', term);
				window.fetch(url.toString(), {
					headers: {'X-Requested-With': 'XMLHttpRequest'},
					credentials: 'same-origin'
				}).then(function (response) {
					return response.ok ? response.json() : [];
				}).then(function (items) {
					if (currentRequest === requestNumber) {
						show(Array.isArray(items) ? items : []);
					}
				}).catch(close);
			}, 200);
		});

		input.addEventListener('keydown', function (event) {
			var items = options();
			if (event.key === 'ArrowDown' && items.length) {
				event.preventDefault();
				setActive(activeIndex + 1);
			} else if (event.key === 'ArrowUp' && items.length) {
				event.preventDefault();
				setActive(activeIndex < 0 ? items.length - 1 : activeIndex - 1);
			} else if (event.key === 'Enter' && activeIndex >= 0 && items[activeIndex]) {
				event.preventDefault();
				choose(items[activeIndex].querySelector('button').textContent);
			} else if (event.key === 'Escape') {
				close();
			}
		});
		input.addEventListener('blur', function () {
			window.setTimeout(close, 150);
		});
	}

	function initializeAll(root) {
		root.querySelectorAll('[data-gallery-author-autocomplete]').forEach(initialize);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function () {
			initializeAll(document);
		});
	} else {
		initializeAll(document);
	}
}());
