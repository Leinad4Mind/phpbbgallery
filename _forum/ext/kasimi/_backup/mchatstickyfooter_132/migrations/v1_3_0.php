<?php

/**
 *
 * @package phpBB Extension - mChat Sticky Footer
 * @copyright (c) 2016 kasimi - https://kasimi.net
 * @license proprietary
 *
 */

namespace kasimi\mchatstickyfooter\migrations;

use kasimi\mchatstickyfooter\controller\resize;
use phpbb\db\migration\migration;

class v1_3_0 extends migration
{
	static public function depends_on()
	{
		return array('\kasimi\mchatstickyfooter\migrations\v1_0_1');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('mchat_sticky_active_users', 1)),
		);
	}

	public function update_schema()
	{
		return array(
			'add_columns' => array(
				$this->table_prefix . 'users' => array(
					'mchat_sticky_width'	=> array('USINT', resize::STICKY_DEFAULT_WIDTH),
					'mchat_sticky_height'	=> array('USINT', resize::STICKY_DEFAULT_HEIGHT),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_columns' => array(
				$this->table_prefix . 'users' => array(
					'mchat_sticky_width',
					'mchat_sticky_height',
				),
			),
		);
	}
}
