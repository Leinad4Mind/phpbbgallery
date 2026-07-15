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

							$.ajax({
								url		: form.attr('action'),
								data	: form.serialize(),
								dataType: 'json',
								type	: 'POST',
								success: function() {
									inSort = false;
								},
								error: function(jqXHR) {
									inSort = false;
									core.ajaxErrorCode(jqXHR);
								}
							});
						}
					}
				})
				.disableSelection();
		},
		
		triggerAction: function(href, data) {
			var self = this;

			$.ajax({
				url			: href,
				data		: data,
				dataType	: 'json',
				type		: 'POST',
				success		: function(json) {
					if(json.S_CONFIRM_ACTION)
					{
						$(json.MESSAGE_BODY).cbbDialog({
							autoClean: false,
							destroyOnClose: true,
							width: 400,
							onSubmit: function(xdata, obj) {
								xdata.confirm = $(obj).attr('data-confirm');
								self.triggerAction(xdata.form_action, xdata);
							}
						});
						
						return;
					}
					
					if(json.action == 'deleteRow')
					{
						$('#row' + json.rowId).fadeOut();
					}
				},
				error	: function(jqXHR) {
					core.ajaxErrorCode(jqXHR);
				}
			});
		}
	};
	
	chatAcp.init();
})(jQuery, cbbCore);
