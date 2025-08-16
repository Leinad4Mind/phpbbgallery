<?php

/**
*
* @package Double Account Preventer
* @copyright (c) 2014 www.phpbb-work.ru
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace shredder\dap\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var \shredder\dap\core */
	protected $core;

	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\config\db_text */
	protected $config_text;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\log\log phpBB log*/
	protected $log;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\user */
	protected $user;

	/** @var string */
	protected $phpbb_root_path;
	protected $php_ext;

	public function __construct(\shredder\dap\core $core, \phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\config\db_text $config_text, \phpbb\db\driver\driver_interface $db, \phpbb\log\log $log, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\user $user, $root_path, $php_ext)
	{
		$this->core = $core;
		$this->auth = $auth;
		$this->config = $config;
		$this->config_text = $config_text;
		$this->db = $db;
		$this->log = $log;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;

		include_once($this->root_path . 'ext/shredder/dap/includes/constants.' . $this->php_ext);
	}

	/**
	* Assign functions defined in this class to event listeners in the core
	*
	* @return array
	* @static
	* @access public
	*/
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'				=> 'track_user_session',
			'core.login_box_redirect'			=> 'track_founder_login',
			'core.ucp_delete_cookies'			=> 'save_dap_cookies',
			'core.add_log'					=> 'add_dap_log',
			'core.get_logs_modify_type'			=> 'view_dap_log',
			'core.user_add_modify_data'			=> 'user_add_before',
			'core.user_add_after'				=> 'user_add_after',
			'core.delete_user_before'			=> 'delete_dap_log_exclusions',
			'core.session_set_custom_ban'			=> 'set_dap_ban',
			'core.page_footer_after'			=> 'seo_return',
		);
	}

	/**
	* Load language files during user setup
	*
	* Check user session and remove if user is banned
	* We need to set banned cookie here so we can't just delete user sessions from ACP as in standard ban
	*/
	public function track_user_session($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'shredder/dap',
			'lang_set' => 'info_acp_dap',
		);
		$event['lang_set_ext'] = $lang_set_ext;

		if (defined('IN_CHECK_DAP') || $this->user->data['user_id'] == ANONYMOUS)
		{
			return;
		}

		if (!$this->request->is_set($this->config['cookie_name'] . '_ck', \phpbb\request\request_interface::COOKIE))
		{
			$this->user->set_cookie('ck', $this->user->data['user_id'] . '|' . base64_encode($this->user->data['username']), time() + 518400000);
		}

		$user_bc = (isset($this->user->data['user_banned_cookie'])) ? $this->user->data['user_banned_cookie'] : 0;

		if ($this->user->data['user_type'] < USER_IGNORE && $this->config['dap_cookie_ban'] && $user_bc != 3)
		{
			$banned_cookie = $this->request->variable($this->config['cookie_name'] . '_bc', '', false, \phpbb\request\request_interface::COOKIE);

			if (!empty($user_bc) && (!isset($banned_cookie) || $banned_cookie != $user_bc))
			{
				$this->user->set_cookie('bc', $user_bc, time() + 518400000);
			}

			if ($this->config['dap_cookie_autoban'] && empty($user_bc) && isset($banned_cookie) && $banned_cookie == 1)
			{
				$this->core->cookie_ban_user($this->user->data['user_id'], true);
				$this->log->add('mod', $this->user->data['user_id'], $this->user->ip, 'LOG_COOKIE_AUTOBAN', time(), array($this->user->data['username']));
				$this->log->add('user', $this->user->data['user_id'], $this->user->ip, 'LOG_COOKIE_AUTOBAN', time(), array('reportee_id' => $this->user->data['user_id'], $this->user->data['username']));
			}

			if ($user_bc == 1 || (isset($banned_cookie) && $banned_cookie == 1 && $user_bc != 2))
			{
				$this->user->session_kill();

				$this->auth->acl($this->user->data);
				$event['user_data'] = $this->user->data;
				$event['user_date_format'] = $this->config['default_dateformat'];
				$event['user_timezone'] = $this->config['board_timezone'];
			}
		}
	}

	/**
	* Check founders data on login to UCP or ACP
	*/
	public function track_founder_login($event)
	{
		if ($this->user->data['user_type'] == USER_FOUNDER)
		{
			$this->core->cookie_tracking(false, defined('ADMIN_START'));
		}
	}

	/**
	* Adding Dap Logs
	*/
	public function add_dap_log($event)
	{
		if ($event['mode'] == 'dap')
		{
			$event['sql_ary'] += array(
				'log_type'		=> LOG_DAP,
				'log_data'		=> (!empty($event['additional_data'])) ? serialize($event['additional_data']) : '',
			);
		}
	}

	/**
	* Viewing Dap Logs
	*/
	public function view_dap_log($event)
	{
		if ($event['mode'] == 'dap')
		{
			$event['log_type'] = LOG_DAP;
		}
	}

	/**
	* Save Dap Cookies from deletion
	*/
	public function save_dap_cookies($event)
	{
		if ($event['cookie_name'] === 'ck' || $event['cookie_name'] === 'bc')
		{
			$event['retain_cookie'] = true;
		}
	}

	/**
	* Delete DAP log's exclusions
	*/
	public function delete_dap_log_exclusions($event)
	{
		$user_ids = $event['user_ids'];

		$excludes_ary = ($this->config_text->get('dap_log_excludes')) ? explode(',', $this->config_text->get('dap_log_excludes')) : array();

		$del = array();
		foreach ($excludes_ary as $part)
		{
			$pair = explode(':', $part);

			if (sizeof(array_intersect($pair, $user_ids)))
			{
				$del[] = $part;
			}
		}

		if (sizeof($del))
		{
			$this->config_text->set('dap_log_excludes', implode(',', array_diff($excludes_ary, $del)));
		}
	}

	/**
	* Checks before user is registered (added to DB)
	*/
	public function user_add_before($event)
	{
		$user_row = $event['user_row'];
		$sql_ary = $event['sql_ary'];

		$user_row += array(
			'ip_common_names'		=> '',
			'c_common_names'		=> '',
		);

		$sql_ary += array(
			'ip_common_names'		=> '',
			'c_common_names'		=> '',
		);

		if (!defined('ADMIN_START'))
		{
			$banned_cookie = $this->request->variable($this->config['cookie_name'] . '_bc', '', false, \phpbb\request\request_interface::COOKIE);

			if ($this->config['dap_cookie_ban'] && $this->config['dap_cookie_reg_deny'] && isset($banned_cookie) && $banned_cookie == 1)
			{
				$contact_link = phpbb_get_board_contact_link($this->config, $this->root_path, $this->php_ext);
				$deny_text = ($this->config['dap_reg_deny_message']) ? $this->config['dap_reg_deny_message'] : $this->user->lang['DAP_COOKIE_DENY_REGISTER_TEXT'];
				$message = '<em>' . $deny_text . '</em><br /><br />' . sprintf($this->user->lang['DAP_CONTACT_ADMIN_MESSAGE'], '', '<a href="' . $contact_link . '">', '</a>');
				trigger_error($message);
			}

			if ($this->config['dap_cookie_check'])
			{
				$c_double_account = $this->core->cookie_check();

				if (sizeof($c_double_account))
				{
					$user_row = array_merge($user_row, $c_double_account);
					$sql_ary = array_merge($sql_ary, $c_double_account);
				}
			}

			if ($this->config['dap_ip_check'] >= 1)
			{
				$ip_double_account = $this->core->duplicate_ip_check();

				if (sizeof($ip_double_account))
				{
					$user_row = array_merge($user_row, $ip_double_account);
					$sql_ary = array_merge($sql_ary, $ip_double_account);
				}
			}
		}

		$event['user_row'] = $user_row;
		$event['sql_ary'] = $sql_ary;
	}

	/**
	* Actions after user is registered
	*/
	public function user_add_after($event)
	{
		$user_id = $event['user_id'];
		$user_row = $event['user_row'];

		if ($user_id === false || defined('ADMIN_START'))
		{
			return;
		}

		if (!$this->request->is_set($this->config['cookie_name'] . '_ck', \phpbb\request\request_interface::COOKIE))
		{
			$this->user->set_cookie('ck', $user_id . '|' . base64_encode($user_row['username']), time() + 518400000);
		}

		if ($user_row['ip_common_names'] || $user_row['c_common_names'])
		{
			$ip_common_names = $this->core->replace_ip_names($user_row['ip_common_names']);
			$c_common_names = $this->core->replace_cookie_names($user_row['c_common_names']);

			if ($this->config['dap_email_notification'])
			{
				$this->core->notify_admin_dupe_ips($user_row['username'], $user_row['user_email'], $user_row['user_regdate'], $user_row['ip_common_names'], $user_row['c_common_names']);
			}

			if ($this->config['dap_pm_notification'])
			{
				$this->core->send_dap_pm($user_id, $user_row['username'], $user_row['user_email'], $user_row['user_regdate'], $ip_common_names, $c_common_names);
			}

			if ($this->config['dap_user_notes_entry'])
			{
				if (!empty($user_row['ip_common_names']))
				{
					$this->log->add('user', $user_id, $this->user->ip, 'LOG_USER_NOTE_IP', time(), array('reportee_id' => $user_id, $this->core->replace_ip_names($user_row['ip_common_names'], true)));
				}

				if (!empty($user_row['c_common_names']))
				{
					$this->log->add('user', $user_id, $this->user->ip, 'LOG_USER_NOTE_COOKIE', time(), array('reportee_id' => $user_id, $this->core->replace_cookie_names($user_row['c_common_names'], true)));
				}
			}

			if (!empty($this->config['dap_post_forum_id']))
			{
				$this->core->submit_dap_post($user_id, $user_row['username'], $user_row['user_email'], $user_row['user_regdate'], $ip_common_names, $c_common_names);
			}
		}

		$banned_cookie = $this->request->variable($this->config['cookie_name'] . '_bc', '', false, \phpbb\request\request_interface::COOKIE);

		if ($this->config['dap_cookie_ban'] && $this->config['dap_cookie_autoban'] && isset($banned_cookie) && $banned_cookie == 1)
		{
			$this->core->cookie_ban_user($user_id, true);

			$this->log->add('mod', $user_id, $this->user->ip, 'LOG_COOKIE_AUTOBAN', time(), array($user_row['username']));
			$this->log->add('user', $user_id, $this->user->ip, 'LOG_COOKIE_AUTOBAN', time(), array('reportee_id' => $user_id, $user_row['username']));
		}
	}

	/**
	* Check and block user if he banned by DAP
	*/
	public function set_dap_ban($event)
	{
		if ($this->user->data['user_id'] == ANONYMOUS || $event['return'])
		{
			return;
		}

		$banned = $event['banned'];
		$dap_ban = $this->core->cookie_tracking($banned, defined('ADMIN_START'));

		if ($dap_ban)
		{
			$banned = true;
			$ban_triggered_by = 'dap';

			$ban_row = array(
				'ban_end'		=> 0,
				'ban_give_reason'	=> ($this->config['dap_cookie_ban_message']) ? $this->config['dap_cookie_ban_message'] : $this->user->lang['DAP_COOKIE_BAN_MESSAGE_TEXT'],
			);

			$event['ban_triggered_by'] = $ban_triggered_by;
			$event['ban_row'] = $ban_row;
		}

		$event['banned'] = $banned;
	}

	public function seo_return($event)
	{
		return;

		if (!defined('PHPBB_WORK_INFO'))
		{
			$this->template->assign_vars(array(
				'PHPBB_WORK_DAP'	=> ($this->config['default_lang'] == 'ru') ? true : false,
			));

			define('PHPBB_WORK_INFO', 1);
		}
	}
}
