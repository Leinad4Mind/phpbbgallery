(function () {
	'use strict';

	function initialiseGalleryTagSearch() {
		var input = document.getElementById('gallery_tags');
		var suggestions = document.getElementById('gallery_tags_suggestions');
		if (!input || !suggestions || !input.dataset.autocompleteUrl || !window.fetch) {
			return;
		}

		var timer = 0;
		var requestNumber = 0;
		input.addEventListener('input', function () {
			window.clearTimeout(timer);
			var separator = input.value.lastIndexOf(',');
			var prefix = separator >= 0 ? input.value.substring(0, separator + 1) + ' ' : '';
			var term = input.value.substring(separator + 1).trim();
			if (!term) {
				suggestions.replaceChildren();
				return;
			}

			timer = window.setTimeout(function () {
				var currentRequest = ++requestNumber;
				var body = new URLSearchParams();
				body.set('term', term);
				window.fetch(input.dataset.autocompleteUrl, {
					method: 'POST',
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
						'X-Requested-With': 'XMLHttpRequest'
					},
					credentials: 'same-origin',
					body: body.toString()
				}).then(function (response) {
					return response.ok ? response.json() : [];
				}).then(function (tags) {
					if (currentRequest !== requestNumber) {
						return;
					}
					suggestions.replaceChildren();
					tags.forEach(function (tag) {
						var option = document.createElement('option');
						option.value = prefix + tag;
						option.label = tag;
						suggestions.appendChild(option);
					});
				}).catch(function () {
					suggestions.replaceChildren();
				});
			}, 150);
		});
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initialiseGalleryTagSearch);
	} else {
		initialiseGalleryTagSearch();
	}
}());
