<?php
/**
 *
 * Advanced Polls
 *
 * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
 */

namespace wolfsblvt\advancedpolls\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 */
class listener implements EventSubscriberInterface
{
	/** @var \wolfsblvt\advancedpolls\core\advancedpolls */
	protected $advancedpolls;

	/** @var \wolfsblvt\advancedpolls\core\vote_user_lifecycle */
	protected $vote_user_lifecycle;

	/** @var \wolfsblvt\advancedpolls\core\multi_question_manager */
	protected $multi_question_manager;

	/** @var \wolfsblvt\advancedpolls\core\poll_option_appender */
	protected $poll_option_appender;

	/** @var \phpbb\request\request_interface */
	protected $request;

	/** @var \phpbb\controller\helper */
	protected $controller_helper;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\path_helper */
	protected $path_helper;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/**
	 * Constructor of event listener
	 *
	 * @param \wolfsblvt\advancedpolls\core\advancedpolls	$advancedpolls		Advanced Polls
	 * @param \wolfsblvt\advancedpolls\core\vote_user_lifecycle $vote_user_lifecycle Vote user lifecycle
	 * @param \wolfsblvt\advancedpolls\core\multi_question_manager $multi_question_manager Multi-question persistence
	 * @param \wolfsblvt\advancedpolls\core\poll_option_appender $poll_option_appender Safe live option appends
	 * @param \phpbb\request\request_interface			$request			Request object
	 * @param \phpbb\controller\helper				$controller_helper Controller helper
	 * @param \phpbb\config\config					$config Config object
	 * @param \phpbb\auth\auth						$auth Auth object
	 * @param \phpbb\path_helper							$path_helper		phpBB path helper
	 * @param \phpbb\template\template						$template			Template object
	 * @param \phpbb\user									$user				User object
	 */
	public function __construct(\wolfsblvt\advancedpolls\core\advancedpolls $advancedpolls, \wolfsblvt\advancedpolls\core\vote_user_lifecycle $vote_user_lifecycle, \wolfsblvt\advancedpolls\core\multi_question_manager $multi_question_manager, \wolfsblvt\advancedpolls\core\poll_option_appender $poll_option_appender, \phpbb\request\request_interface $request, \phpbb\controller\helper $controller_helper, \phpbb\config\config $config, \phpbb\auth\auth $auth, \phpbb\path_helper $path_helper, \phpbb\template\template $template, \phpbb\user $user)
	{
		$this->advancedpolls = $advancedpolls;
		$this->vote_user_lifecycle = $vote_user_lifecycle;
		$this->multi_question_manager = $multi_question_manager;
		$this->poll_option_appender = $poll_option_appender;
		$this->request = $request;
		$this->controller_helper = $controller_helper;
		$this->config = $config;
		$this->auth = $auth;
		$this->path_helper = $path_helper;
		$this->template = $template;
		$this->user = $user;
	}

	/**
	 * Assign functions defined in this class to event listeners in the core
	 *
	 * @return array<string,string>
	 */
	public static function getSubscribedEvents()
	{
		return array(
			'core.permissions'								=> 'adv_polls_permissions',				// permissions
			'core.user_setup'								=> 'load_language_on_setup',			// language for notifications
			'core.delete_user_before'						=> 'delete_user_before',				// retain or remove poll votes
			'core.delete_topics_before_query'			=> 'delete_topics_before',				// remove multi-page data
			'core.posting_modify_submission_errors'			=> 'check_config_for_polls',			// posting check before saving
			'core.posting_modify_template_vars'				=> 'config_for_polls_to_template',		// posting to template
			'core.submit_post_modify_sql_data'				=> 'save_config_for_polls',				// posting to db
			'core.submit_post_end'							=> 'save_multi_questions',				// additional poll pages
			'core.viewtopic_modify_poll_data'				=> 'do_poll_voting_modifications',		// viewtopic to db
			'core.viewtopic_modify_poll_ajax_data'		=> 'do_poll_ajax_modifications',			// redact hidden AJAX results
			'core.viewtopic_modify_poll_template_data'		=> 'do_poll_template_modifications',	// viewtopic to template
		);
	}

	/**
	 * Retain or remove votes according to phpBB's account deletion mode.
	 *
	 * @param object $event Event data
	 * @return void
	 */
	public function delete_user_before($event)
	{
		$this->vote_user_lifecycle->handle(
			$event['mode'],
			$event['user_ids'],
			$event['retain_username'],
			$event['user_rows']
		);
	}

	/**
	 * Remove question, option, vote and ballot rows owned by deleted topics.
	 *
	 * @param object $event Event data
	 * @return void
	 */
	public function delete_topics_before($event)
	{
		$this->multi_question_manager->delete_topics($event['topic_ids']);
		$this->poll_option_appender->delete_topics($event['topic_ids']);
	}

	/**
	 * Adds the permission to the right permission category
	 *
	 * @param object $event The event object
	 * @return void
	 */
	public function adv_polls_permissions($event)
	{
		$permissions = array_merge($event['permissions'], array(
				'f_seevoters'		=> array('lang' => 'ACL_F_SEEVOTERS', 'cat' => 'polls'),
				'm_seevoters'		=> array('lang' => 'ACL_M_SEEVOTERS', 'cat' => 'misc'),
			));
		$event['permissions'] = $permissions;
	}

	/**
	* Load common language files during user setup
	*
	* @param object $event The event object
	* @return void
	*/
	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'wolfsblvt/advancedpolls',
			'lang_set' => array('advancedpolls', 'advancedpolls_common'),
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	/**
	 * Checks the advanced config for polls before saving into the topic, from the posting page
	 *
	 * @param object $event The event object
	 * @return void
	 */
	public function check_config_for_polls($event)
	{
		$poll = $event['poll'];

		if ($event['submit'] && isset($poll['poll_title']) && $poll['poll_title'])
		{
			$error = $this->advancedpolls->check_config_for_polls($poll);
			if (!$error)
			{
				$multi = $this->decode_multi_questions($poll);
				if ($multi['error'])
				{
					$error[] = isset($this->user->lang[$multi['error']]) ? $this->user->lang[$multi['error']] : $this->user->lang['FORM_INVALID'];
				}
				else if ($this->request->is_set_post('ap_append_poll_options'))
				{
					if ($event['mode'] !== 'edit'
						|| !isset($event['post_data']['topic_first_post_id'])
						|| (int) $event['post_id'] !== (int) $event['post_data']['topic_first_post_id'])
					{
						$error[] = $this->user->lang['AP_APPEND_INVALID'];
					}
					else
					{
						$append = $this->poll_option_appender->validate(
							(int) $event['topic_id'],
							$poll,
							$multi['questions'],
							$this->request->variable('wolfsblvt_poll_vote_mode', \wolfsblvt\advancedpolls\core\poll_options::VOTE_MODE_NO_CHANGE)
						);
						if ($append['error'])
						{
							$error[] = isset($this->user->lang[$append['error']]) ? $this->user->lang[$append['error']] : $this->user->lang['FORM_INVALID'];
						}
					}
				}
			}
			if (count($error))
			{
				$event['error'] = array_merge($event['error'], $error);
			}
			else
			{
				$event['poll'] = $poll;
			}
		}
	}

	/**
	 * Adds the poll config options to the posting template
	 *
	 * @param object $event The event object
	 * @return void
	 */
	public function config_for_polls_to_template($event)
	{
		$post_data = $event['post_data'];
		$page_data = $event['page_data'];
		$preview = $event['preview'];
		$this->advancedpolls->config_for_polls_to_template($post_data, $page_data, $preview);
		$topic_id = isset($post_data['topic_id']) ? (int) $post_data['topic_id'] : 0;
		if ($preview || $this->request->is_set_post('ap_multi_questions'))
		{
			$json = $this->request->raw_variable('ap_multi_questions', '', \phpbb\request\request_interface::POST);
		}
		else
		{
			$json = json_encode($topic_id ? $this->multi_question_manager->load($topic_id) : array());
		}
		$page_data['AP_MULTI_QUESTIONS_JSON'] = htmlspecialchars($json ?: '[]', ENT_COMPAT, 'UTF-8');
		$page_data['AP_CAN_APPEND_OPTIONS'] = $event['mode'] === 'edit'
			&& !empty($post_data['poll_title'])
			&& isset($post_data['topic_first_post_id'])
			&& (int) $event['post_id'] === (int) $post_data['topic_first_post_id'];
		$page_data['AP_APPEND_OPTIONS_CHECKED'] = $this->request->is_set_post('ap_append_poll_options') ? ' checked="checked"' : '';
		$event['page_data'] = $page_data;
	}

	/**
	 * Save additional pages after phpBB has assigned the topic ID.
	 *
	 * @param object $event Event object
	 * @return void
	 */
	public function save_multi_questions($event)
	{
		if ($this->poll_option_appender->has_pending())
		{
			$this->poll_option_appender->commit();
			return;
		}

		if (!$this->request->is_set_post('ap_multi_questions'))
		{
			return;
		}

		$topic_id = isset($event['data']['topic_id']) ? (int) $event['data']['topic_id'] : 0;
		if (!$topic_id)
		{
			return;
		}

		$poll = isset($event['poll']) ? $event['poll'] : array();
		$questions = array();
		if (!empty($poll['poll_title']))
		{
			$decoded = $this->decode_multi_questions($poll);
			if ($decoded['error'])
			{
				return;
			}
			$questions = $decoded['questions'];
		}
		$this->multi_question_manager->sync($topic_id, $questions);
	}

	/**
	 * Decode extra questions using the global selection/ranking limit.
	 *
	 * @param array $poll phpBB poll payload
	 * @return array
	 */
	protected function decode_multi_questions(array $poll)
	{
		$minimum_options = isset($poll['poll_max_options']) ? max(2, (int) $poll['poll_max_options']) : 2;
		return \wolfsblvt\advancedpolls\core\multi_question_payload::decode(
			$this->request->raw_variable('ap_multi_questions', '', \phpbb\request\request_interface::POST),
			$minimum_options
		);
	}

	/**
	 * Saves the advanced config for polls into the topic, from the posting page
	 *
	 * @param object $event The event object
	 * @return void
	 */
	public function save_config_for_polls($event)
	{
		if (isset($event['poll']['poll_title']))
		{
			$poll = $event['poll'];
			$editing_topic_poll = in_array($event['post_mode'], array('edit_first_post', 'edit_topic'), true)
				&& isset($event['data']['post_id'], $event['data']['topic_first_post_id'])
				&& (int) $event['data']['post_id'] === (int) $event['data']['topic_first_post_id'];
			if ($this->request->is_set_post('ap_append_poll_options') && $editing_topic_poll)
			{
				$multi = $this->decode_multi_questions($poll);
				$append = $this->poll_option_appender->prepare(
					(int) $event['data']['topic_id'],
					$poll,
					$multi['error'] ? array() : $multi['questions'],
					$this->request->variable('wolfsblvt_poll_vote_mode', \wolfsblvt\advancedpolls\core\poll_options::VOTE_MODE_NO_CHANGE)
				);
				if (!$append['error'])
				{
					$poll['poll_options'] = $append['existing_primary'];
					$poll['poll_options_size'] = count($append['existing_primary']);
					$event['poll'] = $poll;
				}
			}
			$sql_data = $event['sql_data'];
			$this->advancedpolls->save_config_for_polls($sql_data);
			$event['sql_data'] = $sql_data;
		}
	}

	/**
	 * Modifies the voting process depending on the advanced poll settings
	 *
	 * @param object $event The event object
	 * @return void
	 */
	public function do_poll_voting_modifications($event)
	{
		$topic_data = $event['topic_data'];

		if (isset($topic_data['poll_title']))
		{
			$vote_counts = $event['vote_counts'];
			$cur_voted_id = $event['cur_voted_id'];
			$voted_id = $event['voted_id'];
			$poll_info = $event['poll_info'];
			$s_can_vote = $event['s_can_vote'];
			$s_display_results = $event['s_display_results'];
			$viewtopic_url = $event['viewtopic_url'];
			$multi_questions = $this->multi_question_manager->load((int) $topic_data['topic_id']);
			$has_multi_questions = (bool) $multi_questions;
			if ($has_multi_questions && ($this->request->is_set_post('update') || $this->request->is_set_post('delete_vote') || $this->request->is_set_post('no_vote')))
			{
				// Multi-page ballots are accepted only by the atomic extension endpoint.
				$s_can_vote = false;
			}
			else
			{
				$this->advancedpolls->do_poll_voting_modifications($topic_data, $vote_counts, $cur_voted_id, $voted_id, $poll_info, $s_can_vote, $s_display_results, $viewtopic_url);
			}
			if ($has_multi_questions)
			{
				$guest_hash = $this->guest_token_hash((int) $topic_data['topic_id']);
				$completed = $this->multi_question_manager->has_ballot(
					(int) $topic_data['topic_id'],
					(int) $this->user->data['user_id'],
					$guest_hash
				);
				if ($completed)
				{
					$vote_mode = isset($topic_data['wolfsblvt_poll_vote_mode']) ? (int) $topic_data['wolfsblvt_poll_vote_mode'] : \wolfsblvt\advancedpolls\core\poll_options::VOTE_MODE_NO_CHANGE;
					if ($vote_mode === \wolfsblvt\advancedpolls\core\poll_options::VOTE_MODE_NO_CHANGE)
					{
						$s_can_vote = false;
					}
					$ended = !empty($topic_data['poll_length']) && (int) $topic_data['poll_start'] + (int) $topic_data['poll_length'] <= time();
					$visibility = isset($topic_data['wolfsblvt_poll_visibility']) ? (int) $topic_data['wolfsblvt_poll_visibility'] : \wolfsblvt\advancedpolls\core\poll_options::VISIBILITY_DEFAULT;
					$s_display_results = !\wolfsblvt\advancedpolls\core\poll_options::results_are_hidden($visibility, $ended, true, true);
				}
				if (!$s_can_vote && $this->can_continue_incremental_ballot($topic_data, $poll_info, $multi_questions, $guest_hash))
				{
					$s_can_vote = true;
				}
			}
			$event['vote_counts'] = $vote_counts;
			$event['cur_voted_id'] = $cur_voted_id;
			$event['voted_id'] = $voted_id;
			$event['poll_info'] = $poll_info;
			$event['s_can_vote'] = $s_can_vote;
			$event['s_display_results'] = $s_display_results;
		}
	}

	/**
	 * Redacts aggregate vote values from AJAX responses for hidden polls.
	 *
	 * @param object $event Event data
	 * @return void
	 */
	public function do_poll_ajax_modifications($event)
	{
		$data = $event['data'];
		$this->advancedpolls->do_poll_ajax_modifications($event['topic_data'], $data);
		$event['data'] = $data;
	}
	/**
	 * Modifys the viewtopic template vars to match the advanced poll settings
	 *
	 * @param object $event The event object
	 * @return void
	 */
	public function do_poll_template_modifications($event)
	{
		$topic_data = $event['topic_data'];

		if (isset($topic_data['poll_title']))
		{
			$vote_counts = $event['vote_counts'];
			$poll_info = $event['poll_info'];
			$poll_template_data = $event['poll_template_data'];
			$poll_options_template_data = $event['poll_options_template_data'];
			$this->advancedpolls->do_poll_template_modifications($topic_data, $vote_counts, $poll_info, $poll_template_data, $poll_options_template_data);
			$this->add_multi_questions_to_template($topic_data, $poll_template_data);
			$event['poll_template_data'] = $poll_template_data;
			$event['poll_options_template_data'] = $poll_options_template_data;
		}
	}

	/**
	 * Render extra pages using the same rules and vote state as the first page.
	 *
	 * @param array $topic_data Topic row
	 * @param array $poll_template_data Poll template data
	 * @return void
	 */
	protected function add_multi_questions_to_template(array $topic_data, array &$poll_template_data)
	{
		$questions = $this->multi_question_manager->load((int) $topic_data['topic_id']);
		if (!$questions)
		{
			return;
		}

		$guest_hash = '';
		if (!$this->user->data['is_registered'])
		{
			$guest_hash = $this->guest_token_hash((int) $topic_data['topic_id']);
		}
		$current = $this->multi_question_manager->load_votes(
			(int) $topic_data['topic_id'],
			(int) $this->user->data['user_id'],
			$guest_hash
		);
		$distributions = $this->multi_question_manager->load_distributions(array_column($questions, 'id'));
		$show_voters = !empty($topic_data['wolfsblvt_poll_voters_show'])
			&& !empty($poll_template_data['S_DISPLAY_RESULTS'])
			&& $this->auth->acl_get('f_seevoters', (int) $topic_data['forum_id']);
		$voters = $show_voters ? $this->multi_question_manager->load_voters(array_column($questions, 'id')) : array();
		$type = isset($topic_data['wolfsblvt_poll_type']) ? (int) $topic_data['wolfsblvt_poll_type'] : \wolfsblvt\advancedpolls\core\poll_options::TYPE_CHOICE;
		$rank_points = \wolfsblvt\advancedpolls\core\ranked_vote::normalise_points(isset($topic_data['wolfsblvt_poll_rank_points']) ? $topic_data['wolfsblvt_poll_rank_points'] : '');
		if (!empty($topic_data['wolfsblvt_poll_show_ordered']) && !empty($poll_template_data['S_DISPLAY_RESULTS']))
		{
			foreach ($questions as &$ordered_question)
			{
				usort($ordered_question['options'], function (array $left, array $right) {
					return ((int) $right['total'] - (int) $left['total']) ?: ((int) $left['order'] - (int) $right['order']);
				});
			}
			unset($ordered_question);
		}
		$poll_template_data['AP_HAS_MULTI_QUESTIONS'] = true;
		$poll_template_data['AP_MULTI_VOTE_URL'] = $this->controller_helper->route('wolfsblvt_advancedpolls_multi_question_vote', array('topic_id' => (int) $topic_data['topic_id']));
		$poll_template_data['AP_MULTI_TYPE'] = $type;
		$poll_template_data['AP_MULTI_MAX_OPTIONS'] = (int) $topic_data['poll_max_options'];
		$poll_template_data['AP_MULTI_TOTAL_VALUE'] = (int) $topic_data['wolfsblvt_poll_total_value'];
		$poll_template_data['AP_MULTI_RANK_POINTS'] = implode(',', $rank_points);
		$poll_template_data['AP_PRIMARY_REQUIRED'] = !empty($topic_data['wolfsblvt_poll_required']);
		$poll_template_data['AP_MULTI_NO_VOTE'] = !empty($this->config['wolfsblvt.advancedpolls.activate_no_vote']);

		foreach ($questions as $question_index => $question)
		{
			$this->template->assign_block_vars('ap_question', array(
				'ID' => (int) $question['id'],
				'NUMBER' => $question_index + 2,
				'TEXT' => htmlspecialchars(censor_text($question['text']), ENT_QUOTES, 'UTF-8'),
				'REQUIRED' => $question['required'],
				'S_CAN_VOTE' => !empty($poll_template_data['S_CAN_VOTE']),
				'S_DISPLAY_RESULTS' => !empty($poll_template_data['S_DISPLAY_RESULTS']),
			));
			$total = array_sum(array_column($question['options'], 'total'));
			foreach ($question['options'] as $option)
			{
				$value = isset($current[$question['id']][$option['id']]) ? (int) $current[$question['id']][$option['id']] : 0;
				$score_options = '<option value="0"></option>';
				if ($type === \wolfsblvt\advancedpolls\core\poll_options::TYPE_SCORING)
				{
					for ($score = (isset($topic_data['wolfsblvt_poll_min_value']) ? (int) $topic_data['wolfsblvt_poll_min_value'] : 1); $score <= (int) $topic_data['wolfsblvt_poll_max_value']; $score++)
					{
						$score_options .= '<option value="' . $score . '"' . ($score === $value ? ' selected="selected"' : '') . '>' . $score . '</option>';
					}
				}
				$rank = array_search($value, $rank_points, true);
				$voter_names = array();
				$guest_votes = 0;
				foreach (isset($voters[$question['id']][$option['id']]) ? $voters[$question['id']][$option['id']] : array() as $voter)
				{
					if ((int) $voter['vote_user_id'] === ANONYMOUS)
					{
						$guest_votes += (int) $voter['vote_value'];
						continue;
					}
					$deleted = empty($voter['existing_user_id']);
					$name = $deleted ? (!empty($voter['vote_user_name']) ? $voter['vote_user_name'] : $this->user->lang['AP_DELETED_USER']) : $voter['username'];
					$display_name = get_username_string($deleted ? 'no_profile' : 'full', $deleted ? ANONYMOUS : (int) $voter['vote_user_id'], $name, $deleted ? '' : $voter['user_colour']);
					$voter_names[] = $display_name . ($type === \wolfsblvt\advancedpolls\core\poll_options::TYPE_CHOICE ? '' : ' (' . (int) $voter['vote_value'] . ')');
				}
				if ($guest_votes)
				{
					$voter_names[] = $this->user->lang('AP_GUEST_VOTES', $guest_votes);
				}
				$breakdown = array();
				$option_distribution = isset($distributions[$question['id']][$option['id']]) ? $distributions[$question['id']][$option['id']] : array();
				ksort($option_distribution, SORT_NUMERIC);
				foreach ($option_distribution as $score => $voters)
				{
					$position = array_search((int) $score, $rank_points, true);
					$breakdown[] = $type === \wolfsblvt\advancedpolls\core\poll_options::TYPE_RANKING && $position !== false
						? $this->user->lang('AP_RANK_DISTRIBUTION_ENTRY', (int) $voters, $position + 1)
						: $this->user->lang('AP_SCORE_DISTRIBUTION_ENTRY', (int) $voters, (int) $score);
				}
				$this->template->assign_block_vars('ap_question.option', array(
					'ID' => (int) $option['id'],
					'TEXT' => htmlspecialchars(censor_text($option['text']), ENT_QUOTES, 'UTF-8'),
					'TOTAL' => (int) $option['total'],
					'PERCENT' => $total ? round(100 * (int) $option['total'] / $total) : 0,
					'VALUE' => $value,
					'SELECTED' => $value > 0,
					'RANK' => $rank === false ? 0 : $rank + 1,
					'SCORE_OPTIONS' => $score_options,
					'SCORE_TOTAL' => $this->user->lang($type === \wolfsblvt\advancedpolls\core\poll_options::TYPE_RANKING ? 'AP_RANK_TOTAL' : 'AP_SCORE_TOTAL', (int) $option['total']),
					'BREAKDOWN_LABEL' => $this->user->lang[$type === \wolfsblvt\advancedpolls\core\poll_options::TYPE_RANKING ? 'AP_RANK_BREAKDOWN' : 'AP_SCORE_BREAKDOWN'],
					'BREAKDOWN' => implode('<br />', $breakdown),
					'VOTERS' => implode($this->user->lang['COMMA_SEPARATOR'], $voter_names),
				));
			}
		}
	}

	/**
	 * Read and hash the random guest ballot cookie.
	 *
	 * @param int $topic_id Topic ID
	 * @return string
	 */
	protected function guest_token_hash($topic_id)
	{
		if ($this->user->data['is_registered'])
		{
			return '';
		}
		$cookie = $this->request->variable(
			$this->config['cookie_name'] . '_ap_multi_' . (int) $topic_id,
			'',
			true,
			\phpbb\request\request_interface::COOKIE
		);
		return preg_match('/^[a-f0-9]{64}$/D', $cookie) ? hash('sha256', $cookie) : '';
	}

	/**
	 * Restore the voting controls when another page still has incremental capacity.
	 *
	 * @param array  $topic_data Topic row
	 * @param array  $poll_info Native question options
	 * @param array  $questions Extra questions
	 * @param string $guest_hash Guest token hash
	 * @return bool
	 */
	protected function can_continue_incremental_ballot(array $topic_data, array $poll_info, array $questions, $guest_hash)
	{
		if ((int) $topic_data['wolfsblvt_poll_vote_mode'] !== \wolfsblvt\advancedpolls\core\poll_options::VOTE_MODE_INCREMENTAL
			|| !empty($this->user->data['is_bot'])
			|| !$this->auth->acl_get('f_vote', (int) $topic_data['forum_id'])
			|| (int) $topic_data['forum_status'] === ITEM_LOCKED
			|| ((int) $topic_data['topic_status'] === ITEM_LOCKED && empty($this->config['wolfsblvt.advancedpolls.activate_closed_voting']))
			|| (!empty($topic_data['poll_length']) && (int) $topic_data['poll_start'] + (int) $topic_data['poll_length'] <= time()))
		{
			return false;
		}

		$definitions = array(array(
			'id' => 'primary',
			'option_ids' => array_map('intval', array_column($poll_info, 'poll_option_id')),
		));
		foreach ($questions as $question)
		{
			$definitions[] = array(
				'id' => (string) $question['id'],
				'option_ids' => array_map('intval', array_column($question['options'], 'id')),
			);
		}
		$current = $this->multi_question_manager->load_votes(
			(int) $topic_data['topic_id'],
			(int) $this->user->data['user_id'],
			$guest_hash
		);
		$current['primary'] = $this->multi_question_manager->load_primary_votes(
			(int) $topic_data['topic_id'],
			(int) $this->user->data['user_id'],
			$guest_hash
		);
		$rules = array(
			'type' => isset($topic_data['wolfsblvt_poll_type']) ? (int) $topic_data['wolfsblvt_poll_type'] : \wolfsblvt\advancedpolls\core\poll_options::TYPE_CHOICE,
			'max_options' => (int) $topic_data['poll_max_options'],
			'min_value' => isset($topic_data['wolfsblvt_poll_min_value']) ? (int) $topic_data['wolfsblvt_poll_min_value'] : 1,
			'max_value' => (int) $topic_data['wolfsblvt_poll_max_value'],
			'total_value' => (int) $topic_data['wolfsblvt_poll_total_value'],
		);

		return \wolfsblvt\advancedpolls\core\multi_question_vote::can_add_votes($definitions, $current, $rules);
	}
}
