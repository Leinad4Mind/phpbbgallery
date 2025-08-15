head.ready(function () {
; (function ($, window, document) {
	// do stuff here and use $, window and document safely
	// https://www.phpbb.com/community/viewtopic.php?p=13589106#p13589106

	$('.price-toggler').click(function(){
		$('.price-toggle').hide();
		$($(this).attr('data-price-id')).show();
		$('.btn-huge').prop('disabled', false);
	});
})(jQuery, window, document);
});