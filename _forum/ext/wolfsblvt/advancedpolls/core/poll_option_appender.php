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
 * Appends options to a live poll without invalidating existing ballots.
 */
class poll_option_appender
{
	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\notification\manager */
	protected $notifications;

	/** @var \phpbb\log\log_interface */
	protected $log;

	/** @var \phpbb\user */
	protected $user;

	/** @var multi_question_manager */
	protected $multi_question_manager;

	/** @var string */
	protected $revisions_table;

	/** @var string */
	protected $options_table;

	/** @var array|false */
	protected $pending = false;

	public function __construct(
		\phpbb\db\driver\driver_interface $db,
		\phpbb\config\config $config,
		\phpbb\notification\manager $notifications,
		\phpbb\log\log_interface $log,
		\phpbb\user $user,
		multi_question_manager $multi_question_manager,
		$table_prefix
	)
	{
		$this->db = $db;
		$this->config = $config;
		$this->notifications = $notifications;
		$this->log = $log;
		$this->user = $user;
		$this->multi_question_manager = $multi_question_manager;
		$this->revisions_table = $table_prefix . 'advancedpolls_revisions';
		$this->options_table = $table_prefix . 'advancedpolls_options';
	}

	/**
	 * Validate an append-only edit and retain it for submit_post_end.
	 *
	 * @param int   $topic_id Topic ID
	 * @param array $poll Parsed phpBB poll payload
	 * @param array $questions Parsed additional questions
	 * @param int   $vote_mode Submitted vote mode
	 * @return array
	 */
	public function prepare($topic_id, array $poll, array $questions, $vote_mode)
	{
		$result = $this->validate($topic_id, $poll, $questions, $vote_mode);
		if (!$result['error'])
		{
			$this->pending = $result;
		}
		return $result;
	}

	/**
	 * Validate without retaining the operation.
	 *
	 * @param int   $topic_id Topic ID
	 * @param array $poll Parsed phpBB poll payload
	 * @param array $questions Parsed additional questions
	 * @param int   $vote_mode Submitted vote mode
	 * @return array
	 */
	public function validate($topic_id, array $poll, array $questions, $vote_mode)
	{
		return $this->analyse($this->load_state($topic_id), $poll, $questions, $vote_mode);
	}

	/**
	 * Whether a validated append operation awaits persistence.
	 *
	 * @return bool
	 */
	public function has_pending()
	{
		return $this->pending !== false;
	}

	/**
	 * Persist the prepared additions, create one revision and notify voters.
	 *
	 * @return void
	 */
	public function commit()
	{
		if ($this->pending === false)
		{
			return;
		}

		$pending = $this->pending;
		$this->pending = false;
		$this->db->sql_transaction('begin');
		try
		{
			$this->insert_primary_options($pending);
			$this->insert_additional_options($pending);
			$sql_ary = array(
				'topic_id' => (int) $pending['topic']['topic_id'],
				'added_by' => (int) $this->user->data['user_id'],
				'added_at' => time(),
				'option_count' => (int) $pending['option_count'],
			);
			$sql = 'INSERT INTO ' . $this->revisions_table . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
			$this->db->sql_query($sql);
			$revision_id = (int) $this->db->sql_nextid();
			$this->db->sql_transaction('commit');
		}
		catch (\Throwable $exception)
		{
			$this->db->sql_transaction('rollback');
			throw $exception;
		}

		$data = array(
			'revision_id' => $revision_id,
			'topic_id' => (int) $pending['topic']['topic_id'],
			'forum_id' => (int) $pending['topic']['forum_id'],
			'topic_title' => $pending['topic']['topic_title'],
			'poll_title' => $pending['topic']['poll_title'],
			'option_count' => (int) $pending['option_count'],
			'actor_user_id' => (int) $this->user->data['user_id'],
		);
		if (!empty($this->config['wolfsblvt.advancedpolls.activate_notifications']))
		{
			$this->notifications->add_notifications('wolfsblvt.advancedpolls.notification.type.optionsadded', $data);
		}
		$this->log->add('mod', (int) $this->user->data['user_id'], $this->user->ip, 'LOG_AP_POLL_OPTIONS_ADDED', false, array(
			'forum_id' => (int) $pending['topic']['forum_id'],
			'topic_id' => (int) $pending['topic']['topic_id'],
			(int) $pending['option_count'],
			$pending['topic']['topic_title'],
		));
	}

	/**
	 * Remove revision rows belonging to deleted topics.
	 *
	 * @param array $topic_ids Topic IDs
	 * @return void
	 */
	public function delete_topics(array $topic_ids)
	{
		$topic_ids = array_values(array_unique(array_filter(array_map('intval', $topic_ids))));
		if ($topic_ids)
		{
			$sql = 'SELECT revision_id FROM ' . $this->revisions_table . '
				WHERE ' . $this->db->sql_in_set('topic_id', $topic_ids);
			$result = $this->db->sql_query($sql);
			$revision_ids = array();
			while ($row = $this->db->sql_fetchrow($result))
			{
				$revision_ids[] = (int) $row['revision_id'];
			}
			$this->db->sql_freeresult($result);
			if ($revision_ids)
			{
				$this->notifications->delete_notifications('wolfsblvt.advancedpolls.notification.type.optionsadded', $revision_ids);
			}
			$sql = 'DELETE FROM ' . $this->revisions_table . '
				WHERE ' . $this->db->sql_in_set('topic_id', $topic_ids);
			$this->db->sql_query($sql);
		}
	}

	/**
	 * Compare the submitted definition with its stored append-only prefix.
	 *
	 * @param array $state Stored topic and question definition
	 * @param array $poll Parsed phpBB poll payload
	 * @param array $questions Parsed additional questions
	 * @param int   $vote_mode Submitted vote mode
	 * @return array
	 */
	protected function analyse(array $state, array $poll, array $questions, $vote_mode)
	{
		$result = array(
			'error' => false,
			'topic' => isset($state['topic']) ? $state['topic'] : array(),
			'existing_primary' => array(),
			'existing_primary_rows' => isset($state['primary']) ? $state['primary'] : array(),
			'question_rows' => array(),
			'primary_additions' => array(),
			'additional_additions' => array(),
			'option_count' => 0,
		);
		if (empty($state['topic']) || empty($state['primary']))
		{
			$result['error'] = 'AP_APPEND_INVALID';
			return $result;
		}
		if ((int) $vote_mode !== poll_options::VOTE_MODE_CHANGE)
		{
			$result['error'] = 'AP_APPEND_REQUIRES_CHANGES';
			return $result;
		}
		if (!empty($state['topic']['poll_length'])
			&& (int) $state['topic']['poll_start'] + (int) $state['topic']['poll_length'] <= time())
		{
			$result['error'] = 'AP_APPEND_POLL_ENDED';
			return $result;
		}
		if (!isset($poll['poll_title']) || (string) $poll['poll_title'] !== (string) $state['topic']['poll_title'])
		{
			$result['error'] = 'AP_APPEND_STRUCTURE_CHANGED';
			return $result;
		}

		$result['existing_primary'] = array_column($state['primary'], 'text');
		$submitted_primary = isset($poll['poll_options']) ? array_values($poll['poll_options']) : array();
		$error = $this->compare_option_prefix($result['existing_primary'], $submitted_primary, $result['primary_additions']);
		if ($error)
		{
			$result['error'] = $error;
			return $result;
		}

		$stored_questions = isset($state['questions']) ? array_values($state['questions']) : array();
		if (count($stored_questions) !== count($questions))
		{
			$result['error'] = 'AP_APPEND_STRUCTURE_CHANGED';
			return $result;
		}
		foreach ($stored_questions as $index => $stored)
		{
			$result['question_rows'][(int) $stored['id']] = $stored['options'];
			$submitted = $questions[$index];
			if ((int) $submitted['id'] !== (int) $stored['id']
				|| (string) $submitted['text'] !== (string) $stored['text']
				|| (bool) $submitted['required'] !== (bool) $stored['required'])
			{
				$result['error'] = 'AP_APPEND_STRUCTURE_CHANGED';
				return $result;
			}
			$stored_options = array_values($stored['options']);
			$submitted_options = array_values($submitted['options']);
			if (count($submitted_options) < count($stored_options))
			{
				$result['error'] = 'AP_APPEND_STRUCTURE_CHANGED';
				return $result;
			}
			foreach ($stored_options as $option_index => $stored_option)
			{
				if ((int) $submitted_options[$option_index]['id'] !== (int) $stored_option['id']
					|| (string) $submitted_options[$option_index]['text'] !== (string) $stored_option['text'])
				{
					$result['error'] = 'AP_APPEND_STRUCTURE_CHANGED';
					return $result;
				}
			}
			$new_options = array_slice($submitted_options, count($stored_options));
			foreach ($new_options as $new_option)
			{
				if ((int) $new_option['id'] !== 0)
				{
					$result['error'] = 'AP_APPEND_STRUCTURE_CHANGED';
					return $result;
				}
			}
			if ($new_options)
			{
				$result['additional_additions'][(int) $stored['id']] = array_column($new_options, 'text');
			}
		}

		$maximum = !empty($this->config['max_poll_options']) ? (int) $this->config['max_poll_options'] : multi_question_payload::MAX_OPTIONS;
		if (count($submitted_primary) > $maximum)
		{
			$result['error'] = 'AP_APPEND_TOO_MANY';
			return $result;
		}
		foreach ($questions as $question)
		{
			if (count($question['options']) > $maximum)
			{
				$result['error'] = 'AP_APPEND_TOO_MANY';
				return $result;
			}
		}

		$result['option_count'] = count($result['primary_additions']);
		foreach ($result['additional_additions'] as $additions)
		{
			$result['option_count'] += count($additions);
		}
		if (!$result['option_count'])
		{
			$result['error'] = 'AP_APPEND_NONE';
		}
		return $result;
	}

	/**
	 * Require every stored native option to remain an identical prefix.
	 *
	 * @param array $stored Stored option texts
	 * @param array $submitted Submitted option texts
	 * @param array $additions Output additions
	 * @return string|false
	 */
	protected function compare_option_prefix(array $stored, array $submitted, array &$additions)
	{
		if (count($submitted) < count($stored))
		{
			return 'AP_APPEND_STRUCTURE_CHANGED';
		}
		foreach ($stored as $index => $text)
		{
			if (!array_key_exists($index, $submitted) || (string) $submitted[$index] !== (string) $text)
			{
				return 'AP_APPEND_STRUCTURE_CHANGED';
			}
		}
		$additions = array_slice($submitted, count($stored));
		return false;
	}

	/**
	 * Load the current topic definition.
	 *
	 * @param int $topic_id Topic ID
	 * @return array
	 */
	protected function load_state($topic_id)
	{
		$sql = 'SELECT topic_id, forum_id, topic_title, poll_title, poll_start, poll_length
			FROM ' . TOPICS_TABLE . '
			WHERE topic_id = ' . (int) $topic_id;
		$result = $this->db->sql_query_limit($sql, 1);
		$topic = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		if (!$topic)
		{
			return array();
		}

		$sql = 'SELECT poll_option_id, poll_option_text
			FROM ' . POLL_OPTIONS_TABLE . '
			WHERE topic_id = ' . (int) $topic_id . '
			ORDER BY poll_option_id ASC';
		$result = $this->db->sql_query($sql);
		$primary = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$primary[] = array(
				'id' => (int) $row['poll_option_id'],
				'text' => $row['poll_option_text'],
			);
		}
		$this->db->sql_freeresult($result);

		return array(
			'topic' => $topic,
			'primary' => $primary,
			'questions' => $this->multi_question_manager->load((int) $topic_id),
		);
	}

	/**
	 * Insert zero-total native options after the stored option IDs.
	 *
	 * @param array $pending Validated append operation
	 * @return void
	 */
	protected function insert_primary_options(array $pending)
	{
		if (!$pending['primary_additions'])
		{
			return;
		}
		$ids = array_column($pending['existing_primary_rows'], 'id');
		$next_id = $ids ? max($ids) + 1 : 1;
		$rows = array();
		foreach ($pending['primary_additions'] as $text)
		{
			$rows[] = array(
				'poll_option_id' => $next_id++,
				'topic_id' => (int) $pending['topic']['topic_id'],
				'poll_option_text' => $text,
				'poll_option_total' => 0,
			);
		}
		$this->db->sql_multi_insert(POLL_OPTIONS_TABLE, $rows);
	}

	/**
	 * Insert zero-total options on existing additional questions.
	 *
	 * @param array $pending Validated append operation
	 * @return void
	 */
	protected function insert_additional_options(array $pending)
	{
		foreach ($pending['additional_additions'] as $question_id => $additions)
		{
			$existing = $pending['question_rows'][(int) $question_id];
			$orders = array_column($existing, 'order');
			$order = $orders ? max($orders) + 1 : 1;
			$rows = array();
			foreach ($additions as $text)
			{
				$rows[] = array(
					'question_id' => (int) $question_id,
					'option_order' => $order++,
					'option_text' => $text,
					'option_total' => 0,
				);
			}
			$this->db->sql_multi_insert($this->options_table, $rows);
		}
	}
}
