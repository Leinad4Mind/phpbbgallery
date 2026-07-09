<?php
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

namespace lukewcs\limitreplies\migrations;

class v_1_1_0 extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return ['\lukewcs\limitreplies\migrations\v_1_0_0'];
	}

	public function update_data()
	{
		return [
			['config.add', ['limitreplies_select_time_unit', 'minutes']],
		];
	}
}
