/**
 * @package cBB Chat
 * @version 1.2.5 20/09/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */
!function(o,n){"use strict";({init:function(){var i=this,t=(o("#page_file").change(function(){var t=o(this).val(),i="viewforum"==t||"viewtopic"==t,t="-"==t;o("dl:has(#forum_ids)").objView(i),o("dl:has(#custom_file), dl:has(#page_alias)").objView(t)}).change(),o(".pagerow-input").click(function(){this.focus(),this.select()}),o(".js-chat-action").click(function(t){i.triggerAction(this.href),t.preventDefault()}),o("form:first")),e=!1;o(".sortable-text ul").sortable({update:function(){e||(e=!0,n.request({url:t.attr("action"),data:t.serialize(),onComplete:function(){e=!1}}))}}).disableSelection()},triggerAction:function(t,i){n.request({url:t,data:i,onSuccess:function(t){"deleteRow"==t.action&&o("#row"+t.rowId).fadeOut()}})}}).init()}(jQuery,cbbCore);