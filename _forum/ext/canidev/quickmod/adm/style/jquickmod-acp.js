/*
* @package cBB QuickMod
* @version v1.1.2 01/03/2020
*
* @copyright (c) 2020 CaniDev
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