<?php

/**
 *
 * @package phpBB Extension - mChat Sticky Footer
 * @copyright (c) 2016 kasimi - https://kasimi.net
 * @license proprietary
 *
 */

namespace kasimi\mchatstickyfooter\migrations;

use phpbb\db\migration\container_aware_migration;

class v1_0_0 extends container_aware_migration
{
	static public function depends_on()
	{
		return array('\dmzx\mchat\migrations\mchat_2_0_0_rc7');
	}

	public function update_data()
	{
		return array(
			array('permission.add', array('u_mchat_sticky_footer', true)),
		);
	}

	public function update_schema()
	{
		return array(
			'add_columns' => array(
				$this->table_prefix . 'users' => array(
					'user_mchat_sticky_footer'	=> array('BOOL', 1),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_columns' => array(
				$this->table_prefix . 'users' => array(
					'user_mchat_sticky_footer',
				),
			),
		);
	}
}
