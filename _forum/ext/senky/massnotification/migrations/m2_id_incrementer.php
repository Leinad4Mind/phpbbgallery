<?php
/**
 *
 * Mass Notification. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Jakub Senko
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace senky\massnotification\migrations;

class m2_id_incrementer extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['senky_massnotification_id']);
	}

	static public function depends_on()
	{
		return ['\senky\massnotification\migrations\m1_acp_module'];
	}

	public function update_data()
	{
		return [
			['config.add', ['senky_massnotification_id', 0]],
		];
	}
}
