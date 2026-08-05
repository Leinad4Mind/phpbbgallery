<?php
/**
 *
 * @package phpBB Extension - Who Visited This Topic
 * @copyright (c) 2016 dmzx - https://www.dmzx-web.net
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 *
 */

namespace dmzx\whovisitedthistopic\migrations;

use phpbb\db\migration\migration;

class whovisitedthistopic_1_1_0_schema extends migration
{
	static public function depends_on()
	{
		return ['\dmzx\whovisitedthistopic\migrations\whovisitedthistopic_1_1_0_data'];
	}

	public function update_schema()
	{
		$table = $this->table_prefix . 'whovisitedthistopic';

		return [
			'add_unique_index' => [
				$table => ['user_topic' => ['user_id', 'topic_id']],
			],
			'add_index' => [
				$table => [
					'topic_date' => ['topic_id', 'date'],
					'user_date' => ['user_id', 'date'],
				],
			],
		];
	}

	public function revert_schema()
	{
		$table = $this->table_prefix . 'whovisitedthistopic';

		return [
			'drop_keys' => [
				$table => ['user_topic', 'topic_date', 'user_date'],
			],
		];
	}
}
