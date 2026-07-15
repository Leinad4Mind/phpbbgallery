head.ready(function () {

var prefixstarter = {
    init: function() {
	
	// Make divs sortable
		$("#available_prefixes, #used_prefixes").sortable({
		    connectWith: '.prefixed_sortable',
		    items: 'li',
			helper: 'clone', // Fixes onclick weird behavior on firefox
		    forcePlaceholderSize: true,
		    placeholder: 'ui-sortable-placeholder',
		    tolerance: 'pointer',
			
		//	over: function() {
		//	$('.placeholder').hide();
		//	},
		//	out: function() {
		//		$('.placeholder').show();
		//	},
		//	stop: function() {
		//		$('.placeholder').remove();
		//	},
			
	        receive: function(event, ui) {
	//  Handle filling in the tokens
			var ul = $(this).closest('ul.prefixed_sortable');
		}
	}).disableSelection()
	//  lets make it easier and append prefix on click as well
	  .on('click', '.click_area', function(){
				$(this).appendTo($("#available_prefixes, #used_prefixes").not($(this).closest("ul")));
		});

	
    }	
	
}	

$(function() {
	prefixstarter.init();
});

    $('#postform').submit(function() {
	    var input = $("<input>").attr("type", "hidden").attr("name", "prefixes_used").val($('#used_prefixes').sortable('serialize'));
		console.log($('#used_prefixes').sortable('serialize'));
	//  console.log( $( this ).serialize() );
		$('#postform').append($(input));
		
	});

	$("[data-toggle='toggle']").click(function() {
		var selector = $(this).data("target");
		$(selector).toggleClass('in');
		$( '.prefix-popover' ).toggleClass('is-visible');
	});
	
});
