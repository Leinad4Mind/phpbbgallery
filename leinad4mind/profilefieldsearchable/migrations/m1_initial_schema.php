<?php

/**
 *
 * Profile Field Searchable. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\profilefieldsearchable\migrations;

use phpbb\db\migration\migration;

class m1_initial_schema extends migration
{
	/**
	 * @return bool
	 */
	public function effectively_installed()
	{
		return $this->db_tools->sql_column_exists($this->table_prefix . 'profile_fields', 'field_searchable');
	}

	/**
	 * @return array
	 */
	public static function depends_on()
	{
		return [
			'\phpbb\db\migration\data\v32x\v322',
		];
	}

	/**
	 * @return array
	 */
	public function update_schema()
	{
		return [
			'add_columns'	=> [
				$this->table_prefix . 'profile_fields' => [
					'field_searchable' => ['BOOL', 0],
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
			'drop_columns'	=> [
				$this->table_prefix . 'profile_fields' => [
					'field_searchable',
				],
			],
		];
	}
}
