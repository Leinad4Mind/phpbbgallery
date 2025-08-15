<?php

/**
*
* @package phpBB Extension - Basic Stats
* @copyright (c) 2015 OXPUS - www.oxpus.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace oxpus\basicstats\controller;

use Symfony\Component\DependencyInjection\Container;

class main
{
	/* @var \phpbb\db\driver\driver_interface */
	protected $db;

	/* @var \phpbb\controller\helper */
	protected $helper;

	/* @var \phpbb\request\request_interface */
	protected $request;

	/* @var \phpbb\template\template */
	protected $template;

	/* @var \phpbb\user */
	protected $user;

	/* @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\language\language $language Language object */
	protected $language;

	/**
	* Constructor
	*
	* @param \phpbb\db\driver\driver_interfacer		$db
	* @param \phpbb\controller\helper				$helper
	* @param \phpbb\request\request_interface 		$request
	* @param \phpbb\template\template				$template
	* @param \phpbb\user							$user
	* @param \phpbb\config\config					$config
	*/
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\controller\helper $helper, \phpbb\request\request_interface $request, \phpbb\template\template $template, \phpbb\user $user, \phpbb\config\config $config, \phpbb\language\language $language)
	{
		$this->db 						= $db;
		$this->helper 					= $helper;
		$this->request					= $request;
		$this->template 				= $template;
		$this->user 					= $user;
		$this->config 					= $config;
		$this->u_action					= $this->helper->route('oxpus_basicstats_controller');
		$this->language					= $language;

		if ($this->user->data['user_type'] <> USER_FOUNDER)
		{
			trigger_error($this->language->lang('NOT_AUTHORISED'));
		}
	}

	public function handle($view = '')
	{
		// Define the ext path
		$mode		= $this->request->variable('mode', 'm');
		$s_month	= $this->request->variable('s_month', '');
		$s_year		= trim($this->request->variable('s_year', ''));

		switch ($mode)
		{
			case 'd':
				$current_time		= getdate(time()); //calculate the time here which will be used henceforth to prevent any mismatch if date changes at the tick of midnight!!!
				$board_starttime	= getdate($this->config['board_startdate']);

				$start_time = $end_time = $counted_days = 0;
				if (!$s_month)
				{
					$s_month = date('n-Y', $current_time[0]);
				}
				$s_month = explode('-', $s_month, 2); //[0] => month, [1] => year

				if ($s_month[0] == $current_time['mon'] && $s_month[1] == $current_time['year']) //if its the current month
				{
					//check if this is the first month of the board
					if ($board_starttime['mon'] == $current_time['mon'] && $board_starttime['year'] == $current_time['year'])
					{
						$start_time = $board_starttime[0];
					}
					else
					{
						$start_time = mktime(0, 0, 0, $current_time['mon'], 1, $current_time['year']);
					}
					$end_time = $current_time[0];
				}
				else //some different month
				{
					//check if the month is the board startdate month, if so only start days from the board start day
					if ($s_month[0] == $board_starttime['mon'] && $s_month[1] == $board_starttime['year'])
					{
						$start_time = $board_starttime[0];
					}
					else
					{
						$start_time = mktime(0, 0, 0, $s_month[0], 1, $s_month[1]);
					}
					$end_time = mktime(0, 0, 0, $s_month[0] + 1, 1, $s_month[1]);
				}

				$start_time	= getdate($start_time);
				$end_time	= getdate($end_time);

				$totals = $max = array('topics' => 0, 'posts' => 0, 'user_reg' => 0);
				$daily_data = array();
				$first_day = $start_time['mday'];
				//$last_day is tricky, i do this this way
				$last_day = date('j', $end_time[0] - 1);
				$counted_days = $last_day - $first_day + 1;
				for ($i = $first_day; $i <= $last_day; $i++)
				{
					$daily_data[$i] = array('topics' => 0, 'posts' => 0, 'user_reg' => 0);
				}
				//free some memory
				unset($first_day);
				unset($last_day);

				//ok get the data now
				//topics
				$sql = 'SELECT topic_time AS time FROM ' . TOPICS_TABLE . '
							WHERE topic_visibility = ' . ITEM_APPROVED . '
								AND topic_time >= ' . $start_time[0] . ' AND topic_time < ' . $end_time[0];
				$result = $this->db->sql_query($sql);
				while ($row = $this->db->sql_fetchrow($result))
				{
					$daily_data[date('j', $row['time'])]['topics']++;
				}
				$this->db->sql_freeresult($result);

				//posts
				$sql = 'SELECT post_time AS time FROM ' . POSTS_TABLE . '
							WHERE post_visibility = ' . ITEM_APPROVED . '
								AND post_time >= ' . $start_time[0] . ' AND post_time < ' . $end_time[0];
				$result = $this->db->sql_query($sql);
				while ($row = $this->db->sql_fetchrow($result))
				{
					$daily_data[date('j', $row['time'])]['posts']++;
				}
				$this->db->sql_freeresult($result);

				//user regs
				$sql = 'SELECT user_regdate AS time FROM ' . USERS_TABLE . '
							WHERE ' . $this->db->sql_in_set('user_type', array(USER_NORMAL, USER_FOUNDER)) . '
								AND user_regdate >= ' . $start_time[0] . ' AND user_regdate < ' . $end_time[0];
				$result = $this->db->sql_query($sql);
				while ($row = $this->db->sql_fetchrow($result))
				{
					$daily_data[date('j', $row['time'])]['user_reg']++;
				}
				$this->db->sql_freeresult($result);

				//now calculate totals and max
				foreach ($daily_data as $day => $data)
				{
					$totals['topics'] += $data['topics'];
					$totals['posts'] += $data['posts'];
					$totals['user_reg'] += $data['user_reg'];
					if ($data['topics'] > $max['topics'])
					{
						$max['topics'] = $data['topics'];
					}
					if ($data['posts'] > $max['posts'])
					{
						$max['posts'] = $data['posts'];
					}
					if ($data['user_reg'] > $max['user_reg'])
					{
						$max['user_reg'] = $data['user_reg'];
					}
				}

				//now send data to template
				if ($totals['topics'])
				{
					$this->template->assign_var('S_DAILY_TOPICS', true);
					foreach ($daily_data as $day => $data)
					{
						$this->template->assign_block_vars('periodic_topics_row', array(
							'TIME_ELEMENT'	=> date('d F Y', mktime(0, 0, 0, $s_month[0], $day, $s_month[1])),
							'COUNT'			=> $data['topics'],
							'PCT'			=> number_format($data['topics'] / $totals['topics'] * 100, 3),
							'BARWIDTH'		=> number_format($data['topics'] / $max['topics'] * 100, 1),
							'IS_MAX'		=> ($data['topics'] == $max['topics']),
						));
					}
				}
				//posts
				if ($totals['posts'])
				{
					$this->template->assign_var('S_DAILY_POSTS', true);
					foreach ($daily_data as $day => $data)
					{
						$this->template->assign_block_vars('periodic_posts_row', array(
							'TIME_ELEMENT'	=> date('d F Y', mktime(0, 0, 0, $s_month[0], $day, $s_month[1])),
							'COUNT'			=> $data['posts'],
							'PCT'			=> number_format($data['posts'] / $totals['posts'] * 100, 3),
							'BARWIDTH'		=> number_format($data['posts'] / $max['posts'] * 100, 1),
							'IS_MAX'		=> ($data['posts'] == $max['posts']),
						));
					}
				}
				//user regs
				if ($totals['user_reg'])
				{
					$this->template->assign_var('S_DAILY_USER_REGS', true);
					foreach ($daily_data as $day => $data)
					{
						$this->template->assign_block_vars('periodic_user_regs_row', array(
							'TIME_ELEMENT'	=> date('d F Y', mktime(0, 0, 0, $s_month[0], $day, $s_month[1])),
							'COUNT'			=> $data['user_reg'],
							'PCT'			=> number_format($data['user_reg'] / $totals['user_reg'] * 100, 3),
							'BARWIDTH'		=> number_format($data['user_reg'] / $max['user_reg'] * 100, 1),
							'IS_MAX'		=> ($data['user_reg'] == $max['user_reg']),
						));
					}
				}

				//we have to show the month-select box, so get all the months and their display from the board start date
				//calculate the first month and year
				$temp_month = $board_starttime['mon'];
				$temp_year = $board_starttime['year'];
				$month_options = array();

				while (($temp_epoch = mktime(0, 0, 0, $temp_month, 1, $board_starttime['year'])) <= $current_time[0])
				{
					$month_options = array_merge($month_options, array(
						date('n-Y', $temp_epoch) => date('F Y', $temp_epoch)
					));
					$temp_month++;
				}

				$month_select_box = $this->make_select_box($month_options, $s_month[0] . '-' . $s_month[1], 's_month', $this->language->lang('SHOW_STATS_FOR_MONTH'), $this->language->lang('GO'), $this->u_action);

				$this->template->assign_vars(array(
					'TOTAL_TOPICS'				=> $totals['topics'],
					'TOTAL_POSTS'				=> $totals['posts'],
					'TOTAL_USER_REGS'			=> $totals['user_reg'],
					'AVG_TOPICS'				=> number_format($totals['topics'] / $counted_days, 2),
					'AVG_POSTS'					=> number_format($totals['posts'] / $counted_days, 2),
					'AVG_USER_REGS'				=> number_format($totals['user_reg'] / $counted_days, 2),
					'STATS_MONTH_EXPLAIN'		=> $this->language->lang('STATS_MONTH_EXPLAIN', $start_time['month'] . ' ' . $start_time['year']),
					'MONTH_SELECT_BOX'			=> $month_select_box,
				));
			break;

			case 'm':
				$show_all = false; //whether to show from the board start date
				//get the year for which to show stats, by default set it to the current month
				$current_time		= getdate(time()); //calculate the time here which will be used henceforth to prevent any mismatch if date changes at the tick of midnight!!!
				$board_starttime	= getdate($this->config['board_startdate']);
				$counted_months		= 0;

				if (!$s_year)
				{
					$s_year = $current_time['year'];
				}
				else if ($s_year == 'all')
				{
					$show_all = true;
				}

				//now get the first and last time limit for the search
				$start_time = $end_time = $counted_months = 0;
				if ($show_all)
				{
					$start_time = $board_starttime[0];
					$end_time = $current_time[0];
				}
				else
				{
					if ($s_year == $board_starttime['year']) //if the board started in the selected year, start from the board start month
					{
						$start_time = $board_starttime[0];
					}
					else
					{
						$start_time = mktime(0, 0, 0, 1, 1, $s_year);
					}
					if ($s_year == $current_time['year'])
					{
						$end_time = $current_time[0];
					}
					else
					{
						$end_time = mktime(0, 0, 0, 1, 1, $s_year + 1);
					}
				}
				$start_time	= getdate($start_time);
				$end_time	= getdate($end_time);

				$monthly_data = array();
				$offset_start_time = $start_time[0];
				while ($offset_start_time < $end_time[0])
				{
					$monthly_data[date('F Y', $offset_start_time)] = array('topics' => 0, 'posts' => 0, 'user_reg' => 0);
					$counted_months++;
					$offset_start_time = mktime(0, 0, 0, $start_time['mon'] + $counted_months, 1, $start_time['year']);
				}

				//now get the queries
				//topics
				$sql = 'SELECT topic_time AS time FROM ' . TOPICS_TABLE . '
							WHERE topic_visibility = ' . ITEM_APPROVED;
				if (!$show_all)
				{
					$sql .= ' AND topic_time >= ' . $start_time[0] . ' AND topic_time < ' . $end_time[0];
				}
				$result = $this->db->sql_query($sql);
				while ($row = $this->db->sql_fetchrow($result))
				{
					$monthly_data[date('F Y', $row['time'])]['topics']++;
				}
				$this->db->sql_freeresult($result);

				//posts
				$sql = 'SELECT post_time AS time FROM ' . POSTS_TABLE . '
							WHERE post_visibility = ' . ITEM_APPROVED;
				if (!$show_all)
				{
					$sql .= ' AND post_time >= ' . $start_time[0] . ' AND post_time < ' . $end_time[0];
				}
				$result = $this->db->sql_query($sql);
				while ($row = $this->db->sql_fetchrow($result))
				{
					$monthly_data[date('F Y', $row['time'])]['posts']++;
				}
				$this->db->sql_freeresult($result);

				//user regs
				$sql = 'SELECT user_regdate AS time FROM ' . USERS_TABLE . '
							WHERE ' . $this->db->sql_in_set('user_type', array(USER_NORMAL, USER_FOUNDER));
				if (!$show_all)
				{
					$sql .= ' AND user_regdate >= ' . $start_time[0] . ' AND user_regdate < ' . $end_time[0];
				}
				$result = $this->db->sql_query($sql);
				while ($row = $this->db->sql_fetchrow($result))
				{
					$monthly_data[date('F Y', $row['time'])]['user_reg']++;
				}
				$this->db->sql_freeresult($result);

				//all data retrieved now get the max and totals
				$totals = $max = array('topics' => 0, 'posts' => 0, 'user_reg' => 0);
				foreach ($monthly_data as $month => $data)
				{
					$totals['topics'] += $data['topics'];
					$totals['posts'] += $data['posts'];
					$totals['user_reg'] += $data['user_reg'];
					if ($data['topics'] > $max['topics'])
					{
						$max['topics'] = $data['topics'];
					}
					if ($data['posts'] > $max['posts'])
					{
						$max['posts'] = $data['posts'];
					}
					if ($data['user_reg'] > $max['user_reg'])
					{
						$max['user_reg'] = $data['user_reg'];
					}
				}

				//show stats for topics
				if ($totals['topics'])
				{
					$this->template->assign_var('S_MONTHLY_TOPICS', true);
					foreach ($monthly_data as $month => $data)
					{
						$this->template->assign_block_vars('periodic_topics_row', array(
							'TIME_ELEMENT'	=> $month,
							'COUNT'			=> $data['topics'],
							'PCT'			=> number_format($data['topics'] / $totals['topics'] * 100, 3),
							'BARWIDTH'		=> number_format($data['topics'] / $max['topics'] * 100, 1),
							'IS_MAX'		=> ($data['topics'] == $max['topics']),
						));
					}
				}
				//show stats for posts
				if ($totals['posts'])
				{
					$this->template->assign_var('S_MONTHLY_POSTS', true);
					foreach ($monthly_data as $month => $data)
					{
						$this->template->assign_block_vars('periodic_posts_row', array(
							'TIME_ELEMENT'	=> $month,
							'COUNT'			=> $data['posts'],
							'PCT'			=> number_format($data['posts'] / $totals['posts'] * 100, 3),
							'BARWIDTH'		=> number_format($data['posts'] / $max['posts'] * 100, 1),
							'IS_MAX'		=> ($data['posts'] == $max['posts']),
						));
					}
				}

				//show stats for user_reg
				if ($totals['user_reg'])
				{
					$this->template->assign_var('S_MONTHLY_USER_REGS', true);
					foreach ($monthly_data as $month => $data)
					{
						$this->template->assign_block_vars('periodic_user_regs_row', array(
							'TIME_ELEMENT'	=> $month,
							'COUNT'			=> $data['user_reg'],
							'PCT'			=> number_format($data['user_reg'] / $totals['user_reg'] * 100, 3),
							'BARWIDTH'		=> number_format($data['user_reg'] / $max['user_reg'] * 100, 1),
							'IS_MAX'		=> ($data['user_reg'] == $max['user_reg']),
						));
					}
				}

				//we have to show the month-select box, so get all the months and their display from the board start date
				$temp_year = $board_starttime['year'];
				$year_options = array();
				while ((int) $temp_year <= (int) $current_time['year'])
				{
					$year_options = array_merge($year_options, array(
						$temp_year . ' ' => $temp_year //we have to give the space so thats its taken as a string, while receiving the argument at the start of this function, we trim it. I tried converting the number to string but still didn't work!
					));
					$temp_year++;
				}
				//add the extra 'all' option also
				$year_options = array_merge($year_options, array(
					'all' => $this->language->lang('ALL')
				));

				$year_select_box = $this->make_select_box($year_options, ($show_all) ? 'all' : $s_year . ' ', 's_year', $this->language->lang('SHOW_STATS_FOR_YEAR'), $this->language->lang('GO'), $this->u_action);

				$this->template->assign_vars(array(
					'TOTAL_TOPICS'			=> $totals['topics'],
					'TOTAL_POSTS'			=> $totals['posts'],
					'TOTAL_USER_REGS'		=> $totals['user_reg'],
					'AVG_TOPICS'			=> number_format($totals['topics'] / $counted_months, 2),
					'AVG_POSTS'				=> number_format($totals['posts'] / $counted_months, 2),
					'AVG_USER_REGS'			=> number_format($totals['user_reg'] / $counted_months, 2),
					'STATS_YEAR_EXPLAIN'	=> $this->language->lang('STATS_YEAR_EXPLAIN', ($start_time['year'] != $current_time['year'] ? ($show_all ? $start_time['year'] . ' - ' . $current_time['year'] : $start_time['year']) : $current_time['year'])),
					'MONTH_SELECT_BOX'		=> $year_select_box,
				));
			break;

			case 'y':
				$show_all = false; //whether to show from the board start date
				//get the year for which to show stats, by default set it to the current month
				$current_time		= getdate(time()); //calculate the time here which will be used henceforth to prevent any mismatch if date changes at the tick of midnight!!!
				$board_starttime	= getdate($this->config['board_startdate']);
				$counted_years		= 0;

				//now get the first and last time limit for the search
				$start_time = getdate($board_starttime[0]);
				$end_time	= $current_time;

				$yearly_data = array();
				$offset_start_time = $start_time[0];
				while ($offset_start_time < $end_time[0])
				{
					$yearly_data[date('Y', $offset_start_time)] = array('topics' => 0, 'posts' => 0, 'user_reg' => 0);
					$counted_years++;
					$offset_start_time = mktime(0, 0, 0, 1, 1, $start_time['year'] + $counted_years);
				}

				//now get the queries
				//topics
				$sql = 'SELECT topic_time AS time FROM ' . TOPICS_TABLE . '
							WHERE topic_visibility = ' . ITEM_APPROVED;
				$result = $this->db->sql_query($sql);
				while ($row = $this->db->sql_fetchrow($result))
				{
					$yearly_data[date('Y', $row['time'])]['topics']++;
				}
				$this->db->sql_freeresult($result);

				//posts
				$sql = 'SELECT post_time AS time FROM ' . POSTS_TABLE . '
							WHERE post_visibility = ' . ITEM_APPROVED;
				$result = $this->db->sql_query($sql);
				while ($row = $this->db->sql_fetchrow($result))
				{
					$yearly_data[date('Y', $row['time'])]['posts']++;
				}
				$this->db->sql_freeresult($result);

				//user regs
				$sql = 'SELECT user_regdate AS time FROM ' . USERS_TABLE . '
							WHERE ' . $this->db->sql_in_set('user_type', array(USER_NORMAL, USER_FOUNDER));
				$result = $this->db->sql_query($sql);
				while ($row = $this->db->sql_fetchrow($result))
				{
					$yearly_data[date('Y', $row['time'])]['user_reg']++;
				}
				$this->db->sql_freeresult($result);

				//all data retrieved now get the max and totals
				$totals = $max = array('topics' => 0, 'posts' => 0, 'user_reg' => 0);
				foreach ($yearly_data as $year => $data)
				{
					$totals['topics'] += $data['topics'];
					$totals['posts'] += $data['posts'];
					$totals['user_reg'] += $data['user_reg'];
					if ($data['topics'] > $max['topics'])
					{
						$max['topics'] = $data['topics'];
					}
					if ($data['posts'] > $max['posts'])
					{
						$max['posts'] = $data['posts'];
					}
					if ($data['user_reg'] > $max['user_reg'])
					{
						$max['user_reg'] = $data['user_reg'];
					}
				}

				//show stats for topics
				if ($totals['topics'])
				{
					$this->template->assign_var('S_YEARLY_TOPICS', true);
					foreach ($yearly_data as $year => $data)
					{
						$this->template->assign_block_vars('periodic_topics_row', array(
							'TIME_ELEMENT'	=> $year,
							'COUNT'			=> $data['topics'],
							'PCT'			=> number_format($data['topics'] / $totals['topics'] * 100, 3),
							'BARWIDTH'		=> number_format($data['topics'] / $max['topics'] * 100, 1),
							'IS_MAX'		=> ($data['topics'] == $max['topics']),
						));
					}
				}
				//show stats for posts
				if ($totals['posts'])
				{
					$this->template->assign_var('S_YEARLY_POSTS', true);
					foreach ($yearly_data as $year => $data)
					{
						$this->template->assign_block_vars('periodic_posts_row', array(
							'TIME_ELEMENT'	=> $year,
							'COUNT'			=> $data['posts'],
							'PCT'			=> number_format($data['posts'] / $totals['posts'] * 100, 3),
							'BARWIDTH'		=> number_format($data['posts'] / $max['posts'] * 100, 1),
							'IS_MAX'		=> ($data['posts'] == $max['posts']),
						));
					}
				}

				//show stats for user_reg
				if ($totals['user_reg'])
				{
					$this->template->assign_var('S_YEARLY_USER_REGS', true);
					foreach ($yearly_data as $year => $data)
					{
						$this->template->assign_block_vars('periodic_user_regs_row', array(
							'TIME_ELEMENT'	=> $year,
							'COUNT'			=> $data['user_reg'],
							'PCT'			=> number_format($data['user_reg'] / $totals['user_reg'] * 100, 3),
							'BARWIDTH'		=> number_format($data['user_reg'] / $max['user_reg'] * 100, 1),
							'IS_MAX'		=> ($data['user_reg'] == $max['user_reg']),
						));
					}
				}

				$this->template->assign_vars(array(
					'TOTAL_TOPICS'				=> $totals['topics'],
					'TOTAL_POSTS'				=> $totals['posts'],
					'TOTAL_USER_REGS'			=> $totals['user_reg'],
					'AVG_TOPICS'				=> number_format($totals['topics'] / $counted_years, 2),
					'AVG_POSTS'					=> number_format($totals['posts'] / $counted_years, 2),
					'AVG_USER_REGS'				=> number_format($totals['user_reg'] / $counted_years, 2),
				));
			break;

			default:
		}

		$this->template->assign_vars(array(
			'L_TITLE'		=> $this->language->lang('BASIC_STATS'),
			'U_D_MODE'		=> $this->u_action . '?mode=d',
			'U_M_MODE'		=> $this->u_action . '?mode=m',
			'U_Y_MODE'		=> $this->u_action . '?mode=y',
			'S_FORM_ACTION'	=> $this->u_action . '?mode=' . $mode,
			'AS_ON'			=> $this->language->lang('AS_ON', $this->user->format_date($current_time[0])),
		));

		$this->template->set_filenames(array('body' => $mode . '_view.html'));
		$page_title = $this->language->lang('STATISTICS') . ' &bull; ' . $this->language->lang(strtoupper($mode . '_view'));
		page_header($page_title);
		page_footer();
	}

	private function make_select_box($options, $selected, $select_identifier, $label_prompt, $submit_prompt = 'submit', $action_url = '')
	{
		$return_str = $temp_str = '';

		foreach ($options as $option => $option_lang)
		{
			if ($option != $selected)
			{
				$temp_str .= '<option value="' . $option . "\">$option_lang</option>";
			}
			else {
				$temp_str .= '<option value="' . $option . '" selected="selected">' . $option_lang . '</option>';
			}
		}

		$submit_prompt = ucfirst($submit_prompt);

		if ($options)
		{
			$return_str = '<fieldset><label for="' . $select_identifier . '">' . $label_prompt . ': </label><select name=' . $select_identifier . ' id="' . $select_identifier . '">' . $temp_str . '</select> <input class="button2" type="submit" value="' . $submit_prompt . '" /></fieldset>';
		}

		return $return_str;
	}
}
