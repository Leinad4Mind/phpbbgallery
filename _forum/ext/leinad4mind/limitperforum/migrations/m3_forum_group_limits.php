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

class m3_forum_group_limits extends migration
{
	/**
	 * @return array
	 */
	public function update_schema()
	{
		return [
			'add_tables' => [
				$this->table_prefix . 'limit_posts_forum_groups' => [
					'COLUMNS'		=> [
						'forum_id'		=> ['UINT', 0],
						'group_id'		=> ['UINT', 0],
						'topics'		=> ['UINT', 0],
						'posts'			=> ['UINT', 0],
					],
					'KEYS'				=> [
						'lpfg_unq'		=> ['UNIQUE', ['forum_id', 'group_id']],
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
				$this->table_prefix . 'limit_posts_forum_groups',
			],
		];
	}
}
