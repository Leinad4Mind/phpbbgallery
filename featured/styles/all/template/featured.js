(function () {
	'use strict';

	function initCarousel(root) {
		var slides = Array.prototype.slice.call(root.querySelectorAll('[data-gallery-featured-slide]'));
		if (slides.length < 2) { return; }
		var index = 0;
		var timer = null;
		var interval = Math.max(3000, parseInt(root.getAttribute('data-interval'), 10) || 6000);
		var play = root.querySelector('[data-gallery-featured-play]');
		var reduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
		var playing = root.getAttribute('data-autoplay') === '1' && !reduced;
		var touchStart = null;

		function show(next) {
			index = (next + slides.length) % slides.length;
			slides.forEach(function (slide, position) {
				var active = position === index;
				slide.hidden = !active;
				slide.classList.toggle('is-active', active);
			});
			root.querySelectorAll('[data-gallery-featured-go]').forEach(function (indicator, position) {
				indicator.classList.toggle('is-active', position === index);
				indicator.setAttribute('aria-current', position === index ? 'true' : 'false');
			});
		}
		function schedule() {
			window.clearInterval(timer);
			if (playing && !document.hidden) { timer = window.setInterval(function () { show(index + 1); }, interval); }
		}
		function setPlaying(value) {
			playing = value && !reduced;
			if (play) {
				play.setAttribute('aria-pressed', playing ? 'true' : 'false');
				var icon = play.querySelector('.icon');
				if (icon) { icon.classList.toggle('fa-pause', playing); icon.classList.toggle('fa-play', !playing); }
				var label = play.querySelector('.sr-only');
				if (label) { label.textContent = playing ? play.getAttribute('data-pause-label') : play.getAttribute('data-play-label'); }
			}
			schedule();
		}
		root.addEventListener('click', function (event) {
			var control = event.target.closest('[data-gallery-featured-previous], [data-gallery-featured-next], [data-gallery-featured-go], [data-gallery-featured-play]');
			if (!control) { return; }
			if (control.hasAttribute('data-gallery-featured-previous')) { show(index - 1); }
			else if (control.hasAttribute('data-gallery-featured-next')) { show(index + 1); }
			else if (control.hasAttribute('data-gallery-featured-go')) { show(parseInt(control.getAttribute('data-gallery-featured-go'), 10)); }
			else { setPlaying(!playing); return; }
			schedule();
		});
		root.addEventListener('keydown', function (event) {
			if (event.key === 'ArrowLeft') { show(index - 1); }
			if (event.key === 'ArrowRight') { show(index + 1); }
		});
		document.addEventListener('visibilitychange', schedule);
		root.addEventListener('touchstart', function (event) { touchStart = event.changedTouches[0].clientX; }, { passive: true });
		root.addEventListener('touchend', function (event) {
			if (touchStart === null) { return; }
			var distance = event.changedTouches[0].clientX - touchStart;
			if (Math.abs(distance) > 45) { show(index + (distance < 0 ? 1 : -1)); schedule(); }
			touchStart = null;
		}, { passive: true });
		show(0);
		schedule();
	}

	function toggleFeatured(link) {
		if (link.getAttribute('aria-busy') === 'true') { return; }
		link.setAttribute('aria-busy', 'true');
		fetch(link.href, { credentials: 'same-origin', headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
			.then(function (response) { if (!response.ok) { throw new Error(); } return response.json(); })
			.then(function (payload) {
				if (!payload || payload.S_CONFIRM_ACTION) { throw new Error(); }
				var oldUrl = link.href;
				var oldText = link.title;
				link.href = link.getAttribute('data-toggle-url');
				link.setAttribute('data-toggle-url', oldUrl);
				link.title = link.getAttribute('data-toggle-text');
				link.setAttribute('data-toggle-text', oldText);
				link.setAttribute('data-featured', link.getAttribute('data-featured') === '1' ? '0' : '1');
			})
			.catch(function () { window.location.assign(link.href); })
			.then(function () { link.removeAttribute('aria-busy'); });
	}

	document.addEventListener('DOMContentLoaded', function () {
		document.querySelectorAll('[data-gallery-featured]').forEach(initCarousel);
	});
	document.addEventListener('click', function (event) {
		var link = event.target.closest('[data-gallery-featured-toggle]');
		if (!link) { return; }
		event.preventDefault();
		toggleFeatured(link);
	});
}());
