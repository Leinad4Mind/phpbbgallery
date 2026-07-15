/**
 * @package cBB Chat
 * @version 1.2.6 01/07/2024
 *
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */
!function(i,e){"use strict";i("#page_file").change(function(){var e=i(this).val(),t="viewforum"==e||"viewtopic"==e,e="-"==e;i("dl:has(#forum_ids)").objView(t),i("dl:has(#custom_file), dl:has(#page_alias)").objView(e)}).change(),i(".pagerow-input").click(function(){this.focus(),this.select()});var t=i("form:first"),a=!1;i(".sortable-text ul").sortable({update:function(){a||(a=!0,e.request({url:t.attr("action"),data:t.serialize(),onComplete:function(){a=!1}}))}}).disableSelection()}(jQuery,cbbCore);