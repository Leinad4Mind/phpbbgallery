/**
* @package cBB Chat
* @version 1.2.4 17/06/2022
*
* @copyright (c) 2022 CaniDev
* @license https://creativecommons.org/licenses/by-nc/4.0/
*/
(function(e,t){"use_strict";var n={init:function(){var n=this;e("#page_file").change(function(){var t=e(this).val(),n=t=="viewforum"||t=="viewtopic"?true:false,r=t=="-"?true:false;e("dl:has(#forum_ids)").objView(n);e("dl:has(#custom_file), dl:has(#page_alias)").objView(r)}).change();e(".pagerow-input").click(function(){this.focus();this.select()});e(".js-chat-action").click(function(e){n.triggerAction(this.href);e.preventDefault()});var r=e("form:first"),i=false;e(".sortable-text ul").sortable({update:function(e,n){if(!i){i=true;t.request({url:r.attr("action"),data:r.serialize(),onComplete:function(){i=false}})}}}).disableSelection()},triggerAction:function(n,r){t.request({url:n,data:r,onSuccess:function(t){if(t.action=="deleteRow"){e("#row"+t.rowId).fadeOut()}}})}};n.init()})(jQuery,cbbCore);