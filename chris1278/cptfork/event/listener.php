<?php
/**
 *
 * CF Change Post Time
 *
 * @copyright (c) 2024 chris1278
 * @copyright (c) 2015 javiexin ( www.exincastillos.es )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Javier Lopez (javiexin)
 */

namespace chris1278\cptfork\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	protected $config;
	protected $db;
	protected $user;
	protected $auth;
	protected $request;
	protected $log;
	protected $root_path;
	protected $php_ext;

	public function __construct(
		\phpbb\config\config $config,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\user $user,
		\phpbb\auth\auth $auth,
		\phpbb\request\request $request,
		\phpbb\log\log $log,
		$root_path,
		$php_ext
	)
	{
		$this->config		= $config;
		$this->db			= $db;
		$this->user			= $user;
		$this->auth			= $auth;
		$this->request		= $request;
		$this->log			= $log;
		$this->root_path	= $root_path;
		$this->php_ext		= $php_ext;
	}

	public static function getSubscribedEvents()
	{
		return [
			'core.user_setup'							=> 'load_language_on_setup',
			'core.permissions'							=> 'mcp_post_chg_post_time_permission',
			'core.mcp_post_additional_options'			=> 'mcp_post_chg_post_time_action',
			'core.mcp_post_template_data'				=> 'mcp_post_chg_post_time_template',
		];
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name'	=> 'chris1278/cptfork',
			'lang_set'	=> 'mcp_cptfork',
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function mcp_post_chg_post_time_permission($event)
	{
		$permissions = array_merge($event['permissions'], [
				'm_cf_chgposttime'		=> [
					'lang' => 'ACL_M_CF_CHGPOSTTIME',
					'cat' => 'post_actions'
				],
			]);
		$event['permissions'] = $permissions;
	}

	public function mcp_post_chg_post_time_action($event)
	{
		// We only deal with Change Post Time action
		if ($event['action'] !== 'cf_chgposttime')
		{
			return;
		}

		$post_info	= $event['post_info'];
		$post_id	= $post_info['post_id'];

		// Check permissions
		if (!$this->auth->acl_get('m_cf_chgposttime', $post_info['forum_id']))
		{
			trigger_error('NOT_AUTHORISED');
		}

		if ($this->config['cf_cpt_option'] == 'opt_1')
		{
			$php_check_date	= date('Y-m-d');
		}
		else if ($this->config['cf_cpt_option'] == 'opt_2')
		{
			date_default_timezone_set($this->user->data['user_timezone']);
			$timestamp = time();
			$format = 'Y-m-d';
			$php_check_date	= date($format, $timestamp);
		}
		else if ($this->config['cf_cpt_option'] == 'opt_3')
		{
			date_default_timezone_set($this->config['board_timezone']);
			$timestamp = time();
			$format = 'Y-m-d';
			$php_check_date	= date($format, $timestamp);
		}
		else if ($this->config['cf_cpt_option'] == 'opt_4')
		{
			$year			= date('Y');
			$month			= date('m');
			$day			= date('d') +1;

			$php_check_date	= $year . '-' . $month . '-' . $day;
		}

		// Get the original time, and format it according to the user timezone
		$oldtime 		= $this->user->create_datetime()->setTimestamp($post_info['post_time']);
		$from_oldtime	= $oldtime->format();

		//Read the values from the input fields and write them into individual arrays
		list($year, $month, $day)	= explode("-", $this->request->variable('cf_date', ''));
		list($hour, $minute)		= explode(":", $this->request->variable('cf_time', ''));

		$year	= ($year) ? $year : (int) $oldtime->format('Y');
		$month	= ($month) ? $month : (int) $oldtime->format('n');
		$day 	= ($day) ? $day : (int) $oldtime->format('j');
		$hour	= ($hour>=0) ? $hour : (int) $oldtime->format('G');
		$minute = ($minute>=0) ? $minute : (int) $oldtime->format('i');

		// Use user timezone to create UNIX timestamp
		$newtime		= $this->user->create_datetime()->setDate($year, $month, $day)->setTime($hour, $minute);
		$update_time	= $newtime->getTimestamp();

		/*
		* Here it is checked whether the date is less than or equal and if the
		* date is greater than the current date, the entry is canceled and an error message is output.
		* This is a security measure in case someone wants to bypass the HTML query "max".
		*/
		if ($this->config['cf_cpt_option'] != 'opt_5')
		{
			if ($year . '-' . $month . '-' . $day > $php_check_date)
			{
				trigger_error('CF_ERROR_DATE');
			}
		}

		// Update post_time in database
		$sql = 'UPDATE ' . POSTS_TABLE . '
			SET post_time = ' . (int) $update_time .
			' WHERE post_id = ' . (int) $post_id;
		$this->db->sql_query($sql);

		// Synchronize topic and forum
		if (!function_exists('sync'))
		{
			include($this->root_path . 'includes/functions_admin.' . $this->php_ext);
		}
		sync('topic', 'topic_id', $post_info['topic_id'], true);
		sync('forum', 'forum_id', $post_info['forum_id'], true);

		// Renew post info
		if (!function_exists('phpbb_get_post_data'))
		{
			include($this->root_path . 'includes/functions_mcp.' . $this->php_ext);
		}
		$post_info = phpbb_get_post_data([$post_id], false, true);

		if (!sizeof($post_info))
		{
			trigger_error('POST_NOT_EXIST');
		}

		$post_info = $post_info[$post_id];
		$to_newtime = $newtime->format();

		// Now add log entry
		$this->log->add('mod', $this->user->data['user_id'], $this->user->ip, 'LOG_MCP_CF_CHANGE_POSTTIME', false, [
				'forum_id'		=> (int) $post_info['forum_id'],
				'topic_id'		=> (int) $post_info['topic_id'],
				$post_info['topic_title'],
				$from_oldtime,
				$to_newtime,
				(int) $post_id,
			]);

		$event['post_info'] = $post_info;
	}

	public function mcp_post_chg_post_time_template($event)
	{
		$post_info = $event['post_info'];
		$mcp_post_template_data = $event['mcp_post_template_data'];

		$oldtime = $this->user->create_datetime()->setTimestamp($post_info['post_time']);

		//The original values are generated here, which are output when opening the mcp for corresponding changes in the template.
		$year	= (int) $oldtime->format('Y');
		$month	= ((int) $oldtime->format('n') >= 0 && (int) $oldtime->format('n') < 10) ? '-0' . (int) $oldtime->format('n') : '-' . (int) $oldtime->format('n');
		$day 	= ((int) $oldtime->format('j') >= 0 && (int) $oldtime->format('j') < 10) ? '-0' . (int) $oldtime->format('j') : '-' . (int) $oldtime->format('j');
		$hour	= ((int) $oldtime->format('G') >= 0 && (int) $oldtime->format('G') < 10) ? '0' . (int) $oldtime->format('G') : (int) $oldtime->format('G');
		$minute = ((int) $oldtime->format('i') >= 0 && (int) $oldtime->format('i') < 10) ? ':0' . (int) $oldtime->format('i') : ':' . (int) $oldtime->format('i');

		//Funktion für normal date php ohne irgendwelche prüfung
		if ($this->config['cf_cpt_option'] == 'opt_1')
		{
			$date_rule	= date('Y-m-d');
		}
		else if ($this->config['cf_cpt_option'] == 'opt_2')
		{
			date_default_timezone_set($this->user->data['user_timezone']);
			$timestamp = time();
			$format = 'Y-m-d';
			$date_rule	= date($format, $timestamp);

		}
		else if ($this->config['cf_cpt_option'] == 'opt_3')
		{
			date_default_timezone_set($this->config['board_timezone']);
			$timestamp = time();
			$format = 'Y-m-d';
			$date_rule	= date($format, $timestamp);
		}
		else if ($this->config['cf_cpt_option'] == 'opt_4')
		{
			$year1			= date('Y');
			$month1			= date('m');
			$day1			= date('d') +1;

			$date_rule	= $year1 . '-' . $month1 . '-' . $day1;
		}
		else if ($this->config['cf_cpt_option'] == 'opt_5')
		{
			$date_rule	= '';
		}

		$mcp_post_template_data = array_merge($mcp_post_template_data, [
			'S_CF_CAN_CHGPOSTTIME'		=> $this->auth->acl_get('m_cf_chgposttime', $post_info['forum_id']),
			'CF_DATE_RULE'				=> $date_rule,
			'CF_DATE'					=> $year . $month . $day,
			'CF_TIME'					=> $hour . $minute,
		]);

		$event['mcp_post_template_data']	= $mcp_post_template_data;
		$event['s_additional_opts']			= true;
	}
}
