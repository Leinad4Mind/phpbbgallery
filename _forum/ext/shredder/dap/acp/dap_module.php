<?php

/**
*
* @package Double Account Preventer
* @copyright (c) 2014 www.phpbb-work.ru
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace shredder\dap\acp;

/**
* @package acp
*/
class dap_module
{
	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\config\config */
	protected $config;

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

	/** @var ContainerInterface */
	protected $phpbb_container;

	/** @var string */
	protected $phpbb_root_path;
	protected $php_ext;

	/** @var string */
	public $u_action;

	public function main($id, $mode)
	{
		global $auth, $config, $db, $phpbb_log, $request, $template, $user, $phpbb_container, $phpbb_root_path, $phpEx;

		$this->auth = $auth;
		$this->config = $config;
		$this->config_text = $phpbb_container->get('config_text');
		$this->db = $db;
		$this->log = $phpbb_log;
		$this->pagination = $phpbb_container->get('pagination');
		$this->core = $phpbb_container->get('shredder.dap.core');
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->root_path = $phpbb_root_path;
		$this->php_ext = $phpEx;

		include_once($this->root_path . 'ext/shredder/dap/includes/constants.' . $this->php_ext);

		$action = $this->request->variable('action', '');
		$form_key = 'acp_dap';
		add_form_key($form_key);

		switch ($mode)
		{
			case 'settings':

				$display_vars = array(
					'title'	=> 'ACP_DAP_SETTINGS',
					'vars'	=> array(
						'legend1'						=> 'ACP_DAP_SETTINGS',
						'dap_ip_check'				=> array('lang' => 'IP_CHECK_REGISTRATION', 'validate' => 'int', 'type' => 'custom', 'method' => 'select_ip_check_registration', 'explain' => true),
						'dap_cookie_check'			=> array('lang' => 'COOKIE_CHECK_REGISTRATION', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
						'dap_ignore_inactive'			=> array('lang' => 'DAP_IGNORE_INACTIVE', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
						'dap_quick_deletion'			=> array('lang' => 'DAP_QUICK_DELETION', 'validate' => 'int', 'type' => 'custom', 'method' => 'select_quick_deletion', 'explain' => true),
						'dap_users_per_page'					=> array('lang' => 'DAP_DUPLICATES_PER_PAGE', 'validate' => 'int:1', 'type' => 'text:10:10', 'explain' => true),

						'legend2'						=> 'ACP_DAP_COOKIE_BAN_SETTINGS',
						'dap_cookie_ban'			=> array('lang' => 'DAP_COOKIE_BAN_ENABLED', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
						'dap_cookie_autoban'			=> array('lang' => 'DAP_COOKIE_AUTOBAN_ENABLED', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
						'dap_cookie_ban_message'			=> array('lang' => 'DAP_COOKIE_BAN_MESSAGE', 'validate' => 'string', 'type' => 'text:40:255', 'explain' => true),
						'dap_cookie_reg_deny'			=> array('lang' => 'DAP_COOKIE_DENY_REGISTER', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
						'dap_reg_deny_message'			=> array('lang' => 'DAP_COOKIE_DENY_MESSAGE', 'validate' => 'string', 'type' => 'text:40:255', 'explain' => true),

						'legend3'						=> 'ACP_DAP_NOTIFICATIONS',
						'dap_post_forum_id'			=> array('lang' => 'DAP_POST_NOTIFICATION', 'validate' => 'string', 'type' => 'custom', 'method' => 'select_notify_forums', 'explain' => true),
						'dap_pm_notification'		=> array('lang' => 'DAP_PM_NOTIFICATION', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
						'dap_alert_user_id'					=> array('lang' => 'DAP_ALERT_USER_ID', 'validate' => 'int', 'type' => 'text:10:10', 'explain' => true),
						'dap_user_notes_entry'		=> array('lang' => 'DAP_USER_NOTES_ENTRY', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
						'dap_email_notification'		=> array('lang' => 'DAP_EMAIL_NOTIFICATION', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
					)
				);

				$this->template->assign_vars(array(
					'SETTINGS'		=> true,
				));

				$this->page_output($display_vars, $form_key);
			break;

			case 'dupe_user_list':

				$display_vars = array(
					'title' => 'ACP_DAP_DUPE_USER_LIST',
				);

				$this->template->assign_vars(array(
					'L_TITLE'			=> $this->user->lang[$display_vars['title']],
					'L_TITLE_EXPLAIN'	=> $this->user->lang[$display_vars['title'] . '_EXPLAIN'],

					'DUPE_USER_LIST'		=> true,
				));

				if ($this->request->is_set('ban'))
				{
					$ban = $this->request->variable('ban', 0);
					$start = $this->request->variable('start', 0);
					$user_id = $this->request->variable('u', 0);

					$sql = 'SELECT username, user_type, user_banned_cookie
						FROM ' . USERS_TABLE . '
						WHERE user_id = ' . (int) $user_id;
					$result = $this->db->sql_query($sql);
					$row = $this->db->sql_fetchrow($result);
					$this->db->sql_freeresult($result);

					if (!$this->auth->acl_get('a_ban'))
					{
						trigger_error($this->user->lang['ACP_DAP_NO_PERMISSIONS'] . adm_back_link($this->u_action . '&amp;start=' . $start), E_USER_WARNING);
					}
					else if ($user_id == ANONYMOUS && $ban)
					{
						trigger_error($this->user->lang['DAP_CANNOT_BAN_ANONYMOUS'] . adm_back_link($this->u_action . '&amp;start=' . $start), E_USER_WARNING);
					}
					else if ($user_id == $this->user->data['user_id'] && $ban)
					{
						trigger_error($this->user->lang['DAP_CANNOT_BAN_YOURSELF'] . adm_back_link($this->u_action . '&amp;start=' . $start), E_USER_WARNING);
					}
					else if ($row['user_type'] == USER_FOUNDER && $ban)
					{
						trigger_error($this->user->lang['DAP_CANNOT_BAN_FOUNDER'] . adm_back_link($this->u_action . '&amp;start=' . $start), E_USER_WARNING);
					}
					else if ($row['user_type'] == USER_IGNORE && $ban)
					{
						trigger_error($this->user->lang['DAP_CANNOT_BAN_BOT'] . adm_back_link($this->u_action . '&amp;start=' . $start), E_USER_WARNING);
					}
					else
					{
						if ($ban != $row['user_banned_cookie'])
						{
							$this->core->cookie_ban_user($user_id, $ban);
							$ban_status = $this->ban_status($ban);

							$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, $ban_status['log_entry'], time(), array($row['username']));
							$this->log->add('mod', $this->user->data['user_id'], $this->user->ip, $ban_status['log_entry'], time(), array($row['username']));
							$this->log->add('user', $this->user->data['user_id'], $this->user->ip, $ban_status['log_entry'], time(), array('reportee_id' => $user_id, $row['username']));
						}
					}
				}

				$this->list_dupe_users();
			break;

			case 'dupe_log':

				$display_vars = array(
					'title' => 'ACP_DAP_DUPE_LOG',
				);

				$this->template->assign_vars(array(
					'L_TITLE'			=> $this->user->lang[$display_vars['title']],
					'L_TITLE_EXPLAIN'	=> $this->user->lang[$display_vars['title'] . '_EXPLAIN'],

					'DUPE_LOG'		=> true,
				));

				$this->dupe_log();
			break;

			case 'dap_blacklist':

				$display_vars = array(
					'title' => 'ACP_DAP_BLACKLIST',
				);

				$this->template->assign_vars(array(
					'L_TITLE'			=> $this->user->lang[$display_vars['title']],
					'L_TITLE_EXPLAIN'	=> $this->user->lang[$display_vars['title'] . '_EXPLAIN'],

					'BLACKLIST'		=> true,
				));

				$this->cookie_blacklist();
			break;

			default:
				trigger_error('NO_MODE', E_USER_ERROR);
			break;
		}

		if ($action == 'whois')
		{
			include($this->root_path . 'includes/functions_user.' . $this->php_ext);

			$this->user->add_lang('acp/users');
			$this->page_title = 'WHOIS';
			$this->tpl_name = 'simple_body';

			$user_ip = $this->request->variable('user_ip', '');
			$domain = gethostbyaddr($user_ip);
			$ipwhois = user_ipwhois($user_ip);

			$this->template->assign_vars(array(
				'MESSAGE_TITLE'		=> sprintf($this->user->lang['IP_WHOIS_FOR'], $domain),
				'MESSAGE_TEXT'		=> nl2br($ipwhois))
			);

			return;
		}
		else
		{
			$this->tpl_name = 'acp_dap';
			$this->page_title = $this->user->lang[$display_vars['title']];
		}
	}

	public function select_ip_check_registration($value, $key = '')
	{
		$radio_ary = array(0 => 'IP_CHECK_NONE', 1 => 'IP_CHECK_LIGHT', 2 => 'IP_CHECK_FULL');	

		return h_radio('config[dap_ip_check]', $radio_ary, $value, 'dap_ip_check', $key, '<br />');
	}

	public function select_quick_deletion($value, $key = '')
	{
		$radio_ary = array(0 => 'NO', 1 => 'QUICK_DELETE_SILENT', 2 => 'QUICK_DELETE_NOTIFY');

		return h_radio('config[dap_quick_deletion]', $radio_ary, $value, 'dap_quick_deletion', $key, '<br />');
	}

	public function select_notify_forums()
	{
		return '<select id="dap_post_forum_id" name="dap_post_forum_id[]" multiple="multiple" size="10">' . make_forum_select(explode(',', $this->config['dap_post_forum_id']), false, false, true) . '</select>';
	}

	public function ban_status($ban, $count = false)
	{
		$ban_status = array();

		if (empty($ban))
		{
			$ban = 1;
			$ban_color = '';
			$log_entry = ($count) ? 'LOG_COOKIE_UNBAN_MANY' : 'LOG_COOKIE_UNBAN';
			$status = '';
		}
		else if ($ban == 1)
		{
			$ban = 2;
			$ban_color = ' style="color: red;"';
			$log_entry = ($count) ? 'LOG_COOKIE_BLACKLIST_MANY' : 'LOG_COOKIE_BLACKLIST';
			$status = '<p style="color: red; padding-top: 6px;">' . $this->user->lang['DAP_STATUS_BLACKLIST'] . '</p>';
		}
		else if ($ban == 2)
		{
			$ban = 3;
			$ban_color = ' style="color: green;"';
			$log_entry = ($count) ? 'LOG_COOKIE_WHITELIST_MANY' : 'LOG_COOKIE_WHITELIST';
			$status = '<p style="color: green; padding-top: 6px;">' . $this->user->lang['DAP_STATUS_WHITELIST'] . '</p>';
		}
		else
		{
			$ban = 0;
			$ban_color = ' style="color: blue;"';
			$log_entry = ($count) ? 'LOG_COOKIE_EXCLUSION_MANY' : 'LOG_COOKIE_EXCLUSION';
			$status = '<p style="color: blue; padding-top: 6px;">' . $this->user->lang['DAP_STATUS_EXCLUSION'] . '</p>';
		}

		$ban_status = array(
			'ban'			=> $ban,
			'ban_color'		=> $ban_color,
			'status'		=> $status,
			'log_entry'		=> $log_entry,
		);

		return $ban_status;
	}

	private function dap_delete_user($user_id, $delposts, $start)
	{
		$sql = 'SELECT user_id, username, user_type, user_email, user_lang, user_jabber, user_notify_type
			FROM ' . USERS_TABLE . '
			WHERE user_id = ' . (int) $user_id;
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		if ($row['user_id'] == $this->user->data['user_id'])
		{
			trigger_error($this->user->lang['CANNOT_REMOVE_YOURSELF'] . adm_back_link($this->u_action . '&amp;start=' . $start), E_USER_WARNING);
		}

		if ($row['user_id'] == ANONYMOUS)
		{
			trigger_error($this->user->lang['CANNOT_REMOVE_ANONYMOUS'] . adm_back_link($this->u_action . '&amp;start=' . $start), E_USER_WARNING);
		}

		if ($row['user_type'] == USER_FOUNDER)
		{
			trigger_error($this->user->lang['CANNOT_REMOVE_FOUNDER'] . adm_back_link($this->u_action . '&amp;start=' . $start), E_USER_WARNING);
		}

		if (!function_exists('user_delete'))
		{
			include($this->root_path . 'includes/functions_user.' . $this->php_ext);
		}

		if ($this->config['dap_quick_deletion'] == 2)
		{
			include_once($this->root_path . 'includes/functions_messenger.' . $this->php_ext);

			$messenger = new \messenger(false);

			$mail_template_path = $this->root_path . 'ext/shredder/dap/language/' . $row['user_lang'] . '/email/';

			$messenger->template('user_dap_deleted', $row['user_lang'], $mail_template_path);
			$messenger->to($row['user_email'], $row['username']);
			$messenger->im($row['user_jabber'], $row['username']);

			// Email headers
			$messenger->anti_abuse_headers($this->config, $this->user);

			$messenger->assign_vars(array(
				'BOARD_CONTACT'		=> $this->config['board_contact'],
				'USERNAME'			=> htmlspecialchars_decode($row['username']),
			));

			$messenger->send($row['user_notify_type']);
		}

		$delete_type = ($delposts) ? 'remove' : 'retain';

		user_delete($delete_type, $user_id, $row['username']);

		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_USER_DELETED', time(), array($row['username']));
	}

	private function cookie_blacklist()
	{
		// request vars
		$useradd	= $this->request->variable('useradd', false);
		$userfree	= $this->request->variable('userfree', false);

		// form key
		$form_key = 'dap_blacklist';
		add_form_key($form_key);

		if (($useradd || $userfree) && !check_form_key($form_key))
		{
			trigger_error($this->user->lang['FORM_INVALID'] . adm_back_link($this->u_action), E_USER_WARNING);
		}

		// User submitted?
		if ($useradd)
		{
			$usernames = array_map('trim', explode("\n", $this->request->variable('names', '', true)));
			$ban = $this->request->variable('ban_mode', '');

			$banlist_ary = $bot_names = $founder_names = $full_usernames = $sql_usernames = array();

			// Create a list of founders and bots...
			$sql = 'SELECT user_id, user_type, username_clean
				FROM ' . USERS_TABLE . '
				WHERE user_type = ' . USER_FOUNDER . '
					OR user_type = ' . USER_IGNORE;
			$result = $this->db->sql_query($sql);

			while ($row = $this->db->sql_fetchrow($result))
			{
				if ($row['user_type'] == USER_FOUNDER)
				{
					$founder_names[$row['user_id']] = $row['username_clean'];
				}
				if ($row['user_type'] == USER_IGNORE && $row['user_id'] != ANONYMOUS)
				{
					$bot_names[$row['user_id']] = $row['username_clean'];
				}
			}
			$this->db->sql_freeresult($result);

			foreach ($usernames as $username)
			{
				$username = trim($username);
				if ($username != '')
				{
					$clean_name = utf8_clean_string($username);
					if ($clean_name == $this->user->data['username_clean'])
					{
						trigger_error($this->user->lang['DAP_CANNOT_BAN_YOURSELF'] . adm_back_link($this->u_action), E_USER_WARNING);
					}
					if (in_array($clean_name, $founder_names))
					{
						trigger_error($this->user->lang['DAP_CANNOT_BAN_FOUNDER'] . adm_back_link($this->u_action), E_USER_WARNING);
					}
					if (in_array($clean_name, $bot_names))
					{
						trigger_error($this->user->lang['DAP_CANNOT_BAN_BOT'] . adm_back_link($this->u_action), E_USER_WARNING);
					}
					$sql_usernames[] = $clean_name;
				}
			}

			// Make sure we have been given someone to ban
			if (!sizeof($sql_usernames))
			{
				trigger_error($this->user->lang['NO_USER_SPECIFIED'] . adm_back_link($this->u_action), E_USER_WARNING);
			}

			$sql = 'SELECT user_id, username
				FROM ' . USERS_TABLE . '
				WHERE ' . $this->db->sql_in_set('username_clean', $sql_usernames);

			// Do not allow banning yourself, the guest account, or founders.
			$non_bannable = array($this->user->data['user_id'], ANONYMOUS);

			$sql .= ' AND ' . $this->db->sql_in_set('user_id', $non_bannable, true);

			unset($sql_usernames, $non_bannable);

			$result = $this->db->sql_query($sql);

			if ($row = $this->db->sql_fetchrow($result))
			{
				do
				{
					$banlist_ary[] = (int) $row['user_id'];
					$full_usernames[] = $row['username'];
				}
				while ($row = $this->db->sql_fetchrow($result));

				$sql = 'UPDATE ' . USERS_TABLE . '
					SET user_banned_cookie = ' . (int) $ban . '
					WHERE ' . $this->db->sql_in_set('user_id', $banlist_ary);
				$this->db->sql_query($sql);
			}
			else
			{
				$this->db->sql_freeresult($result);
				trigger_error($this->user->lang['NO_USERS'] . adm_back_link($this->u_action), E_USER_WARNING);
			}
			$this->db->sql_freeresult($result);

			$ban_list = (!is_array($full_usernames)) ? array_unique(explode("\n", $full_usernames)) : $full_usernames;
			$ban_list_log = implode(', ', $ban_list);

			unset($full_usernames, $founder_names, $bot_names);

			// Add to moderator log, admin log and user notes
			$count = (sizeof($ban_list) > 1) ? 1 : 0;
			$ban_status = $this->ban_status($ban, $count);

			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, $ban_status['log_entry'], time(), array($ban_list_log));
			$this->log->add('mod', $this->user->data['user_id'], $this->user->ip, $ban_status['log_entry'], time(), array($ban_list_log));

			foreach ($banlist_ary as $user_id)
			{
				$this->log->add('user', $this->user->data['user_id'], $this->user->ip, $ban_status['log_entry'], time(), array('reportee_id' => $user_id, $ban_list_log));
			}

			unset($banlist_ary);

			trigger_error($this->user->lang['ACP_DAP_BLACKLIST_UPDATED'] . adm_back_link($this->u_action));
		}
		else if ($userfree)
		{
			$user_id = $this->request->variable('userlist', array(0 => ''));

			if ($user_id)
			{
				$unban_names = array();

				$sql_where = (is_array($user_id)) ? $this->db->sql_in_set('user_id', array_map('intval', $user_id)) : 'user_id = ' . (int) $user_id;

				$sql = 'UPDATE ' . USERS_TABLE . '
					SET user_banned_cookie = ' . (int) 0 . '
					WHERE ' . $sql_where;
				$this->db->sql_query($sql);

				$sql = 'SELECT username
					FROM ' . USERS_TABLE . '
					WHERE ' . $sql_where;
				$result = $this->db->sql_query($sql);

				while ($row = $this->db->sql_fetchrow($result))
				{
					$unban_names[] = $row['username'];
				}
				$this->db->sql_freeresult($result);

				$ban_list_log = implode(', ', $unban_names);
				$log_entry = (sizeof($unban_names) > 1) ? 'LOG_COOKIE_UNBAN_MANY' : 'LOG_COOKIE_UNBAN';

				unset($unban_names);

				$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, $log_entry, time(), array($ban_list_log));
				$this->log->add('mod', $this->user->data['user_id'], $this->user->ip, $log_entry, time(), array($ban_list_log));

				foreach ($user_id as $id)
				{
					$this->log->add('user', $this->user->data['user_id'], $this->user->ip, $log_entry, time(), array('reportee_id' => $id, $ban_list_log));
				}

				trigger_error($this->user->lang['ACP_DAP_BLACKLIST_UPDATED'] . adm_back_link($this->u_action));
			}
		}

		// select all users
		$sql = 'SELECT user_id, username, user_banned_cookie
			FROM ' . USERS_TABLE . '
			WHERE user_banned_cookie > 0
				ORDER BY username_clean ASC';
		$result = $this->db->sql_query($sql);

		$user_options = '';
		while ($row = $this->db->sql_fetchrow($result))
		{
			$ban_status = $this->ban_status($row['user_banned_cookie']);
			$user_options .= '<option' . $ban_status['ban_color'] . ' value="' . $row['user_id'] . '">' . $row['username']  . '</option>';
		}
		$this->db->sql_freeresult($result);

		// template vars
		$this->template->assign_vars(array(
			'USER_OPTIONS'			=> $user_options,

			'U_ACTION'				=> $this->u_action,
			'U_FIND_USERNAME'		=> append_sid("{$this->root_path}memberlist.$this->php_ext", 'mode=searchuser&amp;form=dap_blacklist&amp;field=names'),
		));
	}

	public function dupe_log()
	{
		// Set up general vars
		$action		= $this->request->variable('action', '');
		$start		= $this->request->variable('start', 0);
		$deletetime	= $this->request->variable('deltime', '');
		$deletemark	= $this->request->variable('delmarked', '');
		$deleteall	= $this->request->variable('delall', '');
		$deletedays	= max(0, $this->request->variable('deldays', 0));
		$marked		= $this->request->variable('mark', array(0));
		$del 		= $this->request->variable('del', 0);
		$user_id 	= $this->request->variable('u', 0);
		$can_delete	= ($this->config['dap_quick_deletion'] && $this->auth->acl_get('a_userdel')) ? true : false;
		$delposts	= $this->request->variable('delposts', '');

		// Sort keys
		$sort_days	= $this->request->variable('st', 0);
		$sort_key	= $this->request->variable('sk', 't');
		$sort_dir	= $this->request->variable('sd', 'd');

		$this->log_type = constant('LOG_DAP');

		// Delete entries if requested and able
		if (($del && $can_delete) || (($deletetime || $deletemark || $deleteall) && $this->auth->acl_get('a_clearlogs')))
		{
			if (confirm_box(true))
			{
				$where_sql = '';

				if ($deletedays)
				{
					$unitime = time() - ($deletedays * 86400);
					$where_sql = ' AND log_time < ' . $unitime;
				}

				if ($deletemark && sizeof($marked))
				{
					$sql_in = array();
					foreach ($marked as $mark)
					{
						$sql_in[] = $mark;
					}
					$where_sql = ' AND ' . $this->db->sql_in_set('log_id', $sql_in);
					unset($sql_in);
				}

				if ($where_sql || $deleteall)
				{
					$sql = 'DELETE FROM ' . LOG_TABLE . "
						WHERE log_type = {$this->log_type}
						$where_sql";
					$this->db->sql_query($sql);

					$affected_rows = $this->db->sql_affectedrows();

					if ($affected_rows)
					{
						$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_CLEAR_DAP');
					}
					else
					{
						trigger_error($this->user->lang['ACP_DAP_NO_MATCHES'] . adm_back_link($this->u_action . '&amp;start=' . $start), E_USER_WARNING);
					}
				}

				if ($del)
				{
					$this->dap_delete_user($user_id, $delposts, $start);

					trigger_error($this->user->lang['ACP_DAP_USER_DELETED'] . adm_back_link($this->u_action . '&amp;start=' . $start));
				}
			}
			else
			{
				$box_template = ($del) ? 'acp_dap_delete.html' : 'confirm_body.html';

				$s_hidden_fields = build_hidden_fields(array(
					'start'		=> $start,
					'deltime'	=> $deletetime,
					'delmarked'	=> $deletemark,
					'delall'	=> $deleteall,
					'deldays'	=> $deletedays,
					'mark'		=> $marked,
					'st'		=> $sort_days,
					'sk'		=> $sort_key,
					'sd'		=> $sort_dir,
					'action'	=> $action)
				);

				confirm_box(false, $this->user->lang['CONFIRM_OPERATION'], $s_hidden_fields, $box_template);
			}
		}

		// Sorting
		$limit_days = array(0 => $this->user->lang['ALL_ENTRIES'], 1 => $this->user->lang['1_DAY'], 7 => $this->user->lang['7_DAYS'], 14 => $this->user->lang['2_WEEKS'], 30 => $this->user->lang['1_MONTH'], 90 => $this->user->lang['3_MONTHS'], 180 => $this->user->lang['6_MONTHS'], 365 => $this->user->lang['1_YEAR']);
		$sort_by_text = array('u' => $this->user->lang['SORT_USERNAME'], 't' => $this->user->lang['SORT_DATE'], 'i' => $this->user->lang['SORT_IP'], 'o' => $this->user->lang['SORT_ACTION']);
		$sort_by_sql = array('u' => 'u.username_clean', 't' => 'l.log_time', 'i' => 'l.log_ip', 'o' => 'l.log_operation');

		$s_limit_days = $s_sort_key = $s_sort_dir = $u_sort_param = '';
		gen_sort_selects($limit_days, $sort_by_text, $sort_days, $sort_key, $sort_dir, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param);

		// Define where and sort sql for use in displaying logs
		$sql_where = ($sort_days) ? (time() - ($sort_days * 86400)) : 0;
		$sql_sort = $sort_by_sql[$sort_key] . ' ' . (($sort_dir == 'd') ? 'DESC' : 'ASC');

		$keywords = $this->request->variable('keywords', '', true);
		$keywords_param = !empty($keywords) ? '&amp;keywords=' . urlencode(htmlspecialchars_decode($keywords)) : '';

		$log_data = array();
		$log_count = 0;
		$start = view_log('dap', $log_data, $log_count, $this->config['topics_per_page'], $start, 0, 0, 0, $sql_where, $sql_sort, $keywords);

		$this->pagination->generate_template_pagination($this->u_action . "&amp;$u_sort_param$keywords_param", 'pagination', 'start', $log_count, $this->config['topics_per_page'], $start);

		$this->template->assign_vars(array(
			'U_ACTION'		=> $this->u_action . "&amp;$u_sort_param$keywords_param&amp;start=$start",
			'DAP_ICONS_PATH'	=> $this->root_path . 'ext/shredder/dap/images',

			'S_LIMIT_DAYS'	=> $s_limit_days,
			'S_SORT_KEY'	=> $s_sort_key,
			'S_SORT_DIR'	=> $s_sort_dir,
			'S_CLEARLOGS'	=> $this->auth->acl_get('a_clearlogs'),
			'S_KEYWORDS'	=> $keywords,
		));

		foreach ($log_data as $row)
		{
			$user_c_delete = '';
			$c_user_id = $row['user_id'];

			preg_match_all("/([\d]+)\|(.*)/", $row['action'], $c_match);
			$cookiedata = isset($c_match[0][0]) ? $c_match[0][0] : '';
			$c_item_id = isset($c_match[1][0]) ? $c_match[1][0] : '';
			$c_item_name = isset($c_match[2][0]) ? $c_match[2][0] : '';

			$sql_ary = array(
				'SELECT'	=> 'u.user_banned_cookie, u2.user_id, u2.username, u2.user_colour',

				'FROM'		=> array(USERS_TABLE => 'u'),

				'LEFT_JOIN'	=> array(
					array(
						'FROM'	=> array(USERS_TABLE => 'u2'),
						'ON'	=> 'u2.user_id = ' . (int) $c_item_id,
					),
				),

				'WHERE'		=> 'u.user_id = ' . (int) $c_user_id,
			);

			$c_sql = $this->db->sql_build_query('SELECT', $sql_ary);
			$c_result = $this->db->sql_query($c_sql);
			$c_row = $this->db->sql_fetchrow($c_result);
			$this->db->sql_freeresult($c_result);

			$ban_status = $this->ban_status($c_row['user_banned_cookie']);

			$user_c_delete = ($c_row['user_id'] && $can_delete) ? append_sid("{$this->root_path}adm/index.$this->php_ext", 'i=-shredder-dap-acp-dap_module&amp;mode=dupe_log&amp;del=1&amp;u=' . $c_row['user_id'] . '&amp;start=' . $start, true) : '';
			$user_colour = ($c_row['user_colour']) ? ' style="color:#' . $c_row['user_colour'] . '" class="username-coloured"' : '';
			$c_common_name = ($c_row['user_id'] && $this->auth->acl_get('a_user')) ? '<a href="' . append_sid("{$this->root_path}adm/index.$this->php_ext", 'i=users&amp;mode=overview&amp;u=' . $c_row['user_id'], true) . '"><span' . $user_colour . '>' . $c_row['username']  . '</span></a>' : $c_item_name;

			$this->template->assign_block_vars('log', array(
				'USERNAME'			=> $row['username_full'],
				'S_BAN_STATUS'			=> $ban_status['status'],

				'IP'				=> $row['ip'],
				'DATE'				=> $this->user->format_date($row['time']),
				'ACTION'			=> str_replace($cookiedata, $c_common_name, $row['action']),
				'ID'				=> $row['id'],

				'U_USER_DELETE'			=> ($can_delete && $row['user_id'] != ANONYMOUS) ? append_sid("{$this->root_path}adm/index.$this->php_ext", 'i=-shredder-dap-acp-dap_module&amp;mode=dupe_log&amp;del=1&amp;u=' . $row['user_id'] . '&amp;start=' . $start, true) : '',
				'U_USER_C_DELETE'		=> $user_c_delete,
				'U_WHOIS'			=> $this->u_action . "&amp;action=whois&amp;user_ip={$row['ip']}",
			));
		}
	}

	public function list_dupe_users()
	{
		$action		= $this->request->variable('action', '');
		$start		= $this->request->variable('start', 0);
		$deletetime	= $this->request->variable('deltime', '');
		$deletemark	= $this->request->variable('delmarked', '');
		$deleteall	= $this->request->variable('delall', '');
		$deletedays	= max(0, $this->request->variable('deldays', 0));
		$marked		= $this->request->variable('mark', array(0));
		$users_per_page = $this->config['dap_users_per_page'];
		$del		= $this->request->variable('del', 0);
		$user_id	= $this->request->variable('u', 0);
		$can_delete	= ($this->config['dap_quick_deletion'] && $this->auth->acl_get('a_userdel')) ? true : false;
		$delposts	= $this->request->variable('delposts', '');

		// Delete entries if requested and able
		if (($del && $can_delete) || (($deletetime || $deletemark || $deleteall) && $this->auth->acl_get('a_cleardupe')))
		{
			if (confirm_box(true))
			{
				$where_sql = '';

				if ($deletedays)
				{
					$unitime = time() - ($deletedays * 86400);
					$where_sql = ' WHERE user_regdate < ' . $unitime;
				}

				if ($deletemark && sizeof($marked))
				{
					$sql_in = array();
					foreach ($marked as $mark)
					{
						$sql_in[] = $mark;
					}
					$where_sql = ' WHERE ' . $this->db->sql_in_set('user_id', $sql_in);
					unset($sql_in);
				}

				if ($where_sql || $deleteall)
				{
					$sql = 'UPDATE ' . USERS_TABLE . "
						SET user_double = 0
						$where_sql";
					$this->db->sql_query($sql);

					$affected_rows = $this->db->sql_affectedrows();

					if ($affected_rows)
					{
						$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_CLEAR_DUPE_LIST');
					}
					else
					{
						trigger_error($this->user->lang['ACP_DAP_NO_MATCHES'] . adm_back_link($this->u_action . '&amp;start=' . $start), E_USER_WARNING);
					}
				}

				if ($del)
				{
					$this->dap_delete_user($user_id, $delposts, $start);

					trigger_error($this->user->lang['ACP_DAP_USER_DELETED'] . adm_back_link($this->u_action . '&amp;start=' . $start));
				}
			}
			else
			{
				$box_template = ($del) ? 'acp_dap_delete.html' : 'confirm_body.html';

				$s_hidden_fields = build_hidden_fields(array(
					'start'		=> $start,
					'deltime'	=> $deletetime,
					'delmarked'	=> $deletemark,
					'delall'	=> $deleteall,
					'deldays'	=> $deletedays,
					'mark'		=> $marked,
					'action'	=> $action)
				);

				confirm_box(false, $this->user->lang['CONFIRM_OPERATION'], $s_hidden_fields, $box_template);
			}
		}

		// Get usercount for pagination
		$sql = 'SELECT COUNT(user_id) AS total_users
			FROM ' . USERS_TABLE . '
			WHERE user_double = ' . (bool) true;
		$result = $this->db->sql_query($sql);
		$total_users = (int) $this->db->sql_fetchfield('total_users');
		$this->db->sql_freeresult($result);

		if ($start >= $total_users)
		{
			$start = ($start - $users_per_page < 0) ? 0 : $start - $users_per_page;
		}

		// Get list of users
		$sql = 'SELECT user_id, username, user_ip, user_regdate, user_colour, user_banned_cookie, ip_common_names, c_common_names
			FROM ' . USERS_TABLE . '
			WHERE user_double = ' . (bool) true . '
			ORDER BY user_id DESC';
		$result = $this->db->sql_query_limit($sql, $users_per_page, $start);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$ban_status = $this->ban_status($row['user_banned_cookie']);

			$ip_common_names = $c_common_names = $user_c_delete = '';

			if (!empty($row['ip_common_names']))
			{
				$ip_common_set = explode('|', $row['ip_common_names']);
				$ip_ids_set = (isset($ip_common_set[0])) ? explode(',', $ip_common_set[0]) : '';
				$ip_names_set = (isset($ip_common_set[1])) ? explode(',', $ip_common_set[1]) : '';

				if (!empty($ip_ids_set) && !empty($ip_names_set))
				{
					$ip_sql = 'SELECT user_id
						FROM ' . USERS_TABLE . '
						WHERE ' . $this->db->sql_in_set('user_id', $ip_ids_set);
					$ip_result = $this->db->sql_query($ip_sql);

					while ($ip_row = $this->db->sql_fetchrow($ip_result))
					{
						$ip_check_set[] = $ip_row['user_id'];
					}
					$this->db->sql_freeresult($ip_result);

					foreach ($ip_ids_set as $ip_id)
					{
						$ip_result_set[] = (!empty($ip_check_set) && in_array($ip_id, $ip_check_set)) ? $ip_id : 0;
					}
					unset($ip_check_set);

					for ($i = 0; $i < sizeof($ip_names_set); $i++)
					{
						$ip_names_array[] = ($ip_result_set[$i] && $this->auth->acl_get('a_user')) ? '<a href="' . append_sid("{$this->root_path}adm/index.$this->php_ext", 'i=users&amp;mode=overview&amp;u=' . $ip_result_set[$i], true) . '">' . base64_decode($ip_names_set[$i]) . '</a>' : base64_decode($ip_names_set[$i]);
					}
					unset($ip_result_set);

					sort($ip_names_array);
					$ip_common_names = implode(', ', $ip_names_array);
					unset($ip_names_array);
				}
			}

			if (!empty($row['c_common_names']))
			{
				$c_item = explode('|', $row['c_common_names']);
				$c_item[0] = (isset($c_item[0])) ? $c_item[0] : '';
				$c_item[1] = (isset($c_item[1])) ? base64_decode($c_item[1]) : '';

				if (!empty($c_item[0]))
				{
					$c_sql = 'SELECT user_id
						FROM ' . USERS_TABLE . '
						WHERE user_id = ' . (int) $c_item[0];
					$c_result = $this->db->sql_query($c_sql);
					$c_id = $this->db->sql_fetchfield('user_id');
					$this->db->sql_freeresult($c_result);
				}

				$c_common_names = (isset($c_id) && $c_id && !empty($c_item[0]) && $this->auth->acl_get('a_user')) ? '<a href="' . append_sid("{$this->root_path}adm/index.$this->php_ext", 'i=users&amp;mode=overview&amp;u=' . $c_item[0], true) . '">' . $c_item[1]  . '</a>' : $c_item[1];
				$user_c_delete = (isset($c_id) && $c_id && $can_delete) ? append_sid("{$this->root_path}adm/index.$this->php_ext", 'i=-shredder-dap-acp-dap_module&amp;mode=dupe_user_list&amp;del=1&amp;u=' . $c_id . '&amp;start=' . $start, true) : '';
			}

			$user_colour = (isset($row['user_colour']) && $row['user_colour']) ? ' style="color:#' . $row['user_colour'] . '" class="username-coloured"' : '';

			$this->template->assign_block_vars('dupe_users', array(
				'USERNAME'		=> ($this->auth->acl_get('a_user')) ? '<a href="' . append_sid("{$this->root_path}adm/index.$this->php_ext", 'i=users&amp;mode=overview&amp;u=' . $row['user_id'], true) . '"><span' . $user_colour . '>' . $row['username']  . '</span></a>' : $row['username'],
				'USER_IP'			=> $row['user_ip'],
				'DATE'				=> $this->user->format_date($row['user_regdate']),
				'ID'				=> $row['user_id'],
				'IP_COMMON_NAMES'		=> $ip_common_names,
				'COOKIE_COMMON_NAMES'		=> $c_common_names,
				'S_BAN_STATUS'			=> $ban_status['status'],

				'U_USER_COOKIE_BAN'		=> append_sid("{$this->root_path}adm/index.$this->php_ext", 'i=-shredder-dap-acp-dap_module&amp;mode=dupe_user_list&amp;ban=1&amp;u=' . $row['user_id'] . '&amp;start=' . $start, true),
				'U_USER_COOKIE_WHITELIST'	=> append_sid("{$this->root_path}adm/index.$this->php_ext", 'i=-shredder-dap-acp-dap_module&amp;mode=dupe_user_list&amp;ban=2&amp;u=' . $row['user_id'] . '&amp;start=' . $start, true),
				'U_USER_COOKIE_EXCLUSION'	=> append_sid("{$this->root_path}adm/index.$this->php_ext", 'i=-shredder-dap-acp-dap_module&amp;mode=dupe_user_list&amp;ban=3&amp;u=' . $row['user_id'] . '&amp;start=' . $start, true),
				'U_USER_COOKIE_UNBLOCK'		=> append_sid("{$this->root_path}adm/index.$this->php_ext", 'i=-shredder-dap-acp-dap_module&amp;mode=dupe_user_list&amp;ban=0&amp;u=' . $row['user_id'] . '&amp;start=' . $start, true),
				'U_USER_DELETE'			=> ($can_delete) ? append_sid("{$this->root_path}adm/index.$this->php_ext", 'i=-shredder-dap-acp-dap_module&amp;mode=dupe_user_list&amp;del=1&amp;u=' . $row['user_id'] . '&amp;start=' . $start, true) : '',
				'U_USER_C_DELETE'		=> $user_c_delete,
				'U_WHOIS'			=> $this->u_action . "&amp;action=whois&amp;user_ip={$row['user_ip']}",
			));
		}
		$this->db->sql_freeresult($result);

		$this->pagination->generate_template_pagination($this->u_action, 'pagination', 'start', $total_users, $users_per_page, $start);

		$this->template->assign_vars(array(			
			'U_ACTION'		=> $this->u_action . "&amp;start=$start",
			'DAP_ICONS_PATH'	=> $this->root_path . 'ext/shredder/dap/images',

			'S_CLEAR_DUPE_LIST'	=> (!empty($total_users) && $this->auth->acl_get('a_cleardupe')) ? true : false,
		));

		return;
	}

	public function page_output($display_vars, $form_key)
	{
		$submit 		= ($this->request->is_set_post('submit')) ? true : false;
		$exclusubmit		= ($this->request->is_set_post('exclusubmit')) ? true : false;
		$unexclusubmit		= ($this->request->is_set_post('unexclusubmit')) ? true : false;

		$this->new_config = $this->config;
		$cfg_array = ($this->request->is_set('config')) ? $this->request->variable('config', array('' => ''), true) : $this->new_config;
		$error = array();

		// We validate the complete config if whished
		validate_config_vars($display_vars['vars'], $cfg_array, $error);

		if (($submit || $exclusubmit || $unexclusubmit) && !check_form_key($form_key))
		{
			$error[] = $this->user->lang['FORM_INVALID'];
		}

		if ($submit)
		{
			$cfg_array['dap_post_forum_id'] = implode(',', $this->request->variable('dap_post_forum_id', array(0)));

			if (strlen($cfg_array['dap_post_forum_id']) > 255)
			{
				$error[] = $this->user->lang['ACP_DAP_FORUM_ID_ERROR'];
			}

			if (!empty($cfg_array['dap_post_forum_id']) || $cfg_array['dap_pm_notification'])
			{
				$sql = 'SELECT user_id
					FROM ' . USERS_TABLE . '
					WHERE user_id = ' . (int) $cfg_array['dap_alert_user_id'];
				$result = $this->db->sql_query($sql);
				$alert_id = $this->db->sql_fetchfield('user_id');
				$this->db->sql_freeresult($result);

				if ($alert_id < 2)
				{
					$error[] = $this->user->lang['ACP_DAP_USER_ID_ERROR'];
				}
			}
		}

		// Do not write values if there is an error
		if (sizeof($error))
		{
			$submit = false;
		}

		if ($submit)
		{
			// We go through the display_vars to make sure no one is trying to set variables he/she is not allowed to...
			foreach ($display_vars['vars'] as $config_name => $null)
			{
				if (!isset($cfg_array[$config_name]) || strpos($config_name, 'legend') !== false)
				{
					continue;
				}

				$this->new_config[$config_name] = $config_value = $cfg_array[$config_name];

				$this->config->set($config_name, $config_value);
			}

			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'ACP_DAP_SETTINGS_UPDATED');
			trigger_error($this->user->lang['ACP_DAP_SAVED_SETTINGS'] . adm_back_link($this->u_action));
		}

		$exclusion 			= $this->request->variable('exclusion', '');
		$excludes 			= $this->request->variable('excludes', '');
		$exclusion_options	= $this->request->variable('exclusion_options', '');

		$excludes_ary = ($this->config_text->get('dap_log_excludes')) ? explode(',', $this->config_text->get('dap_log_excludes')) : array();
		$existed = array();

		foreach ($excludes_ary as $part)
		{
			$part = explode(':', $part);

			$sql_ary = array(
				'SELECT'	=> 'u.user_id, u.username, u2.user_id AS excluded_user_id, u2.username AS excluded_username',

				'FROM'		=> array(USERS_TABLE => 'u'),

				'LEFT_JOIN'	=> array(
					array(
						'FROM'	=> array(USERS_TABLE => 'u2'),
						'ON'	=> 'u2.user_id = ' . $part[1],
					),
				),

				'WHERE'		=> 'u.user_id = ' . $part[0],
			);

			$sql = $this->db->sql_build_query('SELECT', $sql_ary);
			$result = $this->db->sql_query($sql);
			$row = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			$existed[] = $row['user_id'] . ':' . $row['excluded_user_id'];
			$existed[] = $row['excluded_user_id'] . ':' . $row['user_id'];
			$exclusion_options .= '<option value="' . $row['user_id'] . ':' . $row['excluded_user_id'] . '">' . $row['username'] . ' &#8212; ' . $row['excluded_username'] . '</option>';
		}

		if ($exclusubmit)
		{
			if (!empty($exclusion) && !empty($excludes))
			{
				$exclusion_list = array_map('trim', explode("\n", $this->request->variable('exclusion', '', true)));
				$excludes_list = array_map('trim', explode("\n", $this->request->variable('excludes', '', true)));

				$sql_usernames = $exclusion_id_ary = array();

				foreach ($exclusion_list as $username)
				{
					$username = trim($username);
					if ($username != '')
					{
						$sql_usernames[] = utf8_clean_string($username);
					}
				}

				$sql = 'SELECT user_id
					FROM ' . USERS_TABLE . '
					WHERE ' . $this->db->sql_in_set('username_clean', $sql_usernames);
				$result = $this->db->sql_query($sql);

				unset($sql_usernames);

				if ($row = $this->db->sql_fetchrow($result))
				{
					do
					{
						$exclusion_id_ary[] = (int) $row['user_id'];
					}
					while ($row = $this->db->sql_fetchrow($result));
				}
				else
				{
					$this->db->sql_freeresult($result);
					trigger_error($this->user->lang['NO_USERS'] . adm_back_link($this->u_action), E_USER_WARNING);
				}
				$this->db->sql_freeresult($result);

				if (sizeof($exclusion_id_ary))
				{
					$sql_exclude_names = $exclude_id_ary = array();

					foreach ($excludes_list as $username)
					{
						$username = trim($username);
						if ($username != '')
						{
							$sql_exclude_names[] = utf8_clean_string($username);
						}
					}

					$e_sql = 'SELECT user_id
						FROM ' . USERS_TABLE . '
						WHERE ' . $this->db->sql_in_set('username_clean', $sql_exclude_names);
					$e_result = $this->db->sql_query($e_sql);

					unset($sql_exclude_names);

					if ($e_row = $this->db->sql_fetchrow($e_result))
					{
						do
						{
							$exclude_id_ary[] = (int) $e_row['user_id'];
						}
						while ($e_row = $this->db->sql_fetchrow($e_result));
					}
					else
					{
						$this->db->sql_freeresult($e_result);
						trigger_error($this->user->lang['NO_USERS'] . adm_back_link($this->u_action), E_USER_WARNING);
					}
					$this->db->sql_freeresult($e_result);

					if (sizeof($exclude_id_ary))
					{
						$sql_ary = array();
						foreach ($exclusion_id_ary as $exclusion_id)
						{
							foreach ($exclude_id_ary as $exclude_id)
							{
								if ($exclusion_id != $exclude_id && !in_array($exclusion_id . ':' . $exclude_id, $existed))
								{
									$existed[] = $exclusion_id . ':' . $exclude_id;
									$existed[] = $exclude_id . ':' . $exclusion_id;

									$sql_ary[] = (int) $exclusion_id . ':' . (int) $exclude_id;
								}
							}
						}
						if (sizeof($sql_ary))
						{
							$this->config_text->set('dap_log_excludes', implode(',', array_merge($excludes_ary, $sql_ary)));
						}

						unset($exclude_id_ary, $sql_ary);
					}

					unset($exclusion_id_ary);
				}

				$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_EXCLUDES_UPDATED');
				trigger_error($this->user->lang['DAP_EXCLUDES_UPDATE_SUCCESSFUL'] . adm_back_link($this->u_action));
			}
			else
			{
				trigger_error($this->user->lang['NO_USER_SPECIFIED'] . adm_back_link($this->u_action), E_USER_WARNING);
			}
		}
		else if ($unexclusubmit)
		{
			$unexclusion = $this->request->variable('unexclusion', array(''));

			if (sizeof($unexclusion))
			{
				$this->config_text->set('dap_log_excludes', implode(',', array_diff($excludes_ary, $unexclusion)));

				$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_EXCLUDES_UPDATED');
				trigger_error($this->user->lang['DAP_EXCLUDES_UPDATE_SUCCESSFUL'] . adm_back_link($this->u_action));
			}
			else
			{
				trigger_error($this->user->lang['ACP_DAP_NO_USERS_SELECTED'] . adm_back_link($this->u_action), E_USER_WARNING);
			}
		}

		unset($excludes_ary, $existed);

		$this->template->assign_vars(array(
			'DAP_MOD_VERSION'		=> sprintf($this->user->lang['ACP_DAP_SETTINGS_EXPLAIN'], $this->config['dap_version']),
			'EXCLUSION_OPTIONS'		=> $exclusion_options,
			'ERROR_MSG'			=> implode('<br />', $error),
			'L_TITLE'			=> $this->user->lang[$display_vars['title']],
			'L_TITLE_EXPLAIN'	=> $this->user->lang[$display_vars['title'] . '_EXPLAIN'],
			'S_EXCLUSION_OPTIONS'	=> ($exclusion_options) ? true : false,
			'S_ERROR'			=> (sizeof($error)) ? true : false,

			'U_ACTION'			=> $this->u_action,
			'U_FIND_USERNAME'		=> append_sid("{$this->root_path}memberlist.$this->php_ext", 'mode=searchuser&amp;form=acp_lc&amp;field=exclusion'),
			'U_FIND_EXCLUDES'		=> append_sid("{$this->root_path}memberlist.$this->php_ext", 'mode=searchuser&amp;form=acp_lc&amp;field=excludes'),
		));

		// Output relevant page
		foreach ($display_vars['vars'] as $config_key => $vars)
		{
			if (!is_array($vars) && strpos($config_key, 'legend') === false)
			{
				continue;
			}

			if (strpos($config_key, 'legend') !== false)
			{
				$this->template->assign_block_vars('options', array(
					'S_LEGEND'		=> true,
					'LEGEND'		=> (isset($this->user->lang[$vars])) ? $this->user->lang[$vars] : $vars)
				);

				continue;
			}

			$type = explode(':', $vars['type']);

			$l_explain = '';
			if ($vars['explain'] && isset($vars['lang_explain']))
			{
				$l_explain = (isset($this->user->lang[$vars['lang_explain']])) ? $this->user->lang[$vars['lang_explain']] : $vars['lang_explain'];
			}
			else if ($vars['explain'])
			{
				$l_explain = (isset($this->user->lang[$vars['lang'] . '_EXPLAIN'])) ? $this->user->lang[$vars['lang'] . '_EXPLAIN'] : '';
			}

			$content = build_cfg_template($type, $config_key, $this->new_config, $config_key, $vars);

			if (empty($content))
			{
				continue;
			}

			$this->template->assign_block_vars('options', array(
					'KEY'			=> $config_key,
					'TITLE'			=> (isset($this->user->lang[$vars['lang']])) ? $this->user->lang[$vars['lang']] : $vars['lang'],
					'S_EXPLAIN'		=> $vars['explain'],
					'TITLE_EXPLAIN'	=> $l_explain,
					'CONTENT'		=> $content,
				)
			);

			unset($display_vars['vars'][$config_key]);
		}
	}
}
