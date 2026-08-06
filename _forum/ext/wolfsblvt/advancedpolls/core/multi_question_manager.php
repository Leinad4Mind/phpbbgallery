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

/**
 * Persists the extra pages of a topic poll.
 */
class multi_question_manager
{
	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var string */
	protected $questions_table;

	/** @var string */
	protected $options_table;

	/** @var string */
	protected $votes_table;

	/** @var string */
	protected $ballots_table;

	public function __construct(\phpbb\db\driver\driver_interface $db, $table_prefix)
	{
		$this->db = $db;
		$this->questions_table = $table_prefix . 'advancedpolls_questions';
		$this->options_table = $table_prefix . 'advancedpolls_options';
		$this->votes_table = $table_prefix . 'advancedpolls_votes';
		$this->ballots_table = $table_prefix . 'advancedpolls_ballots';
	}

	/**
	 * Load all additional questions and their options.
	 *
	 * @param int $topic_id Topic ID
	 * @return array
	 */
	public function load($topic_id)
	{
		$sql = 'SELECT question_id, question_order, question_text, question_required
			FROM ' . $this->questions_table . '
			WHERE topic_id = ' . (int) $topic_id . '
			ORDER BY question_order ASC, question_id ASC';
		$result = $this->db->sql_query($sql);
		$questions = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$id = (int) $row['question_id'];
			$questions[$id] = array(
				'id' => $id,
				'order' => (int) $row['question_order'],
				'text' => $row['question_text'],
				'required' => !empty($row['question_required']),
				'options' => array(),
			);
		}
		$this->db->sql_freeresult($result);

		if (!$questions)
		{
			return array();
		}

		$sql = 'SELECT option_id, question_id, option_order, option_text, option_total
			FROM ' . $this->options_table . '
			WHERE ' . $this->db->sql_in_set('question_id', array_keys($questions)) . '
			ORDER BY question_id ASC, option_order ASC, option_id ASC';
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$question_id = (int) $row['question_id'];
			$questions[$question_id]['options'][] = array(
				'id' => (int) $row['option_id'],
				'order' => (int) $row['option_order'],
				'text' => $row['option_text'],
				'total' => (int) $row['option_total'],
			);
		}
		$this->db->sql_freeresult($result);

		return array_values($questions);
	}

	/**
	 * Load one registered or token-identified guest ballot for extra pages.
	 *
	 * @param int    $topic_id Topic ID
	 * @param int    $user_id User ID
	 * @param string $guest_token_hash Guest token hash
	 * @return array
	 */
	public function load_votes($topic_id, $user_id, $guest_token_hash = '')
	{
		$where = (int) $user_id !== ANONYMOUS
			? 'v.vote_user_id = ' . (int) $user_id
			: 'v.vote_user_id = ' . ANONYMOUS . " AND v.vote_guest_token = '" . $this->db->sql_escape($guest_token_hash) . "'";
		$sql = 'SELECT v.question_id, v.option_id, v.vote_value
			FROM ' . $this->votes_table . ' v
			INNER JOIN ' . $this->questions_table . ' q ON q.question_id = v.question_id
			WHERE q.topic_id = ' . (int) $topic_id . ' AND ' . $where;
		$result = $this->db->sql_query($sql);
		$votes = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$votes[(int) $row['question_id']][(int) $row['option_id']] = (int) $row['vote_value'];
		}
		$this->db->sql_freeresult($result);
		return $votes;
	}

	/**
	 * Load the current identity's values for the native first question.
	 *
	 * @param int    $topic_id Topic ID
	 * @param int    $user_id User ID
	 * @param string $guest_token_hash Guest token hash
	 * @return array
	 */
	public function load_primary_votes($topic_id, $user_id, $guest_token_hash = '')
	{
		$where = (int) $user_id !== ANONYMOUS
			? 'vote_user_id = ' . (int) $user_id
			: 'vote_user_id = ' . ANONYMOUS . " AND wolfsblvt_vote_guest_token = '" . $this->db->sql_escape($guest_token_hash) . "'";
		$sql = 'SELECT poll_option_id, wolfsblvt_poll_option_value
			FROM ' . POLL_VOTES_TABLE . '
			WHERE topic_id = ' . (int) $topic_id . ' AND poll_option_id > 0 AND ' . $where;
		$result = $this->db->sql_query($sql);
		$votes = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$votes[(int) $row['poll_option_id']] = (int) $row['wolfsblvt_poll_option_value'];
		}
		$this->db->sql_freeresult($result);
		return $votes;
	}

	/**
	 * Load score/rank voter counts for every extra option.
	 *
	 * @param array $question_ids Question IDs
	 * @return array
	 */
	public function load_distributions(array $question_ids)
	{
		if (!$question_ids)
		{
			return array();
		}
		$sql = 'SELECT question_id, option_id, vote_value, COUNT(*) AS voter_count
			FROM ' . $this->votes_table . '
			WHERE ' . $this->db->sql_in_set('question_id', array_map('intval', $question_ids)) . '
			GROUP BY question_id, option_id, vote_value';
		$result = $this->db->sql_query($sql);
		$distribution = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$distribution[(int) $row['question_id']][(int) $row['option_id']][(int) $row['vote_value']] = (int) $row['voter_count'];
		}
		$this->db->sql_freeresult($result);
		return $distribution;
	}

	/**
	 * Whether this identity has submitted the complete multi-page ballot.
	 *
	 * @param int    $topic_id Topic ID
	 * @param int    $user_id User ID
	 * @param string $guest_token_hash Guest token hash
	 * @return bool
	 */
	public function has_ballot($topic_id, $user_id, $guest_token_hash = '')
	{
		$where = (int) $user_id !== ANONYMOUS
			? 'vote_user_id = ' . (int) $user_id
			: 'vote_user_id = ' . ANONYMOUS . " AND vote_guest_token = '" . $this->db->sql_escape($guest_token_hash) . "'";
		$sql = 'SELECT ballot_id FROM ' . $this->ballots_table . '
			WHERE topic_id = ' . (int) $topic_id . ' AND ' . $where;
		$result = $this->db->sql_query_limit($sql, 1);
		$exists = (bool) $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		return $exists;
	}

	/**
	 * Remove all extension-owned data before phpBB deletes topics.
	 *
	 * @param array $topic_ids Topic IDs
	 * @return void
	 */
	public function delete_topics(array $topic_ids)
	{
		$topic_ids = array_values(array_unique(array_filter(array_map('intval', $topic_ids))));
		if (!$topic_ids)
		{
			return;
		}
		$sql = 'SELECT question_id FROM ' . $this->questions_table . '
			WHERE ' . $this->db->sql_in_set('topic_id', $topic_ids);
		$result = $this->db->sql_query($sql);
		$question_ids = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$question_ids[] = (int) $row['question_id'];
		}
		$this->db->sql_freeresult($result);
		if ($question_ids)
		{
			$this->delete_questions($question_ids);
		}
		$sql = 'DELETE FROM ' . $this->ballots_table . '
			WHERE ' . $this->db->sql_in_set('topic_id', $topic_ids);
		$this->db->sql_query($sql);
	}

	/**
	 * Load voter identities and values for visible extra-page voter lists.
	 *
	 * @param array $question_ids Question IDs
	 * @return array
	 */
	public function load_voters(array $question_ids)
	{
		if (!$question_ids)
		{
			return array();
		}
		$sql = 'SELECT v.question_id, v.option_id, v.vote_user_id, v.vote_user_name,
				v.vote_value, u.user_id AS existing_user_id, u.username, u.user_colour
			FROM ' . $this->votes_table . ' v
			LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = v.vote_user_id
			WHERE ' . $this->db->sql_in_set('v.question_id', array_map('intval', $question_ids)) . '
			ORDER BY v.question_id, v.option_id, u.username_clean';
		$result = $this->db->sql_query($sql);
		$voters = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$voters[(int) $row['question_id']][(int) $row['option_id']][] = $row;
		}
		$this->db->sql_freeresult($result);
		return $voters;
	}

	/**
	 * Replace a topic's additional-question definition while retaining votes
	 * attached to submitted question and option IDs.
	 *
	 * @param int   $topic_id Topic ID
	 * @param array $questions Validated questions
	 * @return void
	 */
	public function sync($topic_id, array $questions)
	{
		$topic_id = (int) $topic_id;
		$existing = $this->load($topic_id);
		$existing_questions = array();
		$existing_options = array();
		foreach ($existing as $question)
		{
			$existing_questions[$question['id']] = true;
			$existing_options[$question['id']] = array_fill_keys(array_column($question['options'], 'id'), true);
		}

		$kept_questions = array();
		$this->db->sql_transaction('begin');
		try
		{
			if ($this->definition_changed($existing, $questions))
			{
				// A completed ballot cannot be mapped safely after pages or option IDs
				// change. Reset the whole topic poll, as phpBB does when the native
				// option structure changes.
				$this->reset_topic_votes($topic_id, array_keys($existing_questions));
			}
			foreach ($questions as $question)
			{
				$question_id = (int) $question['id'];
				$sql_ary = array(
					'topic_id' => $topic_id,
					'question_order' => (int) $question['order'],
					'question_text' => (string) $question['text'],
					'question_required' => $question['required'] ? 1 : 0,
				);
				if ($question_id && isset($existing_questions[$question_id]))
				{
					$sql = 'UPDATE ' . $this->questions_table . '
						SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
						WHERE question_id = ' . $question_id . '
							AND topic_id = ' . $topic_id;
					$this->db->sql_query($sql);
				}
				else
				{
					$sql = 'INSERT INTO ' . $this->questions_table . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
					$this->db->sql_query($sql);
					$question_id = (int) $this->db->sql_nextid();
				}
				$kept_questions[$question_id] = true;
				$this->sync_options($question_id, $question['options'], isset($existing_options[$question_id]) ? $existing_options[$question_id] : array());
			}

			$removed_questions = array_diff(array_keys($existing_questions), array_keys($kept_questions));
			if ($removed_questions)
			{
				$this->delete_questions($removed_questions);
			}
			if (!$questions)
			{
				$sql = 'DELETE FROM ' . $this->ballots_table . ' WHERE topic_id = ' . $topic_id;
				$this->db->sql_query($sql);
			}
			$this->db->sql_transaction('commit');
		}
		catch (\Throwable $exception)
		{
			$this->db->sql_transaction('rollback');
			throw $exception;
		}
	}

	/**
	 * Whether a page/option/required-state change invalidates completed ballots.
	 * Text-only edits keep existing votes.
	 *
	 * @param array $existing Stored questions
	 * @param array $submitted Validated questions
	 * @return bool
	 */
	protected function definition_changed(array $existing, array $submitted)
	{
		if (count($existing) !== count($submitted))
		{
			return true;
		}
		$stored = array();
		foreach ($existing as $question)
		{
			$stored[(int) $question['id']] = $question;
		}
		foreach ($submitted as $question)
		{
			$question_id = (int) $question['id'];
			if (!$question_id || !isset($stored[$question_id]) || (bool) $stored[$question_id]['required'] !== (bool) $question['required'])
			{
				return true;
			}
			$old_ids = array_map('intval', array_column($stored[$question_id]['options'], 'id'));
			$new_ids = array_map('intval', array_column($question['options'], 'id'));
			sort($old_ids, SORT_NUMERIC);
			sort($new_ids, SORT_NUMERIC);
			if ($old_ids !== $new_ids || in_array(0, $new_ids, true))
			{
				return true;
			}
		}
		return false;
	}

	/**
	 * Reset native and additional-page votes for an incompatible definition.
	 *
	 * @param int   $topic_id Topic ID
	 * @param array $question_ids Existing extra question IDs
	 * @return void
	 */
	protected function reset_topic_votes($topic_id, array $question_ids)
	{
		$sql = 'DELETE FROM ' . POLL_VOTES_TABLE . ' WHERE topic_id = ' . (int) $topic_id;
		$this->db->sql_query($sql);
		$sql = 'UPDATE ' . POLL_OPTIONS_TABLE . ' SET poll_option_total = 0 WHERE topic_id = ' . (int) $topic_id;
		$this->db->sql_query($sql);
		if ($question_ids)
		{
			$sql = 'DELETE FROM ' . $this->votes_table . '
				WHERE ' . $this->db->sql_in_set('question_id', array_map('intval', $question_ids));
			$this->db->sql_query($sql);
			$sql = 'UPDATE ' . $this->options_table . ' SET option_total = 0
				WHERE ' . $this->db->sql_in_set('question_id', array_map('intval', $question_ids));
			$this->db->sql_query($sql);
		}
		$sql = 'DELETE FROM ' . $this->ballots_table . ' WHERE topic_id = ' . (int) $topic_id;
		$this->db->sql_query($sql);
	}

	protected function sync_options($question_id, array $options, array $existing_options)
	{
		$kept = array();
		foreach ($options as $order => $option)
		{
			$option_id = (int) $option['id'];
			$sql_ary = array(
				'question_id' => (int) $question_id,
				'option_order' => $order + 1,
				'option_text' => (string) $option['text'],
			);
			if ($option_id && isset($existing_options[$option_id]))
			{
				$sql = 'UPDATE ' . $this->options_table . '
					SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
					WHERE option_id = ' . $option_id . '
						AND question_id = ' . (int) $question_id;
				$this->db->sql_query($sql);
			}
			else
			{
				$sql_ary['option_total'] = 0;
				$sql = 'INSERT INTO ' . $this->options_table . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
				$this->db->sql_query($sql);
				$option_id = (int) $this->db->sql_nextid();
			}
			$kept[$option_id] = true;
		}

		$removed = array_diff(array_keys($existing_options), array_keys($kept));
		if ($removed)
		{
			$sql = 'DELETE FROM ' . $this->votes_table . '
				WHERE ' . $this->db->sql_in_set('option_id', $removed);
			$this->db->sql_query($sql);
			$sql = 'DELETE FROM ' . $this->options_table . '
				WHERE question_id = ' . (int) $question_id . '
					AND ' . $this->db->sql_in_set('option_id', $removed);
			$this->db->sql_query($sql);
		}
	}

	protected function delete_questions(array $question_ids)
	{
		$sql = 'DELETE FROM ' . $this->votes_table . '
			WHERE ' . $this->db->sql_in_set('question_id', $question_ids);
		$this->db->sql_query($sql);
		$sql = 'DELETE FROM ' . $this->options_table . '
			WHERE ' . $this->db->sql_in_set('question_id', $question_ids);
		$this->db->sql_query($sql);
		$sql = 'DELETE FROM ' . $this->questions_table . '
			WHERE ' . $this->db->sql_in_set('question_id', $question_ids);
		$this->db->sql_query($sql);
	}
}
