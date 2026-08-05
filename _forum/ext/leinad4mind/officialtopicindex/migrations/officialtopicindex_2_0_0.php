<?php
/**
 *
 * @package phpBB Extension - Official Topic Index
 * @copyright (c) 2015-2022 Leinad4Mind - https://leinad4mind.top/forum
 * @copyright (c) 2015 dmzx - https://www.dmzx-web.net
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace leinad4mind\officialtopicindex\migrations;

class officialtopicindex_2_0_0 extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return [
			'\leinad4mind\officialtopicindex\migrations\officialtopicindex_1_0_3',
			'\leinad4mind\officialtopicindex\migrations\officialtopicindex_module',
			'\leinad4mind\officialtopicindex\migrations\officialtopicindex_schema',
		];
	}

	public function effectively_installed()
	{
		return $this->db_tools->sql_column_exists($this->table_prefix . 'forums', 'topicindex_display_mode')
			&& isset($this->config['officialtopicindex_max_topics'])
			&& isset($this->config['officialtopicindex_new_topic_forum']);
	}

	public function update_schema()
	{
		if ($this->db_tools->sql_column_exists($this->table_prefix . 'forums', 'topicindex_display_mode'))
		{
			return [];
		}

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
		if (!$this->db_tools->sql_column_exists($this->table_prefix . 'forums', 'topicindex_display_mode'))
		{
			return [];
		}

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
			['custom', [[$this, 'preserve_legacy_display_mode']]],
			['custom', [[$this, 'migrate_legacy_settings']]],
		];
	}

	public function preserve_legacy_display_mode()
	{
		if (isset($this->config['topicindex_max_topics']))
		{
			return;
		}

		$sql = 'UPDATE ' . $this->table_prefix . 'forums'
			. ' SET topicindex_display_mode = \'replace\''
			. ' WHERE post_index > 0';
		$this->db->sql_query($sql);
	}

	public function migrate_legacy_settings()
	{
		if (!isset($this->config['officialtopicindex_max_topics']))
		{
			$value = isset($this->config['topicindex_max_topics']) ? (int) $this->config['topicindex_max_topics'] : 1000;
			$this->config->set('officialtopicindex_max_topics', max(1, min(5000, $value)));
		}

		if (!isset($this->config['officialtopicindex_new_topic_forum']))
		{
			$value = isset($this->config['topicindex_new_topic_forum']) ? (int) $this->config['topicindex_new_topic_forum'] : 0;
			$this->config->set('officialtopicindex_new_topic_forum', max(0, $value));
		}
	}
}
