jQuery(function($) {
	$('#phpbb').on('click', '.topic-statistics-followers', function(e) {
		e.preventDefault();
		$('#divfollowers').slideToggle();
	}).on('click', '.topic-statistics-bookmarks', function(e) {
		e.preventDefault();
		$('#divbookmark').slideToggle();
	});
});
