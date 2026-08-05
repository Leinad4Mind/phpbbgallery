(function () {
	'use strict';

	function initialiseForumIcons() {
		var selector = document.getElementById('forumicons-selector');
		var input = document.getElementById('forum_image');
		var preview = document.getElementById('forumicons-preview-image');
		var clearButton = document.getElementById('forumicons-clear');

		if (!selector || !input || !preview || !clearButton) {
			return;
		}

		var options = selector.querySelectorAll('.forumicons-option');

		function updateSelection(path, url, name) {
			input.value = path;

			if (path) {
				preview.src = url;
				preview.alt = name;
				preview.hidden = false;
			} else {
				preview.removeAttribute('src');
				preview.alt = '';
				preview.hidden = true;
			}

			for (var i = 0; i < options.length; i++) {
				options[i].setAttribute(
					'aria-pressed',
					options[i].getAttribute('data-image-path') === path ? 'true' : 'false'
				);
			}
		}

		for (var i = 0; i < options.length; i++) {
			options[i].addEventListener('click', function () {
				updateSelection(
					this.getAttribute('data-image-path'),
					this.getAttribute('data-image-url'),
					this.getAttribute('data-image-name')
				);
			});
		}

		clearButton.addEventListener('click', function () {
			updateSelection('', '', '');
		});

		updateSelection(input.value, preview.getAttribute('src') || '', preview.alt);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initialiseForumIcons);
	} else {
		initialiseForumIcons();
	}
}());
