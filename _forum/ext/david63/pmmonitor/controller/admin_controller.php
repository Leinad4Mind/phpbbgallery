<?php
/**
*
* @package PM Monitor Extension
* @copyright (c) 2015 david63
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace david63\pmmonitor\controller;

use Symfony\Component\DependencyInjection\ContainerInterface;
use david63\pmmonitor\ext;

/**
* Admin controller
*/
class admin_controller implements admin_interface
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\pagination */
	protected $pagination;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var string phpBB root path */
	protected $root_path;

	/** @var string PHP extension */
	protected $phpEx;

	/** @var phpbb\language\language */
	protected $language;

	/** @var \phpbb\log\log */
	protected $log;

	/** @var string Custom form action */
	protected $u_action;

	/**
	* Constructor for admin controller
	*
	* @param \phpbb\config\config				$config		Config object
	* @param \phpbb\db\driver\driver_interface	$db
	* @param \phpbb\request\request				$request	Request object
	* @param \phpbb\template\template			$template	Template object
	* @param \phpbb\pagination					$pagination
	* @param \phpbb\user						$user		User object
	* @param \phpbb\auth\auth 					$auth
	* @param string 							$root_path
	* @param string 							$php_ext
	* @param phpbb\language\language			$language
	* @param \phpbb\log\log						$log
	*
	* @return \david63\pmmonitor\controller\admin_controller
	* @access public
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\pagination $pagination, \phpbb\user $user, \phpbb\auth\auth $auth, $root_path, $php_ext, \phpbb\language\language $language, \phpbb\log\log $log)
	{
		$this->config			= $config;
		$this->db  				= $db;
		$this->request			= $request;
		$this->template			= $template;
		$this->pagination		= $pagination;
		$this->user				= $user;
		$this->auth				= $auth;
		$this->phpbb_root_path	= $root_path;
		$this->phpEx			= $php_ext;
		$this->language			= $language;
		$this->log				= $log;
	}

	/**
	* Display the output for this extension
	*
	* @return null
	* @access public
	*/
	public function display_output()
	{
		// Add the language file
		$this->language->add_lang('acp_pmmonitor', 'david63/pmmonitor');

		// Check that the user has permission to access here
		if (!$this->auth->acl_get('a_comms_pm_manage'))
		{
			trigger_error('NOT_AUTHORISED', E_USER_WARNING);
		}

		// Get message count
		$sql = 'SELECT COUNT(msg_id) AS total_msg
			FROM ' . PRIVMSGS_TO_TABLE;
		$result = $this->db->sql_query($sql);

		$total_msg = (int) $this->db->sql_fetchfield('total_msg');
		$this->db->sql_freeresult($result);

		// If no data then no point going any further
		if ($total_msg == 0)
		{
			trigger_error($this->language->lang('NO_PM_DATA'));
		}

		// Start initial var setup
		$start			= $this->request->variable('start', 0);
		$sort_key		= $this->request->variable('sk', 'd');
		$sd = $sort_dir	= $this->request->variable('sd', 'd');

		if ($this->request->is_set_post('delete'))
		{
			$pm_monitor_list = $this->request->variable('mark', array(''));

			if (!sizeof($pm_monitor_list))
			{
				trigger_error($this->language->lang('NO_PM_SELECTED') . adm_back_link($this->u_action));
			}

			if (confirm_box(true))
			{
				// Restore the array to its correct format
				$pm_monitor_list = str_replace("'", '"', $pm_monitor_list);

				foreach ($pm_monitor_list as $pm_msg_list)
				{
					$pm_list[] = json_decode($pm_msg_list);
				}

				if (!function_exists('delete_pm'))
				{
					include($this->phpbb_root_path . 'includes/functions_privmsgs.' . $this->phpEx);
				}

				foreach ($pm_list as $row)
				{
					delete_pm($row['user_id'], $row['msg_ids'], $row['folder_id']);
				}

				// Add option settings change action to the admin log
				$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_PM_MONITOR');
			}
			else
			{
				confirm_box(false, $this->language->lang('CONFIRM_DELETE'), build_hidden_fields(array(
					'mark'		=> $pm_monitor_list,
					'delete'	=> 'delete'))
				);
			}
		}

		$sort_dir = ($sort_dir == 'd') ? ' DESC' : ' ASC';

		switch ($sort_key)
		{
			case 'b':
				$order_by = 'u.username_clean' . $sort_dir;
				$order_sql = ' AND t.user_id = u.user_id ';
			break;

			case 'd':
				$order_by = 'p.message_time' . $sort_dir;
				$order_sql = ' AND t.user_id = u.user_id ';
			break;

			case 'f':
				$order_by = 'u.username_clean' . $sort_dir;
				$order_sql = ' AND t.author_id = u.user_id ';
			break;

			case 'i':
				$order_by = 'p.author_ip' . $sort_dir. ', u.username_clean ASC';
				$order_sql = ' AND t.user_id = u.user_id ';
			break;

			case 'p':
				$order_by = 't.folder_id' . $sort_dir. ', u.username_clean ASC';
				$order_sql = ' AND t.user_id = u.user_id ';
			break;

			case 't':
				$order_by = 'to_username' . $sort_dir;
				$order_sql = ' AND t.user_id = u.user_id ';
			break;
		}

		$pm_box_ary = array(
			PRIVMSGS_HOLD_BOX	=> $this->language->lang('PM_HOLDBOX'),
			PRIVMSGS_NO_BOX		=> $this->language->lang('PM_NOBOX'),
			PRIVMSGS_OUTBOX		=> $this->language->lang('PM_OUTBOX'),
			PRIVMSGS_SENTBOX	=> $this->language->lang('PM_SENTBOX'),
			PRIVMSGS_INBOX		=> $this->language->lang('PM_INBOX'),
		);

		$flags = (($this->config['auth_bbcode_pm']) ? OPTION_FLAG_BBCODE : 0) + (($this->config['auth_smilies_pm']) ? OPTION_FLAG_SMILIES : 0) + (($this->config['allow_post_links']) ? OPTION_FLAG_LINKS : 0);

		$sql = 'SELECT p.msg_id, p.message_subject, p.message_text, p.bbcode_uid, p.bbcode_bitfield, p.message_time, p.bcc_address, p.to_address, p.author_ip, t.user_id, t.author_id, t.folder_id, LOWER(u.username) AS to_username
			FROM ' . PRIVMSGS_TABLE . ' p, ' . PRIVMSGS_TO_TABLE . ' t, ' . USERS_TABLE . ' u
			WHERE p.msg_id = t.msg_id ' .
				$order_sql . '
			ORDER BY ' . $order_by;

		$result = $this->db->sql_query_limit($sql, $this->config['topics_per_page'], $start);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->template->assign_block_vars('pm_row', array(
				'AUTHOR_IP'				=> $row['author_ip'],
				'BCC'					=> ($row['bcc_address']) ? $this->get_msg_user_data($row['user_id'], $row['author_id']) : '',
				'DATE'					=> $this->user->format_date($row['message_time']),
				'FOLDER'				=> ($row['folder_id'] > PRIVMSGS_INBOX) ? $this->language->lang('PM_SAVED') : $pm_box_ary[$row['folder_id']],
				'FROM'					=> $this->get_msg_user_data($row['author_id']),
				'IS_GROUP'				=> (strstr($row['to_address'], 'g')) ? $this->language->lang('IS_GROUP') : '',
				'LAST_VISIT_FROM'		=> $this->get_last_visit($row['author_id']),
				'LAST_VISIT_TO'			=> ($row['to_address']) ? $this->get_last_visit($row['user_id'], $row['author_id']) : '',
				// Swapping ' for " is needed as request does not handle double quotes
				'PM_ID'					=> str_replace('"', "'", json_encode(array('msg_ids' => $row['msg_id'], 'user_id' => $row['user_id'], 'folder_id' => $row['folder_id']))),
				// Create a unique key for the js script
				'PM_KEY'				=> $row['msg_id'] . $row['user_id'],
				'PM_SUBJECT'			=> $row['message_subject'],
				'PM_TEXT'				=> generate_text_for_display($row['message_text'], $row['bbcode_uid'], $row['bbcode_bitfield'], $flags),
				'TO'					=> ($row['to_address']) ? $this->get_msg_user_data($row['user_id'], $row['author_id']) : '',
			));
		}

		$this->db->sql_freeresult($result);

		$sort_by_text = array('f' => $this->language->lang('SORT_FROM'), 't' => $this->language->lang('SORT_TO'), 'b' => $this->language->lang('SORT_BCC'), 'p' => $this->language->lang('SORT_PM_BOX'), 'i' => $this->language->lang('SORT_IP'), 'd' => $this->language->lang('SORT_DATE'));
		$limit_days = array();
		$s_sort_key = $s_limit_days = $s_sort_dir = $u_sort_param = '';
		gen_sort_selects($limit_days, $sort_by_text, $sort_days, $sort_key, $sd, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param);

		$action = $this->u_action . '&amp;sk=' . $sort_key . '&amp;sd=' . $sd;

		$this->pagination->generate_template_pagination($action, 'pagination', 'start', $total_msg, $this->config['topics_per_page'], $start);

		$this->template->assign_vars(array(
			'MESSAGE_COUNT'			=> $total_msg,
			'PM_MONITOR_VERSION'	=> ext::PM_MONITOR_VERSION,
			'S_CAN_READ'			=> ($this->auth->acl_get('a_comms_pm_manage')) ? true : false,
			'S_SORT_KEY'			=> $s_sort_key,
			'S_SORT_DIR'			=> $s_sort_dir,
			'U_ACTION'				=> $this->u_action . '&amp;action=delete',
		));
	}

	protected function get_msg_user_data($msg_user, $author = 0)
	{
		if ($msg_user == $author)
		{
			$user_info = '';
		}
		else
		{
			$sql = 'SELECT username, user_colour
				FROM ' . USERS_TABLE . '
				WHERE ' . $this->db->sql_in_set('user_id', $msg_user);

			$result	= $this->db->sql_query($sql);
			$row	= $this->db->sql_fetchrow($result);

			$user_info = get_username_string('full',(int) $msg_user, $row['username'], $row['user_colour']);
		}

		return $user_info;
	}

	protected function get_last_visit($user_id, $author = 0)
	{
		if ($user_id == $author)
		{
			$last_visit = '';
		}
		else
		{
			$sql = 'SELECT session_user_id, MAX(session_time) AS session_time
				FROM ' . SESSIONS_TABLE . '
				WHERE session_time >= ' . (time() - $this->config['session_length']) . '
					AND ' . $this->db->sql_in_set('session_user_id', $user_id) . '
				GROUP BY session_user_id';
			$result = $this->db->sql_query($sql);

			$session_times = array();
			while ($row = $this->db->sql_fetchrow($result))
			{
				$session_times[$row['session_user_id']] = $row['session_time'];
			}

			$this->db->sql_freeresult($result);

			$sql = 'SELECT user_lastvisit
				FROM ' . USERS_TABLE . '
				WHERE ' . $this->db->sql_in_set('user_id', $user_id);
			$result = $this->db->sql_query($sql);

			while ($row = $this->db->sql_fetchrow($result))
			{
				$session_time	= (!empty($session_times[$user_id])) ? $session_times[$user_id] : 0;
				$last_visit		= (!empty($session_time)) ? $session_time : $row['user_lastvisit'];
				$last_visit		= $this->user->format_date($last_visit);
			}

			$this->db->sql_freeresult($result);
   		}

		return $last_visit;
	}

	/**
	* Set page url
	*
	* @param string $u_action Custom form action
	* @return null
	* @access public
	*/
	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}
}
