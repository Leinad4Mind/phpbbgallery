(function($, core) {
	'use_strict';
	
	var chatAcp = {
		init: function() {
			var self = this;

			$('#page_file')
				.change(function() {
					var file 	= $(this).val(),
						state1	= (file == 'viewforum' || file == 'viewtopic') ? true : false,
						state2	= (file == '-') ? true : false;
						
					$('dl:has(#forum_ids)').objView(state1);
					$('dl:has(#custom_file), dl:has(#page_alias)').objView(state2);
				})
				.change();
				
			$('.pagerow-input').click(function() {
				this.focus();
				this.select();
			});

			$('.js-chat-action').click(function(e) {
				self.triggerAction(this.href);
				e.preventDefault();
			});
			
			var form 	= $('form:first'),
				inSort	= false;

			$('.sortable-text ul')
				.sortable({
					update: function(event, ui) {
						if(!inSort)
						{
							inSort = true;

							core.request({
								url: form.attr('action'),
								data: form.serialize(),
								onComplete: function() {
									inSort = false;
								}
							});
						}
					}
				})
				.disableSelection();
		},
		
		triggerAction: function(href, data) {
			core.request({
				url: href,
				data: data,
				onSuccess: function(json) {
					if(json.action == 'deleteRow')
					{
						$('#row' + json.rowId).fadeOut();
					}
				}
			});
		}
	};
	
	chatAcp.init();
})(jQuery, cbbCore);
