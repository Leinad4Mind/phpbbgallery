(function () {
	'use strict';

	if (window.phpbbgalleryCommentCounterLoaded) {
		return;
	}

	window.phpbbgalleryCommentCounterLoaded = true;

	function characterLength(value) {
		return Array.from(value).length;
	}

	function isCounterOutput(element) {
		return element && (
			element.hasAttribute('data-gallery-character-counter-output')
			|| element.hasAttribute('data-gallery-comment-counter-output')
		);
	}

	function describedElements(textarea) {
		var ids = (textarea.getAttribute('aria-describedby') || '').trim().split(/\s+/);
		return ids.filter(Boolean).map(function (id) {
			return document.getElementById(id);
		}).filter(Boolean);
	}

	function findOutput(textarea) {
		var outputId = textarea.getAttribute('data-gallery-counter-output-id');
		var explicitOutput = outputId ? document.getElementById(outputId) : null;
		if (isCounterOutput(explicitOutput)) {
			return explicitOutput;
		}

		var describedOutput = describedElements(textarea).find(isCounterOutput);
		if (describedOutput) {
			return describedOutput;
		}

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

	function findGuidanceText(textarea, output) {
		var describedGuidance = describedElements(textarea).find(function (element) {
			return element.hasAttribute('data-gallery-comment-guidance-text');
		});
		return describedGuidance
			|| output.parentNode.querySelector('[data-gallery-comment-guidance-text]');
	}

	function update(textarea, output) {
		var maximum = parseInt(
			textarea.getAttribute('data-gallery-max-length')
				|| textarea.getAttribute('data-comment-max-length'),
			10
		);
		var current = characterLength(textarea.value);
		var exceeded = current > maximum;
		var guidanceText = findGuidanceText(textarea, output);

		if (isNaN(maximum) || maximum < 0) {
			output.hidden = true;
			if (guidanceText) {
				guidanceText.hidden = false;
			}
			return;
		}

		output.textContent = current + ' / ' + maximum;
		output.hidden = current === 0;
		if (current > 0) {
			output.removeAttribute('hidden');
		}
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
