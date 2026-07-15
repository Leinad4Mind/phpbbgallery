head.ready(function() {
	(function($) { // Avoid conflicts with other libraries

		'use strict';

		// Get the collapsible element (has class .topiclist.forums OR .collapsible)
		$.fn.getCollapsible = function(opt) {
			if(opt)
				return this.next('.panel').find('table tbody');
			else
				return this.closest('.panel').find('table tbody');
		};

		$('a.collapse-btn').each(function() {
			var $this = $(this),
				hidden = $this.attr('data-hidden'),
				$content = $this.getCollapsible(true),
				category = $this.next('.panel').find('table thead th:last-child'),
				position = 'append';

			// Return if no collapsible content could be found
			if (!$content.length) {
				return;
			}

			// Unhide the collapse buttons (makes them JS dependent)
			$this.show();

			// Hide hidden forums on load
			if (hidden) {
				$content.hide();
			}

			category[position].apply(category, [$this]);
		});

		phpbb.addAjaxCallback('phpbb_collapse', function(res) {
			if (res.success) {
				var oldTitle = $(this).attr('title'),
					newTitle = $(this).attr('data-title-alt');
				$(this)
					.attr({'title': newTitle, 'data-title-alt': oldTitle})
					.find('i')
					.toggleClass('fa-plus fa-minus')
					.end()
					.getCollapsible(false)
					.stop(true, true)
					.slideToggle('fast')
				;
			}
		});

	})(jQuery); // Avoid conflicts with other libraries
});
