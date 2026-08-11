(function () {
	'use strict';

	function element(name, className, text) {
		var node = document.createElement(name);
		if (className) {
			node.className = className;
		}
		if (typeof text === 'string') {
			node.textContent = text;
		}
		return node;
	}

	function render(widget, data) {
		var content = widget.querySelector('.phpbbgallery-album-embed-content');
		if (content) {
			content.remove();
		}

		content = element('div', 'phpbbgallery-album-embed-content');
		var header = element('div', 'phpbbgallery-album-embed-header');
		var albumLink = element('a', 'phpbbgallery-album-embed-title', data.album.album_name);
		albumLink.href = data.album.view_url;
		header.appendChild(albumLink);
		content.appendChild(header);

		if (data.images.length) {
			var grid = element('div', 'phpbbgallery-album-embed-grid');
			data.images.forEach(function (image) {
				var link = element('a', 'phpbbgallery-album-embed-image');
				link.href = image.view_url;
				var thumbnail = element('img', 'phpbbgallery-album-embed-thumbnail');
				thumbnail.src = image.thumbnail_url;
				thumbnail.alt = image.image_name;
				thumbnail.loading = 'lazy';
				link.appendChild(thumbnail);
				link.appendChild(element('span', 'phpbbgallery-album-embed-caption', image.image_name));
				grid.appendChild(link);
			});
			content.appendChild(grid);
		} else {
			content.appendChild(element('p', 'phpbbgallery-album-embed-empty', data.labels.empty));
		}

		if (data.pagination.pages > 1) {
			var pagination = element('nav', 'phpbbgallery-album-embed-pagination');
			pagination.setAttribute('aria-label', data.labels.page);
			var previous = element('button', 'button button-secondary btn btn-default', data.labels.previous);
			previous.type = 'button';
			previous.disabled = data.pagination.page <= 1;
			previous.addEventListener('click', function () {
				load(widget, data.pagination.page - 1);
			});
			pagination.appendChild(previous);
			pagination.appendChild(element('span', 'phpbbgallery-album-embed-page', data.labels.page));
			var next = element('button', 'button button-secondary btn btn-default', data.labels.next);
			next.type = 'button';
			next.disabled = data.pagination.page >= data.pagination.pages;
			next.addEventListener('click', function () {
				load(widget, data.pagination.page + 1);
			});
			pagination.appendChild(next);
			content.appendChild(pagination);
		}

		var fallback = widget.querySelector('.phpbbgallery-album-embed-fallback');
		if (fallback) {
			fallback.hidden = true;
		}
		widget.appendChild(content);
	}

	function load(widget, page) {
		if (widget.getAttribute('aria-busy') === 'true') {
			return;
		}

		widget.setAttribute('aria-busy', 'true');
		var endpoint = new URL(widget.dataset.endpoint, window.location.href);
		endpoint.searchParams.set('page', Math.max(1, page || 1));

		window.fetch(endpoint.toString(), {
			credentials: 'same-origin',
			headers: {'Accept': 'application/json'}
		}).then(function (response) {
			return response.json().then(function (data) {
				if (!response.ok) {
					throw new Error(data.error || response.statusText);
				}
				return data;
			});
		}).then(function (data) {
			render(widget, data);
		}).catch(function (error) {
			var status = widget.querySelector('.phpbbgallery-album-embed-status');
			if (!status) {
				status = element('p', 'phpbbgallery-album-embed-status');
				widget.appendChild(status);
			}
			status.textContent = error.message;
		}).then(function () {
			widget.removeAttribute('aria-busy');
		});
	}

	function initialize(widget) {
		widget.setAttribute('aria-live', 'polite');
		load(widget, 1);
	}

	var widgets = document.querySelectorAll('.phpbbgallery-album-embed[data-endpoint]');
	if (!widgets.length) {
		return;
	}

	if ('IntersectionObserver' in window) {
		var observer = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					observer.unobserve(entry.target);
					initialize(entry.target);
				}
			});
		}, {rootMargin: '160px'});
		widgets.forEach(function (widget) {
			observer.observe(widget);
		});
	} else {
		widgets.forEach(initialize);
	}
}());
