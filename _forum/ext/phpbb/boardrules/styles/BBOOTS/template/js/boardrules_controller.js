head.ready(function () {
$(function() {

  'use strict';

	// Function to apply highlight class to an element identifier
	var highlight = function (id) {
		$('#' + decodeURIComponent(id)).addClass('bg-info');
	};

	// Apply highlight to clicked rule anchor
	$('.rule-anchor').on('click', function () {
		$('li').removeClass('bg-info');
		highlight($(this).closest('.rule-item').attr('id'));
	});

	// Apply highlight on page load to a rule category
	highlight(window.location.hash.substring(1));
});
});