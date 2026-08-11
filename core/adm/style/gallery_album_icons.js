(function () {
	'use strict';

	function initialiseAlbumIconPicker() {
		var albumImage = document.getElementById('album_image');
		var preview = document.getElementById('gallery-album-image-preview');
		var previewImage = document.getElementById('gallery-album-image-preview-src');
		var choices = document.querySelectorAll('input[name="album_icon_pick"]');

		if (!albumImage) {
			return;
		}

		function updatePreview(choice) {
			var source = choice ? choice.getAttribute('data-album-icon-src') || '' : '';

			if (!preview || !previewImage) {
				return;
			}

			preview.hidden = source === '';
			if (source === '') {
				previewImage.removeAttribute('src');
			} else {
				previewImage.src = source;
			}
		}

		choices.forEach(function (choice) {
			choice.addEventListener('change', function () {
				if (!choice.checked) {
					return;
				}

				albumImage.value = choice.getAttribute('data-album-image-path') || '';
				updatePreview(choice);
			});
		});

		albumImage.addEventListener('input', function () {
			var match = null;

			choices.forEach(function (choice) {
				choice.checked = choice.getAttribute('data-album-image-path') === albumImage.value;
				if (choice.checked) {
					match = choice;
				}
			});
			updatePreview(match);
		});
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initialiseAlbumIconPicker);
	} else {
		initialiseAlbumIconPicker();
	}
}());
