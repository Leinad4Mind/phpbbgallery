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
	public static function depends_on()
	{
		return ['\kasimi\mchatstickyfooter\migrations\v1_0_1'];
	}

	public function update_data()
	{
		return [
			['config.add', ['mchat_sticky_active_users', 1]],
		];
	}

	public function update_schema()
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'users' => [
					'mchat_sticky_width'	=> ['USINT', resize::STICKY_DEFAULT_WIDTH],
					'mchat_sticky_height'	=> ['USINT', resize::STICKY_DEFAULT_HEIGHT],
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_columns' => [
				$this->table_prefix . 'users' => [
					'mchat_sticky_width',
					'mchat_sticky_height',
				],
			],
		];
	}
}
