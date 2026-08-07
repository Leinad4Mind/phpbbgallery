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
use wolfsblvt\advancedpolls\core\poll_options;

class infopoll
{
	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\request\request_interface */
	protected $request;

	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\auth\auth $auth, \phpbb\user $user, \phpbb\request\request_interface $request)
	{
		$this->db = $db;
		$this->auth = $auth;
		$this->user = $user;
		$this->request = $request;
	}

	/**
	 * Return detailed voter information for an AJAX moderator request.
	 *
	 * @param int $topic_id Topic ID
	 * @return JsonResponse
	 */
	public function details($topic_id)
	{
		$this->user->add_lang_ext('wolfsblvt/advancedpolls', 'advancedpolls');
		if (!$this->request->is_ajax())
		{
			return $this->response(array('error' => $this->user->lang['NO_AUTH_OPERATION']), 400);
		}

		$sql = 'SELECT topic_id, forum_id, topic_first_post_id, poll_title, poll_max_options,
				wolfsblvt_poll_type, wolfsblvt_poll_max_value,
				wolfsblvt_poll_score_result
			FROM ' . TOPICS_TABLE . '
			WHERE topic_id = ' . (int) $topic_id;
		$result = $this->db->sql_query($sql);
		$topic = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		if (!$topic || !$topic['poll_title'])
		{
			return $this->response(array('error' => $this->user->lang['NO_TOPIC']), 404);
		}

		$forum_id = (int) $topic['forum_id'];
		if (!$this->auth->acl_get('f_read', $forum_id) || !$this->auth->acl_get('m_seevoters', $forum_id))
		{
			return $this->response(array('error' => $this->user->lang['NOT_AUTHORISED']), 403);
		}

		$options = $this->load_options($topic);
		if (!$options)
		{
			return $this->response(array('error' => $this->user->lang['NO_TOPIC']), 404);
		}
		$question = $options['question'];
		unset($options['question']);

		$type = isset($topic['wolfsblvt_poll_type']) && poll_options::is_valid_type($topic['wolfsblvt_poll_type'])
			? (int) $topic['wolfsblvt_poll_type']
			: ((int) $topic['wolfsblvt_poll_max_value'] > 1 ? poll_options::TYPE_SCORING : poll_options::TYPE_CHOICE);
		$weighted = $type !== poll_options::TYPE_CHOICE;
		$voters = $this->load_voters((int) $topic_id, $weighted);
		$rating_counts = $type === poll_options::TYPE_SCORING
			? $this->load_rating_counts((int) $topic_id)
			: array();
		$all_voters = array();
		$registered_totals = array();

		foreach ($voters as $option_id => $option_voters)
		{
			foreach ($option_voters as $voter)
			{
				$user_id = (int) $voter['user_id'];
				$value = $weighted ? (int) $voter['value'] : 1;
				$registered_totals[$option_id] = isset($registered_totals[$option_id])
					? $registered_totals[$option_id] + $value
					: $value;
				$all_voters[$user_id] = isset($all_voters[$user_id])
					? $all_voters[$user_id] + $value
					: $value;
			}
		}

		$response_options = array();
		$total_guest_votes = 0;
		foreach ($options as $option_id => $option)
		{
			$voter_list = array();
			if (isset($voters[$option_id]))
			{
				foreach ($voters[$option_id] as $voter)
				{
				$voter_list[] = $voter['username'] . ($weighted ? ' (' . (int) $voter['value'] . ')' : '');
				}
			}

			$guest_votes = max(0, (int) $option['total'] - (isset($registered_totals[$option_id]) ? $registered_totals[$option_id] : 0));
			if ($guest_votes)
			{
				$voter_list[] = $this->user->lang('AP_GUEST_VOTES', $guest_votes);
				$total_guest_votes += $guest_votes;
			}

			$average_mode = $type === poll_options::TYPE_SCORING
				&& isset($topic['wolfsblvt_poll_score_result'])
				&& (int) $topic['wolfsblvt_poll_score_result'] === poll_options::SCORE_RESULT_AVERAGE;
			$average = $average_mode
				? poll_options::score_average((int) $option['total'], isset($rating_counts[$option_id]) ? $rating_counts[$option_id] : 0)
				: 0;
			$formatted_average = rtrim(rtrim(number_format($average, 2, '.', ''), '0'), '.');
			$response_options[] = array(
				'caption' => $option['caption'],
				'total' => $average_mode
					? $this->user->lang('AP_SCORE_AVERAGE', $formatted_average, (int) $topic['wolfsblvt_poll_max_value'])
					: $this->user->lang($type === poll_options::TYPE_RANKING ? 'AP_RANK_TOTAL' : 'AP_SCORE_TOTAL', (int) $option['total']),
				'voters' => $voter_list
					? implode($this->user->lang['COMMA_SEPARATOR'], $voter_list)
					: '<span class="ap-infopoll-none">' . $this->user->lang['AP_NONE'] . '</span>',
			);
		}

		$all_voter_list = array();
		foreach ($this->unique_voters($voters) as $user_id => $voter)
		{
			$show_total = $weighted || (int) $topic['poll_max_options'] > 1;
			$all_voter_list[] = $voter['username'] . ($show_total ? ' (' . $all_voters[$user_id] . ')' : '');
		}
		if ($total_guest_votes)
		{
			$all_voter_list[] = $this->user->lang('AP_GUEST_VOTES', $total_guest_votes);
		}

		return $this->response(array(
			'title' => $this->user->lang['INFORMATION'],
			'question' => $question,
			'voters_label' => $this->user->lang['AP_VOTERS'],
			'options' => array_values($response_options),
			'all_voters' => $all_voter_list
				? implode($this->user->lang['COMMA_SEPARATOR'], $all_voter_list)
				: '<span class="ap-infopoll-none">' . $this->user->lang['AP_NONE'] . '</span>',
		), 200);
	}

	/**
	 * Count all registered and guest ratings for each option.
	 *
	 * @param int $topic_id Topic ID
	 * @return array
	 */
	protected function load_rating_counts($topic_id)
	{
		$sql = 'SELECT poll_option_id, COUNT(*) AS rating_count
			FROM ' . POLL_VOTES_TABLE . '
			WHERE topic_id = ' . (int) $topic_id . '
				AND poll_option_id > 0
				AND wolfsblvt_poll_option_value > 0
			GROUP BY poll_option_id';
		$result = $this->db->sql_query($sql);
		$counts = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$counts[(int) $row['poll_option_id']] = (int) $row['rating_count'];
		}
		$this->db->sql_freeresult($result);
		return $counts;
	}

	/**
	 * Load and parse poll options.
	 *
	 * @param array $topic Topic row
	 * @return array
	 */
	protected function load_options(array $topic)
	{
		$sql = 'SELECT o.poll_option_id, o.poll_option_text, o.poll_option_total,
				p.bbcode_bitfield, p.bbcode_uid
			FROM ' . POLL_OPTIONS_TABLE . ' o, ' . POSTS_TABLE . ' p
			WHERE o.topic_id = ' . (int) $topic['topic_id'] . '
				AND p.post_id = ' . (int) $topic['topic_first_post_id'] . '
				AND p.topic_id = o.topic_id
			ORDER BY o.poll_option_id';
		$result = $this->db->sql_query($sql);
		$rows = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$rows[] = $row;
		}
		$this->db->sql_freeresult($result);

		if (!$rows)
		{
			return array();
		}

		$parse_flags = ($rows[0]['bbcode_bitfield'] ? OPTION_FLAG_BBCODE : 0) | OPTION_FLAG_SMILIES;
		$options = array(
			'question' => generate_text_for_display($topic['poll_title'], $rows[0]['bbcode_uid'], $rows[0]['bbcode_bitfield'], $parse_flags, true),
		);
		foreach ($rows as $row)
		{
			$options[(int) $row['poll_option_id']] = array(
				'caption' => generate_text_for_display($row['poll_option_text'], $row['bbcode_uid'], $row['bbcode_bitfield'], $parse_flags, true),
				'total' => (int) $row['poll_option_total'],
			);
		}

		return $options;
	}

	/**
	 * Load registered voters grouped by poll option.
	 *
	 * @param int  $topic_id Topic ID
	 * @param bool $weighted Scoring or ranking poll
	 * @return array
	 */
	protected function load_voters($topic_id, $weighted)
	{
		$sql = 'SELECT v.poll_option_id, v.vote_user_id, v.wolfsblvt_poll_option_value,
				v.wolfsblvt_vote_user_name, u.user_id AS existing_user_id,
				u.username, u.username_clean, u.user_colour
			FROM ' . POLL_VOTES_TABLE . ' v
			LEFT JOIN ' . USERS_TABLE . ' u
				ON u.user_id = v.vote_user_id
			WHERE v.topic_id = ' . (int) $topic_id . '
				AND v.poll_option_id > 0
				AND v.vote_user_id <> ' . ANONYMOUS . '
			ORDER BY v.poll_option_id ASC, u.username_clean ASC';
		$result = $this->db->sql_query($sql);
		$voters = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$option_id = (int) $row['poll_option_id'];
			$deleted = empty($row['existing_user_id']);
			$name = $deleted
				? (!empty($row['wolfsblvt_vote_user_name']) ? $row['wolfsblvt_vote_user_name'] : $this->user->lang['AP_DELETED_USER'])
				: $row['username'];
			$voters[$option_id][] = array(
				'user_id' => (int) $row['vote_user_id'],
				'value' => $weighted ? (int) $row['wolfsblvt_poll_option_value'] : 1,
				'username' => get_username_string(
					$deleted ? 'no_profile' : 'full',
					$deleted ? ANONYMOUS : $row['vote_user_id'],
					$name,
					$deleted ? '' : $row['user_colour']
				),
			);
		}
		$this->db->sql_freeresult($result);

		return $voters;
	}

	/**
	 * Reduce option voter lists to one record per user.
	 *
	 * @param array $voters Voters grouped by option
	 * @return array
	 */
	protected function unique_voters(array $voters)
	{
		$unique = array();
		foreach ($voters as $option_voters)
		{
			foreach ($option_voters as $voter)
			{
				$unique[(int) $voter['user_id']] = $voter;
			}
		}

		return $unique;
	}

	/**
	 * Build a private JSON response.
	 *
	 * @param array $data Response data
	 * @param int   $status HTTP status
	 * @return JsonResponse
	 */
	protected function response(array $data, $status)
	{
		$response = new JsonResponse($data, $status);
		$response->headers->set('Cache-Control', 'private, no-store');
		$response->headers->set('X-Content-Type-Options', 'nosniff');

		return $response;
	}
}
