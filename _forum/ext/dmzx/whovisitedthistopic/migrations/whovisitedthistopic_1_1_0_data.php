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

class whovisitedthistopic_1_1_0_data extends migration
{
	const BATCH_SIZE = 250;
	const MAX_VISITS = 16777215;

	static public function depends_on()
	{
		return ['\dmzx\whovisitedthistopic\migrations\whovisitedthistopic_1_0_9'];
	}

	public function update_data()
	{
		return [
			['config.add', ['whovisitedthistopic_retention_days', 0]],
			['config.add', ['whovisitedthistopic_prune_last_gc', 0, true]],
			['config.remove', ['whovisitedthistopic_version']],
			['permission.permission_unset', ['REGISTERED', 'u_whovisitedthistopic_profile', 'group']],
			['custom', [[$this, 'remove_orphans']]],
			['custom', [[$this, 'deduplicate_visits']]],
		];
	}

	public function remove_orphans()
	{
		$table = $this->table_prefix . 'whovisitedthistopic';
		$sql = 'DELETE FROM ' . $table . '
			WHERE user_id NOT IN (SELECT user_id FROM ' . USERS_TABLE . ')
				OR topic_id NOT IN (SELECT topic_id FROM ' . TOPICS_TABLE . ')';
		$this->db->sql_query($sql);
	}

	public function deduplicate_visits($state)
	{
		$last_user = isset($state['user_id']) ? (int) $state['user_id'] : 0;
		$last_topic = isset($state['topic_id']) ? (int) $state['topic_id'] : 0;
		$table = $this->table_prefix . 'whovisitedthistopic';

		$sql = 'SELECT user_id, topic_id, MIN(count_id) AS keep_id,
				SUM(counter_user) AS visit_count, MAX(date) AS last_visit,
				COUNT(count_id) AS row_count
			FROM ' . $table . '
			WHERE user_id > ' . $last_user . '
				OR (user_id = ' . $last_user . ' AND topic_id > ' . $last_topic . ')
			GROUP BY user_id, topic_id
			ORDER BY user_id, topic_id';
		$result = $this->db->sql_query_limit($sql, self::BATCH_SIZE);

		$processed = 0;
		while ($row = $this->db->sql_fetchrow($result))
		{
			$processed++;
			$last_user = (int) $row['user_id'];
			$last_topic = (int) $row['topic_id'];
			if ((int) $row['row_count'] < 2)
			{
				continue;
			}

			$sql = 'UPDATE ' . $table . '
				SET ' . $this->db->sql_build_array('UPDATE', [
					'counter_user' => min(self::MAX_VISITS, (int) $row['visit_count']),
					'date' => (int) $row['last_visit'],
				]) . '
				WHERE count_id = ' . (int) $row['keep_id'];
			$this->db->sql_query($sql);

			$sql = 'DELETE FROM ' . $table . '
				WHERE user_id = ' . $last_user . '
					AND topic_id = ' . $last_topic . '
					AND count_id <> ' . (int) $row['keep_id'];
			$this->db->sql_query($sql);
		}
		$this->db->sql_freeresult($result);

		return $processed === self::BATCH_SIZE ? ['user_id' => $last_user, 'topic_id' => $last_topic] : null;
	}
}
