<?php

/**
 *
 * Hide Profile Fields To Groups. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\hideprofilefieldstogroups\migrations;

use phpbb\db\migration\migration;

class m1_add_profilefieldgroups_table extends migration
{
	/**
	 * @return bool
	 */
	public function effectively_installed()
	{
		return $this->db_tools->sql_table_exists($this->table_prefix . 'profile_field_groups');
	}

	/**
	 * @return array
	 */
	public static function depends_on()
	{
		return [
			'\phpbb\db\migration\data\v320\v320',
		];
	}

	/**
	 * @return array
	 */
	public function update_schema()
	{
		return [
			'add_tables' => [
				$this->table_prefix . 'profile_field_groups' => [
					'COLUMNS'		=> [
						'field_id'		=> ['UINT', 0],
						'group_id'		=> ['UINT', 0],
					],
					'KEYS'				=> [
						'pfg_unq'		=> ['UNIQUE', ['field_id', 'group_id']],
					],
				],
			],
		];
	}

	/**
	 * @return array
	 */
	public function revert_schema()
	{
		return [
			'drop_tables' => [
				$this->table_prefix . 'profile_field_groups',
			],
		];
	}
}
