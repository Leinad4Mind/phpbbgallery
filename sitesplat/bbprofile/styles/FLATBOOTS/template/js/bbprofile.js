head.ready(function () {
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
	if (window.location.hash == '#bbprofile_signature') {
		scrollTo($('#postform'), false);
	}
	if (window.location.hash.startsWith('#bbprofile_cpf_')) {
		scrollTo($('label[for="pf_' + window.location.hash.replace('#bbprofile_cpf_', '') + '"]').parent(), true);
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
});