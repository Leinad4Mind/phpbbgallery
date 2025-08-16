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

class m4_time_limit extends migration
{
	/**
	 * @return array
	 */
	public static function depends_on()
	{
		return ['\leinad4mind\limitperforum\migrations\m3_forum_group_limits'];
	}

	/**
	 * @return array
	 */
	public function update_schema()
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'forums' => [
					'forum_topic_time_limit'	=> ['UINT', 0],
					'forum_post_time_limit'		=> ['UINT', 0],
				],
				$this->table_prefix . 'limit_posts_forum_groups' => [
					'topic_time_limit'			=> ['UINT', 0],
					'post_time_limit'			=> ['UINT', 0],
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
					'forum_topic_time_limit',
					'forum_post_time_limit',
				],
			$this->table_prefix . 'limit_posts_forum_groups' => [
					'topic_time_limit',
					'post_time_limit',
				],
			],
		];
	}
}
