<?php
/**
 *
 * @package phpBB Extension - Topic Index
 * @copyright (c) 2015 dmzx - https://www.dmzx-web.net
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace dmzx\topicindex\migrations;

class topicindex_2_0_0 extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return [
			'\dmzx\topicindex\migrations\topicindex_1_0_5',
		];
	}

	public function update_schema()
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'forums' => [
					'topicindex_display_mode' => ['VCHAR:8', 'after'],
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_columns' => [
				$this->table_prefix . 'forums' => [
					'topicindex_display_mode',
				],
			],
		];
	}

	public function update_data()
	{
		return [
			['config.add', ['topicindex_max_topics', 1000]],
			['config.add', ['topicindex_new_topic_forum', 0]],
			['config.remove', ['topicindex_version']],
			['custom', [[$this, 'preserve_legacy_display_mode']]],
		];
	}

	public function preserve_legacy_display_mode()
	{
		$sql = 'UPDATE ' . $this->table_prefix . "forums
			SET topicindex_display_mode = 'replace'
			WHERE post_index > 0";
		$this->db->sql_query($sql);
	}
}
