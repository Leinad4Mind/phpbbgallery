head.ready(function () {
	(function ($) {
		// Avoid conflicts with other libraries
		'use strict';

		// some quick and simple tricks
		$('#custom_message').focusin(function () {
			$('.counter-pos').css('display', 'inline-block');
		});
		$('#custom_message').focusout(function () {
			$('.counter-pos').css('display', 'none');
		});

		// Fix the counter bug once exeeeded functions below is triggered and page reloaded keeping the btn disabled
		$('.btn-bbdonation').prop('disabled', false);

		$('.dcount').characterCounter({
			counterFormat: '%1/80',
			limit: 80,
			counterCssClass: 'counter-pos',
			counterExceededCssClass: 'exceeded',
			onExceed: function (count) {
				$('.btn-bbdonation').prop('disabled', true);
			},
			onDeceed: function (count) {
				$('.btn-bbdonation').prop('disabled', false);
			},
		});
	})(jQuery); // Avoid conflicts with other libraries
});
