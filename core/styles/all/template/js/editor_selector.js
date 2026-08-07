(function () {
	'use strict';

	var dialog = document.getElementById('phpbbgallery-selector-dialog');
	var triggers = document.querySelectorAll('[data-gallery-selector-open]');
	if (!dialog || !triggers.length)
	{
		return;
	}
	if (typeof window.fetch !== 'function' || typeof window.URL !== 'function')
	{
		return;
	}

	var endpoint = dialog.getAttribute('data-endpoint');
	var albumSelect = dialog.querySelector('[data-gallery-selector-album]');
	var closeButton = dialog.querySelector('[data-gallery-selector-close]');
	var grid = dialog.querySelector('[data-gallery-selector-grid]');
	var status = dialog.querySelector('[data-gallery-selector-status]');
	var previous = dialog.querySelector('[data-gallery-selector-previous]');
	var next = dialog.querySelector('[data-gallery-selector-next]');
	var activeTrigger = null;
	var currentPage = 1;
	var currentAlbum = 0;
	var requestController = null;

	function placeToolbarTriggers()
	{
		triggers.forEach(function (trigger) {
			if (!trigger.hasAttribute('data-gallery-selector-toolbar'))
			{
				return;
			}

			var form = trigger.closest('form');
			var toolbar = form ? form.querySelector('#format-buttons, .posting-btns') : null;
			if (toolbar && !toolbar.contains(trigger))
			{
				toolbar.appendChild(trigger);
			}
		});
	}

	function clearElement(element)
	{
		while (element.firstChild)
		{
			element.removeChild(element.firstChild);
		}
	}

	function setStatus(message, isError)
	{
		status.textContent = message;
		status.hidden = !message;
		status.classList.toggle('phpbbgallery-selector-error', !!isError);
	}

	function finishClose()
	{
		if (requestController)
		{
			requestController.abort();
			requestController = null;
		}
		dialog.hidden = true;
		dialog.classList.remove('phpbbgallery-selector-fallback-open');
		document.body.classList.remove('phpbbgallery-selector-page-open');
		if (activeTrigger)
		{
			activeTrigger.setAttribute('aria-expanded', 'false');
			activeTrigger.focus();
			activeTrigger = null;
		}
	}

	function closeDialog()
	{
		if (typeof dialog.close === 'function' && dialog.open)
		{
			dialog.close();
			return;
		}
		finishClose();
	}

	function openDialog(trigger)
	{
		if (activeTrigger && activeTrigger !== trigger)
		{
			activeTrigger.setAttribute('aria-expanded', 'false');
		}
		activeTrigger = trigger;
		activeTrigger.setAttribute('aria-expanded', 'true');
		dialog.hidden = false;
		document.body.classList.add('phpbbgallery-selector-page-open');
		if (typeof dialog.showModal === 'function')
		{
			dialog.showModal();
		}
		else
		{
			dialog.classList.add('phpbbgallery-selector-fallback-open');
		}
		closeButton.focus();
		loadImages(currentPage);
	}

	function insertAtCursor(imageId)
	{
		if (!Number.isInteger(imageId) || imageId < 1 || !activeTrigger)
		{
			return;
		}

		var form = activeTrigger.closest('form');
		var textarea = form ? form.querySelector('textarea[name="message"]') : null;
		if (!textarea)
		{
			setStatus(dialog.getAttribute('data-error-label'), true);
			return;
		}

		var bbcodeTag = dialog.getAttribute('data-bbcode-tag') || 'image';
		var bbcode = '[' + bbcodeTag + ']' + imageId + '[/' + bbcodeTag + ']';
		textarea.focus();
		if (form.id === 'postform' && typeof window.insert_text === 'function')
		{
			window.insert_text(bbcode, true);
		}
		else if (typeof textarea.setRangeText === 'function')
		{
			textarea.setRangeText(bbcode, textarea.selectionStart, textarea.selectionEnd, 'end');
		}
		else
		{
			textarea.value += bbcode;
		}
		textarea.dispatchEvent(new Event('input', { bubbles: true }));
		setStatus(dialog.getAttribute('data-inserted-label'), false);
		closeDialog();
	}

	function renderAlbums(albums, selectedAlbum)
	{
		clearElement(albumSelect);
		var allOption = document.createElement('option');
		allOption.value = '0';
		allOption.textContent = dialog.getAttribute('data-all-label');
		albumSelect.appendChild(allOption);

		albums.forEach(function (album) {
			var option = document.createElement('option');
			var depth = Math.max(0, Math.min(20, Number(album.album_depth) || 0));
			option.value = String(album.album_id);
			option.textContent = Array(depth + 1).join('\u2014 ') + album.album_name;
			albumSelect.appendChild(option);
		});
		albumSelect.value = String(selectedAlbum);
	}

	function renderImages(images)
	{
		clearElement(grid);
		if (!images.length)
		{
			setStatus(dialog.getAttribute('data-empty-label'), false);
			return;
		}

		setStatus('', false);
		images.forEach(function (image) {
			var imageId = Number(image.image_id);
			if (!Number.isInteger(imageId) || imageId < 1)
			{
				return;
			}

			var button = document.createElement('button');
			button.type = 'button';
			button.className = 'phpbbgallery-selector-card';
			button.setAttribute('aria-label', dialog.getAttribute('data-insert-label') + ': ' + image.image_name);

			var thumbnail = document.createElement('img');
			thumbnail.src = image.thumbnail_url;
			thumbnail.alt = image.image_name;
			thumbnail.loading = 'lazy';

			var name = document.createElement('strong');
			name.textContent = image.image_name;

			var album = document.createElement('span');
			album.textContent = image.album_name;

			button.appendChild(thumbnail);
			button.appendChild(name);
			button.appendChild(album);
			button.addEventListener('click', function () {
				insertAtCursor(imageId);
			});
			grid.appendChild(button);
		});
	}

	function renderPagination(pagination)
	{
		currentPage = Number(pagination.page) || 1;
		previous.disabled = currentPage <= 1;
		next.disabled = currentPage >= (Number(pagination.pages) || 1);
	}

	function loadImages(page)
	{
		if (requestController)
		{
			requestController.abort();
		}
		requestController = typeof AbortController === 'function' ? new AbortController() : null;

		setStatus(dialog.getAttribute('data-loading-label'), false);
		clearElement(grid);
		previous.disabled = true;
		next.disabled = true;

		var url = new URL(endpoint, window.location.href);
		url.searchParams.set('album_id', String(currentAlbum));
		url.searchParams.set('page', String(page));
		var options = {
			credentials: 'same-origin',
			headers: { Accept: 'application/json' }
		};
		if (requestController)
		{
			options.signal = requestController.signal;
		}

		fetch(url.toString(), options)
			.then(function (response) {
				if (!response.ok)
				{
					throw new Error('Gallery selector request failed.');
				}
				return response.json();
			})
			.then(function (data) {
				renderAlbums(data.albums || [], Number(data.album_id) || 0);
				renderImages(data.images || []);
				renderPagination(data.pagination || {});
			})
			.catch(function (error) {
				if (error.name !== 'AbortError')
				{
					setStatus(dialog.getAttribute('data-error-label'), true);
				}
			});
	}

	placeToolbarTriggers();

	triggers.forEach(function (trigger) {
		trigger.addEventListener('click', function (event) {
			event.preventDefault();
			openDialog(trigger);
		});
	});

	closeButton.addEventListener('click', closeDialog);
	albumSelect.addEventListener('change', function () {
		currentAlbum = Number(albumSelect.value) || 0;
		currentPage = 1;
		loadImages(currentPage);
	});
	previous.addEventListener('click', function () {
		if (currentPage > 1)
		{
			loadImages(currentPage - 1);
		}
	});
	next.addEventListener('click', function () {
		loadImages(currentPage + 1);
	});

	dialog.addEventListener('close', finishClose);
	dialog.addEventListener('click', function (event) {
		if (event.target === dialog)
		{
			closeDialog();
		}
	});
	dialog.addEventListener('keydown', function (event) {
		if (event.key === 'Escape' && !(typeof dialog.showModal === 'function' && dialog.open))
		{
			event.preventDefault();
			closeDialog();
			return;
		}
		if (event.key !== 'Tab')
		{
			return;
		}

		var focusable = Array.prototype.slice.call(dialog.querySelectorAll(
			'button:not([disabled]), select:not([disabled]), a[href], [tabindex]:not([tabindex="-1"])'
		));
		if (!focusable.length)
		{
			return;
		}
		var first = focusable[0];
		var last = focusable[focusable.length - 1];
		if (event.shiftKey && document.activeElement === first)
		{
			event.preventDefault();
			last.focus();
		}
		else if (!event.shiftKey && document.activeElement === last)
		{
			event.preventDefault();
			first.focus();
		}
	});
})();
