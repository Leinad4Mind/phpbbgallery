<?php
/**
 * @package cBB Blockgets
 * @version 2.0.6 20/09/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\controller;

use canidev\blockgets\libraries\constants;
use Symfony\Component\HttpFoundation\Response;
use \canidev\core\JsonResponse;

/**
 * Calendar controller
 */
class calendar_controller
{
	private $created_calendar	= 0;

	private $time;
	private $now;
	private $events;

	protected $auth;
	protected $config;
	protected $db;
	protected $dispatcher;
	protected $helper;
	protected $language;
	protected $log;
	protected $request;
	protected $template;
	protected $user;

	protected $tables;
	
	protected $options = [
		'birthdays'	=> true,
		'events'	=> true,
		'months'	=> 1,
	];

	/**
	 * Constructor
	 *
	 * @param \phpbb\auth\auth 						$auth				Authentication object
	 * @param \phpbb\config\config 					$config				Config Object
	 * @param \phpbb\db\driver\driver_interface		$db					DB Object
	 * @param \phpbb\event\dispatcher_interface		$phpbb_dispatcher	Event dispatcher
	 * @param \canidev\blockgets\libraries\helper	$helper       		Blockgets helper object
	 * @param \phpbb\language\language				$language			Blockgets language Object
	 * @param \phpbb\log\log                       	$log				Log Object
	 * @param \phpbb\request\request 				$request			Request object
	 * @param \canidev\core\template 				$template 			Core Template object
	 * @param \phpbb\user							$user				User object
	 * @param array 								$tables 			Blockgets DB Tables
	 *
	 * @access public
	 */
	public function __construct(
		\phpbb\auth\auth $auth,
		\phpbb\config\config $config,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\event\dispatcher_interface $phpbb_dispatcher,
		\canidev\blockgets\libraries\helper $helper,
		\phpbb\language\language $language,
		\phpbb\log\log $log,
		\phpbb\request\request $request,
		\canidev\core\template $template,
		\phpbb\user $user,
		$tables)
	{
		$this->auth			= $auth;
		$this->config		= $config;
		$this->db			= $db;
		$this->dispatcher	= $phpbb_dispatcher;
		$this->helper 		= $helper;
		$this->language		= $language;
		$this->log			= $log;
		$this->request		= $request;
		$this->template 	= $template;
		$this->user			= $user;

		$this->tables 		= $tables;

		$time = $this->user->create_datetime();
		$this->now = phpbb_gmgetdate($time->getTimestamp() + $time->getOffset());

		// The time of actual month (always set on first day)
		$this->time = $this->request->variable('time_now', time());
		$this->time = strtotime(date('Y/m/01', $this->time), $this->time);
	}

	/**
	 * Display the calendar
	 * @return Response
	 */
	public function display()
	{
		$time		= $this->request->variable('t', '');
		$action		= $this->request->variable('action', '');
		$event_id	= $this->request->variable('id', 0);
		$flags 		= OPTION_FLAG_BBCODE | OPTION_FLAG_SMILIES | constants::FLAG_HTML;

		$this->set_options([
			'birthdays'	=> (bool)$this->config['blg_calendar_birthdays'] && $this->auth->acl_get('u_blockgets_birthdays'),
		]);

		$this->template->set_filenames([
			'calendar'	=> '@canidev_blockgets/calendar_body.html'
		]);
		
		switch($action)
		{
			case 'delete_event':
				if(!$this->auth->acl_get('u_blockgets_events'))
				{
					$this->helper->json->send([
						'message'	=> $this->language->lang('NOT_AUTHORISED'),
						'status'	=> JsonResponse::JSON_STATUS_ERROR
					]);
				}

				// Get event data for log
				$sql = 'SELECT data_title
					FROM ' . $this->tables['data'] . '
					WHERE data_type = ' . constants::DATA_EVENT . '
					AND data_id = ' . $event_id;
				$result = $this->db->sql_query($sql);
				$event_title = $this->db->sql_fetchfield('data_title');
				$this->db->sql_freeresult($result);
				
				if($event_title)
				{
					// Remove the event
					$sql = 'DELETE FROM ' . $this->tables['data'] . '
						WHERE data_type = ' . constants::DATA_EVENT . '
						AND data_id = ' . $event_id;
					$this->db->sql_query($sql);

					$this->log->add('mod',
						$this->user->data['user_id'],
						$this->user->ip,
						'LOG_EVENT_REMOVED',
						time(),
						[$event_title]
					);
				}
				
				$this->helper->json->send([
					'message'	=> $this->language->lang('EVENT_REMOVED'),
				]);
			break;

			case 'load_birthday_list':
				$time = $this->request->variable('time', 0);

				$sql_where = 'u.user_birthday ' . $this->db->sql_like_expression(sprintf('%2d-%2d-', date('j', $time), date('n', $time)) . $this->db->get_any_char());

				$sql = 'SELECT u.user_id, u.username, u.user_colour, u.user_birthday,
					u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height
					FROM ' . USERS_TABLE . ' u
					LEFT JOIN ' . BANLIST_TABLE . " b ON (u.user_id = b.ban_userid)
					WHERE (b.ban_id IS NULL OR b.ban_exclude = 1)
					AND ($sql_where)
					AND u.user_type IN (" . USER_NORMAL . ', ' . USER_FOUNDER . ')
					ORDER BY username_clean ASC';
				$result = $this->db->sql_query($sql);
				while($row = $this->db->sql_fetchrow($result))
				{
					list($bday, $bmonth, $byear) = explode('-', str_replace(' ', '', $row['user_birthday']));

					$age = $this->now['year'] - (int)$byear;

					$this->template->assign_block_vars('user', [
						'AGE'			=> $age,
						'AVATAR'		=> phpbb_get_user_avatar($row),
						'USERNAME_FULL'	=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
					]);
				}
				$this->db->sql_freeresult($result);

				$this->template->assign_vars([
					'IN_BIRTHDAY_LIST'	=> true,
				]);

				$this->helper->json
					->addHtml($this->template->assign_display('calendar'))
					->send();
			break;

			case 'load_event':
				$sql = 'SELECT *
					FROM ' . $this->tables['data'] . '
					WHERE data_type = ' . constants::DATA_EVENT . '
					AND data_id = ' . $event_id;
				$result = $this->db->sql_query($sql);
				$event_row = $this->db->sql_fetchrow($result);
				$this->db->sql_freeresult($result);
				
				if(!$event_row)
				{
					$this->helper->json->send([
						'message'	=> $this->language->lang('EVENT_ERROR'),
						'status'	=> JsonResponse::JSON_STATUS_ERROR,
					]);
				}

				$event_content = generate_text_for_display($event_row['data_content'], $event_row['bbcode_uid'], $event_row['bbcode_bitfield'], $flags);
				$event_content = \canidev\core\TextParser::fixSmiliesPath($event_content);

				$this->template->assign_vars([
					'CAN_MANAGE_EVENT'	=> $this->can_manage_event($event_row),
					'IN_EVENT'			=> true,
					'S_EVENT_TITLE'		=> $event_row['data_title'],
					'S_EVENT_CONTENT'	=> $event_content,
				
					'S_HIDDEN_FIELDS'	=> build_hidden_fields([
						'event_id'		=> $event_id,
						'event_time'	=> $event_row['data_time'],
					]),
				]);

				$this->helper->json
					->addHtml($this->template->assign_display('calendar'))
					->send();
			break;
			
			default:
				if(preg_match('#([0-9]{2})\-([0-9]{4})#', $time, $match))
				{
					$this->set_month($match[1], $match[2]);
				}

				$this
					->get_events()
					->create_calendar();

				$next_data = $this->get_month('next');
				$prev_data = $this->get_month('prev');

				// Month selector
				$month_names = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
				$month_options = '';

				foreach($month_names as $i => $month_name)
				{
					$month_options .= '<option value="' . sprintf('%02d', $i+1) . '">' . $this->language->lang(['datetime', $month_name]) . '</option>';
				}
					
				$this->template->assign_vars([
					'BLG_ENABLED'		=> true,
					'S_MONTH_OPTIONS'	=> $month_options,
					
					'U_NEXT'		=> $this->helper->route('canidev_blockgets_calendar_controller', ['t' => $next_data['month'] . '-' . $next_data['year']]),
					'U_PREV'		=> $this->helper->route('canidev_blockgets_calendar_controller', ['t' => $prev_data['month'] . '-' . $prev_data['year']]),
					'U_TODAY'		=> $this->helper->route('canidev_blockgets_calendar_controller'),
				]);
				
				$this->template->append_asset('css', [
					'content'	=> '@canidev_blockgets/calendar_print.css',
					'media' 	=> 'print',
				]);
			break;
		}

		page_header($this->language->lang('CALENDAR'));

		page_footer(true, false, false);

		$headers = !empty($this->user->data['is_bot']) ? ['X-PHPBB-IS-BOT' => 'yes'] : [];

		return new Response($this->template->assign_display('calendar'), 200, $headers);
	}
	
	/**
	 * Create calendar
	 * Build the month form (days, weeks)
	 * 
	 * @return static
	 */
	public function create_calendar()
	{
		$day_names	= ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
		$days		= $this->get_month_days();
		$month_data = $this->get_month();
		
		$this->template->assign_vars([
			'S_CAN_CREATE_EVENT'	=> $this->auth->acl_get('u_blockgets_events'),
		]);

		$this->template->assign_block_vars('calendar', [
			'S_MONTH'				=> $this->language->lang(['datetime', $month_data['name']]) . ' ' . $month_data['year'],

			'S_HIDDEN_FIELDS'		=> build_hidden_fields([
				'time_now'	=> $this->time,
			]),
			
			'U_ACTION'				=> $this->helper->route('canidev_blockgets_calendar_controller', ['t' => $month_data['month'] . '-' . $month_data['year']]),
		]);

		$i 			= 0;
		$in_header 	= true;
		
		while($i < 7)
		{
			$day 		= '';
			$day_time 	= 0;

			if($in_header)
			{
				$d = $i + (int)$this->config['blg_calendar_first_day'];
				
				if($d > 6)
				{
					$d = $d-7;
				}

				$day = $this->language->lang(['datetime', $day_names[$d]]);
			}
			else if(isset($days[0]))
			{
				if($this->get_week_day($days[0]['week_day']) == $i)
				{
					$day = $days[0]['day'];
					$day_time = $days[0]['day_time'];
					array_shift($days);
				}
			}

			$this->template->assign_block_vars('calendar.days', [
				'IS_HEADER'		=> $in_header,
				'IS_TODAY'		=> (date('j-n-Y', $this->now[0]) == date('j-n-Y', $day_time)) ? true : false,
				'S_EVENT'		=> (isset($this->events[$day_time]) ? 1 : 0),
				'S_COLOR'		=> (isset($this->events[$day_time]) && sizeof($this->events[$day_time]) == 1) ? $this->events[$day_time][0]['color'] : '',
				'S_DATA'		=> $day_time,
				'S_DAY'			=> $day,
				'S_DAY_SHORT'	=> utf8_substr($day, 0, 3),
				'NEW_LINE'		=> ($i == 0) ? true : false,
			]);
			
			if(isset($this->events[$day_time]))
			{
				$this->events_to_template('calendar.days.event', $this->events[$day_time]);
			}

			if(isset($days[0]) && $i == 6)
			{
				$in_header = false;
				$i = 0;
				continue;
			}
			$i++;
		}

		$this->created_calendar++;

		if($this->options['months'] > $this->created_calendar)
		{
			$this->time = strtotime("+1 month", $this->time);
			$this->create_calendar();
		}
		
		return $this;
	}

	/**
	 * Get the calendar events and birthdays and put into template
	 * 
	 * @param int 	$timestamp
	 * @return static
	 */
	public function get_events($timestamp = 0)
	{
		$events = $month_years = [];

		if($timestamp)
		{
			$start_time = $end_time = $timestamp;
			$sql_where = 'data_time = ' . (int)$timestamp;
			$events[$timestamp] = [];
		}
		else
		{
			$start_time	= $this->time;
			$end_time	= strtotime("+{$this->options['months']} month", $start_time);
			$sql_where	= "(data_time BETWEEN $start_time AND $end_time)";
		}

		// Get events
		if($this->options['events'])
		{
			$sql = 'SELECT *
				FROM ' . $this->tables['data'] . '
				WHERE data_type = ' . constants::DATA_EVENT . "
				AND $sql_where";
			$result = $this->db->sql_query($sql);
			while($row = $this->db->sql_fetchrow($result))
			{
				$settings 	= unserialize($row['data_settings']);
				$c_time 	= $row['data_time'];

				if(!$this->helper->group_auth($settings['groups']))
				{
					continue;
				}

				if(!isset($events[$c_time]))
				{
					$events[$c_time] = [];
				}

				$events[$c_time][] = [
					'id'		=> $row['data_id'],
					'title'		=> $row['data_title'],
					'type'		=> 'event',
					'content'	=> $row['data_content'],
					'color'		=> $settings['color'],
				];
			}
			$this->db->sql_freeresult($result);
		}

		// Get time period for birthdays
		if($this->options['birthdays'] && $this->config['allow_birthdays'])
		{
			$birthday_ary = [];
			$sql_where = '';
			$t = $start_time;

			if($timestamp)
			{
				$sql_where = 'u.user_birthday ' . $this->db->sql_like_expression(sprintf('%2d-%2d-', date('j', $t), date('n', $t)) . $this->db->get_any_char());
			}
			else
			{
				for($i = 0; $i < $this->options['months']; $i++)
				{
					if($i > 0)
					{
						$t = strtotime("+{$i} month", $start_time);
					}

					$month_years[date('n', $t)] = $t;

					$sql_where .= (($sql_where) ? ' OR ' : '') . 'u.user_birthday ' . $this->db->sql_like_expression($this->db->get_any_char() . sprintf('-%2d-', date('n', $t)) . $this->db->get_any_char());
				}
			}

			$sql = 'SELECT u.user_id, u.username, u.user_colour, u.user_birthday
				FROM ' . USERS_TABLE . ' u
				LEFT JOIN ' . BANLIST_TABLE . " b ON (u.user_id = b.ban_userid)
				WHERE (b.ban_id IS NULL OR b.ban_exclude = 1)
				AND ($sql_where)
				AND u.user_type IN (" . USER_NORMAL . ', ' . USER_FOUNDER . ')';
			$result = $this->db->sql_query($sql);
			while($row = $this->db->sql_fetchrow($result))
			{
				list($bday, $bmonth, $byear) = explode('-', str_replace(' ', '', $row['user_birthday']));

				$t_year = (isset($month_years[$bmonth]) ? $month_years[$bmonth] : $this->time);
				$c_time = ($timestamp) ? ($timestamp) : strtotime(date('Y', $t_year) . "/$bmonth/$bday");
				$age = $this->now['year'] - (int)$byear;

				if(!isset($birthday_ary[$c_time]))
				{
					$birthday_ary[$c_time] = [];
				}

				if($age)
				{
					$birthday_ary[$c_time][] = get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']) . " ($age)";
				}
			}
			$this->db->sql_freeresult($result);

			foreach($birthday_ary as $e_time => $e_data)
			{
				$events[$e_time][] = [
					'title'		=> '',
					'type'		=> 'birthday',
					'content'	=> $e_data,
					'color'		=> '',
				];
			}
		}

		/**
		 * @event calendar.load_events_after
		 * @var array	events			Array with event's data
		 * @var int		start_time		Timestamp of range start
		 * @var int		end_time		Timestamp of range end
		 * @since 2.0.0
		 */
		$vars = ['events', 'start_time', 'end_time'];
		extract($this->dispatcher->trigger_event('calendar.load_events_after', compact($vars)));
	
		$this->events = $events;
		
		if($timestamp)
		{
			return $this->events[$timestamp];
		}

		return $this;
	}
	
	/**
	 * Reset properties
	 */
	public function reset()
	{
		$this->created_calendar = 0;
		$this->time = time();
		$this->time = strtotime(date('Y/m/01', $this->time), $this->time);
		
		$this->template->destroy_block_vars('calendar');
	}
	
	/**
	 * Set options
	 * 
	 * @param array 	$options
	 * @return static
	 */
	public function set_options($options)
	{
		$this->options = array_merge($this->options, $options);
		return $this;
	}
	
	/**
	 * Set current month
	 * 
	 * @param int 	$month
	 * @param int 	$year
	 * 
	 * @return static
	 */
	public function set_month($month, $year)
	{
		$this->time = strtotime("$year/$month/01", time());
		return $this;
	}
	
	/**
	 * Get current month
	 * 
	 * @param string|int|null 		$input
	 * @return array
	 */
	public function get_month($input = null)
	{
		$time = 0;
		
		if($input == 'prev')
		{
			$time = strtotime("-{$this->options['months']} month", $this->time);
		}
		else if($input == 'next')
		{
			$time = strtotime('+1 month', $this->time);
		}
		else if(is_numeric($input))
		{
			$time = (int)$input;
		}
		else if(is_null($input))
		{
			$time = $this->time;
		}
		
		if($time)
		{
			$data = getdate($time);

			return [
				'month'			=> sprintf('%02d', $data['mon']),
				'name'			=> $data['month'],
				'year'			=> $data['year'],
				'timestamp'		=> $time,
			];
		}
	}

	/**
	 * Put events into template
	 * 
	 * @param string 	$template_key
	 * @param array		$event_ary
	 * 
	 * @access private
	 */
	public function events_to_template($template_key, $event_ary)
	{
		foreach($event_ary as $event)
		{
			$attr = [
				'class'			=> 'blg-calendar-event',
				'data-color'	=> $event['color'],
				'data-event' 	=> isset($event['id']) ? $event['id'] : 0,
			];

			if($event['type'] == 'birthday')
			{
				$attr['class'] .= ' blg-event-birthday';

				if(sizeof($event['content']) > 2)
				{
					$title_ary = array_splice($event['content'], 0, 2);
					
					$event['title'] = $this->language->lang(
						'CALENDAR_BIRTHDAY_TITLE',
						implode(', ', $title_ary),
						sizeof($event['content'])
					);
				}
				else
				{
					$event['title'] = implode(', ', $event['content']);
				}

				$event['content'] = '';
			}

			$this->template->assign_block_vars($template_key, [
				'S_ATTR'	=> \canidev\core\tools::array_to_attr($attr),
				'S_TITLE'	=> $event['title'],
				'S_TYPE'	=> $event['type'],
				'S_CONTENT'	=> $event['content'],
			]);
		}
	}
	
	/**
	 * Check if user can manage event
	 * 
	 * @param array|false 	$row
	 * @return bool
	 * @access private
	 */
	private function can_manage_event($row = false)
	{
		return ($this->auth->acl_get('u_blockgets_events') &&
			($this->auth->acl_get('m_') ||
				($row !== false && $this->user->data['user_id'] == $row['user_id'])));
	}

	/**
	 * Get month days
	 * @return array
	 * @access private
	 */
	private function get_month_days() 
	{
		list($myear, $mmonth, $month_days) = explode(',', date("Y,n,t", $this->time));

		$day = [];
    
		for($i = 1; $i < $month_days +1; $i++) 
		{
			$day_time = strtotime("$myear/$mmonth/$i");

			$day[] = [
				'day'		=> $i,
				'week_day'	=> (int)date('w', $day_time),
				'day_time'	=> $day_time,
			];
		}

		return $day;
	}

	/**
	 * Get week day
	 * 
	 * @param int 	$day
	 * @return int
	 * @access private
	 */
	private function get_week_day($day)
	{
		$day = (int)$day;

		$seg = $day - (int)$this->config['blg_calendar_first_day'];

		if($seg < 0)
		{
			return $seg + 7;
		}

		if($seg > 6)
		{
			return $seg -7;
		}

		return $seg;
	}
}
