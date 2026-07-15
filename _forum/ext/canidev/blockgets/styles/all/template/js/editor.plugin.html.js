/*
* @name editor.plugin.html.js
* @package cBB Blockgets
* @version v2.0.2 12/01/2021 $
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/
(function(e,t){"use strict";cbbEditorWrapper.plugins.html={eventAfterAddButton:function(){if(!this.editor.toolbar.children('[data-code="html"]').length){this.editor.toolbar.append('<button type="button" title="'+t.lang("INSERT_HTML")+'" data-code="html"><i class="fa fa-html5 fa-fw" aria-hidden="true"></i></button>')}},eventAfterAddCommand:function(){if(sceditor.command.get("html")===null){sceditor.command.set("html",{forceNewLineAfter:["code"],exec:function(){this.wysiwygEditorInsertHtml('<code data-sceditor-html="1" data-title="'+t.lang("HTML_TITLE")+'">',(t.browser.msie&&t.browser.version<11?"":"<br />")+"</code>")},txtExec:["[html]","[/html]"],tooltip:"INSERT_HTML"});sceditor.formats.phpbb.set("html",{tags:{code:{"data-sceditor-html":null}},isInline:false,allowedChildren:["#","#newline"],format:"[html]{0}[/html]",html:function(e,n,r,i){return'<code data-sceditor-html="1" data-title="'+t.lang("HTML_TITLE")+'">'+r+"</code>"}});sceditor.icons.phpbb.icons["html"]="fa-html5"}if(e.inArray("html",this.editor.options.toolbar)==-1){var n=this.editor.options.toolbar.lastIndexOf("|");if(n==-1){n=this.editor.options.toolbar.length}this.editor.options.toolbar.splice(n,0,"|","html")}}}})(jQuery,cbbCore);