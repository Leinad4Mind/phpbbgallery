<?php

/**
 *
 * Forcing Profile Fields. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017, leinad4mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\forcingprofilefields\migrations;

use phpbb\db\migration\migration;

class m1_initial_data extends migration
{
	public function update_data()
	{
		return [
			['config.add', ['forcingprofilefields_skip_metarefresh', 1]],
		];
	}
}
