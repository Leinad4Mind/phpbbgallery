$(document).on('ready', function(){
	if (window.location.hash.indexOf('bbprofile_') !== -1) {
		$('#bbprofile_box').hide();
	}
});

$(window).on('load hashchange', function(){
	if (window.location.hash == '#bbprofile_avatar') {
		scrollTo($('#ucp'), false);
	}
	if (window.location.hash == '#bbprofile_birtdate') {
		scrollTo($('label[for="bday_day"]').first().parent(), true);
	}
	if (window.location.hash == '#bbprofile_facebook') {
		scrollTo($('label[for="pf_phpbb_facebook"]').parent(), true);
	}
	if (window.location.hash == '#bbprofile_googleplus') {
		scrollTo($('label[for="pf_phpbb_googleplus"]').parent(), true);
	}
	if (window.location.hash == '#bbprofile_signature') {
		scrollTo($('#postform'), false);
	}
	if (window.location.hash == '#bbprofile_skype') {
		scrollTo($('label[for="pf_phpbb_skype"]').parent(), true);
	}
	if (window.location.hash == '#bbprofile_twitter') {
		scrollTo($('label[for="pf_phpbb_twitter"]').parent(), true);
	}
	if (window.location.hash == '#bbprofile_youtube') {
		scrollTo($('label[for="pf_phpbb_youtube"]').parent(), true);
	}

	function scrollTo($element, highlight)
	{
		if (highlight) {
			$element.css({
				backgroundColor: '#ddd',
			});
		}
		$element.css({
			transition: 'background-color 1s'
		});

		$('html, body').animate({
			scrollTop: $element.offset().top
		}, 1000, 'swing', function(){
			if (highlight) {
				$element.css({
					backgroundColor: '#eee',
				});
			}
		});
	}
});
