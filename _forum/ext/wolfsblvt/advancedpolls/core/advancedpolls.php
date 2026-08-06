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

namespace wolfsblvt\advancedpolls\core;

class advancedpolls
{
	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\event\dispatcher_interface */
	protected $dispatcher;

	/** @var \phpbb\controller\helper */
	protected $controller_helper;

	/** @var array */
	protected $cur_voted_val;

	/** @var array */
	protected $abstaining_voters;

	/** @var array */
	protected $retained_voter_names;

	/**
	 * Constructor
	 *
	 * @param \phpbb\db\driver\driver_interface		$db				Database
	 * @param \phpbb\config\config					$config			Config helper
	 * @param \phpbb\template\template				$template		Template object
	 * @param \phpbb\user							$user			User object
	 * @param \phpbb\auth\auth						$auth			Auth object
	 * @param \phpbb\request\request				$request		Request object
	 * @param \phpbb\event\dispatcher_interface		$dispatcher		The dispatcher object
	 * @param \phpbb\controller\helper					$controller_helper Controller helper
	 */
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\config\config $config, \phpbb\template\template $template, \phpbb\user $user, \phpbb\auth\auth $auth, \phpbb\request\request $request, \phpbb\event\dispatcher_interface $dispatcher, \phpbb\controller\helper $controller_helper)
	{
		$this->db = $db;
		$this->config = $config;
		$this->template = $template;
		$this->user = $user;
		$this->auth = $auth;
		$this->request = $request;
		$this->dispatcher = $dispatcher;
		$this->controller_helper = $controller_helper;

		$this->cur_voted_val = array();
		$this->abstaining_voters = array();
		$this->retained_voter_names = array();
	}

	/**
	 * Checks the selected poll options
	 *
	 * @param array	$poll		The array of poll data, modified here
	 * @return array 			Array with processed language strings with errors, if any
	 */
	public function check_config_for_polls(&$poll)
	{
		$visibility = $this->request->variable('wolfsblvt_poll_visibility', poll_options::VISIBILITY_DEFAULT);
		$vote_mode = $this->request->variable('wolfsblvt_poll_vote_mode', poll_options::VOTE_MODE_NO_CHANGE);
		$poll_type = $this->request->variable('wolfsblvt_poll_type', poll_options::TYPE_CHOICE);
		if (!poll_options::is_valid_visibility($visibility) || !poll_options::is_valid_vote_mode($vote_mode) || !poll_options::is_valid_type($poll_type))
		{
			return array($this->user->lang['FORM_INVALID']);
		}
		if (empty($this->config['wolfsblvt.advancedpolls.activate_poll_scoring']) && (int) $poll_type !== poll_options::TYPE_CHOICE)
		{
			return array($this->user->lang['FORM_INVALID']);
		}

		// Check for poll scoring options to be consistent
		if ($this->config['wolfsblvt.advancedpolls.activate_poll_scoring'])
		{
			$poll_max_value = $this->request->variable('wolfsblvt_poll_max_value', 1);
			$poll_min_value = $this->request->variable('wolfsblvt_poll_min_value', 1);
			$poll_total_value = $this->request->variable('wolfsblvt_poll_total_value', 1);

			if ((int) $poll_type === poll_options::TYPE_RANKING)
			{
				if ((int) $vote_mode === poll_options::VOTE_MODE_INCREMENTAL)
				{
					return array($this->user->lang['AP_RANK_INCREMENTAL_UNSUPPORTED']);
				}

				$rank_points = ranked_vote::normalise_points($this->request->variable('wolfsblvt_poll_rank_points', array(0)));
				$rank_error = ranked_vote::validate_configuration(
					(int) $poll['poll_max_options'],
					$rank_points,
					isset($poll['poll_options']) ? count($poll['poll_options']) : 0
				);
				if ($rank_error)
				{
					return array($this->user->lang[$rank_error]);
				}

				$this->request->overwrite('wolfsblvt_poll_max_value', max($rank_points));
				$this->request->overwrite('wolfsblvt_poll_min_value', 1);
				$this->request->overwrite('wolfsblvt_poll_total_value', array_sum($rank_points));
			}
			else if ((int) $poll_type === poll_options::TYPE_SCORING && ($poll_min_value < 1 || $poll_max_value < $poll_min_value || $poll_total_value < $poll_min_value || (int) $poll['poll_max_options'] < 1))
			{
				return array($this->user->lang['AP_POLL_VALUES_INVALID']);
			}
			else if ((int) $poll_type === poll_options::TYPE_SCORING && $poll_max_value > $poll_total_value)
			{
				return array($this->user->lang['AP_POLL_TOTAL_LOWER_MAX_VOTES']);
			}
			if ((int) $poll_type === poll_options::TYPE_SCORING && $poll_max_value === 1 && (int) $poll['poll_max_options'] > 1)
			{
				$poll_total_value = (int) $poll['poll_max_options'];
				$this->request->overwrite('wolfsblvt_poll_total_value', (int) $poll['poll_max_options']);
			}
			if ((int) $poll_type === poll_options::TYPE_SCORING && (int) $poll['poll_max_options'] > $poll_total_value)
			{
				return array($this->user->lang['AP_POLL_TOTAL_LOWER_MAX_OPTS']);
			}
		}

		// Check for poll end specs
		if ($this->config['wolfsblvt.advancedpolls.activate_poll_end'])
		{
			// Poll data from the form
			$current_time = time();
			$poll_length_scale = $this->request->variable('wolfsblvt_poll_length_scale', 24);
			$poll_start = $poll['poll_start'] ?: $current_time;
			$poll_length = $poll['poll_length'] ? $poll['poll_length'] * $poll_length_scale * 3600 : 0;
			$poll_end = $poll_start + $poll_length;
			$poll_end_ary = array_map('intval', explode('-', $this->user->format_date($poll_end ?: $current_time, 'Y-n-j-G-i')));
			$poll['poll_length'] = ceil($poll['poll_length'] * $poll_length_scale / 24);
			$poll['poll_start'] = $poll_end - $poll['poll_length'] * 86400;

			// Gather the options we should set, default to selected poll_end, order is critical here
			$opts = array('year', 'mon', 'mday', 'hours', 'minutes');
			$new_poll_end_ary = array();
			foreach ($opts as $key => $opt)
			{
				$new_poll_end_ary[$opt] = $this->request->variable('wolfsblvt_poll_end_' . $opt, -1);
				$new_poll_end_ary[$opt] = (($new_poll_end_ary[$opt] > 0) || (($new_poll_end_ary[$opt] == 0) && in_array($opt, array('hours', 'minutes')))) ? $new_poll_end_ary[$opt] : $poll_end_ary[$key];
			}

			// Check that the input date is valid
			if (!checkdate($new_poll_end_ary['mon'], $new_poll_end_ary['mday'], $new_poll_end_ary['year']) || $new_poll_end_ary['hours'] > 23 || $new_poll_end_ary['minutes'] > 59)
			{
				return array($this->user->lang['AP_POLL_END_INVALID']);
			}

			// Calculate poll_start and poll_length based on poll_end, if specified in the form
			$new_poll_end = $this->user->get_timestamp_from_format('Y-n-j-G-i', sprintf('%d-%d-%d-%02d-%02d', $new_poll_end_ary['year'], $new_poll_end_ary['mon'], $new_poll_end_ary['mday'], $new_poll_end_ary['hours'], $new_poll_end_ary['minutes']));

			$new_poll_length = 0;
			if (abs($new_poll_end - $poll_end) > 60)
			{
				if ($new_poll_end > $current_time)
				{
					$new_poll_length = ceil(($new_poll_end - $current_time) / 86400);
				}
				else if ($poll_end > $current_time)
				{
					$new_poll_length = ceil(($new_poll_end - min($poll_start, $new_poll_end - 60)) / 86400);
				}
			}

			if ($new_poll_length > 0)
			{
				$poll['poll_length'] = $new_poll_length;
				$poll['poll_start'] = $new_poll_end - $new_poll_length * 86400;
			}
		}
		return array();
	}

	/**
	 * Saves the selected poll options to the topic
	 *
	 * @param array	$sql_data	The array of data to be inserted in the database, modified here
	 * @return void
	 */
	public function save_config_for_polls(&$sql_data)
	{
		$options = $this->get_possible_options();

		// Gather the options we should set
		foreach ($options as $option => $default_val)
		{
			if (strpos($option, 'wolfsblvt_poll_end_') !== false)
			{
				continue; // already processed
			}
			else if ($option !== 'wolfsblvt_poll_rank_points')
			{
				$sql_data[TOPICS_TABLE]['sql'][$option] = $this->request->variable($option, $default_val);
			}
		}

		$poll_type = isset($sql_data[TOPICS_TABLE]['sql']['wolfsblvt_poll_type'])
			? (int) $sql_data[TOPICS_TABLE]['sql']['wolfsblvt_poll_type']
			: poll_options::TYPE_CHOICE;
		$sql_data[TOPICS_TABLE]['sql']['wolfsblvt_poll_type'] = $poll_type;
		$rank_points = $poll_type === poll_options::TYPE_RANKING
			? ranked_vote::normalise_points($this->request->variable('wolfsblvt_poll_rank_points', array(0)))
			: array();
		$sql_data[TOPICS_TABLE]['sql']['wolfsblvt_poll_rank_points'] = implode(',', $rank_points);

		$visibility = (int) $sql_data[TOPICS_TABLE]['sql']['wolfsblvt_poll_visibility'];
		$vote_mode = (int) $sql_data[TOPICS_TABLE]['sql']['wolfsblvt_poll_vote_mode'];
		$sql_data[TOPICS_TABLE]['sql']['wolfsblvt_poll_votes_hide'] = ($visibility === poll_options::VISIBILITY_PRIVATE) ? 1 : 0;
		$sql_data[TOPICS_TABLE]['sql']['poll_vote_change'] = ($vote_mode === poll_options::VOTE_MODE_CHANGE) ? 1 : 0;

		// A new or reopened finite poll may need to emit a fresh end
		// notification. Editing an already-ended poll must not notify twice.
		$poll_start = isset($sql_data[TOPICS_TABLE]['sql']['poll_start'])
			? (int) $sql_data[TOPICS_TABLE]['sql']['poll_start']
			: 0;
		$poll_length = isset($sql_data[TOPICS_TABLE]['sql']['poll_length'])
			? (int) $sql_data[TOPICS_TABLE]['sql']['poll_length']
			: 0;
		if ($poll_start > 0 && $poll_length > 0 && $poll_start + $poll_length > time())
		{
			$sql_data[TOPICS_TABLE]['sql']['wolfsblvt_poll_notified'] = 0;
		}
	}

	/**
	 * Adds the enabled poll options to the posting template
	 *
	 * @param array	$post_data		The array of post data
	 * @param array	$page_data		The array of template data, will be modified here
	 * @param bool	$preview		Whether or not the post is being previewed
	 * @return void
	 */
	public function config_for_polls_to_template($post_data, &$page_data, $preview = false)
	{
		// The extension exposes a single vote-mode control, so hide phpBB's
		// overlapping change-vote checkbox.
		if (isset($page_data['S_POLL_VOTE_CHANGE']) && $page_data['S_POLL_VOTE_CHANGE'])
		{
			$page_data['S_POLL_VOTE_CHANGE'] = false;
		}
		$options = $this->get_possible_options();

		if ($post_data['poll_length'])
		{
			$poll_end = $post_data['poll_start'] + $post_data['poll_length'] * 86400;
			$poll_end_ary = array_map('intval', explode('-', $this->user->format_date($poll_end, 'Y-n-j-G-i')));

			// Present the options we should set, order is critical here
			$opts = array('year', 'mon', 'mday', 'hours', 'minutes');
			foreach ($opts as $key => $opt)
			{
				if (isset($options['wolfsblvt_poll_end_' . $opt]))
				{
					$options['wolfsblvt_poll_end_' . $opt] = $poll_end_ary[$key];
				}
			}
		}

		foreach ($options as $option => $default_val)
		{
			if ($option === 'wolfsblvt_poll_rank_points')
			{
				if ($preview || $this->request->is_set($option))
				{
					$value_to_take = implode(',', ranked_vote::normalise_points($this->request->variable($option, array(0))));
				}
				else if (!empty($post_data['poll_title']) && isset($post_data[$option]))
				{
					$value_to_take = (string) $post_data[$option];
				}
				else
				{
					$value_to_take = '';
				}
			}
			else if ($preview || $this->request->is_set($option))
			{
				$value_to_take = $this->request->variable($option, $default_val);
			}
			else if (!empty($post_data['poll_title']) && isset($post_data[$option]))
			{
				$value_to_take = is_bool($default_val) ? (($post_data[$option] == 1) ? true : false) : (int) $post_data[$option];
			}
			else
			{
				$default_config = str_replace('wolfsblvt_', 'wolfsblvt.advancedpolls.default_', $option);
				$value_to_take = is_bool($default_val) ? (isset($this->config[$default_config]) && $this->config[$default_config] == 1) : $default_val;
			}

			if ($option == 'wolfsblvt_poll_max_value')
			{
				$page_data['WOLFSBLVT_POLL_SCORING'] = true;
			}

			if ($option == 'wolfsblvt_poll_end_year')
			{
				$page_data['WOLFSBLVT_POLL_END'] = true;
			}

			if (is_bool($value_to_take))
			{
				$page_data[strtoupper($option)] = true;
				$page_data[strtoupper($option) . '_CHECKED'] = ($value_to_take) ? ' checked="checked"' : '';
			}
			else if ($value_to_take < 0)
			{
				$page_data[strtoupper($option)] = '';
			}
			else
			{
				$page_data[strtoupper($option)] = $value_to_take;
			}

		}

		$poll_type = isset($page_data['WOLFSBLVT_POLL_TYPE'])
			? (int) $page_data['WOLFSBLVT_POLL_TYPE']
			: poll_options::TYPE_CHOICE;
		$page_data['AP_POLL_TYPE_OPTIONS'] = $this->build_select_options(array(
			poll_options::TYPE_CHOICE => 'AP_POLL_TYPE_CHOICE',
			poll_options::TYPE_SCORING => 'AP_POLL_TYPE_SCORING',
			poll_options::TYPE_RANKING => 'AP_POLL_TYPE_RANKING',
		), $poll_type);
		$rank_points = ranked_vote::normalise_points(isset($page_data['WOLFSBLVT_POLL_RANK_POINTS']) ? $page_data['WOLFSBLVT_POLL_RANK_POINTS'] : '');
		$page_data['AP_RANK_POINT_INPUTS'] = $this->build_rank_point_inputs($rank_points);
		$page_data['AP_IS_SCORING'] = $poll_type === poll_options::TYPE_SCORING;
		$page_data['AP_IS_RANKING'] = $poll_type === poll_options::TYPE_RANKING;

		if ($preview && ($page_data['AP_IS_SCORING'] || $page_data['AP_IS_RANKING']))
		{
			$option_eval_opts_txt = '<option value="0"></option>';
			if ($page_data['AP_IS_SCORING'])
			{
				for ($i = (int) $page_data['WOLFSBLVT_POLL_MIN_VALUE']; $i <= (int) $page_data['WOLFSBLVT_POLL_MAX_VALUE']; $i++)
				{
					$option_eval_opts_txt .= '<option value="' . $i . '">' . $i . '</option>';
				}
			}
			$block_vars = array(
				'AP_POLL_OPTION_VALUE' => 0,
				'AP_POLL_OPTION_OPTS' => $option_eval_opts_txt,
			);
			for ($i = 0, $count = count($post_data['poll_options']); $i < $count; $i++)
			{
				$this->template->alter_block_array('poll_option', $block_vars, $i, 'change');
			}
		}

		$visibility = isset($page_data['WOLFSBLVT_POLL_VISIBILITY'])
			? (int) $page_data['WOLFSBLVT_POLL_VISIBILITY']
			: poll_options::VISIBILITY_DEFAULT;
		$vote_mode = isset($page_data['WOLFSBLVT_POLL_VOTE_MODE'])
			? (int) $page_data['WOLFSBLVT_POLL_VOTE_MODE']
			: poll_options::VOTE_MODE_NO_CHANGE;
		$page_data['AP_POLL_VISIBILITY_OPTIONS'] = $this->build_select_options(array(
			poll_options::VISIBILITY_PUBLIC => 'AP_VISIBILITY_PUBLIC',
			poll_options::VISIBILITY_DEFAULT => 'AP_VISIBILITY_DEFAULT',
			poll_options::VISIBILITY_VOTE_COMPLETED => 'AP_VISIBILITY_VOTE_COMPLETED',
			poll_options::VISIBILITY_PRIVATE => 'AP_VISIBILITY_PRIVATE',
		), $visibility);
		$page_data['AP_POLL_VOTE_MODE_OPTIONS'] = $this->build_select_options(array(
			poll_options::VOTE_MODE_NO_CHANGE => 'AP_VOTE_MODE_NO_CHANGE',
			poll_options::VOTE_MODE_INCREMENTAL => 'AP_VOTE_MODE_INCREMENTAL',
			poll_options::VOTE_MODE_CHANGE => 'AP_VOTE_MODE_CHANGE',
		), $vote_mode);
		return;
	}

	/**
	 * Render trusted numeric point controls for ranking positions.
	 *
	 * @param array $points Points in rank order
	 * @return string
	 */
	protected function build_rank_point_inputs(array $points)
	{
		$html = '';
		foreach ($points as $index => $point)
		{
			$position = $index + 1;
			$html .= '<label class="ap-rank-point"><span>' . $this->user->lang('AP_RANK_POSITION', $position) . '</span> '
				. '<input type="number" min="1" max="999" name="wolfsblvt_poll_rank_points[]" value="' . (int) $point . '" class="inputbox autowidth" /></label>';
		}
		return $html;
	}

	/**
	 * Build trusted select options from extension language keys.
	 *
	 * @param array $options Value => language key
	 * @param int   $selected Selected value
	 * @return string
	 */
	protected function build_select_options(array $options, $selected)
	{
		$html = '';
		foreach ($options as $value => $language_key)
		{
			$html .= '<option value="' . (int) $value . '"' . ((int) $selected === (int) $value ? ' selected="selected"' : '') . '>'
				. htmlspecialchars($this->user->lang[$language_key], ENT_COMPAT, 'UTF-8') . '</option>';
		}
		return $html;
	}
	/**
	 * Perform all poll related modifications
	 *
	 * @param array	$topic_data						The array of topic data
	 * @param array $vote_counts					Array with the vote counts for every poll option, updated here
	 * @param array $cur_voted_id					Array of current votes, stored in the database, updated here
	 * @param array $voted_id						Array of votes, submitted in the form, updated here
	 * @param array $poll_info						Array with poll options and details, updated here
	 * @param bool $s_can_vote						May the user vote in this poll?  May be modified here
	 * @param bool $s_display_results				Whether aggregate results may be displayed
	 * @param string $viewtopic_url					URL with the return topic
	 * @return void
	 */
	public function do_poll_voting_modifications($topic_data, &$vote_counts, &$cur_voted_id, &$voted_id, &$poll_info, &$s_can_vote, &$s_display_results, $viewtopic_url)
	{
		$options = $this->get_possible_options(true);
		$options = array_keys($options);

		$poll_options = array_keys($vote_counts);
		$poll_options_count = count($poll_options);

		// Get votes data
		$sql = 'SELECT *
				FROM ' . POLL_VOTES_TABLE . '
				WHERE topic_id = ' . (int) $topic_data['topic_id'];
		$result = $this->db->sql_query($sql);

		$option_voters = array_fill_keys($poll_options, array());
		$this->abstaining_voters = array();
		$this->retained_voter_names = array();
		$cur_voted_val = array();
		$cur_total_val = 0;
		$guest_token_hash = '';
		if (!$this->user->data['is_registered'])
		{
			$guest_token = $this->request->variable(
				$this->config['cookie_name'] . '_ap_multi_' . (int) $topic_data['topic_id'],
				'',
				true,
				\phpbb\request\request_interface::COOKIE
			);
			if (preg_match('/^[a-f0-9]{64}$/D', $guest_token))
			{
				$guest_token_hash = hash('sha256', $guest_token);
				$cur_voted_id = array();
			}
		}
		while ($row = $this->db->sql_fetchrow($result))
		{
			$vote_user_id = (int) $row['vote_user_id'];
			$is_current_guest = $guest_token_hash !== ''
				&& $vote_user_id === ANONYMOUS
				&& !empty($row['wolfsblvt_vote_guest_token'])
				&& hash_equals($guest_token_hash, $row['wolfsblvt_vote_guest_token']);
			if ($vote_user_id !== ANONYMOUS && !empty($row['wolfsblvt_vote_user_name']))
			{
				$this->retained_voter_names[$vote_user_id] = $row['wolfsblvt_vote_user_name'];
			}

			if ((int) $row['poll_option_id'] === 0)
			{
				if ($is_current_guest)
				{
					$cur_voted_val[0] = 1;
					$cur_voted_id[] = 0;
				}
				if ((int) $row['vote_user_id'] !== ANONYMOUS)
				{
					$this->abstaining_voters[(int) $row['vote_user_id']] = true;
				}
				continue;
			}

			if (!isset($option_voters[(int) $row['poll_option_id']]))
			{
				continue;
			}

			$option_voters[$row['poll_option_id']][(int) $row['vote_user_id']] = (int) $row['wolfsblvt_poll_option_value'];
			if (($this->user->data['is_registered'] && ($this->user->data['user_id'] == $row['vote_user_id'])) || $is_current_guest)
			{
				$cur_voted_val[(int) $row['poll_option_id']] = (int) $row['wolfsblvt_poll_option_value'];
				$cur_total_val += (int) $row['wolfsblvt_poll_option_value'];
				if ($is_current_guest)
				{
					$cur_voted_id[] = (int) $row['poll_option_id'];
				}
			}
		}
		$this->db->sql_freeresult($result);

		for ($i = 0; $i < $poll_options_count; $i++)
		{
			$poll_info[$i]['option_voters'] = $option_voters[$poll_info[$i]['poll_option_id']];
		}

		if (!$this->user->data['is_registered'] && !$cur_voted_val)
		{
			// Cookie based guest tracking ... I don't like this but hum ho
			// it's oft requested. This relies on "nice" users who don't feel
			// the need to delete cookies to mess with results.
			if ($this->request->is_set($this->config['cookie_name'] . '_poll_votes_' . $topic_data['topic_id'], \phpbb\request\request_interface::COOKIE))
			{
				$cur_voted_votes = explode(',', $this->request->variable($this->config['cookie_name'] . '_poll_votes_' . $topic_data['topic_id'], '', true, \phpbb\request\request_interface::COOKIE));
				$cur_voted_votes = array_map('intval', $cur_voted_votes);
				if (count($cur_voted_id) === count($cur_voted_votes))
				{
					$cur_voted_val = array_combine($cur_voted_id, $cur_voted_votes);
					$cur_total_val = array_sum($cur_voted_votes);
				}
			}
		}

		$voted_val = array();

		$scoring = $this->request->variable('scoring', false);
		$ranking = $this->request->variable('ranking', false);
		$update = $this->request->variable('update', false);

		$poll_type = $this->resolve_poll_type($topic_data);
		$s_is_scoring = $poll_type === poll_options::TYPE_SCORING;
		$s_is_ranking = $poll_type === poll_options::TYPE_RANKING;
		$s_is_weighted = $s_is_scoring || $s_is_ranking;

		if ($s_is_ranking && $ranking)
		{
			$voted_val = $this->request->variable('vote_id', array(0 => 0));
			$voted_val = array_diff($voted_val, array(0));
			$voted_id = array_keys($voted_val);
			$voted_id = (sizeof($voted_id) > 1) ? array_unique($voted_id) : $voted_id;
		}
		else if ($scoring)
		{
			$voted_val	= $this->request->variable('vote_id', array(0 => 0));
			$voted_val	= array_diff($voted_val, array(0));
			$voted_id	= array_keys($voted_val);
			$voted_id	= (sizeof($voted_id) > 1) ? array_unique($voted_id) : $voted_id;
		}

		if (!in_array('wolfsblvt_no_vote', $options) && in_array(0, $cur_voted_id))
		{
			// Ignore legacy abstention rows without mutating data during a page view.
			$cur_voted_val = array_diff_key($cur_voted_val, array(0 => true));
			$cur_voted_id = array_keys($cur_voted_val);
		}
		$vote_mode = isset($topic_data['wolfsblvt_poll_vote_mode'])
			? (int) $topic_data['wolfsblvt_poll_vote_mode']
			: (!empty($topic_data['poll_vote_change'])
				? poll_options::VOTE_MODE_CHANGE
				: (in_array('wolfsblvt_incremental_votes', $options) ? poll_options::VOTE_MODE_INCREMENTAL : poll_options::VOTE_MODE_NO_CHANGE));
		$s_incremental = ($vote_mode === poll_options::VOTE_MODE_INCREMENTAL);
		$has_abstained = in_array(0, array_map('intval', $cur_voted_id), true);
		$s_vote_incomplete = !$has_abstained && ($s_incremental
			? ($s_is_weighted ? $cur_total_val < $topic_data['wolfsblvt_poll_total_value'] : sizeof($cur_voted_val) < $topic_data['poll_max_options'])
			: !sizeof($cur_voted_val));

		$s_can_change_vote = ($vote_mode === poll_options::VOTE_MODE_CHANGE && $this->auth->acl_get('f_votechg', $topic_data['forum_id']));
		$can_cast_vote = $this->auth->acl_get('f_vote', $topic_data['forum_id']) &&
			(($topic_data['poll_length'] != 0 && $topic_data['poll_start'] + $topic_data['poll_length'] > time()) || $topic_data['poll_length'] == 0) &&
			($topic_data['topic_status'] != ITEM_LOCKED || in_array('wolfsblvt_closed_voting', $options)) &&
			$topic_data['forum_status'] != ITEM_LOCKED &&
			($s_vote_incomplete || $s_can_change_vote);
		$s_can_vote = $s_can_vote || $can_cast_vote;

		$poll_ended = !empty($topic_data['poll_length'])
			&& (int) $topic_data['poll_start'] + (int) $topic_data['poll_length'] <= time();
		$has_participated = $has_abstained || !empty($cur_voted_val);
		$vote_completed = $has_abstained || !$s_vote_incomplete;
		$visibility = isset($topic_data['wolfsblvt_poll_visibility'])
			? (int) $topic_data['wolfsblvt_poll_visibility']
			: (!empty($topic_data['wolfsblvt_poll_votes_hide']) ? poll_options::VISIBILITY_PRIVATE : poll_options::VISIBILITY_DEFAULT);
		$s_display_results = !poll_options::results_are_hidden($visibility, $poll_ended, $has_participated, $vote_completed);

		if ($this->request->is_ajax() && $this->request->is_set_post('delete_vote'))
		{
			$can_delete_vote = !empty($this->config['wolfsblvt.advancedpolls.activate_vote_delete'])
				&& $this->user->data['is_registered']
				&& $s_can_change_vote
				&& $s_can_vote
				&& !empty($cur_voted_val)
				&& check_form_key('posting');

			if (!$can_delete_vote)
			{
				$json_response = new \phpbb\json_response;
				$json_response->send(array(
					'success' => false,
					'error' => $this->user->lang['FORM_INVALID'],
				));
			}

			$this->db->sql_transaction('begin');
			try
			{
				foreach ($cur_voted_val as $option_id => $option_value)
				{
					$sql = 'UPDATE ' . POLL_OPTIONS_TABLE . '
						SET poll_option_total = CASE
							WHEN poll_option_total >= ' . (int) $option_value . ' THEN poll_option_total - ' . (int) $option_value . '
							ELSE 0
						END
						WHERE poll_option_id = ' . (int) $option_id . '
							AND topic_id = ' . (int) $topic_data['topic_id'];
					$this->db->sql_query($sql);
				}

				$sql = 'DELETE FROM ' . POLL_VOTES_TABLE . '
					WHERE topic_id = ' . (int) $topic_data['topic_id'] . '
						AND vote_user_id = ' . (int) $this->user->data['user_id'] . '
						AND poll_option_id > 0';
				$this->db->sql_query($sql);

				$sql = 'UPDATE ' . TOPICS_TABLE . '
					SET poll_last_vote = ' . time() . '
					WHERE topic_id = ' . (int) $topic_data['topic_id'];
				$this->db->sql_query($sql);
				$this->db->sql_transaction('commit');
			}
			catch (\Throwable $exception)
			{
				$this->db->sql_transaction('rollback');
				throw $exception;
			}

			$json_response = new \phpbb\json_response;
			$json_response->send(array('success' => true));
		}
		$invalid_voted_options = array_diff(array_map('intval', $voted_id), array_map('intval', $poll_options));

		if ($update && $s_can_vote)
		{
			if (!sizeof($voted_id) || sizeof($voted_id) > $topic_data['poll_max_options'] ||
				$invalid_voted_options || $scoring !== $s_is_weighted || $ranking !== $s_is_ranking || (!$s_can_change_vote && sizeof(array_diff($cur_voted_id, $voted_id))) || !check_form_key('posting'))
			{
				meta_refresh(5, $viewtopic_url);
				if (!sizeof($voted_id))
				{
					$message = 'NO_VOTE_OPTION';
				}
				else if (sizeof($voted_id) > $topic_data['poll_max_options'])
				{
					$message = 'TOO_MANY_VOTE_OPTIONS';
				}
				else if ($invalid_voted_options || $scoring !== $s_is_weighted || $ranking !== $s_is_ranking)
				{
					$message = 'AP_POLL_TYPE_MISMATCH';
				}
				else if (!$s_can_change_vote && sizeof(array_diff($cur_voted_id, $voted_id)))
				{
					$message = 'AP_VOTE_CHANGED';
				}
				else
				{
					$message = 'FORM_INVALID';
				}

				$message = $this->user->lang[$message] . '<br /><br />' . sprintf($this->user->lang['RETURN_TOPIC'], '<a href="' . $viewtopic_url . '">', '</a>');
				trigger_error($message);
			}

			if ($this->user->data['is_registered'] && in_array(0, $cur_voted_id))
			{
				$sql = 'DELETE FROM ' . POLL_VOTES_TABLE . '
					WHERE topic_id = ' . (int) $topic_data['topic_id'] . '
						AND poll_option_id = ' . 0 . '
						AND vote_user_id = ' . (int) $this->user->data['user_id'];
				$this->db->sql_query($sql);
				$cur_voted_id = array_keys($cur_voted_val);
			}
		}

		if ($update && $s_can_vote && $s_is_ranking)
		{
			$rank_error = ranked_vote::validate_vote(
				$voted_val,
				$poll_options,
				ranked_vote::normalise_points($topic_data['wolfsblvt_poll_rank_points']),
				(int) $topic_data['poll_max_options']
			);
			if ($rank_error)
			{
				meta_refresh(5, $viewtopic_url);
				$message = $this->user->lang[$rank_error] . '<br /><br />' . sprintf($this->user->lang['RETURN_TOPIC'], '<a href="' . $viewtopic_url . '">', '</a>');
				trigger_error($message);
			}
		}

		if ($update && $s_can_vote && $s_is_weighted)
		{
			$validation_error = vote_validator::validate_scoring(
				$voted_val,
				$poll_options,
				(int) $topic_data['wolfsblvt_poll_max_value'],
				(int) $topic_data['wolfsblvt_poll_total_value'],
				$s_can_change_vote,
				$cur_voted_val,
				isset($topic_data['wolfsblvt_poll_min_value']) ? (int) $topic_data['wolfsblvt_poll_min_value'] : 1
			);

			if ($validation_error)
			{
				meta_refresh(5, $viewtopic_url);
				$message = $this->user->lang[$validation_error] . '<br /><br />' . sprintf($this->user->lang['RETURN_TOPIC'], '<a href="' . $viewtopic_url . '">', '</a>');
				trigger_error($message);
			}

			$voted_total_val = array_sum($voted_val);
			$this->db->sql_transaction('begin');
			foreach ($cur_voted_id as $option)
			{
				if (!in_array($option, $voted_id) || $cur_voted_val[$option] != $voted_val[$option])
				{
					$sql = 'UPDATE ' . POLL_OPTIONS_TABLE . '
						SET poll_option_total = poll_option_total - ' . (int) $cur_voted_val[$option] . '
						WHERE poll_option_id = ' . (int) $option . '
							AND topic_id = ' . (int) $topic_data['topic_id'];
					$this->db->sql_query($sql);

					$vote_counts[$option] -= (int) $cur_voted_val[$option];

					if ($this->user->data['is_registered'])
					{
						$sql = 'DELETE FROM ' . POLL_VOTES_TABLE . '
							WHERE topic_id = ' . (int) $topic_data['topic_id'] . '
								AND poll_option_id = ' . (int) $option . '
								AND vote_user_id = ' . (int) $this->user->data['user_id'];
						$this->db->sql_query($sql);
					}
				}
			}

			foreach ($voted_id as $option)
			{
				// no changed vote, do nothing
				if (in_array($option, $cur_voted_id) && $cur_voted_val[$option] == $voted_val[$option])
				{
					continue;
				}

				// updates the total number of votes for that option
				$sql = 'UPDATE ' . POLL_OPTIONS_TABLE . '
					SET poll_option_total = poll_option_total + ' . (int) $voted_val[$option] . '
					WHERE poll_option_id = ' . (int) $option . '
						AND topic_id = ' . (int) $topic_data['topic_id'];
				$this->db->sql_query($sql);

				$vote_counts[$option] += (int) $voted_val[$option];

				if ($this->user->data['is_registered'])
				{
					$sql_ary = array(
						'topic_id'			=> (int) $topic_data['topic_id'],
						'poll_option_id'	=> (int) $option,
						'wolfsblvt_poll_option_value'	=> (int) $voted_val[$option],
						'vote_user_id'		=> (int) $this->user->data['user_id'],
						'vote_user_ip'		=> (string) $this->user->ip,
					);

					$sql = 'INSERT INTO ' . POLL_VOTES_TABLE . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
					$this->db->sql_query($sql);
				}
			}

			if ($this->user->data['user_id'] == ANONYMOUS && !$this->user->data['is_bot'])
			{
				$this->user->set_cookie('poll_' . $topic_data['topic_id'], implode(',', array_keys($voted_val)), time() + 31536000);
				$this->user->set_cookie('poll_votes_' . $topic_data['topic_id'], implode(',', array_values($voted_val)), time() + 31536000);
			}

			$sql = 'UPDATE ' . TOPICS_TABLE . '
				SET poll_last_vote = ' . time() . '
				WHERE topic_id = ' . (int) $topic_data['topic_id'];
			$this->db->sql_query($sql);
			$this->db->sql_transaction('commit');
			$message = $this->user->lang['VOTE_SUBMITTED'] . '<br /><br />' . sprintf($this->user->lang['RETURN_TOPIC'], '<a href="' . $viewtopic_url . '">', '</a>');

			if ($this->request->is_ajax())
			{
				// Filter out invalid options
				$valid_user_votes = array_intersect(array_keys($vote_counts), $voted_id);
				$s_vote_incomplete = $s_incremental ?
						($s_is_weighted ? $voted_total_val < $topic_data['wolfsblvt_poll_total_value'] : sizeof($valid_user_votes) < $topic_data['poll_max_options']) : !sizeof($valid_user_votes);

				$data = array(
					'NO_VOTES'			=> $this->user->lang['NO_VOTES'],
					'success'			=> true,
					'scoring'			=> true,
					'ranking'			=> $s_is_ranking,
					'user_votes'		=> array_flip($valid_user_votes),
					'user_vote_counts'	=> $voted_val,
					'vote_counts'		=> $vote_counts,
					'total_votes'		=> array_sum($vote_counts),
					'can_vote'			=> $s_vote_incomplete || $s_can_change_vote,
				);
				$this->hide_ajax_results($data, $topic_data, sizeof($valid_user_votes) > 0, !$data['can_vote']);
				if (empty($data['results_hidden']))
				{
					$data['score_breakdowns'] = $this->format_score_breakdowns(
						$this->get_score_distribution((int) $topic_data['topic_id']),
						$vote_counts,
						$s_is_ranking ? ranked_vote::normalise_points($topic_data['wolfsblvt_poll_rank_points']) : array()
					);
				}
				$json_response = new \phpbb\json_response();
				$json_response->send($data);
			}

			meta_refresh(5, $viewtopic_url);
			trigger_error($message);
		}

		// If we have ajax call here with no_vote, we exit save it here and return json_response
		if (in_array('wolfsblvt_no_vote', $options) && $this->request->is_ajax() && $this->request->is_set_post('no_vote'))
		{
			$existing_votes = array_filter($cur_voted_id, function ($option_id)
			{
				return (int) $option_id > 0;
			});

			$already_abstained = in_array(0, $cur_voted_id);
			if ($this->user->data['is_registered'] && ($s_can_vote || $already_abstained) && !$existing_votes && check_form_key('posting'))
			{
				if (!in_array(0, $cur_voted_id))
				{
					$sql_ary = array(
						'topic_id'			=> (int) $topic_data['topic_id'],
						'poll_option_id'	=> 0,
						'wolfsblvt_poll_option_value'	=> 0,
						'vote_user_id'		=> (int) $this->user->data['user_id'],
						'vote_user_ip'		=> (string) $this->user->ip,
					);

					$sql = 'INSERT INTO ' . POLL_VOTES_TABLE . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
					$this->db->sql_query($sql);
				}

				$json_response = new \phpbb\json_response;
				$json_response->send(array('success' => true));
			}

			$json_response = new \phpbb\json_response;
			$json_response->send(array(
				'success' => false,
				'error' => $this->user->lang['FORM_INVALID'],
			));
		}
		$this->cur_voted_val = $cur_voted_val;

		return;
	}

	/**
	 * Remove private aggregate values from phpBB's AJAX vote response.
	 *
	 * @param array $topic_data Topic data
	 * @param array $data AJAX response data, modified here
	 * @return void
	 */
	public function do_poll_ajax_modifications($topic_data, &$data)
	{
		$has_voted = !empty($data['user_votes']);
		$vote_mode = isset($topic_data['wolfsblvt_poll_vote_mode'])
			? (int) $topic_data['wolfsblvt_poll_vote_mode']
			: (!empty($topic_data['poll_vote_change']) ? poll_options::VOTE_MODE_CHANGE : poll_options::VOTE_MODE_NO_CHANGE);

		if ($vote_mode === poll_options::VOTE_MODE_CHANGE)
		{
			$data['can_vote'] = $this->auth->acl_get('f_votechg', $topic_data['forum_id']);
		}
		else if ($vote_mode === poll_options::VOTE_MODE_INCREMENTAL)
		{
			$data['can_vote'] = count($data['user_votes']) < (int) $topic_data['poll_max_options'];
		}
		else
		{
			$data['can_vote'] = false;
		}

		$vote_completed = !$data['can_vote'];
		$this->hide_ajax_results($data, $topic_data, $has_voted, $vote_completed);
	}

	/**
	 * Hide aggregate result values when the visibility policy requires it.
	 *
	 * The current user's own selections remain in the response so the UI can
	 * acknowledge the vote without revealing other voters' results.
	 *
	 * @param array $data AJAX response data
	 * @param array $topic_data Topic data
	 * @param bool  $has_voted Viewer has voted
	 * @param bool  $vote_completed Viewer has completed voting
	 * @return void
	 */
	protected function hide_ajax_results(&$data, $topic_data, $has_voted, $vote_completed)
	{
		$visibility = isset($topic_data['wolfsblvt_poll_visibility'])
			? (int) $topic_data['wolfsblvt_poll_visibility']
			: (!empty($topic_data['wolfsblvt_poll_votes_hide']) ? poll_options::VISIBILITY_PRIVATE : poll_options::VISIBILITY_DEFAULT);
		$poll_ended = !empty($topic_data['poll_length'])
			&& (int) $topic_data['poll_start'] + (int) $topic_data['poll_length'] <= time();

		if (!poll_options::results_are_hidden($visibility, $poll_ended, $has_voted, $vote_completed))
		{
			return;
		}

		if (isset($data['vote_counts']) && is_array($data['vote_counts']))
		{
			$data['vote_counts'] = array_fill_keys(array_keys($data['vote_counts']), 0);
		}
		$data['total_votes'] = 0;
		unset($data['score_breakdowns']);
		$data['results_hidden'] = true;
	}

	/**
	 * Perform all poll related template modifications for viewtopic
	 *
	 * @param array	$topic_data						The array of topic data
	 * @param array $vote_counts					Array with the vote counts for every poll option
	 * @param array $poll_info						Array with the poll options and information
	 * @param array $poll_template_data				Array with the poll template data, passed by reference (return value)
	 * @param array $poll_options_template_data		Array with the poll options template data, passed by reference (return value)
	 * @return void
	 */
	public function do_poll_template_modifications($topic_data, $vote_counts, $poll_info, &$poll_template_data, &$poll_options_template_data)
	{
		$vote_mode = isset($topic_data['wolfsblvt_poll_vote_mode'])
			? (int) $topic_data['wolfsblvt_poll_vote_mode']
			: (!empty($topic_data['poll_vote_change']) ? poll_options::VOTE_MODE_CHANGE : poll_options::VOTE_MODE_NO_CHANGE);
		$javascript_vars = array(
			'wolfsblvt_poll_votes_hide_topic'		=> false,
			'wolfsblvt_poll_voters_show_topic'		=> false,
			'wolfsblvt_poll_voters_limit_topic'		=> false,
			'wolfsblvt_poll_show_ordered'			=> false,
			'wolfsblvt_poll_scoring'				=> false,
			'wolfsblvt_poll_ranking'				=> false,
			'wolfsblvt_poll_no_vote'				=> false,
			'can_change_vote'						=> ($vote_mode === poll_options::VOTE_MODE_CHANGE && $this->auth->acl_get('f_votechg', $topic_data['forum_id'])),
			'username_clean'						=> $this->user->data['username_clean'],
			'username_string'						=> get_username_string('full', $this->user->data['user_id'], $this->user->data['username'], $this->user->data['user_colour']),
			'l_seperator'							=> $this->user->lang['COMMA_SEPARATOR'],
			'l_none'								=> $this->user->lang['AP_NONE'],
			'rank_limit'							=> (int) $topic_data['poll_max_options'],
			'rank_points'						=> ranked_vote::normalise_points(isset($topic_data['wolfsblvt_poll_rank_points']) ? $topic_data['wolfsblvt_poll_rank_points'] : ''),
			'l_rank_limit'						=> $this->user->lang('AP_RANK_SELECT_EXACTLY', (int) $topic_data['poll_max_options']),
		);

		$options = $this->get_possible_options(true);
		$options = array_keys($options);

		$poll_options = array_keys($vote_counts);
		$poll_options_count = count($poll_options);

		$poll_end = ($topic_data['poll_start'] + $topic_data['poll_length']);

		$poll_votes_hidden = $poll_scoring = false;
		$poll_type = $this->resolve_poll_type($topic_data);

		$view = $this->request->variable('view', '');
		$poll_force_display_results = (($view === 'infopoll') && $this->auth->acl_get('m_seevoters', $topic_data['forum_id'])) ? true : false;

		if (!$poll_force_display_results && empty($poll_template_data['S_DISPLAY_RESULTS']))
		{
			$javascript_vars['wolfsblvt_poll_votes_hide_topic'] = true;

			// Overwrite options to hide values
			for ($i = 0; $i < $poll_options_count; $i++)
			{
				$poll_options_template_data[$i]['POLL_OPTION_RESULT'] = '??';
				$poll_options_template_data[$i]['POLL_OPTION_PERCENT'] = '??%';
				$poll_options_template_data[$i]['POLL_OPTION_PERCENT_REL'] = sprintf('%.1d%%', round(100 * (1 / $poll_options_count)));
				$poll_options_template_data[$i]['POLL_OPTION_PCT'] = round(100 * (1 / $poll_options_count));
				$poll_options_template_data[$i]['POLL_OPTION_WIDTH'] = round(250 * (1 / $poll_options_count));
				$poll_options_template_data[$i]['POLL_OPTION_MOST_VOTES'] = false;
			}

			// Overwrite language vars to explain the hide
			$poll_template_data = array_merge($poll_template_data, array(
				'L_NO_VOTES'			=> $this->user->lang['AP_VOTES_HIDDEN'],
				'AP_POLL_HIDE_VOTES'	=> true,
				'TOTAL_VOTES'			=> '??',
			));
			if ($topic_data['poll_length'] > 0 && $poll_end > time())
			{
				$poll_template_data['L_POLL_LENGTH'] .= $this->user->lang['AP_POLL_RUN_TILL_APPEND'];
			}
			$poll_votes_hidden = true;
		}

		if (in_array('wolfsblvt_poll_max_value', $options))
		{
			$poll_template_data['WOLFSBLVT_POLL_SCORING'] = true;
			if ($poll_type === poll_options::TYPE_SCORING || $poll_type === poll_options::TYPE_RANKING)
			{
				$javascript_vars['wolfsblvt_poll_scoring'] = true;
				$javascript_vars['wolfsblvt_poll_ranking'] = $poll_type === poll_options::TYPE_RANKING;
				for ($j = 0; $j < $poll_options_count; $j++)
				{
					$option_eval_opts_txt = '<option value="0"></option>';
					$sel = isset($this->cur_voted_val[(int) $poll_info[$j]['poll_option_id']]) ? $this->cur_voted_val[(int) $poll_info[$j]['poll_option_id']] : 0;
					$poll_options_template_data[$j]['AP_POLL_OPTION_VALUE'] = $sel;
					if ($poll_type === poll_options::TYPE_SCORING)
					{
						for ($i = (isset($topic_data['wolfsblvt_poll_min_value']) ? (int) $topic_data['wolfsblvt_poll_min_value'] : 1); $i <= $topic_data['wolfsblvt_poll_max_value']; $i++)
						{
							$option_eval_opts_txt .= '<option value="' . $i . ((($i == $sel) && !$poll_force_display_results) ? '" selected="selected">' : '">') . $i . '</option>';
						}
					}
					$poll_options_template_data[$j]['AP_POLL_OPTION_OPTS'] = $option_eval_opts_txt;
					$rank_points = ranked_vote::normalise_points($topic_data['wolfsblvt_poll_rank_points']);
					$rank_index = $poll_type === poll_options::TYPE_RANKING ? array_search((int) $sel, $rank_points, true) : false;
					$poll_options_template_data[$j]['AP_POLL_OPTION_RANK'] = $rank_index === false ? 0 : $rank_index + 1;
				}
				$poll_template_data['L_MAX_VOTES'] = $poll_type === poll_options::TYPE_RANKING
					? $this->user->lang('AP_RANK_SELECT_EXACTLY', (int) $topic_data['poll_max_options'])
					: $this->user->lang('AP_MAX_VOTES_SELECT', (int) $topic_data['poll_max_options'], (int) $topic_data['wolfsblvt_poll_total_value']);
				$poll_template_data['AP_IS_SCORING'] = $poll_type === poll_options::TYPE_SCORING;
				$poll_template_data['AP_IS_RANKING'] = $poll_type === poll_options::TYPE_RANKING;
				$poll_template_data['AP_RANK_LIMIT'] = (int) $topic_data['poll_max_options'];

				$scoring_hidden_fields = build_hidden_fields(array(
					'scoring' => (int) 1,
					'ranking' => $poll_type === poll_options::TYPE_RANKING ? (int) 1 : (int) 0,
				));
				$poll_template_data['S_HIDDEN_FIELDS'] = (isset($poll_template_data['S_HIDDEN_FIELDS']) ? $poll_template_data['S_HIDDEN_FIELDS'] : '') . $scoring_hidden_fields;

				$poll_scoring = true;
			}
		}

		if ($poll_scoring && !$poll_votes_hidden)
		{
			$score_breakdowns = $this->format_score_breakdowns(
				$this->get_score_distribution((int) $topic_data['topic_id']),
				$vote_counts,
				$poll_type === poll_options::TYPE_RANKING ? ranked_vote::normalise_points($topic_data['wolfsblvt_poll_rank_points']) : array()
			);
			for ($i = 0; $i < $poll_options_count; $i++)
			{
				$option_id = (int) $poll_info[$i]['poll_option_id'];
				if (isset($score_breakdowns[$option_id]))
				{
					$poll_options_template_data[$i]['AP_SCORE_TOTAL'] = $score_breakdowns[$option_id]['total'];
					$poll_options_template_data[$i]['AP_SCORE_BREAKDOWN'] = $score_breakdowns[$option_id]['detail'];
					$poll_options_template_data[$i]['AP_BREAKDOWN_LABEL'] = $score_breakdowns[$option_id]['label'];
				}
			}
		}

		$poll_votes_are_visible = ($topic_data['wolfsblvt_poll_voters_show'] == 1 && in_array('wolfsblvt_poll_voters_show', $options)) ? true : false;
		$show_abstainers = !empty($this->config['wolfsblvt.advancedpolls.activate_show_abstainers'])
			&& in_array('wolfsblvt_no_vote', $options)
			&& !$poll_votes_hidden
			&& !empty($this->abstaining_voters);

		if ($show_abstainers)
		{
			$poll_template_data['AP_SHOW_ABSTAINERS'] = true;
			$poll_template_data['AP_ABSTAINERS_COUNT'] = count($this->abstaining_voters);
			$poll_template_data['AP_ABSTAINER_LIST'] = false;

			$may_show_abstainer_names = $poll_force_display_results
				|| ($poll_votes_are_visible && $this->auth->acl_get('f_seevoters', $topic_data['forum_id']));
			if ($may_show_abstainer_names)
			{
				$abstainer_users = array();
				$sql = 'SELECT user_id, username, user_colour
					FROM ' . USERS_TABLE . '
					WHERE ' . $this->db->sql_in_set('user_id', array_keys($this->abstaining_voters));
				$result = $this->db->sql_query($sql);
				while ($row = $this->db->sql_fetchrow($result))
				{
					$abstainer_users[(int) $row['user_id']] = $row;
				}
				$this->db->sql_freeresult($result);

				$abstainer_list = array();
				foreach (array_keys($this->abstaining_voters) as $abstainer_id)
				{
					if (isset($abstainer_users[$abstainer_id]))
					{
						$abstainer = $abstainer_users[$abstainer_id];
						$abstainer_list[] = get_username_string('full', $abstainer_id, $abstainer['username'], $abstainer['user_colour']);
					}
					else
					{
						$name = isset($this->retained_voter_names[$abstainer_id])
							? $this->retained_voter_names[$abstainer_id]
							: $this->user->lang['AP_DELETED_USER'];
						$abstainer_list[] = get_username_string('no_profile', ANONYMOUS, $name);
					}
				}
				$poll_template_data['AP_ABSTAINER_LIST'] = implode($this->user->lang['COMMA_SEPARATOR'], $abstainer_list);
			}
		}

		if ($poll_force_display_results || ($poll_votes_are_visible && !$poll_votes_hidden && $this->auth->acl_get('f_seevoters', $topic_data['forum_id'])))
		{
			$javascript_vars['wolfsblvt_poll_voters_show_topic'] = true;

			$user_cache = array();
			for ($i = 0; $i < $poll_options_count; $i++)
			{
				foreach ($poll_info[$i]['option_voters'] as $vote_user_id => $poll_option_value)
				{
					$user_cache[$vote_user_id] = null;
				}
			}

			// We need to get the user data so that we can print out their username
			if (!empty($user_cache))
			{
				$sql = 'SELECT user_id, username, username_clean, user_colour
						FROM ' . USERS_TABLE . '
						WHERE ' . $this->db->sql_in_set('user_id', array_keys($user_cache));
				$result = $this->db->sql_query($sql);
				while ($row = $this->db->sql_fetchrow($result))
				{
					$user_cache[$row['user_id']] = $row;
					$user_cache[$row['user_id']]['total_user_votes'] = 0;
				}
				$this->db->sql_freeresult($result);
			}

			$user_cache = $this->complete_voter_cache($user_cache);

			$poll_total_vote_value = $poll_total_guest_votes = 0;
			for ($i = 0; $i < $poll_options_count; $i++)
			{
				$voter_list = array();
				$total_vote_value = 0;
				foreach ($poll_info[$i]['option_voters'] as $voter_id => $vote_value)
				{
					$username = get_username_string(
						!empty($user_cache[$voter_id]['is_deleted']) ? 'no_profile' : 'full',
						!empty($user_cache[$voter_id]['is_deleted']) ? ANONYMOUS : $voter_id,
						$user_cache[$voter_id]['username'],
						$user_cache[$voter_id]['user_colour']
					);

					$voter_list[] = '<span name="' . $user_cache[$voter_id]['username_clean'] . '">' . $username . ($poll_scoring ? ('(' . $vote_value . ')') : '') . '</span>';
					$total_vote_value += ($poll_scoring ? $vote_value : 1);
					$user_cache[$voter_id]['total_user_votes'] += ($poll_scoring ? $vote_value : 1);
				}
				$poll_options_template_data[$i]['AP_VOTERS'] = !empty($voter_list) && $poll_scoring && $poll_force_display_results ? (' (' . count($voter_list) . ')') : '';
				$poll_options_template_data[$i]['POLL_OPTION_VOTED'] = $poll_options_template_data[$i]['POLL_OPTION_VOTED'] && !$poll_force_display_results;

				if ($poll_info[$i]['poll_option_total'] > $total_vote_value)
				{
					$guest_votes = $poll_info[$i]['poll_option_total'] - $total_vote_value;
					$voter_list[] = '<span name="guestvotes">' . $this->user->lang('AP_GUEST_VOTES', $guest_votes) . '</span>';
					$poll_total_guest_votes += $guest_votes;
				}
				$poll_options_template_data[$i]['AP_VOTER_LIST'] = !empty($voter_list) ? implode($this->user->lang['COMMA_SEPARATOR'], $voter_list) : false;

				$poll_total_vote_value += $poll_info[$i]['poll_option_total'];
			}

			if ($poll_force_display_results)
			{
				$poll_template_data['S_DISPLAY_RESULTS'] = true;
				$voter_list = array();
				$poll_multivalue = $poll_scoring || $topic_data['poll_max_options'] > 1;
				foreach ($user_cache as $voter_id => $voter_data)
				{
					$username = get_username_string(
						!empty($voter_data['is_deleted']) ? 'no_profile' : 'full',
						!empty($voter_data['is_deleted']) ? ANONYMOUS : $voter_id,
						$voter_data['username'],
						$voter_data['user_colour']
					);
					$voter_list[] = '<span name="' . $voter_data['username_clean'] . '">' . $username . ($poll_multivalue ? ('(' . $voter_data['total_user_votes'] . ')') : '') . '</span>';
				}
				$poll_voters_count = !empty($voter_list) && $poll_multivalue ? (' (' . count($voter_list) . ')') : '';
				if ($poll_total_guest_votes > 0)
				{
					$voter_list[] = '<span name="guestvotes">' . $this->user->lang('AP_GUEST_VOTES', $poll_total_guest_votes) . '</span>';
				}
				$poll_template_data['AP_SHOW_ALL_VOTERS'] = true;
				$poll_template_data['AP_ALL_VOTERS_COUNT'] = $poll_voters_count;
				$poll_template_data['AP_ALL_VOTER_LIST'] = !empty($voter_list)
					? implode($this->user->lang['COMMA_SEPARATOR'], $voter_list)
					: '<span name="none">' . $this->user->lang['AP_NONE'] . '</span>';
				$poll_template_data['S_CAN_VOTE'] = false;
			}

			$poll_template_data['AP_POLL_SHOW_VOTERS'] = true;
		}

		if ($topic_data['wolfsblvt_poll_voters_limit'] == 1 && in_array('wolfsblvt_poll_voters_limit', $options) && $poll_template_data['S_CAN_VOTE'])
		{
			$javascript_vars['wolfsblvt_poll_voters_limit_topic'] = true;

			$not_be_able_to_vote = false;
			$reason = '';

			// Check if user has posted in this thread
			$sql = 'SELECT post_id
					FROM ' . POSTS_TABLE . '
					WHERE poster_id = ' . $this->user->data['user_id'] . '
						AND topic_id = ' . $topic_data['topic_id'];
			$result = $this->db->sql_query_limit($sql, 1);
			$has_posted = ($this->db->sql_fetchrow($result)) ? true : false;
			$this->db->sql_freeresult($result);

			if (!$has_posted)
			{
				$not_be_able_to_vote = true;
				$reason = $this->user->lang['AP_POLL_REASON_NOT_POSTED'];
			}

			/**
			 * Event to modify the limit poll modification
			 *
			 * @event wolfsblvt.advancedpolls.modify_poll_limit
			 * @var	bool	not_be_able_to_vote			Bool if the user should be able to vote.
			 * @var bool	has_posted					Bool if the user already has posted in this topic
			 * @var string	reason						The reason why the user can't vote. Should be translated already.
			 * @var	array	topic_data					The topic data array
			 * @since 1.0.0
			 */
			$vars = array('not_be_able_to_vote', 'has_posted', 'reason', 'topic_data');
			extract($this->dispatcher->trigger_event('wolfsblvt.advancedpolls.modify_poll_limit', compact($vars)));

			if ($not_be_able_to_vote)
			{
				$poll_template_data['S_CAN_VOTE'] = false;

				$vote_error = $this->user->lang['AP_POLL_CANT_VOTE'] . $this->user->lang['COLON'] . ' ' . $reason;
				$poll_template_data['L_POLL_LENGTH'] = '<span class="poll_vote_notice">' . $vote_error . '</span>';
			}
			$poll_template_data['L_AP_POLL_LIMIT_VOTES_REASON'] = $reason ?: false;

			$poll_template_data['AP_POLL_LIMIT_VOTES'] = true;
		}

		if ($poll_votes_are_visible && $poll_template_data['S_CAN_VOTE'])
		{
			$message = $this->user->lang['AP_POLL_VOTES_ARE_VISIBLE'];
			$poll_template_data['L_POLL_LENGTH'] .= '<span class="poll_vote_notice">' . $message . '</span>';
		}

		if ($topic_data['wolfsblvt_poll_show_ordered'] == 1 && in_array('wolfsblvt_poll_show_ordered', $options) && !$poll_votes_hidden && $poll_template_data['S_DISPLAY_RESULTS'])
		{
			$javascript_vars['wolfsblvt_poll_show_ordered'] = true;

			$message = $this->user->lang['AP_POLL_RESULTS_ARE_ORDERED'];
			$poll_template_data['L_POLL_LENGTH'] .= '<span class="poll_vote_notice">' . $message . '</span>';
			usort($poll_options_template_data, array($this, 'order_by_votes'));
		}

		// Add the "don't want to vote possibility
		if (in_array('wolfsblvt_no_vote', $options))
		{
			$javascript_vars['wolfsblvt_poll_no_vote'] = true;

			$poll_template_data['L_VIEW_RESULTS'] = $this->user->lang['AP_POLL_DONT_VOTE_SHOW_RESULTS'];
		}

		$poll_template_data['AP_CAN_DELETE_VOTE'] = !empty($this->config['wolfsblvt.advancedpolls.activate_vote_delete'])
			&& $this->user->data['is_registered']
			&& $vote_mode === poll_options::VOTE_MODE_CHANGE
			&& $this->auth->acl_get('f_votechg', $topic_data['forum_id'])
			&& !empty($this->cur_voted_val)
			&& !empty($poll_template_data['S_CAN_VOTE']);
		$poll_template_data['AP_POLL_COLLAPSIBLE'] = !empty($this->config['wolfsblvt.advancedpolls.activate_poll_collapsible'])
			&& !empty($topic_data['wolfsblvt_poll_collapsible']);
		$poll_template_data['AP_POLL_TOPIC_ID'] = (int) $topic_data['topic_id'];

		// Add the button to see poll results, if you have permissions
		if ($this->auth->acl_get('m_seevoters', $topic_data['forum_id']))
		{
			$poll_template_data['U_AP_POLL_INFO'] = $poll_template_data['S_POLL_ACTION'] . '&amp;view=infopoll';
			$poll_template_data['U_AP_POLL_INFO_AJAX'] = $this->controller_helper->route('wolfsblvt_advancedpolls_infopoll', array(
				'topic_id' => (int) $topic_data['topic_id'],
			));
		}

		// Okay, lets push some of this information to the template
		$poll_template_data['AP_JSON_DATA'] = 'var wolfsblvt_ap_json_data = ' . json_encode($javascript_vars, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) . ';';

		return;
	}

	/**
	 * Supply safe, unlinked display data for votes whose user no longer exists.
	 *
	 * @param array $user_cache User rows keyed by voter ID; missing rows are null
	 * @return array
	 */
	protected function complete_voter_cache(array $user_cache)
	{
		foreach ($user_cache as $voter_id => $voter_data)
		{
			if ($voter_data !== null)
			{
				continue;
			}

			$user_cache[$voter_id] = array(
				'username' => isset($this->retained_voter_names[$voter_id])
					? $this->retained_voter_names[$voter_id]
					: $this->user->lang['AP_DELETED_USER'],
				'username_clean' => 'advancedpolls_deleted_' . (int) $voter_id,
				'user_colour' => '',
				'total_user_votes' => 0,
				'is_deleted' => true,
			);
		}

		return $user_cache;
	}

	/**
	 * Load the number of voters who assigned each score to every poll option.
	 *
	 * @param int $topic_id Topic ID
	 * @return array
	 */
	protected function get_score_distribution($topic_id)
	{
		$sql = 'SELECT poll_option_id,
				wolfsblvt_poll_option_value AS score_value,
				COUNT(*) AS voter_count
			FROM ' . POLL_VOTES_TABLE . '
			WHERE topic_id = ' . (int) $topic_id . '
				AND poll_option_id > 0
				AND wolfsblvt_poll_option_value > 0
			GROUP BY poll_option_id, wolfsblvt_poll_option_value
			ORDER BY poll_option_id ASC, wolfsblvt_poll_option_value ASC';
		$result = $this->db->sql_query($sql);
		$rows = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$rows[] = $row;
		}
		$this->db->sql_freeresult($result);

		return score_distribution::from_rows($rows);
	}

	/**
	 * Format score distributions for templates and AJAX responses.
	 *
	 * @param array $distribution Option => score => voter count map
	 * @param array $vote_counts Weighted totals by option
	 * @param array $rank_points Points in rank order; empty for numeric scoring
	 * @return array
	 */
	protected function format_score_breakdowns(array $distribution, array $vote_counts, array $rank_points = array())
	{
		$is_ranking = !empty($rank_points);
		$breakdowns = array();
		foreach ($distribution as $option_id => $scores)
		{
			$entries = array();
			foreach ($scores as $score => $voters)
			{
				$rank_index = $is_ranking ? array_search((int) $score, $rank_points, true) : false;
				if ($is_ranking && $rank_index === false)
				{
					continue;
				}
				$entries[] = '<span class="ap-score-breakdown-entry">'
					. ($is_ranking
						? $this->user->lang('AP_RANK_DISTRIBUTION_ENTRY', (int) $voters, $rank_index + 1)
						: $this->user->lang('AP_SCORE_DISTRIBUTION_ENTRY', (int) $voters, (int) $score))
					. '</span>';
			}

			if (!$entries || !isset($vote_counts[$option_id]))
			{
				continue;
			}

			$breakdowns[$option_id] = array(
				'total' => $this->user->lang($is_ranking ? 'AP_RANK_TOTAL' : 'AP_SCORE_TOTAL', (int) $vote_counts[$option_id]),
				'detail' => implode('', $entries),
				'label' => $this->user->lang[$is_ranking ? 'AP_RANK_BREAKDOWN' : 'AP_SCORE_BREAKDOWN'],
			);
		}

		return $breakdowns;
	}

	/**
	 * Internal function to implement ordering of votes: decreasing by number of votes received, increasing by poll option id when same number of votes
	 *
	 * @param array	$a		Array of post option data
	 * @param array	$b		Array of post option data
	 * @return int 			Greater than 0 if a < b, 0 if a = b, less than 0 if a > b
	 */
	protected function order_by_votes($a, $b)
	{
		return (((int) $b['POLL_OPTION_RESULT'] - (int) $a['POLL_OPTION_RESULT']) ?: ((int) $a['POLL_OPTION_ID'] - (int) $b['POLL_OPTION_ID']));
	}

	/**
	 * Internal function to get the possible options for polls, if they aren't deactivated in ACP
	 *
	 * @param bool $all		Get all options, or only those options configurable per poll
	 * @return array		Array of Advanced Polls options enabled in the ACP
	 */
	protected function get_possible_options($all = false)
	{
		// options configurable per poll
		$options = array(
			'wolfsblvt_poll_votes_hide',
			'wolfsblvt_poll_voters_show',
			'wolfsblvt_poll_voters_limit',
			'wolfsblvt_poll_show_ordered',
			'wolfsblvt_poll_collapsible',
			'wolfsblvt_poll_scoring',
			'wolfsblvt_poll_end',
		);
		// options configurable globally (ACP only)
		$extra = array(
			'wolfsblvt_incremental_votes',
			'wolfsblvt_closed_voting',
			'wolfsblvt_no_vote',
		);

		if ($all)
		{
			$options = array_merge($options, $extra);
		}

		$valid_options = array();
		$valid_options['wolfsblvt_poll_visibility'] = isset($this->config['wolfsblvt.advancedpolls.default_poll_visibility'])
			? (int) $this->config['wolfsblvt.advancedpolls.default_poll_visibility']
			: poll_options::VISIBILITY_DEFAULT;
		$valid_options['wolfsblvt_poll_vote_mode'] = isset($this->config['wolfsblvt.advancedpolls.default_poll_vote_mode'])
			? (int) $this->config['wolfsblvt.advancedpolls.default_poll_vote_mode']
			: poll_options::VOTE_MODE_NO_CHANGE;
		$valid_options['wolfsblvt_poll_required'] = true;
		foreach ($options as $option)
		{
			$config_name = str_replace('wolfsblvt_', 'wolfsblvt.advancedpolls.activate_', $option);

			if (!empty($this->config[$config_name]))
			{
				if ($option == 'wolfsblvt_poll_scoring')
				{
					$valid_options['wolfsblvt_poll_type'] = poll_options::TYPE_CHOICE;
					$valid_options['wolfsblvt_poll_min_value'] = 1;
					$valid_options['wolfsblvt_poll_max_value'] = 1;
					$valid_options['wolfsblvt_poll_total_value'] = 1;
					$valid_options['wolfsblvt_poll_rank_points'] = '';
				}
				else if ($option == 'wolfsblvt_poll_end')
				{
					$valid_options['wolfsblvt_poll_end_year'] = -1;
					$valid_options['wolfsblvt_poll_end_mon'] = -1;
					$valid_options['wolfsblvt_poll_end_mday'] = -1;
					$valid_options['wolfsblvt_poll_end_hours'] = -1;
					$valid_options['wolfsblvt_poll_end_minutes'] = -1;
				}
				else
				{
					$valid_options[$option] = false;
				}
			}
		}

		return $valid_options;
	}

	/**
	 * Resolve explicit poll type while retaining compatibility with old rows.
	 *
	 * @param array $poll Poll or topic data
	 * @return int
	 */
	protected function resolve_poll_type(array $poll)
	{
		if (isset($poll['wolfsblvt_poll_type']) && poll_options::is_valid_type($poll['wolfsblvt_poll_type']))
		{
			return (int) $poll['wolfsblvt_poll_type'];
		}

		return !empty($poll['wolfsblvt_poll_max_value']) && (int) $poll['wolfsblvt_poll_max_value'] > 1
			? poll_options::TYPE_SCORING
			: poll_options::TYPE_CHOICE;
	}
}
