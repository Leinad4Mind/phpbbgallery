<?php

/**
*
* @package Double Account Preventer
* @copyright (c) 2014 www.phpbb-work.ru
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace shredder\dap;

class core
{
	/**
	* Constructor
	* NOTE: The parameters of this method must match in order and type with
	* the dependencies defined in the services.yml file for this service.
	*

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

	/** @var \phpbb\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var string */
	protected $phpbb_root_path;
	protected $php_ext;

	public function __construct(\phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\config\db_text $config_text, \phpbb\db\driver\driver_interface $db, \phpbb\log\log $log, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\user $user, $root_path, $php_ext)
	{
		$this->auth = $auth;
		$this->config = $config;
		$this->config_text = $config_text;
		$this->db = $db;
		$this->log = $log;
		$this->request = $request;
		$this->user = $user;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;

		include_once($this->root_path . 'ext/shredder/dap/includes/constants.' . $this->php_ext);
	}

	// Check for the DAP cookie
	public function cookie_check()
	{
		$double_account = array();

		if ($this->request->is_set($this->config['cookie_name'] . '_ck', \phpbb\request\request_interface::COOKIE))
		{
			$cookiedata = $this->request->variable($this->config['cookie_name'] . '_ck', '', true, \phpbb\request\request_interface::COOKIE);
			$user_inactive = '';

			if ($this->config['dap_ignore_inactive'])
			{
				$c_userdata = (!empty($cookiedata)) ? explode('|', $cookiedata) : '';
				$cookie_id = isset($c_userdata[0]) ? $c_userdata[0] : '';

				$sql = 'SELECT user_id FROM ' . USERS_TABLE . '
					WHERE user_id = ' . (int) $cookie_id . '
						AND user_type = ' . USER_INACTIVE;
				$result = $this->db->sql_query($sql);
				$user_inactive = $this->db->sql_fetchfield('user_id');
				$this->db->sql_freeresult($result);
			}

			if (empty($user_inactive))
			{
				$double_account = array(
					'user_double'			=> true,
					'c_common_names'		=> $cookiedata,
				);
			}
		}

		return $double_account;
	}

	// Ban user by cookie
	public function cookie_ban_user($user_id, $ban)
	{
		$and_sql = ($ban) ? 'AND user_type < ' . USER_IGNORE : '';

		$sql = 'UPDATE ' . USERS_TABLE . '
			SET user_banned_cookie = ' . (int) $ban . '
			WHERE user_id = ' . (int) $user_id . "
				$and_sql";
		$this->db->sql_query($sql);
	}

	// Check for cookie bans and log entries handle
	public function cookie_tracking($banned = false, $admin = false)
	{
		define('IN_CHECK_DAP', true);

		$dap_ban = false;

		$id = $this->user->data['user_id'];
		$name = $this->user->data['username'];

		if ($this->user->data['user_type'] != USER_FOUNDER)
		{
			$banned_cookie = $this->request->variable($this->config['cookie_name'] . '_bc', '', false, \phpbb\request\request_interface::COOKIE);
		}

		$user_bc = ($this->user->data['user_type'] != USER_FOUNDER) ? $this->user->data['user_banned_cookie'] : 0;

		$cookiedata = $this->request->variable($this->config['cookie_name'] . '_ck', '', true, \phpbb\request\request_interface::COOKIE);
		$c_userdata = (!empty($cookiedata)) ? explode('|', $cookiedata) : '';
		$cookie_id = isset($c_userdata[0]) ? $c_userdata[0] : '';
		$cookie_name = isset($c_userdata[1]) ? base64_decode($c_userdata[1]) : '';
		$userdata = $cookie_id . '|' . $cookie_name;

		if (!empty($cookie_id))
		{
			$sql = 'SELECT user_id, user_type
				FROM ' . USERS_TABLE . '
				WHERE user_id = ' . (int) $cookie_id;
			$result = $this->db->sql_query($sql);
			$row = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			if ($this->config['dap_ignore_inactive'] && isset($row['user_id']))
			{
				$cookie_id = ($row['user_type'] != USER_INACTIVE) ? $cookie_id : $id;
			}
		}

		if (!$this->request->is_set($this->config['cookie_name'] . '_ck', \phpbb\request\request_interface::COOKIE) || !isset($row['user_id']))
		{
			$this->user->set_cookie('ck', $id . '|' . base64_encode($name), time() + 518400000);
		}

		$new_session = (empty($this->user->data['session_id']) || $this->user->data['user_type'] == USER_FOUNDER) ? true : false;

		if ($this->user->data['user_type'] < USER_IGNORE && $this->config['dap_cookie_ban'] && $user_bc != 3)
		{
			if (!empty($user_bc) && (!isset($banned_cookie) || $banned_cookie != $user_bc))
			{
				$this->user->set_cookie('bc', $user_bc, time() + 518400000);
			}

			if ($this->config['dap_cookie_autoban'] && empty($user_bc) && isset($banned_cookie) && $banned_cookie == 1)
			{
				$this->cookie_ban_user($id, true);
				$this->log->add('mod', $id, $this->user->ip, 'LOG_COOKIE_AUTOBAN', time(), array($name));
				$this->log->add('user', $id, $this->user->ip, 'LOG_COOKIE_AUTOBAN', time(), array('reportee_id' => $id, $name));
			}

			if ($user_bc == 1 || (isset($banned_cookie) && $banned_cookie == 1 && $user_bc != 2))
			{
				$dap_ban = true;
			}
		}

		$excludes_ary = ($this->config_text->get('dap_log_excludes')) ? explode(',', $this->config_text->get('dap_log_excludes')) : array();
		$excluded = sizeof(array_intersect(array($id . ':' . $cookie_id, $cookie_id . ':' . $id), $excludes_ary)) ? 1 : 0;

		if ($this->config['dap_cookie_check'] && $new_session && $this->request->is_set($this->config['cookie_name'] . '_ck', \phpbb\request\request_interface::COOKIE) && $id != $cookie_id && !$excluded)
		{
			if ($this->config['dap_cookie_ban'] && isset($banned_cookie) && $banned_cookie == 1 && $user_bc < 2)
			{
				$this->log->add('dap', $id, $this->user->ip, 'LOG_COOKIE_BLOCK', time(), array($userdata));
			}
			else if ($this->config['dap_cookie_ban'] && $user_bc == 1)
			{
				$this->log->add('dap', $id, $this->user->ip, 'LOG_BLACKLIST_BLOCK', time(), array($userdata));
			}
			else if ($banned)
			{
				$this->log->add('dap', $id, $this->user->ip, 'LOG_STANDARD_BLOCK', time(), array($userdata));
			}
			else if ($admin)
			{
				$this->log->add('dap', $id, $this->user->ip, 'LOG_LOGIN_WITH_DATA_ACP', time(), array($userdata));
			}
			else
			{
				$this->log->add('dap', $id, $this->user->ip, 'LOG_LOGIN_WITH_DATA', time(), array($userdata));
			}

			if ($this->config['dap_user_notes_entry'])
			{
				$found = false;

				$sql = 'SELECT log_data
					FROM ' . LOG_TABLE . '
					WHERE log_type = ' . LOG_USERS . "
						AND user_id = $id
						AND log_operation = 'LOG_USER_NOTE_AUTH'";
				$result = $this->db->sql_query($sql);

				while ($row = $this->db->sql_fetchrow($result))
				{
					if (strpos($row['log_data'], $cookie_name) !== false)
					{
						$found = true;
					}
				}

				if (!$found)
				{
					$this->log->add('user', $id, $this->user->ip, 'LOG_USER_NOTE_AUTH', time(), array('reportee_id' => $id, $cookie_name));
				}
			}
		}

		unset($excludes_ary);

		return $dap_ban;
	}

	// Replace ip-duplicates with real accounts
	public function replace_ip_names($ip_common_names, $mail = false)
	{
		if (!empty($ip_common_names))
		{
			$ip_common_set = explode('|', $ip_common_names);
			$ip_ids_set = (isset($ip_common_set[0])) ? explode(',', $ip_common_set[0]) : '';
			$ip_names_set = (isset($ip_common_set[1])) ? explode(',', $ip_common_set[1]) : '';

			if (!empty($ip_ids_set) && !empty($ip_names_set))
			{
				for ($i = 0; $i < sizeof($ip_ids_set); $i++)
				{
					if ($mail)
					{
						$ip_names_array[] = htmlspecialchars_decode(base64_decode($ip_names_set[$i]));
					}
					else
					{
						$ip_names_array[] = '[url=' . generate_board_url() . '/memberlist.' . $this->php_ext . '?mode=viewprofile&amp;u=' . $ip_ids_set[$i] . ']' . base64_decode($ip_names_set[$i]) . '[/url]';
					}
				}

				sort($ip_names_array);
				$ip_common_names = implode(', ', $ip_names_array);
				unset($ip_names_array);
			}
		}

		return $ip_common_names;
	}

	// Replace cookie-duplicates with real accounts
	public function replace_cookie_names($c_common_names, $mail = false)
	{
		if (!empty($c_common_names))
		{
			$c_item = explode('|', $c_common_names);
			$c_item[0] = (isset($c_item[0])) ? $c_item[0] : '';
			$c_item[1] = (isset($c_item[1])) ? base64_decode($c_item[1]) : '';

			if (!$mail && !empty($c_item[0]))
			{
				$c_sql = 'SELECT user_id
					FROM ' . USERS_TABLE . '
					WHERE user_id = ' . (int) $c_item[0];
				$c_result = $this->db->sql_query($c_sql);
				$c_id = $this->db->sql_fetchfield('user_id');
				$this->db->sql_freeresult($c_result);
			}

			if ($mail)
			{
				$c_common_names = htmlspecialchars_decode($c_item[1]);
			}
			else
			{
				$c_common_names = (isset($c_id) && $c_id && !empty($c_item[0])) ? '[url=' . generate_board_url() . '/memberlist.' . $this->php_ext . '?mode=viewprofile&amp;u=' . $c_item[0] . ']' . $c_item[1] . '[/url]' : $c_item[1];
			}
		}

		return $c_common_names;
	}

	// Replace shortcodes for the PMs and posts
	public function replace_strings(&$string, $user_id, $data_username, $data_email, $user_regdate, $ip_common_names, $c_common_names)
	{
		$string = str_replace('[sitename]', $this->config['sitename'], $string);
		$string = str_replace('[username]', $data_username, $string);
		$string = str_replace('[user_ip]', $this->user->ip, $string);
		$string = str_replace('[user_email]', $data_email, $string);
		$string = str_replace('[user_regdate]', $this->user->format_date($user_regdate, false, true), $string);
		$string = str_replace('[ip_common_names]', $ip_common_names, $string);
		$string = str_replace('[c_common_names]', $c_common_names, $string);

		return;
	}

	// Send a PM to all users with a_user permission
	public function send_dap_pm($user_id, $data_username, $data_email, $user_regdate, $ip_common_names, $c_common_names)
	{
		include($this->root_path . 'includes/functions_privmsgs.' . $this->php_ext);

		// Grab an array of user_id's with a_user permissions to send a PM to
		$admin_ary = $this->auth->acl_get_list(false, 'a_user', false);
		$admin_ary = (!empty($admin_ary[0]['a_user'])) ? $admin_ary[0]['a_user'] : array();

		if (sizeof($admin_ary))
		{
			$where_sql = 'WHERE ' . $this->db->sql_in_set('user_id', $admin_ary);
		}
		else
		{
			$where_sql = 'WHERE user_type = ' . USER_FOUNDER; // There are no admins, so select a founder
		}

		$sql = 'SELECT user_id, username, user_email, user_lang, user_jabber, user_notify_type
			FROM ' . USERS_TABLE . ' ' .
			$where_sql;
		$result = $this->db->sql_query($sql);

		// Loop through our results
		while ($row = $this->db->sql_fetchrow($result))
		{
			$contact_users[] = $row;
		}
		$this->db->sql_freeresult($result);

		// Get the subject and message
		$message = $this->user->lang['DAP_NOTIFICATION_MESSAGE'];
		$subject = $this->user->lang['DAP_NOTIFICATION_SUBJECT'];

		$username_full = '[url=' . generate_board_url() . '/memberlist.' . $this->php_ext . '?mode=viewprofile&amp;u=' . $user_id . ']' . $data_username . '[/url]';

		// Replace the shortcodes
		$this->replace_strings($message, $user_id, $username_full, $data_email, $user_regdate, $ip_common_names, $c_common_names);
		$this->replace_strings($subject, $user_id, $data_username, $data_email, $user_regdate, $ip_common_names, $c_common_names);

		$sql = 'SELECT username, user_ip
			FROM ' . USERS_TABLE . '
			WHERE user_id = ' . (int) $this->config['dap_alert_user_id'];
		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$alert_user_ip = $row['user_ip'];
			$alert_username = $row['username'];
		}
		$this->db->sql_freeresult($result);

		$uid = $bitfield = $options = ''; 

		generate_text_for_storage($message, $uid, $bitfield, $options, true, true, true);

		// Set the PM data
		$pm_data = array(
			'from_user_id'		=> $this->config['dap_alert_user_id'],
			'from_user_ip'		=> $alert_user_ip,
			'from_username'		=> $alert_username,
			'enable_sig'		=> false,
			'enable_bbcode'		=> true,
			'enable_smilies'	=> true,
			'enable_urls'		=> false,
			'icon_id'			=> 0,
			'bbcode_bitfield'	=> $bitfield,
			'bbcode_uid'		=> $uid,
			'message'			=> $message,
		);

		// Loop through our list of users
		for ($i = 0, $size = sizeof($contact_users); $i < $size; $i++)
		{
			$pm_data['address_list'] = array('u' => array($contact_users[$i]['user_id'] => 'to'));

			submit_pm('post', $subject, $pm_data, true);

			unset($contact_users[$i]);
		}
	}

	// Post in the specified forums
	public function submit_dap_post($user_id, $data_username, $data_email, $user_regdate, $ip_common_names, $c_common_names)
	{
		include($this->root_path . 'includes/functions_posting.' . $this->php_ext);

		// Get the subject and message
		// Also get the forums to post in
		$message = $this->user->lang['DAP_NOTIFICATION_MESSAGE'];
		$subject = $this->user->lang['DAP_NOTIFICATION_SUBJECT'];
		$forums = $this->config['dap_post_forum_id'];
		$alert_user_id = $this->config['dap_alert_user_id'];

		$username_full = '[url=' . generate_board_url() . '/memberlist.' . $this->php_ext . '?mode=viewprofile&amp;u=' . $user_id . ']' . $data_username . '[/url]';

		// Replace the shortcodes
		$this->replace_strings($message, $user_id, $username_full, $data_email, $user_regdate, $ip_common_names, $c_common_names);
		$this->replace_strings($subject, $user_id, $data_username, $data_email, $user_regdate, $ip_common_names, $c_common_names);

		// Backup and replace the $this->user and $this->auth constants so an actual user can post, not just a guest with a username
		$backup = array(
			'user_data'	=> $this->user->data,
			'user_ip'	=> $this->user->ip,
			'auth'		=> $this->auth,
		);

		$sql = "SELECT *
			FROM " . USERS_TABLE . "
			WHERE user_id = '" . $alert_user_id . "'";
		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			// We have to overwrite some $this->user values to make the script post correctly
			$this->user->data = $row;
			$this->user->ip = '0.0.0.0';
			$this->auth->acl($this->user->data);
			$this->user->data['is_registered'] = false;

			// We set these so we don't have to use the overwritten values. It's just safer this way.
			$alert_user = array(
				'user_id'		=> (int) $alert_user_id,
				'user_ip'		=> '0.0.0.0',
				'username'		=> $row['username'],
			);
		}
		$this->db->sql_freeresult($result);

		$forums = explode(',', $forums);

		// variables to hold the parameters for submit_post
		$poll = $uid = $bitfield = $options = ''; 

		generate_text_for_storage($message, $uid, $bitfield, $options, true, true, true);

		// Set the post data
		$data = array( 
			'icon_id'			=> false,
			'enable_bbcode'		=> true,
			'enable_smilies'	=> true,
			'enable_urls'		=> true,
			'enable_sig'		=> true,
			'message'			=> $message,
			'message_md5'		=> md5($message),
			'bbcode_bitfield'	=> $bitfield,
			'bbcode_uid'		=> $uid,
			'post_edit_locked'	=> 0,
			'topic_title'		=> $subject,
			'notify_set'		=> false,
			'notify'			=> false,
			'post_time' 		=> 0,
			'forum_name'		=> '',
			'enable_indexing'	=> true,
			'topic_approved'	=> true,
			'post_approved'		=> true,
		);

		// Loop through and post in the correct forums
		foreach ($forums as $forum_id)
		{
			$data['forum_id'] = $forum_id;

			// Time to post
			submit_post('post', $subject, $alert_user['username'], POST_NORMAL, $poll, $data);
		}

		// Extract the backup to set the $this->user and $this->auth constants to what they were before
		$this->auth = $backup['auth'];
		$this->user->data = $backup['user_data'];
		$this->user->ip = $backup['user_ip'];
		unset($backup);
	}

	// Send email to all users with a_user permission
	public function notify_admin_dupe_ips($data_username, $data_email, $user_regdate, $ip_common_names, $c_common_names)
	{
		include_once($this->root_path . 'includes/functions_messenger.' . $this->php_ext);

		$messenger = new \messenger(false);

		// Codes below take from "Notify admin on registration MOD" by ameeck
		// Grab an array of user_id's with a_user permissions ... these users can activate a user
		$admin_ary = $this->auth->acl_get_list(false, 'a_user', false);
		$admin_ary = (!empty($admin_ary[0]['a_user'])) ? $admin_ary[0]['a_user'] : array();

		if (sizeof($admin_ary))
		{
			$where_sql = 'WHERE ' . $this->db->sql_in_set('user_id', $admin_ary);
		}
		else
		{
			$where_sql = 'WHERE user_type = ' . USER_FOUNDER; // There are no admins, so select a founder
		}

		$sql = 'SELECT user_id, username, user_email, user_lang, user_jabber, user_notify_type
			FROM ' . USERS_TABLE . ' ' .
			$where_sql;
		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$mail_template_path = $this->root_path . 'ext/shredder/dap/language/' . $row['user_lang'] . '/email/';

			$messenger->template('admin_notify_duplicates', $row['user_lang'], $mail_template_path);
			$messenger->to($row['user_email'], $row['username']);
			$messenger->im($row['user_jabber'], $row['username']);

			// Email headers
			$messenger->anti_abuse_headers($this->config, $this->user);

			$messenger->assign_vars(array(
				'USERNAME'				=> htmlspecialchars_decode($data_username),
				'USER_MAIL'				=> $data_email,
				'USER_IP'				=> $this->user->ip,
				'USER_REGDATE'			=> $this->user->format_date($user_regdate, false, true),
				'IP_COMMON_NAMES'		=> $this->replace_ip_names($ip_common_names, true),
				'COOKIE_COMMON_NAMES'	=> $this->replace_cookie_names($c_common_names, true),
			));

			$messenger->send($row['user_notify_type']);
		}
		$this->db->sql_freeresult($result);
	}

	/*
	* The following Duplicate IP check code was created by mtrs and ameeck
	* Huge thanks to both of them for allowing me to use their code for this mod
	*/
	public function duplicate_ip_check()
	{
		$double_account = array();

		if ($this->config['dap_ip_check'] == 2)
		{
			$sql_add = ' UNION ALL SELECT user_id AS total_id
				FROM ' . LOG_TABLE . '
				WHERE log_ip = "' . $this->db->sql_escape($this->user->ip) . '"
					AND user_id <> ' . ANONYMOUS . '
					UNION ALL
				SELECT poster_id AS total_id
				FROM ' . POSTS_TABLE . '
				WHERE poster_ip = "' . $this->db->sql_escape($this->user->ip) . '"
					AND poster_id <> ' . ANONYMOUS . '
					UNION ALL
				SELECT author_id AS total_id
				FROM ' . PRIVMSGS_TABLE . '
				WHERE author_ip = "' . $this->db->sql_escape($this->user->ip) . '"
					AND author_id <> ' . ANONYMOUS . '
					UNION ALL
				SELECT vote_user_id AS total_id
				FROM ' . POLL_VOTES_TABLE . '
				WHERE vote_user_ip = "' . $this->db->sql_escape($this->user->ip) . '"
					AND vote_user_id <> ' . ANONYMOUS;
		}
		else
		{
			$sql_add = '';
		}

		if ($this->config['dap_ip_check'] >= 1)
		{
			$sql = 'SELECT user_id AS total_id
				FROM ' . USERS_TABLE . '
				WHERE user_ip = "' . $this->db->sql_escape($this->user->ip) . '"
					AND user_type <> ' . USER_IGNORE . '
					UNION ALL
				SELECT session_user_id AS total_id
				FROM ' . SESSIONS_TABLE . '
				WHERE session_ip = "' . $this->db->sql_escape($this->user->ip) . '"
					AND session_user_id <> ' . ANONYMOUS . '
					UNION ALL
				SELECT user_id AS total_id
				FROM ' . SESSIONS_KEYS_TABLE . '
				WHERE last_ip = "' . $this->db->sql_escape($this->user->ip) . '"
					AND user_id <> ' . ANONYMOUS . $sql_add;
			$result = $this->db->sql_query($sql);

			while ($row = $this->db->sql_fetchrow($result))
			{
				$dupe_ips[] = $row['total_id'];
			}
			$this->db->sql_freeresult($result);
		}

		if (isset($dupe_ips))
		{
			$dupe_ips = array_unique($dupe_ips);

			if ($this->config['dap_ignore_inactive'])
			{
				$ignore_ips = array();

				$sql = 'SELECT user_id, user_type
					FROM ' . USERS_TABLE . '
					WHERE ' . $this->db->sql_in_set('user_id', $dupe_ips);
				$result = $this->db->sql_query($sql);

				while ($row = $this->db->sql_fetchrow($result))
				{
					$ignore_ips[] = ($row['user_type'] == USER_INACTIVE) ? $row['user_id'] : 0;
				}
				$this->db->sql_freeresult($result);

				$dupe_ips = array_diff($dupe_ips, $ignore_ips);

				unset($ignore_ips);
			}

			if (sizeof($dupe_ips))
			{
				// Get usernames list for notifications
				$sql = 'SELECT user_id, username
					FROM ' . USERS_TABLE . '
					WHERE ' . $this->db->sql_in_set('user_id', $dupe_ips);
				$result = $this->db->sql_query($sql);

				while ($row = $this->db->sql_fetchrow($result))
				{
					$ip_common_ids_array[] = $row['user_id'];
					$ip_common_names_array[] = base64_encode($row['username']);
				}
				$this->db->sql_freeresult($result);

				// Generate list of duplicate accounts
				$ip_common_ids = (isset($ip_common_ids_array)) ? implode(',', $ip_common_ids_array) : '';
				$ip_common_names = (isset($ip_common_names_array)) ? implode(',', $ip_common_names_array) : '';

				unset($dupe_ips, $ip_common_ids_array, $ip_common_names_array);

				// Assign array values for insertion into the users table
				$double_account = array(
					'user_double'			=> true,
					'ip_common_names'	=> $ip_common_ids . '|' . $ip_common_names,
				);
			}
		}

		return $double_account;
	}
}
