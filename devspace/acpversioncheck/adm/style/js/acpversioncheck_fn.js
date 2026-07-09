jQuery(function() {
	$(document).ready(function() {
		$('.toggle').prev().append(' <a href="#" class="toggleLink">'+ showText + '</a>');
		$('.toggle').prev().data('is_visible', true);
		$('.toggle').hide();
		$('a.toggleLink').click(function() {
			$(this).data('is_visible', !$(this).data('is_visible'));
			$(this).html((!$(this).data('is_visible')) ? showText : hideText);
			$(this).parent().next('.toggle').toggle(500);

			return false;
		});
	});
});
