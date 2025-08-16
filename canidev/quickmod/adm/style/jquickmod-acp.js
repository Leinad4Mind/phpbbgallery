/*
* @name jquickmod-acp.js
* @package cBB QuickMod
* @version v1.1.0 17/01/2017 $
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
var jQM=jQuery;

jQM(function(e){e.fn.help_icon=function(t,n){var r=e("<a></a>");r.attr("href",n).attr("title",t).css("opacity",.4).addClass("qm-help").click(function(e){window.open(this.href);e.preventDefault()}).hover(function(){e(this).css("opacity",1)},function(){e(this).css("opacity",.4)});e(this).append(r)};e(".qm_drag_row").sortable({connectWith:".qm_drag_row"}).disableSelection().bind("sortreceive",function(t,n){e(this).find(".qm_draggable").each(function(t){e(this).children("input[type=hidden]").attr("name",e(this).parent().attr("id")+"[]")})});e("input[type=text], select, textarea").addClass("qm_inputbox");if(window.__jQM&&window.__jQM.help_url){e("#content").help_icon(window.__jQM.help_title,window.__jQM.help_url)}});