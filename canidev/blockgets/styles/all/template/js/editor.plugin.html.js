(function($, core) {
	'use strict';

	cbbEditorWrapper.plugins.html = {
		eventAfterAddButton: function() {
			if(!this.editor.toolbar.children('[data-code="html"]').length)
			{
				this.editor.toolbar.append('<button type="button" title="' + core.lang('INSERT_HTML') + '" data-code="html"><i class="fa fa-html5 fa-fw" aria-hidden="true"></i></button>');
			}
		},

		eventAfterAddCommand: function() {
			if(sceditor.command.get('html') === null)
			{
				sceditor.command.set('html', {
					forceNewLineAfter: ['code'],
					exec: function () {
						this.wysiwygEditorInsertHtml(
							'<code data-sceditor-html="1" data-title="' + core.lang('HTML_TITLE') + '">',
							((core.browser.msie && core.browser.version < 11) ? '' : '<br />') + '</code>'
						);
					},
					txtExec: ['[html]', '[/html]'],
					tooltip: 'INSERT_HTML'
				});

				sceditor.formats.phpbb.set('html', {
					tags: {
						code: {
							'data-sceditor-html': null
						}
					},
					isInline: false,
					allowedChildren: ['#', '#newline'],
					format: '[html]{0}[/html]',
					html: function(base, token, attrs) {
						return '<code data-sceditor-html="1" data-title="' + core.lang('HTML_TITLE') + '">' + attrs + '</code>';
					}
				});

				sceditor.icons.phpbb.icons['html'] = 'fa-html5';
			}

			if($.inArray('html', this.editor.options.toolbar) == -1)
			{
				var lastSeparator = this.editor.options.toolbar.lastIndexOf('|');

				if(lastSeparator == -1)
				{
					lastSeparator = this.editor.options.toolbar.length;
				}

				this.editor.options.toolbar.splice(lastSeparator, 0, '|', 'html');
			}
		}
	};
})(jQuery, cbbCore);