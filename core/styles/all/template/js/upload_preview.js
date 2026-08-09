(function () {
	'use strict';

	var dialog = null;
	var dialogImage = null;
	var dialogCaption = null;
	var closeButton = null;

	function createDialog() {
		var frame;
		var figure;

		dialog = document.createElement('dialog');
		dialog.className = 'gallery-upload-preview-dialog';

		frame = document.createElement('div');
		frame.className = 'gallery-upload-preview-frame';
		dialog.appendChild(frame);

		closeButton = document.createElement('button');
		closeButton.type = 'button';
		closeButton.className = 'gallery-upload-preview-close';
		closeButton.textContent = '\u00d7';
		closeButton.addEventListener('click', function () { dialog.close(); });
		frame.appendChild(closeButton);

		figure = document.createElement('figure');
		frame.appendChild(figure);

		dialogImage = document.createElement('img');
		figure.appendChild(dialogImage);

		dialogCaption = document.createElement('figcaption');
		figure.appendChild(dialogCaption);

		dialog.addEventListener('click', function (event) {
			if (event.target === dialog) {
				dialog.close();
			}
		});
		dialog.addEventListener('close', function () {
			dialogImage.removeAttribute('src');
		});
		document.body.appendChild(dialog);
	}

	document.addEventListener('click', function (event) {
		var link = event.target.closest('[data-gallery-upload-preview]');
		var imageName;

		if (!link || typeof window.HTMLDialogElement === 'undefined') {
			return;
		}

		if (!dialog) {
			createDialog();
		}
		if (typeof dialog.showModal !== 'function') {
			return;
		}

		event.preventDefault();
		imageName = link.getAttribute('data-image-name') || '';
		dialogImage.src = link.href;
		dialogImage.alt = imageName;
		dialogCaption.textContent = imageName;
		closeButton.setAttribute('aria-label', link.getAttribute('data-close-label') || 'Close');
		dialog.showModal();
	});
}());
