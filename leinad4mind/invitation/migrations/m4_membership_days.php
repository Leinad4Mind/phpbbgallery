<?php

/**
 *
 * Invitation. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2010-2015, KillBill
 * @copyright (c) 2017, kasimi
 * @copyright (c) 2017-2021, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\invitation\migrations;

class m4_membership_days extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return array('\leinad4mind\invitation\migrations\m3_notification_user');
	}

	public function update_data()
	{
		return array(
			array('custom', array(array($this, 'update_invite_config'))),
		);
	}

	public function update_invite_config()
	{
		$insert_values = array(
			array(
				'config_name'	=> 'meghivo_membership_days',
				'config_value'	=> 0,
			),
		);

		$this->db->sql_multi_insert($this->table_prefix . 'invite_config', $insert_values);
	}
}
