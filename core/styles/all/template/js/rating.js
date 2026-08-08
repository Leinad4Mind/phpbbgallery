(function () {
	'use strict';

	if (window.phpbbgalleryRatingLoaded) {
		return;
	}

	window.phpbbgalleryRatingLoaded = true;

	function setBusy(container, busy) {
		container.classList.toggle('is-busy', busy);
		Array.prototype.forEach.call(container.querySelectorAll('[data-rating-value]'), function (button) {
			button.disabled = busy || container.classList.contains('is-rated');
		});
	}

	function showError(container, message) {
		var status = container.querySelector('[data-gallery-rating-status]');
		if (status) {
			status.textContent = message;
		}
		if (window.phpbb && typeof window.phpbb.alert === 'function') {
			var wrapper = document.getElementById('darkenwrapper');
			var title = wrapper ? wrapper.getAttribute('data-ajax-error-title') : '';
			window.phpbb.alert(title || message, message);
		}
	}

	function submitRating(container, button) {
		var form = container.closest('form');
		var body = new FormData();
		var tokenFields = form ? form.querySelectorAll('input[name="creation_time"], input[name="form_token"]') : [];

		body.append('rating', button.getAttribute('data-rating-value'));
		Array.prototype.forEach.call(tokenFields, function (field) {
			body.append(field.name, field.value);
		});

		setBusy(container, true);
		fetch(container.getAttribute('data-rating-url'), {
			method: 'POST',
			body: body,
			credentials: 'same-origin',
			headers: {'X-Requested-With': 'XMLHttpRequest'}
		}).then(function (response) {
			return response.json().catch(function () {
				return {message: response.statusText};
			}).then(function (data) {
				if (!response.ok || !data.success) {
					throw new Error(data.message || response.statusText);
				}
				return data;
			});
		}).then(function (data) {
			container.classList.add('is-rated');
			button.classList.add('is-selected');
			button.setAttribute('aria-checked', 'true');
			if (container.hasAttribute('data-gallery-rating-remove-after-submit')) {
				Array.prototype.forEach.call(container.querySelectorAll('[data-rating-value]'), function (ratingButton) {
					ratingButton.hidden = true;
				});
				container.removeAttribute('role');
			}
			var status = container.querySelector('[data-gallery-rating-status]');
			if (status) {
				status.textContent = data.message;
			}
			setBusy(container, false);
		}).catch(function (error) {
			setBusy(container, false);
			showError(container, error.message);
		});
	}

	document.addEventListener('click', function (event) {
		var button = event.target.closest('[data-gallery-rating] [data-rating-value]');
		if (!button || button.disabled) {
			return;
		}

		event.preventDefault();
		submitRating(button.closest('[data-gallery-rating]'), button);
	});
}());
