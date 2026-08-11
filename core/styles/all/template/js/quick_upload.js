(function () {
	'use strict';

	var ACTIVE_UPLOADS = 3;

	function initialize() {
		var dropZone = document.querySelector('[data-gallery-quick-upload]');
		var form = document.getElementById('postform');
		var fileInput = document.getElementById('files');
		var output = document.getElementById('outputTarget');

		if (!dropZone || !form || !fileInput || !output || !window.FormData || !window.XMLHttpRequest) {
			return;
		}

		var outputItems = output.querySelector('.containuploads');
		var progressBar = output.querySelector('.meter > span');
		var progressLabel = progressBar ? progressBar.querySelector('.gallery-quick-upload-progress-label') : null;
		var endpoint = dropZone.getAttribute('data-url') || form.getAttribute('action');
		var maximumFileSize = parseInt(dropZone.getAttribute('data-max-file-size'), 10) || 0;
		var uploadLimit = parseInt(dropZone.getAttribute('data-upload-limit'), 10) || 0;
		var allowedExtensions = (dropZone.getAttribute('data-allowed-extensions') || '')
			.split(',')
			.map(function (extension) {
				return extension.trim().replace(/^\./, '').toLowerCase();
			})
			.filter(Boolean);
		var labels = {
			cancel: dropZone.getAttribute('data-label-cancel') || 'Cancel',
			error: dropZone.getAttribute('data-label-error') || 'Error',
			imageName: dropZone.getAttribute('data-label-image-name') || 'Image name',
			invalidType: dropZone.getAttribute('data-error-file-type') || 'File type is not allowed',
			invalidSize: dropZone.getAttribute('data-error-file-size') || 'File is too large',
			tooMany: dropZone.getAttribute('data-error-upload-limit') || 'Upload limit reached'
		};
		var queue = [];
		var tasks = [];
		var active = 0;
		var accepted = 0;
		var dragTimeout = null;
		var reviewRequired = false;
		var reviewSubmitted = false;
		var resetting = false;
		var resetCleanupRequest = null;
		var fileInputWasDisabled = fileInput.disabled;

		function extensionOf(filename) {
			var position = filename.lastIndexOf('.');
			return position === -1 ? '' : filename.slice(position + 1).toLowerCase();
		}

		function createElement(name, className, text) {
			var element = document.createElement(name);
			if (className) {
				element.className = className;
			}
			if (typeof text === 'string') {
				element.textContent = text;
			}
			return element;
		}

		function createRow(file) {
			var row = createElement('div', 'uploadImage gallery-quick-upload-item');
			var preview = createElement('div', 'preview');
			var information = createElement('div', 'info');
			var nameLabel = createElement('label', '', labels.imageName + ': ');
			var name = createElement('span', 'name', file.name);
			var error = createElement('div', 'error gallery-quick-upload-error');
			var cancel = createElement('button', 'button2 btn btn-default btn-sm gallery-quick-upload-cancel', labels.cancel);

			cancel.type = 'button';
			nameLabel.appendChild(name);
			information.appendChild(nameLabel);
			information.appendChild(error);
			information.appendChild(cancel);
			row.appendChild(preview);
			row.appendChild(information);

			if (file.type.indexOf('image/') === 0 && extensionOf(file.name) !== 'zip') {
				var previewUrl = URL.createObjectURL(file);
				var image = createElement('img');
				image.alt = '';
				image.addEventListener('load', function () {
					URL.revokeObjectURL(previewUrl);
				}, {once: true});
				image.addEventListener('error', function () {
					URL.revokeObjectURL(previewUrl);
				}, {once: true});
				image.src = previewUrl;
				preview.appendChild(image);
			}

			outputItems.appendChild(row);
			return {
				cancel: cancel,
				error: error,
				name: name,
				preview: preview,
				row: row
			};
		}

		function setError(task, message) {
			task.status = 'failed';
			task.loaded = task.file.size;
			task.elements.error.textContent = message || labels.error;
			task.elements.row.classList.add('gallery-quick-upload-failed');
			task.elements.cancel.hidden = false;
			updateProgress();
		}

		function removeTask(task) {
			queue = queue.filter(function (queuedTask) {
				return queuedTask !== task;
			});
			tasks = tasks.filter(function (existingTask) {
				return existingTask !== task;
			});
			if (task.accepted) {
				accepted = Math.max(0, accepted - 1);
				task.accepted = false;
			}
			task.status = 'cancelled';
			task.elements.row.remove();
			updateProgress();
			if (!tasks.length) {
				output.classList.add('hidden');
			}
		}

		function cancelTask(task) {
			if (task.status === 'uploading' && task.request) {
				task.request.abort();
				return;
			}

			removeTask(task);
			processQueue();
			openMetadataReview();
		}

		function updateProgress() {
			var total = tasks.reduce(function (sum, task) {
				return sum + task.file.size;
			}, 0);
			var loaded = tasks.reduce(function (sum, task) {
				return sum + Math.min(task.loaded, task.file.size);
			}, 0);
			var percent = total ? Math.round(loaded / total * 100) : 0;

			if (progressBar) {
				progressBar.style.width = percent + '%';
				progressBar.setAttribute('aria-valuenow', String(percent));
			}
			if (progressLabel) {
				progressLabel.textContent = percent + '%';
			}
		}

		function appendFormFields(data) {
			var currentForm = new FormData(form);
			currentForm.forEach(function (value, name) {
				if (!(value instanceof File)) {
					data.append(name, value);
				}
			});
		}

		function responseError(response) {
			if (!response || !Array.isArray(response.files) || !response.files.length) {
				return labels.error;
			}
			for (var index = 0; index < response.files.length; index++) {
				if (response.files[index] && response.files[index].error) {
					var parser = new DOMParser();
					var documentFragment = parser.parseFromString(String(response.files[index].error), 'text/html');
					return documentFragment.body.textContent || labels.error;
				}
			}
			return '';
		}

		function renderUploadedFile(elements, file) {
			var link = createElement('a', '', file.name || elements.name.textContent);
			link.href = file.url;
			elements.name.textContent = '';
			elements.name.appendChild(link);

			if (file.thumbnail) {
				var previewLink = createElement('a');
				var image = createElement('img');
				previewLink.href = file.url;
				image.alt = file.name || '';
				image.src = file.thumbnail;
				previewLink.appendChild(image);
				elements.preview.textContent = '';
				elements.preview.appendChild(previewLink);
			}
		}

		function complete(task, response) {
			var error = responseError(response);
			if (error) {
				setError(task, error);
				return;
			}

			response.files.forEach(function (uploadedFile, index) {
				var elements = index === 0 ? task.elements : createRow({name: uploadedFile.name || task.file.name, type: '', size: 0});
				renderUploadedFile(elements, uploadedFile);
				elements.cancel.hidden = true;
				elements.row.classList.add('gallery-quick-upload-complete');
			});

			task.status = 'complete';
			task.loaded = task.file.size;
			reviewRequired = reviewRequired || response.review_required === true;
			updateProgress();
		}

		function openMetadataReview() {
			if (resetting || reviewSubmitted || !reviewRequired || active || queue.length || tasks.some(function (task) {
				return task.status === 'failed';
			})) {
				return;
			}

			var mode = form.querySelector('input[name="mode"]');
			if (!mode) {
				return;
			}

			reviewSubmitted = true;
			mode.value = 'upload_edit';
			window.HTMLFormElement.prototype.submit.call(form);
		}

		function upload(task) {
			var request = new XMLHttpRequest();
			var data = new FormData();

			active++;
			task.status = 'uploading';
			task.request = request;
			appendFormFields(data);
			data.append('files[]', task.file, task.file.name);

			request.open('POST', endpoint, true);
			request.setRequestHeader('Accept', 'application/json');
			request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
			request.upload.addEventListener('progress', function (event) {
				if (event.lengthComputable) {
					task.loaded = event.loaded;
					updateProgress();
				}
			});
			request.addEventListener('load', function () {
				var response = null;
				try {
					response = JSON.parse(request.responseText);
				} catch (error) {
					response = null;
				}

				if (request.status >= 200 && request.status < 300) {
					complete(task, response);
				} else {
					setError(task, responseError(response));
				}
			});
			request.addEventListener('error', function () {
				setError(task, labels.error);
			});
			request.addEventListener('abort', function () {
				removeTask(task);
			});
			request.addEventListener('loadend', function () {
				active = Math.max(0, active - 1);
				if (resetting) {
					if (!active) {
						discardPendingDrafts();
					}
					return;
				}
				processQueue();
				openMetadataReview();
			});
			request.send(data);
		}

		function processQueue() {
			if (resetting) {
				return;
			}

			while (active < ACTIVE_UPLOADS && queue.length) {
				var task = queue.shift();
				if (task.status === 'queued') {
					upload(task);
				}
			}
		}

		function addFiles(files) {
			if (resetting || !files.length) {
				return;
			}

			output.classList.remove('hidden');
			Array.prototype.forEach.call(files, function (file) {
				var elements = createRow(file);
				var task = {
					accepted: false,
					elements: elements,
					file: file,
					loaded: 0,
					request: null,
					status: 'queued'
				};
				tasks.push(task);
				elements.cancel.addEventListener('click', function () {
					cancelTask(task);
				});

				if (uploadLimit && accepted >= uploadLimit) {
					setError(task, labels.tooMany);
					return;
				}
				if (allowedExtensions.indexOf(extensionOf(file.name)) === -1) {
					setError(task, labels.invalidType);
					return;
				}
				if (maximumFileSize && file.size > maximumFileSize) {
					setError(task, labels.invalidSize);
					return;
				}

				accepted++;
				task.accepted = true;
				queue.push(task);
			});

			updateProgress();
			processQueue();
			openMetadataReview();
		}

		function finishReset() {
			resetCleanupRequest = null;
			resetting = false;
			fileInput.disabled = fileInputWasDisabled;
		}

		function discardPendingDrafts() {
			if (resetCleanupRequest) {
				return;
			}

			var request = new XMLHttpRequest();
			var data = new FormData();
			appendFormFields(data);
			data.delete('mode');
			data.append('mode', 'upload');
			data.append('discard_pending', '1');
			resetCleanupRequest = request;
			request.open('POST', endpoint, true);
			request.setRequestHeader('Accept', 'application/json');
			request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
			request.addEventListener('load', function () {
				var response = null;
				try {
					response = JSON.parse(request.responseText);
				} catch (error) {
					response = null;
				}
				if (request.status < 200 || request.status >= 300 || !response || response.success !== true) {
					window.location.reload();
				}
			});
			request.addEventListener('error', function () {
				window.location.reload();
			});
			request.addEventListener('loadend', finishReset);
			request.send(data);
		}

		function resetUpload() {
			if (resetting) {
				return;
			}

			resetting = true;
			reviewRequired = false;
			reviewSubmitted = false;
			fileInput.disabled = true;
			queue = [];
			tasks.slice().forEach(function (task) {
				if (task.status === 'uploading' && task.request) {
					task.request.abort();
				} else {
					removeTask(task);
				}
			});
			tasks = [];
			accepted = 0;
			fileInput.value = '';
			outputItems.textContent = '';
			output.classList.add('hidden');
			updateProgress();

			if (!active) {
				discardPendingDrafts();
			}
		}

		fileInput.addEventListener('change', function () {
			addFiles(fileInput.files);
			fileInput.value = '';
		});

		form.addEventListener('reset', resetUpload);

		document.addEventListener('dragover', function (event) {
			if (!event.dataTransfer || Array.prototype.indexOf.call(event.dataTransfer.types, 'Files') === -1) {
				return;
			}
			event.preventDefault();
			dropZone.classList.add('in');
			dropZone.classList.toggle('hover', dropZone.contains(event.target));
			window.clearTimeout(dragTimeout);
			dragTimeout = window.setTimeout(function () {
				dropZone.classList.remove('in', 'hover');
			}, 150);
		});

		document.addEventListener('drop', function (event) {
			if (!event.dataTransfer || !event.dataTransfer.files.length) {
				return;
			}
			event.preventDefault();
			window.clearTimeout(dragTimeout);
			dropZone.classList.remove('in', 'hover');
			if (dropZone.contains(event.target)) {
				addFiles(event.dataTransfer.files);
			}
		});
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initialize);
	} else {
		initialize();
	}
})();
