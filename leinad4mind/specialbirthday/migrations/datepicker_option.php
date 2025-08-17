<?php
/**
*
* @package Special Birthday
* @copyright (c) 2016 leinad4mind
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace leinad4mind\specialbirthday\migrations;

use phpbb\db\migration\migration;

class datepicker_option extends migration
{
	public function update_data()
	{
		return [
			['config.add', ['registration_age_datepicker', 0]],
		];
	}
}
