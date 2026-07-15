<?php

/**
 *
 * Special Topic Move. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\specialtopicmove\migrations;

use phpbb\db\migration\migration;

class m1_topic_schema extends migration
{
	/**
	 * @return bool
	 */
	public function effectively_installed()
	{
		return $this->db_tools->sql_column_exists($this->table_prefix . 'topics', 'topic_moved_reason');
	}

	/**
	 * @return array
	 */
	public static function depends_on()
	{
		return ['\phpbb\db\migration\data\v320\v320'];
	}

	/**
	 * @return array
	 */
	public function update_schema()
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'topics' => [
					'topic_moved_from'			=> ['UINT', 0],
					'topic_moved_user'			=> ['UINT', 0],
					'topic_moved_time'			=> ['TIMESTAMP', 0],
					'topic_moved_last_post_id'	=> ['UINT', 0],
					'topic_moved_reason'		=> ['VCHAR', ''],
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
				$this->table_prefix . 'topics' => [
					'topic_moved_from',
					'topic_moved_user',
					'topic_moved_time',
					'topic_moved_last_post_id',
					'topic_moved_reason',
				],
			],
		];
	}
}
