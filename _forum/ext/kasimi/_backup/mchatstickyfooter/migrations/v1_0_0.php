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
	public static function depends_on()
	{
		return ['\dmzx\mchat\migrations\mchat_2_0_0_rc7'];
	}

	public function update_data()
	{
		return [
			['permission.add', ['u_mchat_sticky_footer', true]],
		];
	}

	public function update_schema()
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'users' => [
					'user_mchat_sticky_footer'	=> ['BOOL', 1],
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_columns' => [
				$this->table_prefix . 'users' => [
					'user_mchat_sticky_footer',
				],
			],
		];
	}
}
