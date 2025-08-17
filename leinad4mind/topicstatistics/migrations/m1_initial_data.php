<?php

/**
 *
 * Topic Statistics. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\topicstatistics\migrations;

use phpbb\db\migration\migration;

class m1_initial_data extends migration
{
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
	public function update_data()
	{
		return [
			['config.add', ['topics_display_statistics', 1]],
			['config.add', ['topics_display_visit', 1]],
			['config.add', ['topics_display_bookmarks', 1]],
			['config.add', ['topics_display_bookmarks_users', 1]],
			['config.add', ['topics_display_followers', 1]],
			['config.add', ['topics_display_followers_users', 1]],
		];
	}
}
