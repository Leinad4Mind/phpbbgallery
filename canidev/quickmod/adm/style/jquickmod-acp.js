/*
* @name jquickmod-acp.js
* @package cBB QuickMod
* @version v1.1.1 25/03/2019 $
*
* @copyright (c) 2019 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/
(function(e){"use_strict";e(".qm_drag_row").sortable({connectWith:".qm_drag_row",receive:function(t,n){n.item.children("input[type=hidden]").attr("name",e(this).attr("id")+"[]")}}).disableSelection()})(jQuery);