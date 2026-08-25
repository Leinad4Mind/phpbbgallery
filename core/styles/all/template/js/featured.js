(function () {
	'use strict';

	function initCarousel(root) {
		var track = root.querySelector('[data-gallery-featured-track]');
		var slides = Array.prototype.slice.call(root.querySelectorAll('[data-gallery-featured-slide]'));
		if (!track || !slides.length) { return; }
		root.classList.add('is-enhanced');
		var index = 0;
		var timer = null;
		var interval = Math.max(3000, parseInt(root.getAttribute('data-interval'), 10) || 6000);
		var play = root.querySelector('[data-gallery-featured-play]');
		var controls = root.querySelector('.gallery-featured-controls');
		var indicators = Array.prototype.slice.call(root.querySelectorAll('[data-gallery-featured-go]'));
		var reduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
		var playing = root.getAttribute('data-autoplay') === '1' && !reduced;
		var touchStart = null;
		var resizeTimer = null;

		function visibleCount() {
			var count = parseInt(window.getComputedStyle(root).getPropertyValue('--gallery-featured-visible'), 10) || 1;
			return Math.max(1, Math.min(count, slides.length));
		}
		function maximumIndex() {
			return Math.max(0, slides.length - visibleCount());
		}
		function layout() {
			var styles = window.getComputedStyle(track);
			var gap = parseFloat(styles.columnGap || styles.gap) || 0;
			var count = visibleCount();
			var width = Math.max(0, (track.clientWidth - (gap * (count - 1))) / count);
			slides.forEach(function (slide) {
				slide.style.flexBasis = width + 'px';
			});
			return width + gap;
		}
		function show(next, wrap) {
			var maximum = maximumIndex();
			if (wrap !== false && next < 0) { index = maximum; }
			else if (wrap !== false && next > maximum) { index = 0; }
			else { index = Math.max(0, Math.min(next, maximum)); }
			track.style.transform = 'translate3d(-' + (index * layout()) + 'px, 0, 0)';
			var lastVisible = index + visibleCount() - 1;
			slides.forEach(function (slide, position) {
				var visible = position >= index && position <= lastVisible;
				slide.classList.toggle('is-active', visible);
				slide.setAttribute('aria-hidden', visible ? 'false' : 'true');
				slide.querySelectorAll('a, button, input, select, textarea').forEach(function (item) {
					if (visible) { item.removeAttribute('tabindex'); }
					else { item.setAttribute('tabindex', '-1'); }
				});
			});
			indicators.forEach(function (indicator, position) {
				indicator.hidden = position > maximum;
				indicator.classList.toggle('is-active', position === index);
				indicator.setAttribute('aria-current', position === index ? 'true' : 'false');
			});
			if (controls) { controls.hidden = maximum === 0; }
		}
		function schedule() {
			window.clearInterval(timer);
			if (playing && !document.hidden && maximumIndex() > 0) {
				timer = window.setInterval(function () { show(index + 1); }, interval);
			}
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
			if (control.hasAttribute('data-gallery-featured-previous')) { show(index - 1, true); }
			else if (control.hasAttribute('data-gallery-featured-next')) { show(index + 1, true); }
			else if (control.hasAttribute('data-gallery-featured-go')) { show(parseInt(control.getAttribute('data-gallery-featured-go'), 10), false); }
			else { setPlaying(!playing); return; }
			schedule();
		});
		root.addEventListener('keydown', function (event) {
			if (event.key === 'ArrowLeft') { show(index - 1, true); }
			if (event.key === 'ArrowRight') { show(index + 1, true); }
		});
		document.addEventListener('visibilitychange', schedule);
		root.addEventListener('touchstart', function (event) { touchStart = event.changedTouches[0].clientX; }, { passive: true });
		root.addEventListener('touchend', function (event) {
			if (touchStart === null) { return; }
			var distance = event.changedTouches[0].clientX - touchStart;
			if (Math.abs(distance) > 45) { show(index + (distance < 0 ? 1 : -1), true); schedule(); }
			touchStart = null;
		}, { passive: true });
		window.addEventListener('resize', function () {
			window.clearTimeout(resizeTimer);
			resizeTimer = window.setTimeout(function () { show(index, false); schedule(); }, 100);
		});
		show(0, false);
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
				var featured = link.getAttribute('data-featured') !== '1';
				link.setAttribute('data-featured', featured ? '1' : '0');
				link.classList.toggle('active', featured);
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
