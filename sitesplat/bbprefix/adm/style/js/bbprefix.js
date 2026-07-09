; (function ($, window, document) {

	$('.row').bind('mouseenter', function(){
		var $this = $(this);
	
		if(this.offsetWidth < this.scrollWidth && !$this.attr('title')){
			$this.attr('title', $this.text());
		}
	});

})(jQuery, window, document);
