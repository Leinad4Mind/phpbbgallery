<?php
/**
 *
 * @package phpBB Extension - Who Visited This Topic
 * @copyright (c) 2016 dmzx - https://www.dmzx-web.net
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 *
 */

namespace dmzx\whovisitedthistopic\core;

use phpbb\db\driver\driver_interface;

class visit_repository
{
	const MAX_VISITS = 16777215;

	/** @var driver_interface */
	protected $db;

	/** @var string */
	protected $table;

	public function __construct(driver_interface $db, $table)
	{
		$this->db = $db;
		$this->table = $table;
	}

	public function record($user_id, $topic_id, $timestamp)
	{
		$user_id = (int) $user_id;
		$topic_id = (int) $topic_id;
		$timestamp = (int) $timestamp;
		if ($user_id <= 0 || $topic_id <= 0)
		{
			return;
		}

		$this->update($user_id, $topic_id, $timestamp);
		if ((int) $this->db->sql_affectedrows() > 0)
		{
			return;
		}

		$sql = 'INSERT INTO ' . $this->table . ' ' . $this->db->sql_build_array('INSERT', [
			'counter_user' => 1,
			'user_id' => $user_id,
			'topic_id' => $topic_id,
			'date' => $timestamp,
		]);
		$this->db->sql_return_on_error(true);
		$this->db->sql_query($sql);
		$insert_failed = $this->db->get_sql_error_triggered();
		$this->db->sql_return_on_error(false);

		if ($insert_failed)
		{
			// A concurrent request may have inserted the unique pair first.
			$this->update($user_id, $topic_id, $timestamp);
			if ((int) $this->db->sql_affectedrows() === 0)
			{
				throw new \RuntimeException('Unable to record the topic visit.');
			}
		}
	}

	public function delete_users(array $user_ids)
	{
		$user_ids = array_values(array_filter(array_unique(array_map('intval', $user_ids))));
		if (!$user_ids)
		{
			return;
		}

		$sql = 'DELETE FROM ' . $this->table . '
			WHERE ' . $this->db->sql_in_set('user_id', $user_ids);
		$this->db->sql_query($sql);
	}

	public function prune_before($cutoff)
	{
		$sql = 'DELETE FROM ' . $this->table . '
			WHERE date < ' . (int) $cutoff;
		$this->db->sql_query($sql);
	}

	private function update($user_id, $topic_id, $timestamp)
	{
		$sql = 'UPDATE ' . $this->table . '
			SET counter_user = CASE WHEN counter_user < ' . self::MAX_VISITS . ' THEN counter_user + 1 ELSE counter_user END,
				date = ' . (int) $timestamp . '
			WHERE user_id = ' . (int) $user_id . '
				AND topic_id = ' . (int) $topic_id;
		$this->db->sql_query($sql);
	}
}
