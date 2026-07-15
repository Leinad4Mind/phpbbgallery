/*
* @package cBB QuickMod
* @version v1.1.3 16/04/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

(function($) {
	'use_strict';

	$('.qm-drag-row')
		.sortable({
			connectWith: '.qm-drag-row',
			receive: function(e, ui) {
				ui.item.children('input[type=hidden]').attr('name', $(this).attr('id') + '[]');
			}
		})
		.disableSelection();
})(jQuery);