; (function ($, window, document) {

	$('.row').bind('mouseenter', function(){
		var $this = $(this);

		if(this.offsetWidth < this.scrollWidth && !$this.attr('title')){
			$this.attr('title', $this.text());
		}
	});

	var sortable_el = document.getElementById('bbprefix_sortable');
	if (sortable_el && typeof Sortable !== 'undefined') {
		var sortable = Sortable.create(sortable_el, {
			handle: '.bbprefix-drag-handle',
			ghostClass: 'ui-sortable-placeholder'
		});

		var order_field = document.getElementById('bbprefix_order');
		var form = sortable_el.closest('form');
		if (order_field && form) {
			// Written on every submit of this form, not just the reorder
			// button - harmless when "add" is what was clicked, since the
			// server only reads this field when submit_reorder is present.
			form.addEventListener('submit', function () {
				order_field.value = sortable.toArray().join(',');
			});
		}
	}

})(jQuery, window, document);
