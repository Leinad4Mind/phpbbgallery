<?php
/**
 *
 * Advanced Polls
 *
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace wolfsblvt\advancedpolls\core;

class vote_user_lifecycle
{
	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/**
	 * Constructor.
	 *
	 * @param \phpbb\db\driver\driver_interface $db Database connection
	 */
	public function __construct(\phpbb\db\driver\driver_interface $db)
	{
		$this->db = $db;
	}

	/**
	 * Apply phpBB's user-deletion choice to the user's poll votes.
	 *
	 * @param string $mode Delete mode: retain or remove
	 * @param array  $user_ids Deleted user IDs
	 * @param mixed  $retain_username Whether retained content keeps the username
	 * @param array  $user_rows User rows captured by phpBB before deletion
	 * @return void
	 */
	public function handle($mode, array $user_ids, $retain_username, array $user_rows)
	{
		$user_ids = array_values(array_unique(array_filter(array_map('intval', $user_ids))));
		if (!$user_ids)
		{
			return;
		}

		if ($mode === 'retain')
		{
			if ($retain_username !== false)
			{
				$this->retain_usernames($user_ids, $user_rows);
			}
			return;
		}

		if ($mode === 'remove')
		{
			$this->remove_votes($user_ids);
		}
	}

	/**
	 * Store an unlinked username snapshot for retained votes.
	 *
	 * @param array $user_ids User IDs
	 * @param array $user_rows User rows keyed by user ID
	 * @return void
	 */
	protected function retain_usernames(array $user_ids, array $user_rows)
	{
		$cases = array();
		foreach ($user_ids as $user_id)
		{
			if (!isset($user_rows[$user_id]['username']))
			{
				continue;
			}
			$cases[] = 'WHEN ' . $user_id . " THEN '" . $this->db->sql_escape($user_rows[$user_id]['username']) . "'";
		}

		if (!$cases)
		{
			return;
		}

		$sql = 'UPDATE ' . POLL_VOTES_TABLE . '
			SET wolfsblvt_vote_user_name = CASE vote_user_id
				' . implode("\n\t\t\t\t", $cases) . '
				ELSE wolfsblvt_vote_user_name
			END
			WHERE ' . $this->db->sql_in_set('vote_user_id', $user_ids);
		$this->db->sql_query($sql);
	}

	/**
	 * Remove votes and subtract their weighted values from poll totals.
	 *
	 * @param array $user_ids User IDs
	 * @return void
	 */
	protected function remove_votes(array $user_ids)
	{
		$user_where = $this->db->sql_in_set('vote_user_id', $user_ids);
		$sql = 'SELECT topic_id, poll_option_id,
				SUM(wolfsblvt_poll_option_value) AS removed_value
			FROM ' . POLL_VOTES_TABLE . '
			WHERE ' . $user_where . '
				AND poll_option_id > 0
			GROUP BY topic_id, poll_option_id';
		$result = $this->db->sql_query($sql);
		$removed_votes = array();
		$topic_ids = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$removed_votes[] = $row;
			$topic_ids[(int) $row['topic_id']] = true;
		}
		$this->db->sql_freeresult($result);

		foreach ($removed_votes as $vote)
		{
			$removed_value = max(0, (int) $vote['removed_value']);
			$sql = 'UPDATE ' . POLL_OPTIONS_TABLE . '
				SET poll_option_total = CASE
					WHEN poll_option_total >= ' . $removed_value . ' THEN poll_option_total - ' . $removed_value . '
					ELSE 0
				END
				WHERE topic_id = ' . (int) $vote['topic_id'] . '
					AND poll_option_id = ' . (int) $vote['poll_option_id'];
			$this->db->sql_query($sql);
		}

		$sql = 'DELETE FROM ' . POLL_VOTES_TABLE . '
			WHERE ' . $user_where;
		$this->db->sql_query($sql);

		if ($topic_ids)
		{
			$sql = 'UPDATE ' . TOPICS_TABLE . '
				SET poll_last_vote = ' . time() . '
				WHERE ' . $this->db->sql_in_set('topic_id', array_keys($topic_ids));
			$this->db->sql_query($sql);
		}
	}
}
