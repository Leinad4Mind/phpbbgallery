(function () {
	'use strict';

	var matrices = {
		1: [1, 0, 0, 1],
		2: [-1, 0, 0, 1],
		3: [-1, 0, 0, -1],
		4: [1, 0, 0, -1],
		5: [0, 1, 1, 0],
		6: [0, 1, -1, 0],
		7: [0, -1, -1, 0],
		8: [0, -1, 1, 0]
	};

	function multiply(left, right) {
		return [
			left[0] * right[0] + left[2] * right[1],
			left[1] * right[0] + left[3] * right[1],
			left[0] * right[2] + left[2] * right[3],
			left[1] * right[2] + left[3] * right[3]
		];
	}

	function orientationFor(matrix) {
		var found = 1;
		Object.keys(matrices).some(function (key) {
			if (matrices[key].every(function (value, index) { return value === matrix[index]; })) {
				found = parseInt(key, 10);
				return true;
			}
			return false;
		});
		return found;
	}

	function apply(editor, value) {
		var input = editor.querySelector('[data-gallery-orientation-input]');
		var labels = editor.querySelector('[data-gallery-orientation-labels]');
		var state = editor.querySelector('[data-gallery-orientation-state]');
		var preview = editor.closest('[data-gallery-orientation-item]');
		var image = preview ? preview.querySelector('[data-gallery-orientation-preview] img') : null;
		var matrix = matrices[value] || matrices[1];

		editor.setAttribute('data-orientation', String(value));
		input.value = String(value);
		if (state && labels) {
			state.textContent = labels.getAttribute('data-orientation-' + value) || '';
		}
		if (image) {
			image.style.transform = 'matrix(' + matrix.join(',') + ',0,0)';
			image.setAttribute('data-gallery-orientation', String(value));
		}
	}

	function initialise(root) {
		(root || document).querySelectorAll('[data-gallery-orientation-editor]').forEach(function (editor) {
			if (editor.getAttribute('data-gallery-orientation-ready') === '1') {
				return;
			}
			editor.setAttribute('data-gallery-orientation-ready', '1');
			apply(editor, parseInt(editor.querySelector('[data-gallery-orientation-input]').value, 10) || 1);
			editor.addEventListener('click', function (event) {
				var button = event.target.closest('[data-gallery-orientation-operation]');
				if (!button || !editor.contains(button)) {
					return;
				}
				var operation = button.getAttribute('data-gallery-orientation-operation');
				var current = parseInt(editor.getAttribute('data-orientation'), 10) || 1;
				var value = operation === 'reset'
					? 1
					: orientationFor(multiply(matrices[parseInt(operation, 10)], matrices[current]));
				apply(editor, value);

				var applyAll = document.querySelector('[data-gallery-orientation-apply-all]');
				if (applyAll && applyAll.checked) {
					document.querySelectorAll('[data-gallery-orientation-editor]').forEach(function (other) {
						apply(other, value);
					});
				}
			});
		});
	}

	document.addEventListener('DOMContentLoaded', function () { initialise(document); });
	document.addEventListener('phpbbgallery:imagechange', function (event) { initialise(event.target); });
}());
