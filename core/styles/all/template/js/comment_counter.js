(function () {
	'use strict';

	if (window.phpbbgalleryCommentCounterLoaded) {
		return;
	}

	window.phpbbgalleryCommentCounterLoaded = true;

	function characterLength(value) {
		return Array.from(value).length;
	}

	function findOutput(textarea) {
		var container = textarea.parentNode;
		while (container && container !== document) {
			var output = container.querySelector(
				'[data-gallery-character-counter-output], [data-gallery-comment-counter-output]'
			);
			if (output) {
				return output;
			}
			container = container.parentNode;
		}
		return null;
	}

	function update(textarea, output) {
		var maximum = parseInt(
			textarea.getAttribute('data-gallery-max-length')
				|| textarea.getAttribute('data-comment-max-length'),
			10
		);
		var current = characterLength(textarea.value);
		var exceeded = current > maximum;
		var guidanceText = output.parentNode.querySelector('[data-gallery-comment-guidance-text]');

		if (isNaN(maximum) || maximum < 0) {
			output.hidden = true;
			if (guidanceText) {
				guidanceText.hidden = false;
			}
			return;
		}

		output.textContent = current + ' / ' + maximum;
		output.hidden = current === 0;
		if (guidanceText) {
			guidanceText.hidden = current > 0;
		}
		output.classList.toggle('gallery-comment-counter-exceeded', exceeded);
		if (exceeded) {
			textarea.setAttribute('aria-invalid', 'true');
		} else {
			textarea.removeAttribute('aria-invalid');
		}
	}

	function initialize(root) {
		var textareas = root.querySelectorAll(
			'[data-gallery-character-counter], [data-gallery-comment-counter]'
		);
		Array.prototype.forEach.call(textareas, function (textarea) {
			if (textarea.getAttribute('data-gallery-character-counter-ready') === '1') {
				return;
			}
			var output = findOutput(textarea);
			if (!output) {
				return;
			}
			textarea.setAttribute('data-gallery-character-counter-ready', '1');
			textarea.addEventListener('input', function () {
				update(textarea, output);
			});
			update(textarea, output);
		});
	}

	document.addEventListener('phpbbgallery:imagechange', function (event) {
		initialize(event.detail && event.detail.root ? event.detail.root : document);
	});

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function () {
			initialize(document);
		});
	} else {
		initialize(document);
	}
}());
