; (function ($, window, document) {
	// do stuff here and use $, window and document safely
	// https://www.phpbb.com/community/viewtopic.php?p=13589106#p13589106
	
	$(function(){
		$('#bblightbox_plugin').on('change', function(){
			$('#captions_options, #fancybox_options, #Chocolat_options').hide();
			$('#slide_options').show();
	
			switch ($(this).val())
			{
				case 'baguetteBox':
					$('#captions_options').show();
				break;
	
				case 'jsOnlyLightbox':
					$('#captions_options').show();
				break;
	
				case 'fancybox':
					$('#fancybox_options').show();
				break;
	
				case 'Chocolat':
					$('#Chocolat_options').show();
				break;
	
				case 'lightgallery':
					$('#slide_options').hide();
					$('#lightgallery_options').show();
				break;
			}
			switch_layout();
		});
	});

	$("input:radio[name='bblightbox[bbcode_allow]']").on("change", function() {
	if ($('#bblightbox_bbcode_allow').prop('checked') === true)
		{
			$('#Quoted_images').css('display', 'block');
			$('#Resize_images').css('display', 'block');
		} else
		{
			$('#Quoted_images').css('display', 'none');
			$('#Resize_images').css('display', 'none');
		}
	});

	$("input:radio[name='bblightbox[collums]']").on("change", function() {
		switch_layout();
	});

	function switch_layout()
	{
		var col = $("input:radio[name='bblightbox[collums]']:checked").val();
		if ($('#bblightbox_plugin').val() !== '------')
		{
			if (col == 0)
			{
				$('.aboximg').removeClass('small');
				$('.aboximg').removeClass('medium');
				$('.aboximg').removeClass('columnreg');
			}
			
			if (col > 0) $('.aboximg').addClass('columnreg');
			if (col == 1)
			{
				$('.aboximg').removeClass('small');
				$('.aboximg').removeClass('medium');
				
			} else if (col == 2)
			{
				$('.aboximg').addClass('medium');
				$('.aboximg').removeClass('small');
			} else if (col == 3)
			{
				$('.aboximg').removeClass('medium');
				$('.aboximg').addClass('small');
			}
		} else
		{
			$('.aboximg').removeClass('small');
			$('.aboximg').removeClass('medium');
			$('.aboximg').removeClass('columnreg');
		}
	}


})(jQuery, window, document);

phpbb.addAjaxCallback('bblightbox_multistep', function(res) {
	function next_call(url) {
		$.getJSON(url, function(data) {
			if (data.S_USER_NOTICE) {
				phpbb.alert(data.MESSAGE_TITLE, data.MESSAGE_TEXT);
			}
			phpbb.alert(data.PROGRESS);
			next_call(data.NEXT_URL);
		});
	}

	next_call(res.NEXT_URL);
});
