<?php

/**
 *
 * Limit Posts and Topics per Forum. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019-2020, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\limitperforum\migrations;

use phpbb\db\migration\migration;

class m2_initial_schema extends migration
{
	/**
	 * @return array
	 */
	public static function depends_on()
	{
		return ['\leinad4mind\limitperforum\migrations\m1_initial_data'];
	}

	/**
	 * @return bool
	 */
	public function effectively_installed()
	{
		return $this->db_tools->sql_column_exists($this->table_prefix . 'forums', 'forum_topic_limit') && $this->db_tools->sql_column_exists($this->table_prefix . 'forums', 'forum_post_limit');
	}

	/**
	 * @return array
	 */
	public function update_schema()
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'forums' => [
					'forum_topic_limit' => ['UINT', 0],
					'forum_post_limit' => ['UINT', 0],
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
			'drop_columns' => [
				$this->table_prefix . 'forums' => [
					'forum_topic_limit',
					'forum_post_limit',
				],
			],
		];
	}
}
