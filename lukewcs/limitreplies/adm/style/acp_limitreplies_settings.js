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

	const constants = Object.freeze({
		OpacityEnabled	: '1.0',
		OpacityDisabled	: '0.35',
	});

	function setState() {
		dimOptionGroup('[name="limitreplies_number_wait_time"]', !$('[name="limitreplies_switch_enable"]').prop('checked'));
		dimOptionGroup('[name="limitreplies_select_hint_mode"]', !$('[name="limitreplies_switch_enable"]').prop('checked'));
	};

	function dimOptionGroup(selector, dimCondition) {
		const c = constants;

		$(selector).parents('dl').css('opacity', dimCondition ? c.OpacityDisabled : c.OpacityEnabled);
	}

	function formReset() {
		setTimeout(function() {
			setState();
		});
	};

	function disableEnter(e) {
		if (e.key == 'Enter' && e.target.type != 'textarea') {
			return false;
		}
	};

	$(function() {
		setState();

		$('#limitreplies_settings')				.on('keypress'	, disableEnter);
		$('#limitreplies_settings')				.on('reset'		, formReset);
		$('[name="limitreplies_switch_enable"]').on('change'	, setState);
	});
})(jQuery);
