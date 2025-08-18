/**
*
* Limit Multiple Replies. An extension for the phpBB Forum Software package.
*
* @copyright (c) 2024, LukeWCS, https://github.com/LukeWCS
* @license GNU General Public License, version 2 (GPL-2.0-only)
*
* Note: This extension is 100% genuine handcraft and consists of selected
*       natural raw materials. There was no AI involved in making it.
*
*/

(function ($) {

'use strict';

const HintModeOnClick	= 1;
const HintModeAlways	= 2;

$(function () {
	$('a[href*="mode=quote"],a[href*="mode=reply"]').on('click', function (e) {
		e.preventDefault();
		if (limitreplies.HintMode == HintModeOnClick) {
			phpbb.alert(limitreplies.MessageTitle, limitreplies.MessageText);
		}
	});

	if (limitreplies.HintMode == HintModeAlways) {
		$('a[href*="mode=quote"],a[href*="mode=reply"]').addClass('limitreplies_lock');
	};
});

})(jQuery);
