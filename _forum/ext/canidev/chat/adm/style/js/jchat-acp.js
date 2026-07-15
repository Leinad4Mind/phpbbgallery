/*
* @name jchat-acp.js
* @package cBB Chat
* @version v1.2.1 01/02/2020 $
*
* @copyright (c) 2020 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/
(function(e,t){"use_strict";var n={init:function(){var n=this;e("#page_file").change(function(){var t=e(this).val(),n=t=="viewforum"||t=="viewtopic"?true:false,r=t=="-"?true:false;e("dl:has(#forum_ids)").objView(n);e("dl:has(#custom_file), dl:has(#page_alias)").objView(r)}).change();e(".pagerow-input").click(function(){this.focus();this.select()});e(".js-chat-action").click(function(e){n.triggerAction(this.href);e.preventDefault()});var r=e("form:first"),i=false;e(".sortable-text ul").sortable({update:function(e,n){if(!i){i=true;t.request({url:r.attr("action"),data:r.serialize(),onComplete:function(){i=false}})}}}).disableSelection()},triggerAction:function(n,r){t.request({url:n,data:r,onSuccess:function(t){if(t.action=="deleteRow"){e("#row"+t.rowId).fadeOut()}}})}};n.init()})(jQuery,cbbCore);