<?php
/**
 *
 * Advanced Polls
 *
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace wolfsblvt\advancedpolls\controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use wolfsblvt\advancedpolls\core\multi_question_manager;
use wolfsblvt\advancedpolls\core\multi_question_vote;
use wolfsblvt\advancedpolls\core\poll_options;
use wolfsblvt\advancedpolls\core\ranked_vote;

/**
 * Atomically submits every page of a multi-question poll.
 */
class multi_question
{
	const MAX_ANSWER_BYTES = 262144;

	protected $db;
	protected $auth;
	protected $user;
	protected $request;
	protected $config;
	protected $manager;
	protected $questions_table;
	protected $options_table;
	protected $votes_table;
	protected $ballots_table;

	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\auth\auth $auth, \phpbb\user $user, \phpbb\request\request_interface $request, \phpbb\config\config $config, multi_question_manager $manager, $table_prefix)
	{
		$this->db = $db;
		$this->auth = $auth;
		$this->user = $user;
		$this->request = $request;
		$this->config = $config;
		$this->manager = $manager;
		$this->questions_table = $table_prefix . 'advancedpolls_questions';
		$this->options_table = $table_prefix . 'advancedpolls_options';
		$this->votes_table = $table_prefix . 'advancedpolls_votes';
		$this->ballots_table = $table_prefix . 'advancedpolls_ballots';
	}

	/**
	 * @param int $topic_id Topic ID
	 * @return JsonResponse
	 */
	public function submit($topic_id)
	{
		$this->user->add_lang_ext('wolfsblvt/advancedpolls', 'advancedpolls');
		if (!$this->request->is_ajax() || !check_form_key('posting'))
		{
			return $this->error('FORM_INVALID', 400);
		}

		$topic = $this->load_topic($topic_id);
		if (!$topic || !$topic['poll_title'])
		{
			return $this->error('NO_TOPIC', 404);
		}
		if (!$this->can_vote($topic))
		{
			return $this->error('NOT_AUTHORISED', 403);
		}

		$questions = $this->build_questions($topic);
		if (count($questions) < 2)
		{
			return $this->error('FORM_INVALID', 400);
		}
		$delete_vote = $this->request->is_set_post('delete_vote');
		$abstain = $this->request->is_set_post('no_vote');
		if ($delete_vote)
		{
			$can_delete = !empty($this->config['wolfsblvt.advancedpolls.activate_vote_delete'])
				&& $this->user->data['is_registered']
				&& (int) $topic['wolfsblvt_poll_vote_mode'] === poll_options::VOTE_MODE_CHANGE
				&& $this->auth->acl_get('f_votechg', (int) $topic['forum_id']);
			if (!$can_delete)
			{
				return $this->error('FORM_INVALID', 403);
			}
			$decoded = array();
		}
		else if ($abstain)
		{
			if (empty($this->config['wolfsblvt.advancedpolls.activate_no_vote']))
			{
				return $this->error('FORM_INVALID', 403);
			}
			$decoded = array();
		}
		else
		{
			$answer_json = $this->request->raw_variable('answers', '', \phpbb\request\request_interface::POST);
			if (strlen($answer_json) > self::MAX_ANSWER_BYTES)
			{
				return $this->error('FORM_INVALID', 400);
			}
			$decoded = json_decode($answer_json, true);
		}
		if (!is_array($decoded) || (!$delete_vote && !$abstain && json_last_error() !== JSON_ERROR_NONE))
		{
			return $this->error('FORM_INVALID', 400);
		}

		$identity = $this->voter_identity((int) $topic_id);
		$rules = array(
			'type' => $this->poll_type($topic),
			'vote_mode' => (int) $topic['wolfsblvt_poll_vote_mode'],
			'max_options' => (int) $topic['poll_max_options'],
			'min_value' => (int) $topic['wolfsblvt_poll_min_value'],
			'max_value' => (int) $topic['wolfsblvt_poll_max_value'],
			'total_value' => (int) $topic['wolfsblvt_poll_total_value'],
			'rank_points' => ranked_vote::normalise_points($topic['wolfsblvt_poll_rank_points']),
		);
		$this->db->sql_transaction('begin');
		try
		{
			// Serialise submissions for this topic so repeated concurrent requests
			// cannot both pass the no-change check.
			$sql = 'UPDATE ' . TOPICS_TABLE . '
				SET poll_last_vote = poll_last_vote
				WHERE topic_id = ' . (int) $topic_id;
			$this->db->sql_query($sql);
			$current = $this->load_current_votes((int) $topic_id, $identity);
			if (!empty($current['_completed']) && $rules['vote_mode'] === poll_options::VOTE_MODE_CHANGE && !$this->auth->acl_get('f_votechg', (int) $topic['forum_id']))
			{
				$this->db->sql_transaction('rollback');
				return $this->error('NOT_AUTHORISED', 403);
			}
			if ($abstain && !empty($current['_completed']) && $rules['vote_mode'] === poll_options::VOTE_MODE_NO_CHANGE)
			{
				$this->db->sql_transaction('rollback');
				return $this->error('AP_VOTE_CHANGED', 400);
			}
			$validated = ($delete_vote || $abstain)
				? array('answers' => array(), 'error' => false)
				: multi_question_vote::validate($questions, $decoded, $rules, $current);
			if ($validated['error'])
			{
				$this->db->sql_transaction('rollback');
				return $this->error($validated['error'], 400);
			}
			$this->store_ballot((int) $topic_id, $questions, $current, $validated['answers'], $identity, !$delete_vote, $abstain);
			$this->db->sql_transaction('commit');
		}
		catch (\Throwable $exception)
		{
			$this->db->sql_transaction('rollback');
			throw $exception;
		}
		if (!$this->user->data['is_registered'] && $identity['new_token'])
		{
			$this->user->set_cookie('ap_multi_' . (int) $topic_id, $identity['token'], time() + 31536000);
		}

		$results_hidden = poll_options::results_are_hidden(
			(int) $topic['wolfsblvt_poll_visibility'],
			!empty($topic['poll_length']) && (int) $topic['poll_start'] + (int) $topic['poll_length'] <= time(),
			$abstain || $this->has_answers($validated['answers']),
			$abstain || $this->required_complete($questions, $validated['answers'])
		);

		$can_vote = false;
		if ($delete_vote)
		{
			$can_vote = true;
		}
		else if ($rules['vote_mode'] === poll_options::VOTE_MODE_CHANGE)
		{
			$can_vote = $this->auth->acl_get('f_votechg', (int) $topic['forum_id']);
		}
		else if (!$abstain && $rules['vote_mode'] === poll_options::VOTE_MODE_INCREMENTAL)
		{
			$can_vote = multi_question_vote::can_add_votes($questions, $validated['answers'], $rules);
		}
		$data = array(
			'success' => true,
			'message' => $this->user->lang['VOTE_SUBMITTED'],
			'can_vote' => $can_vote,
			'results_hidden' => $results_hidden,
		);
		if (!$results_hidden)
		{
			$data['results'] = $this->load_results($questions);
			if ($rules['type'] === poll_options::TYPE_SCORING || $rules['type'] === poll_options::TYPE_RANKING)
			{
				$data['breakdowns'] = $this->load_breakdowns(
					(int) $topic_id,
					$questions,
					$data['results'],
					$rules['type'],
					$rules['rank_points'],
					isset($topic['wolfsblvt_poll_score_result']) ? (int) $topic['wolfsblvt_poll_score_result'] : poll_options::SCORE_RESULT_TOTAL,
					(int) $topic['wolfsblvt_poll_max_value'],
					!isset($topic['wolfsblvt_poll_show_percent']) || !empty($topic['wolfsblvt_poll_show_percent'])
				);
			}
			if (!empty($this->config['wolfsblvt.advancedpolls.activate_poll_voters_show'])
				&& !empty($topic['wolfsblvt_poll_voters_show'])
				&& $this->auth->acl_get('f_seevoters', (int) $topic['forum_id']))
			{
				$data['voters'] = $this->load_voter_lists((int) $topic_id, $questions, $rules['type']);
			}
		}

		return $this->response($data, 200);
	}

	protected function load_topic($topic_id)
	{
		$sql = 'SELECT topic_id, forum_id, poll_title, poll_start, poll_length,
			poll_max_options, topic_status, forum_status,
			wolfsblvt_poll_type, wolfsblvt_poll_min_value, wolfsblvt_poll_max_value,
			wolfsblvt_poll_total_value, wolfsblvt_poll_rank_points,
			wolfsblvt_poll_vote_mode, wolfsblvt_poll_visibility,
			wolfsblvt_poll_required, wolfsblvt_poll_voters_limit,
			wolfsblvt_poll_voters_show, wolfsblvt_poll_score_result,
			wolfsblvt_poll_show_percent
			FROM ' . TOPICS_TABLE . '
			WHERE topic_id = ' . (int) $topic_id;
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		return $row;
	}

	protected function can_vote(array $topic)
	{
		$forum_id = (int) $topic['forum_id'];
		if (!empty($this->user->data['is_bot']))
		{
			return false;
		}
		if (!$this->auth->acl_get('f_read', $forum_id) || !$this->auth->acl_get('f_vote', $forum_id))
		{
			return false;
		}
		if (!empty($topic['poll_length']) && (int) $topic['poll_start'] + (int) $topic['poll_length'] <= time())
		{
			return false;
		}
		if ((int) $topic['forum_status'] === ITEM_LOCKED)
		{
			return false;
		}
		if ((int) $topic['topic_status'] === ITEM_LOCKED && empty($this->config['wolfsblvt.advancedpolls.activate_closed_voting']))
		{
			return false;
		}
		if (!empty($topic['wolfsblvt_poll_voters_limit']))
		{
			if (!$this->user->data['is_registered'])
			{
				return false;
			}
			$sql = 'SELECT 1 AS posted FROM ' . POSTS_TABLE . '
				WHERE topic_id = ' . (int) $topic['topic_id'] . '
					AND poster_id = ' . (int) $this->user->data['user_id'];
			$result = $this->db->sql_query_limit($sql, 1);
			$posted = (bool) $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);
			if (!$posted)
			{
				return false;
			}
		}
		return true;
	}

	protected function build_questions(array $topic)
	{
		$sql = 'SELECT poll_option_id, poll_option_total
			FROM ' . POLL_OPTIONS_TABLE . '
			WHERE topic_id = ' . (int) $topic['topic_id'] . '
			ORDER BY poll_option_id ASC';
		$result = $this->db->sql_query($sql);
		$primary_ids = array();
		$primary_totals = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$id = (int) $row['poll_option_id'];
			$primary_ids[] = $id;
			$primary_totals[$id] = (int) $row['poll_option_total'];
		}
		$this->db->sql_freeresult($result);
		$questions = array(array(
			'id' => 'primary',
			'required' => !empty($topic['wolfsblvt_poll_required']),
			'option_ids' => $primary_ids,
			'totals' => $primary_totals,
		));
		foreach ($this->manager->load((int) $topic['topic_id']) as $question)
		{
			$totals = array();
			foreach ($question['options'] as $option)
			{
				$totals[(int) $option['id']] = (int) $option['total'];
			}
			$questions[] = array(
				'id' => (string) $question['id'],
				'required' => $question['required'],
				'option_ids' => array_keys($totals),
				'totals' => $totals,
			);
		}
		return $questions;
	}

	protected function voter_identity($topic_id)
	{
		if ($this->user->data['is_registered'])
		{
			return array('user_id' => (int) $this->user->data['user_id'], 'token' => '', 'token_hash' => '', 'new_token' => false);
		}
		$cookie = $this->config['cookie_name'] . '_ap_multi_' . (int) $topic_id;
		$token = $this->request->variable($cookie, '', true, \phpbb\request\request_interface::COOKIE);
		$new = !preg_match('/^[a-f0-9]{64}$/D', $token);
		if ($new)
		{
			$token = bin2hex(random_bytes(32));
		}
		return array('user_id' => ANONYMOUS, 'token' => $token, 'token_hash' => hash('sha256', $token), 'new_token' => $new);
	}

	protected function load_current_votes($topic_id, array $identity)
	{
		$current = array('primary' => array());
		$ballot_where = $identity['user_id'] !== ANONYMOUS
			? 'vote_user_id = ' . (int) $identity['user_id']
			: 'vote_user_id = ' . ANONYMOUS . " AND vote_guest_token = '" . $this->db->sql_escape($identity['token_hash']) . "'";
		$sql = 'SELECT ballot_id FROM ' . $this->ballots_table . '
			WHERE topic_id = ' . (int) $topic_id . ' AND ' . $ballot_where;
		$result = $this->db->sql_query_limit($sql, 1);
		$current['_completed'] = (bool) $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		$where = $this->identity_where($identity, true);
		$sql = 'SELECT poll_option_id, wolfsblvt_poll_option_value
			FROM ' . POLL_VOTES_TABLE . '
			WHERE topic_id = ' . (int) $topic_id . ' AND ' . $where;
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			if ((int) $row['poll_option_id'] > 0)
			{
				$current['primary'][(int) $row['poll_option_id']] = (int) $row['wolfsblvt_poll_option_value'];
			}
		}
		$this->db->sql_freeresult($result);

		$where = $this->identity_where($identity, false);
		$sql = 'SELECT v.question_id, v.option_id, v.vote_value
			FROM ' . $this->votes_table . ' v
			INNER JOIN ' . $this->questions_table . ' q ON q.question_id = v.question_id
			WHERE q.topic_id = ' . (int) $topic_id . ' AND ' . $where;
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$current[(string) (int) $row['question_id']][(int) $row['option_id']] = (int) $row['vote_value'];
		}
		$this->db->sql_freeresult($result);
		return $current;
	}

	protected function identity_where(array $identity, $native, $aliased = true)
	{
		$prefix = (!$native && $aliased) ? 'v.' : '';
		if ($identity['user_id'] !== ANONYMOUS)
		{
			return $prefix . 'vote_user_id = ' . (int) $identity['user_id'];
		}
		$token_column = $native ? 'wolfsblvt_vote_guest_token' : $prefix . 'vote_guest_token';
		return $prefix . 'vote_user_id = ' . ANONYMOUS . " AND $token_column = '" . $this->db->sql_escape($identity['token_hash']) . "'";
	}

	protected function store_ballot($topic_id, array $questions, array $current, array $answers, array $identity, $record_ballot = true, $abstain = false)
	{
		foreach ($questions as $question)
		{
			$key = (string) $question['id'];
			$old = isset($current[$key]) ? $current[$key] : array();
			$new = isset($answers[$key]) ? $answers[$key] : array();
			foreach (array_keys($question['totals']) as $option_id)
			{
				$delta = (isset($new[$option_id]) ? (int) $new[$option_id] : 0) - (isset($old[$option_id]) ? (int) $old[$option_id] : 0);
				if ($delta)
				{
					$table = $key === 'primary' ? POLL_OPTIONS_TABLE : $this->options_table;
					$id_column = $key === 'primary' ? 'poll_option_id' : 'option_id';
					$total_column = $key === 'primary' ? 'poll_option_total' : 'option_total';
					$expression = $delta > 0
						? $total_column . ' + ' . $delta
						: 'CASE WHEN ' . $total_column . ' >= ' . abs($delta) . ' THEN ' . $total_column . ' - ' . abs($delta) . ' ELSE 0 END';
					$sql = 'UPDATE ' . $table . '
						SET ' . $total_column . ' = ' . $expression . '
						WHERE ' . $id_column . ' = ' . (int) $option_id . ($key === 'primary'
							? ' AND topic_id = ' . (int) $topic_id
							: ' AND question_id = ' . (int) $key);
					$this->db->sql_query($sql);
				}
			}
			$this->replace_voter_rows($topic_id, $key, $new, $identity);
		}
		$sql = 'UPDATE ' . TOPICS_TABLE . ' SET poll_last_vote = ' . time() . ' WHERE topic_id = ' . (int) $topic_id;
		$this->db->sql_query($sql);
		$ballot_where = $identity['user_id'] !== ANONYMOUS
			? 'vote_user_id = ' . (int) $identity['user_id']
			: 'vote_user_id = ' . ANONYMOUS . " AND vote_guest_token = '" . $this->db->sql_escape($identity['token_hash']) . "'";
		$sql = 'DELETE FROM ' . $this->ballots_table . '
			WHERE topic_id = ' . (int) $topic_id . ' AND ' . $ballot_where;
		$this->db->sql_query($sql);
		if ($record_ballot)
		{
			if ($abstain)
			{
				$row = array(
					'topic_id' => (int) $topic_id,
					'poll_option_id' => 0,
					'vote_user_id' => (int) $identity['user_id'],
					'vote_user_ip' => (string) $this->user->ip,
					'wolfsblvt_poll_option_value' => 1,
					'wolfsblvt_vote_user_name' => '',
					'wolfsblvt_vote_guest_token' => $identity['token_hash'],
				);
				$sql = 'INSERT INTO ' . POLL_VOTES_TABLE . ' ' . $this->db->sql_build_array('INSERT', $row);
				$this->db->sql_query($sql);
			}
			$row = array(
				'topic_id' => (int) $topic_id,
				'vote_user_id' => (int) $identity['user_id'],
				'vote_guest_token' => $identity['token_hash'],
				'submitted_at' => time(),
			);
			$sql = 'INSERT INTO ' . $this->ballots_table . ' ' . $this->db->sql_build_array('INSERT', $row);
			$this->db->sql_query($sql);
		}
	}

	protected function replace_voter_rows($topic_id, $question_id, array $votes, array $identity)
	{
		$native = $question_id === 'primary';
		$table = $native ? POLL_VOTES_TABLE : $this->votes_table;
		$sql = 'DELETE FROM ' . $table . ' WHERE ';
		if (!$native)
		{
			$sql .= 'question_id = ' . (int) $question_id . ' AND ';
		}
		else
		{
			$sql .= 'topic_id = ' . (int) $topic_id . ' AND ';
		}
		$sql .= $this->identity_where($identity, $native, false);
		$this->db->sql_query($sql);

		foreach ($votes as $option_id => $value)
		{
			if ($native)
			{
				$row = array(
					'topic_id' => (int) $topic_id,
					'poll_option_id' => (int) $option_id,
					'vote_user_id' => (int) $identity['user_id'],
					'vote_user_ip' => (string) $this->user->ip,
					'wolfsblvt_poll_option_value' => (int) $value,
					'wolfsblvt_vote_user_name' => '',
					'wolfsblvt_vote_guest_token' => $identity['token_hash'],
				);
			}
			else
			{
				$row = array(
					'question_id' => (int) $question_id,
					'option_id' => (int) $option_id,
					'vote_user_id' => (int) $identity['user_id'],
					'vote_user_ip' => (string) $this->user->ip,
					'vote_user_name' => '',
					'vote_guest_token' => $identity['token_hash'],
					'vote_value' => (int) $value,
				);
			}
			$sql = 'INSERT INTO ' . $table . ' ' . $this->db->sql_build_array('INSERT', $row);
			$this->db->sql_query($sql);
		}
	}

	protected function load_results(array $questions)
	{
		$results = array();
		foreach ($questions as $question)
		{
			$key = (string) $question['id'];
			$table = $key === 'primary' ? POLL_OPTIONS_TABLE : $this->options_table;
			$id_column = $key === 'primary' ? 'poll_option_id' : 'option_id';
			$total_column = $key === 'primary' ? 'poll_option_total' : 'option_total';
			$sql = 'SELECT ' . $id_column . ' AS option_id, ' . $total_column . ' AS option_total FROM ' . $table . '
				WHERE ' . $this->db->sql_in_set($id_column, $question['option_ids']);
			$result = $this->db->sql_query($sql);
			$results[$key] = array();
			while ($row = $this->db->sql_fetchrow($result))
			{
				$results[$key][(int) $row['option_id']] = (int) $row['option_total'];
			}
			$this->db->sql_freeresult($result);
		}
		return $results;
	}

	protected function load_breakdowns($topic_id, array $questions, array $results, $type, array $rank_points, $score_result, $maximum_score, $show_percent)
	{
		$distribution = array();
		if ($topic_id)
		{
			$sql = 'SELECT poll_option_id, wolfsblvt_poll_option_value, COUNT(*) AS voter_count
				FROM ' . POLL_VOTES_TABLE . '
				WHERE topic_id = ' . $topic_id . ' AND poll_option_id > 0
				GROUP BY poll_option_id, wolfsblvt_poll_option_value';
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$distribution['primary'][(int) $row['poll_option_id']][(int) $row['wolfsblvt_poll_option_value']] = (int) $row['voter_count'];
			}
			$this->db->sql_freeresult($result);
		}
		$extra_ids = array();
		foreach ($questions as $question)
		{
			if ((string) $question['id'] !== 'primary')
			{
				$extra_ids[] = (int) $question['id'];
			}
		}
		$distribution += $this->manager->load_distributions($extra_ids);

		$formatted = array();
		foreach ($results as $question_id => $option_totals)
		{
			foreach ($option_totals as $option_id => $total)
			{
				$scores = isset($distribution[$question_id][$option_id]) ? $distribution[$question_id][$option_id] : array();
				ksort($scores, SORT_NUMERIC);
				$entries = array();
				foreach ($scores as $score => $voters)
				{
					$position = array_search((int) $score, $rank_points, true);
					$entries[] = $type === poll_options::TYPE_RANKING && $position !== false
						? $this->user->lang('AP_RANK_DISTRIBUTION_ENTRY', (int) $voters, $position + 1)
						: $this->user->lang('AP_SCORE_DISTRIBUTION_ENTRY', (int) $voters, (int) $score);
				}
				$rating_count = array_sum($scores);
				$average = poll_options::score_average((int) $total, $rating_count);
				$formatted_average = rtrim(rtrim(number_format($average, 2, '.', ''), '0'), '.');
				$average_mode = $type === poll_options::TYPE_SCORING
					&& (int) $score_result === poll_options::SCORE_RESULT_AVERAGE;
				$bar_percent = $average_mode && $maximum_score > 0
					? min(100, max(0, (int) round(100 * $average / $maximum_score)))
					: 0;
				$formatted[(string) $question_id][(int) $option_id] = array(
					'total' => $average_mode
						? $this->user->lang('AP_SCORE_AVERAGE', $formatted_average, (int) $maximum_score)
						: $this->user->lang($type === poll_options::TYPE_RANKING ? 'AP_RANK_TOTAL' : 'AP_SCORE_TOTAL', (int) $total),
					'label' => $this->user->lang[$type === poll_options::TYPE_RANKING ? 'AP_RANK_BREAKDOWN' : 'AP_SCORE_BREAKDOWN'],
					'detail' => implode('<br />', $entries),
					'average' => $formatted_average,
					'rating_count' => $rating_count,
					'weighted_total' => (int) $total,
					'maximum_score' => (int) $maximum_score,
					'bar_percent' => $bar_percent,
					'average_mode' => $average_mode,
					'show_percent' => !$average_mode || $show_percent,
				);
			}
		}
		return $formatted;
	}

	/**
	 * Load the public voter list after an AJAX ballot update.
	 *
	 * @param int   $topic_id Topic ID
	 * @param array $questions Poll questions
	 * @param int   $type Poll type
	 * @return array
	 */
	protected function load_voter_lists($topic_id, array $questions, $type)
	{
		$lists = array();
		foreach ($questions as $question)
		{
			foreach ($question['option_ids'] as $option_id)
			{
				$lists[(string) $question['id']][(int) $option_id] = '';
			}
		}

		$sql = 'SELECT v.poll_option_id AS option_id, v.vote_user_id,
				v.wolfsblvt_vote_user_name AS vote_user_name,
				v.wolfsblvt_poll_option_value AS vote_value,
				u.user_id AS existing_user_id, u.username, u.user_colour
			FROM ' . POLL_VOTES_TABLE . ' v
			LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = v.vote_user_id
			WHERE v.topic_id = ' . (int) $topic_id . ' AND v.poll_option_id > 0
			ORDER BY v.poll_option_id, u.username_clean';
		$result = $this->db->sql_query($sql);
		$primary = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$primary[(int) $row['option_id']][] = $row;
		}
		$this->db->sql_freeresult($result);

		$extra_ids = array_map('intval', array_filter(array_column($questions, 'id'), function ($question_id) {
			return (string) $question_id !== 'primary';
		}));
		$voters = array('primary' => $primary) + $this->manager->load_voters($extra_ids);
		foreach ($voters as $question_id => $option_voters)
		{
			foreach ($option_voters as $option_id => $rows)
			{
				$names = array();
				$guest_votes = 0;
				foreach ($rows as $row)
				{
					if ((int) $row['vote_user_id'] === ANONYMOUS)
					{
						$guest_votes += (int) $row['vote_value'];
						continue;
					}
					$deleted = empty($row['existing_user_id']);
					$name = $deleted ? (!empty($row['vote_user_name']) ? $row['vote_user_name'] : $this->user->lang['AP_DELETED_USER']) : $row['username'];
					$display_name = get_username_string($deleted ? 'no_profile' : 'full', $deleted ? ANONYMOUS : (int) $row['vote_user_id'], $name, $deleted ? '' : $row['user_colour']);
					$names[] = $display_name . ($type === poll_options::TYPE_CHOICE ? '' : ' (' . (int) $row['vote_value'] . ')');
				}
				if ($guest_votes)
				{
					$names[] = $this->user->lang('AP_GUEST_VOTES', $guest_votes);
				}
				$lists[(string) $question_id][(int) $option_id] = implode($this->user->lang['COMMA_SEPARATOR'], $names);
			}
		}

		return $lists;
	}

	protected function poll_type(array $topic)
	{
		return poll_options::is_valid_type($topic['wolfsblvt_poll_type'])
			? (int) $topic['wolfsblvt_poll_type']
			: ((int) $topic['wolfsblvt_poll_max_value'] > 1 ? poll_options::TYPE_SCORING : poll_options::TYPE_CHOICE);
	}

	protected function has_answers(array $answers)
	{
		foreach ($answers as $votes)
		{
			if ($votes)
			{
				return true;
			}
		}
		return false;
	}

	protected function required_complete(array $questions, array $answers)
	{
		foreach ($questions as $question)
		{
			if (!empty($question['required']) && empty($answers[(string) $question['id']]))
			{
				return false;
			}
		}
		return true;
	}

	protected function error($key, $status)
	{
		$message = isset($this->user->lang[$key]) ? $this->user->lang[$key] : $this->user->lang['FORM_INVALID'];
		return $this->response(array('success' => false, 'error' => $message), $status);
	}

	protected function response(array $data, $status)
	{
		$response = new JsonResponse($data, $status);
		$response->headers->set('Cache-Control', 'private, no-store');
		$response->headers->set('X-Content-Type-Options', 'nosniff');
		return $response;
	}
}
