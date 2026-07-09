/**
 * @package cBB Chat
 * @version 1.2.7 10/03/2025
 *
 * @copyright (c) 2025 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */
((t,e)=>{t("#page_file").change(function(){var e=t(this).val(),i="viewforum"==e||"viewtopic"==e,e="-"==e;t("dl:has(#forum_ids)").objView(i),t("dl:has(#custom_file), dl:has(#page_alias)").objView(e)}).change(),t(".pagerow-input").click(function(){this.focus(),this.select()});var i=t("form:first"),a=!1;t(".sortable-text ul").sortable({update:function(){a||(a=!0,e.request({url:i.attr("action"),data:i.serialize(),onComplete:function(){a=!1}}))}}).disableSelection()})(jQuery,cbbCore);