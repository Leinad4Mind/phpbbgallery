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

	function setAlbumRatingMetadata(form, voting) {
		var card = form.closest('.gallery-image-card');
		var items;

		if (!card) {
			return;
		}

		items = Array.prototype.filter.call(card.querySelectorAll('[data-gallery-card-metadata]'), function (item) {
			return item.textContent.trim() !== '' || item.children.length > 0;
		});
		items.forEach(function (item, index) {
			item.hidden = voting && index >= 2;
		});
	}

	function toggleAlbumRating(trigger) {
		var formId = trigger.getAttribute('aria-controls');
		var form = formId ? document.getElementById(formId) : null;
		if (!form) {
			return;
		}

		var opening = form.hidden;
		form.hidden = !opening;
		setAlbumRatingMetadata(form, opening);
		trigger.setAttribute('aria-expanded', opening ? 'true' : 'false');
		if (opening) {
			var firstRating = form.querySelector('[data-rating-value]');
			if (firstRating) {
				firstRating.focus();
			}
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
				var albumForm = container.closest('[data-gallery-rating-form]');
				var albumTrigger = albumForm ? albumForm.previousElementSibling : null;
				if (albumTrigger && albumTrigger.hasAttribute('data-gallery-rating-trigger')) {
					albumTrigger.hidden = true;
					albumTrigger.setAttribute('aria-expanded', 'false');
				}
				if (albumForm) {
					setAlbumRatingMetadata(albumForm, false);
				}
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
		var trigger = event.target.closest('[data-gallery-rating-trigger]');
		if (trigger) {
			event.preventDefault();
			toggleAlbumRating(trigger);
			return;
		}

		var button = event.target.closest('[data-gallery-rating] [data-rating-value]');
		if (!button || button.disabled) {
			return;
		}

		event.preventDefault();
		submitRating(button.closest('[data-gallery-rating]'), button);
	});
}());
