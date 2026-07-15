jQuery(function() {
	$(document).ready(function()
	{
     	$('.showkey').on('click', function()
		{
     		var key = $(this).attr('key');
			$('#' + key).toggle();
		});

		$('.whois').on('click', function(event)
		{
			var width	= 700;
			var height	= 500;
			var name	= '_whois';
			var url		= $(this).attr('href');

    		event.preventDefault();
    		window.open(url.replace(/&amp;/g, '&'), 'PopupWindow', 'width=' + width + ', height=' + height + ', resizable=yes, scrollbars=yes, name=' + name).focus();
			return false;
		});
  	});
});
