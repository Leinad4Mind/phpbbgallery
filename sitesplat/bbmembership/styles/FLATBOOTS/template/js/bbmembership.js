head.ready(function () {
; (function ($, window, document) {
	// do stuff here and use $, window and document safely
	// https://www.phpbb.com/community/viewtopic.php?p=13589106#p13589106

	$('.price-toggler').click(function(){
		$('.price-toggle').hide();
		$($(this).attr('data-price-id')).show();
		$('.btn-huge').prop('disabled', false);
	});
	
	if (typeof membership_end !== 'undefined')
	{
		if (membership_end === '-1')
		{
			$('#clock').html('Unlimited!')
		} else
		{
			$('#clock').countdown(membership_end).on('update.countdown', function(event)
			{
				var format = '%H:%M:%S';
				if (event.offset.totalDays > 0)
				{
					format = '%-d day%!d ' + format;
				}
				if (event.offset.weeks > 0) 
				{
					format = '%-w week%!w ' + format;
				}
				$(this).html(event.strftime(format));
			}).on('finish.countdown', function(event)
			{
				$(this).html('This offer has expired!').parent().addClass('disabled');
			});
		}
	}
	
})(jQuery, window, document);
});