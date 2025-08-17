<?php
/**
*
* @package Special Birthday
* @copyright (c) 2019 Leinad4Mind
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace leinad4mind\specialbirthday\migrations;

use phpbb\db\migration\migration;

class registration_age_required extends migration
{
	public function update_data()
	{
		return [
			['config.add', ['registration_age_required', 0]],
		];
	}
}
