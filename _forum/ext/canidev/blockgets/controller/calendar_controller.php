<?php
/*
* @package cBB Blockgets
* @version v2.0.2 12/01/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\controller;

use Symfony\Component\HttpFoundation\Response;
use \canidev\core\json_response;

/**
* Main controller
*/
class calendar_controller implements main_interface
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
	protected $lang;
	protected $log;
	protected $request;
	protected $template;
	protected $user;
	
	protected $options = array(
		'birthdays'	=> true,
		'events'	=> true,
		'months'	=> 1,
	);

	/**
	* Constructor
	*
	* @param \phpbb\auth\auth 						$auth				Authentication object
	* @param \phpbb\config\config 					$config				Config Object
	* @param ContainerInterface 					$container			Service container interface
	* @param \phpbb\db\driver\driver_interface		$db					DB Object
	* @param \phpbb\event\dispatcher_interface		$phpbb_dispatcher	Event dispatcher
	* @param \canidev\blockgets\libraries\helper	$helper       		Blockgets helper object
	* @param \phpbb\language\language				$language			Blockgets language Object
	* @param \phpbb\log\log                       	$log				Log Object
	* @param \phpbb\request\request 				$request			Request object
	* @param \phpbb\user							$user				User object
	*
	* @access public
	*/
	public function __construct(
		\phpbb\auth\auth $auth,
		\phpbb\config\config $config,
		\Symfony\Component\DependencyInjection\ContainerInterface $container,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\event\dispatcher_interface $phpbb_dispatcher,
		\canidev\blockgets\libraries\helper $helper,
		\phpbb\language\language $language,
		\phpbb\log\log $log,
		\phpbb\request\request $request,
		\phpbb\user $user)
	{
		$this->auth			= $auth;
		$this->config		= $config;
		$this->db			= $db;
		$this->dispatcher	= $phpbb_dispatcher;
		$this->helper 		= $helper;
		$this->lang			= $language;
		$this->log			= $log;
		$this->request		= $request;
		$this->template 	= \canidev\core\template::get_instance($container);
		$this->user			= $user;

		$time = $this->user->create_datetime();
		$this->now = phpbb_gmgetdate($time->getTimestamp() + $time->getOffset());

		// The time of actual month (always set on first day)
		$this->time = $this->request->variable('time_now', time());
		$this->time = strtotime(date('Y/m/01', $this->time), $this->time);
	}

	/**
	* Display the calendar
	* @access public
	*/
	public function display()
	{
		$time		= $this->request->variable('t', '');
		$action		= $this->request->variable('action', '');
		$event_id	= $this->request->variable('id', 0);
		$flags 		= OPTION_FLAG_BBCODE | OPTION_FLAG_SMILIES | BLG_FLAG_HTML;

		$this->set_options(array(
			'birthdays'	=> (bool)$this->config['blg_calendar_birthdays'],
		));

		$this->template->set_filenames(array(
			'calendar'	=> '@canidev_blockgets/calendar_body.html'
		));
		
		switch($action)
		{
			case 'delete_event':
				if(!$this->auth->acl_get('u_blockgets_events'))
				{
					$this->helper->json->send(array(
						'message'	=> $this->lang->lang('NOT_AUTHORISED'),
						'status'	=> json_response::JSON_STATUS_ERROR
					));
				}

				// Get event data for log
				$sql = 'SELECT data_title
					FROM ' . BLG_DATA_TABLE . '
					WHERE data_type = ' . BLG_DATA_EVENT . '
					AND data_id = ' . $event_id;
				$result = $this->db->sql_query($sql);
				$event_title = $this->db->sql_fetchfield('data_title');
				$this->db->sql_freeresult($result);
				
				if($event_title)
				{
					// Remove the event
					$sql = 'DELETE FROM ' . BLG_DATA_TABLE . '
						WHERE data_type = ' . BLG_DATA_EVENT . '
						AND data_id = ' . $event_id;
					$this->db->sql_query($sql);

					$this->log->add('mod',
						$this->user->data['user_id'],
						$this->user->ip,
						'LOG_EVENT_REMOVED',
						time(),
						array($event_title)
					);
				}
				
				$this->helper->json->send(array(
					'message'	=> $this->lang->lang('EVENT_REMOVED'),
				));
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
					AND u.user_posts > 100
					AND u.user_type IN (" . USER_NORMAL . ', ' . USER_FOUNDER . ')
					ORDER BY username_clean ASC';
				$result = $this->db->sql_query($sql);
				while($row = $this->db->sql_fetchrow($result))
				{
					list($bday, $bmonth, $byear) = explode('-', str_replace(' ', '', $row['user_birthday']));

					$age = $this->now['year'] - (int)$byear;

					$user_avatar = phpbb_get_user_avatar(array(
						'avatar'		=> $row['user_avatar'],
						'avatar_type'	=> $row['user_avatar_type'],
						'avatar_width'	=> $row['user_avatar_width'], 
						'avatar_height'	=> $row['user_avatar_height'],
					));

					$this->template->assign_block_vars('user', array(
						'AGE'			=> $age,
						'AVATAR'		=> $user_avatar,
						'USERNAME_FULL'	=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
					));
				}
				$this->db->sql_freeresult($result);

				$this->template->assign_vars(array(
					'IN_BIRTHDAY_LIST'	=> true,
				));

				$this->helper->json
					->add_html($this->template->assign_display('calendar'))
					->send();
			break;

			case 'load_event':
				$sql = 'SELECT *
					FROM ' . BLG_DATA_TABLE . '
					WHERE data_type = ' . BLG_DATA_EVENT . '
					AND data_id = ' . $event_id;
				$result = $this->db->sql_query($sql);
				$event_row = $this->db->sql_fetchrow($result);
				$this->db->sql_freeresult($result);
				
				if(!$event_row)
				{
					$this->helper->json->send(array(
						'message'	=> $this->lang->lang('EVENT_ERROR'),
						'status'	=> json_response::JSON_STATUS_ERROR,
					));
				}

				$event_content = generate_text_for_display($event_row['data_content'], $event_row['bbcode_uid'], $event_row['bbcode_bitfield'], $flags);
				$event_content = \canidev\core\tools::fix_smilies_path($event_content);

				$this->template->assign_vars(array(
					'CAN_MANAGE_EVENT'	=> $this->can_manage_event($event_row),
					'IN_EVENT'			=> true,
					'S_EVENT_TITLE'		=> $event_row['data_title'],
					'S_EVENT_CONTENT'	=> $event_content,
				
					'S_HIDDEN_FIELDS'	=> build_hidden_fields(array(
						'event_id'		=> $event_id,
						'event_time'	=> $event_row['data_time'],
					)),
				));

				$this->helper->json
					->add_html($this->template->assign_display('calendar'))
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
					
				$this->template->assign_vars(array(
					'BLG_ENABLED'	=> true,
					
					'U_NEXT'		=> $this->helper->route('canidev_blockgets_calendar_controller', array('t' => $next_data['month'] . '-' . $next_data['year'])),
					'U_PREV'		=> $this->helper->route('canidev_blockgets_calendar_controller', array('t' => $prev_data['month'] . '-' . $prev_data['year'])),
					'U_TODAY'		=> $this->helper->route('canidev_blockgets_calendar_controller'),
				));
				
				$this->template->append_asset('css', array(
					'content'	=> '@canidev_blockgets/../theme/calendar_print.css',
					'media' 	=> 'print',
				));
			break;
		}

		page_header($this->lang->lang('CALENDAR'));

		page_footer(true, false, false);

		$headers = !empty($this->user->data['is_bot']) ? array('X-PHPBB-IS-BOT' => 'yes') : array();

		return new Response($this->template->assign_display('calendar'), 200, $headers);
	}
	
	/*
	* create calendar
	* Build the month form (days, weeks)
	*/
	public function create_calendar()
	{
		$day_names	= array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
		$days		= $this->get_month_days();
		$month_data = $this->get_month();
		
		$this->template->assign_vars(array(
			'S_CAN_CREATE_EVENT'	=> $this->auth->acl_get('u_blockgets_events'),
		));

		$this->template->assign_block_vars('calendar', array(
			'S_MONTH'				=> $this->lang->lang(array('datetime', $month_data['name'])) . ' ' . $month_data['year'],

			'S_HIDDEN_FIELDS'		=> build_hidden_fields(array(
				'time_now'	=> $this->time,
			)),
			
			'U_ACTION'				=> $this->helper->route('canidev_blockgets_calendar_controller', array('t' => $month_data['month'] . '-' . $month_data['year'])),
		));

		$i = 0;
		$in_header = true;
		while($i < 7)
		{
			$day = '';
			$day_time = 0;

			if($in_header)
			{
				$d = $i + (int)$this->config['blg_calendar_first_day'];
				if($d > 6)
				{
					$d = $d-7;
				}

				$day = $this->lang->lang(array('datetime', $day_names[$d]));
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

			$this->template->assign_block_vars('calendar.days', array(
				'IS_HEADER'		=> $in_header,
				'IS_TODAY'		=> (date('j-n-Y', $this->now[0]) == date('j-n-Y', $day_time)) ? true : false,
				'S_EVENT'		=> (isset($this->events[$day_time]) ? 1 : 0),
				'S_COLOR'		=> (isset($this->events[$day_time]) && sizeof($this->events[$day_time]) == 1) ? $this->events[$day_time][0]['color'] : '',
				'S_DATA'		=> $day_time,
				'S_DAY'			=> $day,
				'S_DAY_SHORT'	=> utf8_substr($day, 0, 3),
				'NEW_LINE'		=> ($i == 0) ? true : false,
			));
			
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
	* get_events
	* Get the calendar events and birthdays and put into template
	*/
	public function get_events($timestamp = 0)
	{
		$events = $month_years = array();

		if($timestamp)
		{
			$start_time = $end_time = $timestamp;
			$sql_where = 'data_time = ' . (int)$timestamp;
			$events[$timestamp] = array();
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
				FROM ' . BLG_DATA_TABLE . '
				WHERE data_type = ' . BLG_DATA_EVENT . "
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
					$events[$c_time] = array();
				}

				$events[$c_time][] = array(
					'id'		=> $row['data_id'],
					'title'		=> $row['data_title'],
					'type'		=> 'event',
					'content'	=> $row['data_content'],
					'color'		=> $settings['color'],
				);
			}
			$this->db->sql_freeresult($result);
		}

		// Get time period for birthdays
		if($this->options['birthdays'] && $this->config['allow_birthdays'])
		{
			$birthday_ary = array();
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
				AND u.user_posts > 100
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
					$birthday_ary[$c_time] = array();
				}

				if($age)
				{
					$birthday_ary[$c_time][] = get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']) . " ($age)";
				}
			}
			$this->db->sql_freeresult($result);

			foreach($birthday_ary as $e_time => $e_data)
			{
				$events[$e_time][] = array(
					'title'		=> '',
					'type'		=> 'birthday',
					'content'	=> $e_data,
					'color'		=> '',
				);
			}
		}

		/*
		* @event calendar.load_events_after
		* @var array	events			Array with event's data
		* @var int		start_time		Timestamp of range start
		* @var int		end_time		Timestamp of range end
		* @since 2.0.0
		*/
		$vars = array('events', 'start_time', 'end_time');
		extract($this->dispatcher->trigger_event('calendar.load_events_after', compact($vars)));
	
		$this->events = $events;
		
		if($timestamp)
		{
			return $this->events[$timestamp];
		}

		return $this;
	}
	
	public function reset()
	{
		$this->created_calendar = 0;
		$this->time = time();
		$this->time = strtotime(date('Y/m/01', $this->time), $this->time);
		
		$this->template->destroy_block_vars('calendar');
	}
	
	public function set_options($options)
	{
		$this->options = array_merge($this->options, $options);
		return $this;
	}
	
	public function set_month($month, $year)
	{
		$this->time = strtotime("$year/$month/01", time());
		return $this;
	}
	
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

			return array(
				'month'			=> (($data['mon'] < 10) ? '0' : '') . $data['mon'],
				'name'			=> $data['month'],
				'year'			=> $data['year'],
				'timestamp'		=> $time,
			);
		}
	}

	public function events_to_template($templateKey, $event_ary)
	{
		foreach($event_ary as $event)
		{
			$attr = array(
				'class'			=> 'blg-calendar-event',
				'data-color'	=> $event['color'],
				'data-event' 	=> (isset($event['id']) ? $event['id'] : 0),
			);

			if($event['type'] == 'birthday')
			{
				$attr['class'] .= ' blg-event-birthday';

				if(sizeof($event['content']) > 2)
				{
					$title_ary = array_splice($event['content'], 0, 2);
					
					$event['title'] = $this->lang->lang(
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

			$this->template->assign_block_vars($templateKey, array(
				'S_ATTR'	=> \canidev\core\tools::array_to_attr($attr),
				'S_TITLE'	=> $event['title'],
				'S_TYPE'	=> $event['type'],
				'S_CONTENT'	=> $event['content'],
			));
		}
	}
	
	private function can_manage_event($row = false)
	{
		return ($this->auth->acl_get('u_blockgets_events') &&
			($this->auth->acl_get('m_') ||
				($row !== false && $this->user->data['user_id'] == $event_row['user_id'])));
	}

	private function get_month_days() 
	{
		list($myear, $mmonth, $month_days) = explode(',', date("Y,n,t", $this->time));

		$day = array();
    
		for($i = 1; $i < $month_days +1; $i++) 
		{
			$day_time = strtotime("$myear/$mmonth/$i");

			$day[] = array(
				'day'		=> $i,
				'week_day'	=> (int)date('w', $day_time),
				'day_time'	=> $day_time,
			);
		}

		return $day;
	}

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
