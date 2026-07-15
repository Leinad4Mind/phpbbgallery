(function($) {
	$(function() {
		$('#usernames').on('input change keyup paste', function() {
			$('#group').parents('dl').toggle(!this.value);
		})
	});
})(jQuery);
