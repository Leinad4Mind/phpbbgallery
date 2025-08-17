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

class m2_alter_collation extends migration
{
	/**
	 * @return array
	 */
	public static function depends_on()
	{
		return [
			'\leinad4mind\profilefieldsearchable\migrations\m1_initial_schema',
		];
	}

	/**
	 * @return array
	 */
	public function update_data()
	{
		return [
			['custom', [[$this, 'alter_collation']]],
		];
	}

	/**
	 *
	 */
	public function alter_collation()
	{
		$this->db->sql_query('ALTER TABLE ' . $this->table_prefix . 'profile_fields_data CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci');
	}
}
