<?php

/**
 *
 * Invite. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2010-2015, KillBill
 * @copyright (c) 2017, kasimi
 * @copyright (c) 2017-2018, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\invitation\includes;

use leinad4mind\invitation\ext;
use leinad4mind\invitation\includes\config as ext_config;
use phpbb\auth\auth;
use phpbb\config\config as phpbb_config;
use phpbb\db\driver\driver_interface as db_interface;
use phpbb\language\language;
use phpbb\language\language_file_loader;
use phpbb\log\log_interface;
use phpbb\notification\manager;
use phpbb\pagination;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\user;

class functions
{
	/** @var request_interface */
	protected $request;

	/** @var db_interface */
	protected $db;

	/** @var phpbb_config */
	protected $config;

	/** @var ext_config */
	protected $ext_config;

	/** @var user */
	protected $user;

	/** @var language */
	protected $language;

	/** @var language_file_loader */
	protected $language_file_loader;

	/** @var auth */
	protected $auth;

	/** @var template */
	protected $template;

	/** @var pagination */
	protected $pagination;

	/** @var log_interface */
	protected $log;

	/** @var manager */
	protected $notification_manager;

	/** @var string */
	protected $table_users;

	/** @var string */
	protected $table_sessions;

	/** @var string */
	protected $table_groups;

	/** @var string */
	protected $table_banlist;

	/** @var string */
	protected $table_zebra;

	/** @var string */
	protected $table_invite;

	/** @var string */
	protected $table_invite_users;

	/** @var string */
	protected $table_invite_claimed;

	/** @var string */
	protected $root_path;

	/** @var string */
	protected $php_ext;

	/** @var array */
	protected $meghivo_user;

	/**
	 * @param \phpbb\request\request_interface        $request
	 * @param \phpbb\db\driver\driver_interface       $db
	 * @param \phpbb\config\config                    $config
	 * @param \leinad4mind\invitation\includes\config $ext_config
	 * @param \phpbb\user                             $user
	 * @param \phpbb\language\language                $language
	 * @param \phpbb\language\language_file_loader    $language_file_loader
	 * @param \phpbb\auth\auth                        $auth
	 * @param \phpbb\template\template                $template
	 * @param \phpbb\pagination                       $pagination
	 * @param \phpbb\log\log_interface                $log
	 * @param \phpbb\notification\manager             $notification_manager
	 * @param string                                  $table_users
	 * @param string                                  $table_sessions
	 * @param string                                  $table_groups
	 * @param string                                  $table_banlist
	 * @param string                                  $table_zebra
	 * @param string                                  $table_invite
	 * @param string                                  $table_invite_users
	 * @param string                                  $table_invite_claimed
	 * @param string                                  $root_path
	 * @param string                                  $php_ext
	 */
	public function __construct(request_interface $request, db_interface $db, phpbb_config $config, ext_config $ext_config, user $user, language $language, language_file_loader $language_file_loader, auth $auth, template $template, pagination $pagination, log_interface $log, manager $notification_manager, $table_users, $table_sessions, $table_groups, $table_banlist, $table_zebra, $table_invite, $table_invite_users, $table_invite_claimed, $root_path, $php_ext)
	{
		$this->request = $request;
		$this->db = $db;
		$this->config = $config;
		$this->ext_config = $ext_config;
		$this->user = $user;
		$this->language = $language;
		$this->language_file_loader = $language_file_loader;
		$this->auth = $auth;
		$this->template = $template;
		$this->pagination = $pagination;
		$this->log = $log;
		$this->notification_manager = $notification_manager;
		$this->table_users = $table_users;
		$this->table_sessions = $table_sessions;
		$this->table_groups = $table_groups;
		$this->table_banlist = $table_banlist;
		$this->table_zebra = $table_zebra;
		$this->table_invite = $table_invite;
		$this->table_invite_users = $table_invite_users;
		$this->table_invite_claimed = $table_invite_claimed;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
	}

	/**
	 *
	 */
	public function ini()
	{
		$register_enabled = !$this->ext_config['meghivo_enable'] || $this->config['require_ac_invite'] != ext::ACC_INVITE_ENABLE;

		$template_vars = array(
			'S_REGISTER_ENABLED' => $register_enabled,
		);

		if ($this->user->data['is_registered'])
		{
			$this->language->add_lang('meghivo', 'leinad4mind/invitation');

			if ($this->ext_config['verify_time'] <= time())
			{
				$this->expired();
			}

			if ($this->config['allow_birthdays'] && $this->ext_config['meghivo_birthdays'])
			{
				$this->birthday();
			}

			$template_vars = array_merge($template_vars, array(
				'U_INVITE'	=> $this->auth->acl_get('u_meghivo_kuld') ? append_sid("{$this->root_path}ucp.$this->php_ext", 'i=' . ext::get_module_id('ucp') . '&amp;mode=adat#meghivo_adat') : false,
				'L_INVITE'	=> $this->language->lang('MEGHIVO') . (($this->ext_config['meghivo_db'] || $this->auth->acl_get('u_meghivo_max')) ? '' : ' (' . $this->user->data['user_meghivo'] . ')'),
			));
		}

		$this->template->assign_vars($template_vars);
	}

	/**
	 * @return bool|array
	 */
	public function verify()
	{
		$meghivo_uid	= $this->request->variable('muid', 0);
		$meghivo_key	= $this->request->variable('mkey', '');
		$delete			= $this->request->variable('mdel', false);
		$meghivo_keys	= explode('|', $meghivo_key, $delete ? PHP_INT_MAX : 1);

		$invite_disabled = !$this->ext_config['meghivo_enable'] || $this->config['require_ac_invite'] == ext::ACC_INVITE_DISABLE;

		if ($invite_disabled && !$meghivo_uid && !$meghivo_keys && !$delete)
		{
			return $this->meghivo_user;
		}

		$this->language->add_lang('meghivo', 'leinad4mind/invitation');

		if ($meghivo_uid)
		{
			if ($meghivo_keys)
			{
				$delete_ids = array();

				$sql = 'SELECT id, meghivo_email, user_id, meghivo_kod, friend
						FROM ' . $this->table_invite . '
						WHERE ' . $this->db->sql_in_set('meghivo_kod', $meghivo_keys) . '
							AND user_id = ' . (int) $meghivo_uid;
				$result = $this->db->sql_query($sql);
				while ($row = $this->db->sql_fetchrow($result))
				{
					if ($delete)
					{
						$delete_ids[] = $row['id'];
					}
					else if (!$this->meghivo_user)
					{
						$this->meghivo_user = array(
							'mid'		=> $row['id'],
							'mmail'		=> $row['meghivo_email'],
							'muid'		=> $row['user_id'],
							'mkey'		=> $row['meghivo_kod'],
							'friend'	=> $row['friend'],
						);

						$this->template->assign_var('S_MEGHIVO_EMAIL_BLOCK', !$this->ext_config['email_address_change']);
					}
				}
				$this->db->sql_freeresult($result);

				if ($delete_ids)
				{
					$this->delete_key($delete_ids);
					trigger_error('MEGHIVO_DELETE_SUCCES' . (sizeof($delete_ids) > 1 ? 'S': ''));
				}
			}

			if (!$this->meghivo_user)
			{
				trigger_error($invite_disabled ? 'MEGHIVO_DISABLED' : 'MEGHIVO_KEY_ERROR');
			}
			else if ($invite_disabled)
			{
				trigger_error($this->language->lang('MEGHIVO_DISABLED') . '<br /><br />' . $this->language->lang('MEGHIVO_DELETE_CONFIRM', '<a href="' . append_sid("{$this->root_path}ucp.$this->php_ext", "mode=register&amp;muid={$meghivo_uid}&amp;mkey={$meghivo_key}&amp;mdel=yes") . '">', '</a>'));
			}
		}

		if ($this->config['require_activation'] != USER_ACTIVATION_DISABLE && $this->config['require_ac_invite'] == ext::ACC_INVITE_ENABLE && !$this->meghivo_user)
		{
			trigger_error('MEGHIVO_REGISTRATION');
		}

		return $this->meghivo_user;
	}

	/**
	 * @param int $user_id
	 * @param array $user_row
	 */
	public function delet($user_id, $user_row)
	{
		$sql = 'SELECT user_id, username, user_colour, user_lang, user_meghivo_member
				FROM ' . $this->table_users . '
				WHERE user_id = ' . (int) $this->meghivo_user['muid'];
		$result	= $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		$sql = 'SELECT group_colour
				FROM ' . $this->table_groups . '
				WHERE group_id = ' . (int) $user_row['group_id'];
		$result = $this->db->sql_query_limit($sql, 1);
		$group = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		$sql_ary = array(
			'user_id'			=> (int) $user_id,
			'user_name'			=> $user_row['username'],
			'user_colour'		=> $group['group_colour'],
			'user_reg_email'	=> $user_row['user_email'],
			'user_regdate'		=> (int) $user_row['user_regdate'],
			'meghivo_uid'		=> (int) $row['user_id'],
		);

		$this->db->sql_query('INSERT INTO ' . $this->table_invite_users . ' ' . $this->db->sql_build_array('INSERT', $sql_ary));

		$invited_users = $row['user_meghivo_member'] + 1;

		$sql = 'UPDATE ' . $this->table_users . '
				SET user_meghivo_member = ' . (int) $invited_users . '
				WHERE user_id = ' . (int) $row['user_id'];
		$this->db->sql_query($sql);

		if ($this->ext_config['gift_invited_users'] && $this->ext_config['gift_invited_users_invitation'])
		{
			$count = $invited_users / $this->ext_config['gift_invited_users'];

			if (is_int($count))
			{
				$sql = 'UPDATE ' . $this->table_users . '
						SET user_meghivo = user_meghivo + ' . (int) $this->ext_config['gift_invited_users_invitation'] . '
						WHERE user_id = ' . (int) $row['user_id'];
				$this->db->sql_query($sql);

				$this->send_notification('gift', array(
					'gift_user_id'					=> (int) $row['user_id'],
					'gift_invited_user_id'			=> (int) $user_id,
					'gift_count'					=> $count,
					'gift_invited_users'	 		=> $this->ext_config['gift_invited_users'],
					'gift_invited_users_invitation'	=> $this->ext_config['gift_invited_users_invitation'],
				));
			}
		}

		if ($this->meghivo_user['friend'])
		{
			$sql_ary = array(
				'user_id'	=> (int) $row['user_id'],
				'zebra_id'	=> (int) $user_id,
				'friend'	=> 1,
			);

			$sql = 'INSERT INTO ' . $this->table_zebra . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
			$this->db->sql_query($sql);
		}

		$this->send_notification('join', array(
			'join_user_id'			=> (int) $user_id,
			'join_notify_user_id'	=> (int) $row['user_id'],
		));

		$this->delete_key($this->meghivo_user['mid']);
		$this->ext_config->set('total_users', $this->ext_config['total_users'] + 1);
	}

	/**
	 * @param string $lang_file
	 * @param string $user_lang_name
	 * @return language
	 */
	public function trans_lang($lang_file, $user_lang_name)
	{
		$language = new language($this->language_file_loader, array());
		$this->language->set_user_language($user_lang_name);
		$language->add_lang($lang_file, 'leinad4mind/invitation');
		return $language;
	}

	/**
	 *
	 */
	protected function birthday()
	{
		$now = $this->user->create_datetime();
		$now = phpbb_gmgetdate($now->getTimestamp() + $now->getOffset());

		$time = time();

		// Display birthdays of 29th february on 28th february in non-leap-years
		$leap_year_birthdays = '';
		if ($now['mday'] == 28 && $now['mon'] == 2 && !$this->user->format_date($time, 'L'))
		{
			$leap_year_birthdays = " OR user_birthday LIKE '" . $this->db->sql_escape(sprintf('%2d-%2d-', 29, 2)) . "%'";
		}

		$sql = 'SELECT u.user_id, u.username, u.user_colour, u.user_birthday, u.user_lang, u.user_meghivo_block
				FROM ' . $this->table_users . ' u
				LEFT JOIN ' . $this->table_banlist . " b ON (u.user_id = b.ban_userid)
				WHERE (b.ban_id IS NULL OR b.ban_exclude = 1)
					AND u.user_birthday LIKE '" . $this->db->sql_escape(sprintf('%2d-%2d-', $now['mday'], $now['mon'])) . "%' $leap_year_birthdays
					AND " . $this->db->sql_in_set('u.user_type', array(USER_NORMAL, USER_FOUNDER));
		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			if ($row['user_meghivo_block'] > $time)
			{
				continue;
			}

			// blocking 1 year - 1 day
			$next_year = $time + (86400 * 364);

			$sql = 'UPDATE ' . USERS_TABLE . '
					SET user_meghivo = user_meghivo + ' . (int) $this->ext_config['meghivo_birthdays'] . ', user_meghivo_block = ' . (int) $next_year . '
					WHERE user_id = ' . (int) $row['user_id'];
			$this->db->sql_query($sql);

			$this->send_notification('birthday', array(
				'birthday_user_id' => $row['user_id'],
				'invitation_count' => $this->ext_config['meghivo_birthdays'],
			));
		}

		$this->db->sql_freeresult($result);
	}

	/**
	 * @param int $user_id
	 * @param int $total_users
	 */
	public function ac_user($user_id, $total_users)
	{
		if ($user_id == ANONYMOUS)
		{
			return;
		}

		$this->language->add_lang('meghivo', 'leinad4mind/invitation');

		$this->template->assign_vars(array(
			'MEGHIVO_USER_DB'		=> $this->language->lang('MEGHIVO_PERSON', '<b>' . $total_users . '</b>'),
			'MEGHIVO_USERS_LIST'	=> $total_users && $this->auth->acl_get('u_meghivo_users') ? append_sid("{$this->root_path}memberlist.$this->php_ext", "meghivo=users_list&amp;u={$user_id}") : false
		));

		$sql = 'SELECT u.user_id, u.username, u.user_colour
				FROM ' . $this->table_invite_users . ' m
				LEFT JOIN ' . $this->table_users . ' u ON m.meghivo_uid = u.user_id
				WHERE m.user_id = ' . (int) $user_id;

		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		if (!$row['user_id'])
		{
			return;
		}

		$this->template->assign_var('MEGHIVO_USER_NAME', '<strong>' . get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) . '</strong>');
	}

	/**
	 * @param string $mode
	 * @param int $user_id
	 */
	public function members_list($mode, $user_id = 0)
	{
		if ($mode == 'member' && !$this->auth->acl_get('u_meghivo_users'))
		{
			trigger_error('NOT_AUTHORISED');
		}

		$start			= $this->request->variable('start', 0);
		$sort_key		= $this->request->variable('sk','reg');
		$sort_dir		= $this->request->variable('sd','d');
		$list_meghivo	= $this->ext_config['meghivo_oldal_list'];

		$sort_by_text = array(
			'name' => $this->language->lang('SORT_USERNAME'),
			'post' => $this->language->lang('POST'),
			'reg' => $this->language->lang('JOINED'),
		);

		$sort_by_sql = array(
			'name' => 'u.username_clean',
			'post' => 'u.user_posts',
			'reg' => 'u.user_regdate',
		);

		if ($this->auth->acl_get('u_viewonline'))
		{
			$sort_by_text['aktiv'] = $this->language->lang('UCP_MEGHIVO_LAST_ACTIVE');
			$sort_by_sql['aktiv'] = 'u.user_lastvisit';
		}

		$limit_days = array();
		$s_sort_key = $s_sort_dir = $u_sort_param = $s_limit_days = '';
		$sort_days = 0;

		gen_sort_selects($limit_days, $sort_by_text, $sort_days, $sort_key, $sort_dir, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param);

		$sql_sort = $sort_by_sql[$sort_key] . ' ' . ($sort_dir == 'd' ? 'DESC' : 'ASC');

		$users_count = $this->get_users_count($user_id);
		$data = $this->users($users_count, $list_meghivo, $start, $sql_sort, $user_id);

		$url_param = $mode == 'ucp' ? append_sid("{$this->root_path}ucp.$this->php_ext", "i=" . ext::get_module_id('ucp') . "&amp;mode=user&amp;{$u_sort_param}") : append_sid("{$this->root_path}memberlist.$this->php_ext", "meghivo=users_list&amp;u={$user_id}&amp;{$u_sort_param}");

		$this->pagination->generate_template_pagination($url_param, 'pagination', 'start', $users_count, $list_meghivo, $start, true);

		$this->template->assign_vars(array(
			'S_MEGHIVO_USERS_LIST'	=> $mode == 'member',
			'UCP_MEGHIVO_USER'		=> $mode == 'ucp',
			'S_VIEWONLINE'			=> $this->auth->acl_get('u_viewonline')	? true : false,
			'TOTAL_COUNT'			=> $users_count ? $this->language->lang('UCP_MEGHIVO_USERS_COUNT', $users_count) : false,
			'PM_IMG'				=> $this->auth->acl_get('u_sendpm') && $mode == 'ucp' ? $this->user->img('icon_contact_pm', $this->language->lang('SEND_PRIVATE_MESSAGE')) : false,
			'EMAIL_IMG'				=> $this->auth->acl_get('u_sendemail') && $mode == 'ucp' ? $this->user->img('icon_contact_email', $this->language->lang('EMAIL')) : false,
			'S_ON_PAGE'				=> $this->pagination->on_page($users_count, $list_meghivo, $start),
			'S_SORT_KEY'			=> str_replace('<select', '<select onchange="this.form.submit();"', $s_sort_key),
			'S_SORT_DIR'			=> str_replace('<select', '<select onchange="this.form.submit();"', $s_sort_dir),
		));

		foreach ($data as $row)
		{
			$this->template->assign_block_vars('users', array(
				'H_USERNAME'	=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
				'H_REG_TIME'	=> $this->user->format_date($row['user_regdate']),
				'H_U_AKTIV'		=> $row['user_lastvisit'] || !empty($row['most_time']) ? $this->user->format_date($row[!empty($row['most_time']) ? 'most_time' : 'user_lastvisit']) : '-',
				'H_POSTS'		=> $row['user_posts'],
				'U_POSTS'		=> $this->auth->acl_get('u_search') && $this->config['load_search'] && $row['user_posts'] ? append_sid("{$this->root_path}search.$this->php_ext", 'author_id=' . $row['user_id'] . '&amp;sr=posts') : false,
				'U_H_PM'		=> $mode == 'ucp' ? append_sid("{$this->root_path}ucp.$this->php_ext", 'i=pm&amp;mode=compose&amp;u=' . $row['user_id']) : false,
				'U_H_EMAIL'		=> $mode == 'ucp' ? append_sid("{$this->root_path}memberlist.$this->php_ext", 'mode=email&amp;u=' . $row['user_id']) : false
			));
		}
	}

	/**
	 * @param int $user_id
	 * @return mixed
	 */
	protected function get_users_count($user_id)
	{
		if ($user_id)
		{
			$sql = 'SELECT user_meghivo_member
					FROM ' . $this->table_users . '
					WHERE user_id = ' . (int) $user_id;
			$result = $this->db->sql_query($sql);
			$users_count = (int) $this->db->sql_fetchfield('user_meghivo_member');
			$this->db->sql_freeresult($result);
		}
		else
		{
			$users_count = (int) $this->user->data['user_meghivo_member'];
		}

		return $users_count;
	}

	/**
	 * @param int $users_count
	 * @param int $limit
	 * @param int $offset
	 * @param string $sort_by
	 * @param int $user_id
	 * @return array
	 */
	protected function users($users_count, $limit = 20, $offset = 0, $sort_by = 'u.user_regdate DESC', $user_id = 0)
	{
		if (!$user_id)
		{
			$user_id = $this->user->data['user_id'];
		}

		if ($offset >= $users_count)
		{
			$offset = $offset - $limit < 0 ? 0 : $offset - $limit;
		}

		$sql_array = array(
			'SELECT'	=> 'MAX(s.session_time) AS most_time, u.user_id, u.username, u.username_clean, u.user_colour, u.user_posts, u.user_lastvisit, u.user_regdate',
			'FROM'		=> array($this->table_invite_users => 'm'),
			'LEFT_JOIN'	=> array(
				array(
					'FROM'	=> array($this->table_users => 'u'),
					'ON'	=> 'm.user_id = u.user_id',
				),
				array(
					'FROM'	=> array($this->table_sessions => 's'),
					'ON'	=> 'u.user_id = s.session_user_id',
				),
			),
			'WHERE'		=> 'm.meghivo_uid = ' . (int) $user_id,
			'GROUP_BY'	=> 'u.user_id, u.username, u.username_clean, u.user_colour, u.user_posts, u.user_lastvisit, u.user_regdate',
			'ORDER_BY'	=> $sort_by
		);

		$sql	= $this->db->sql_build_query('SELECT', $sql_array);
		$result	= $this->db->sql_query_limit($sql, $limit, $offset);
		$data	= $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		return $data;
	}

	/**
	 * @param string $value
	 * @return array
	 */
	public function select_acc_invite($value)
	{
		$radio_ary = array(
			ext::ACC_INVITE_DISABLE		=> 'ACC_INVITE_DISABLE',
			ext::ACC_INVITE_ENABLE		=> 'ACC_INVITE_ENABLE',
			ext::ACC_INVITE_REGISTER	=> 'ACC_INVITE_REGISTER',
		);

		return array(
			'require_ac_invite' => array(
				'lang'		=> 'ACP_INVITE_REGISTER',
				'validate'	=> 'int',
				'type'		=> 'custom',
				'append'	=> h_radio('config[require_ac_invite]', $radio_ary, $value, 'require_ac_invite', false, '<br />'),
				'explain'	=> true,
			),
		);
	}

	/**
	 * @return array
	 */
	public function invite_add_rows()
	{
		return array(
			'user_meghivo'			=> $this->ext_config['meghivo_enable'] ? $this->ext_config['meghivo_uj_reg'] : 0,
			'user_meghivo_member'	=> 0,
			'user_meghivo_block'	=> 0,
		);
	}

	/**
	 * @param int $user_id
	 */
	public function delete_user($user_id)
	{
		$users_count = 0;
		$sql = 'SELECT meghivo_uid
				FROM ' . $this->table_invite_users . '
				WHERE user_id = ' . (int) $user_id;
		$result = $this->db->sql_query($sql);
		$uid = (int) $this->db->sql_fetchfield('meghivo_uid');
		$this->db->sql_freeresult($result);

		if ($uid)
		{
			$this->db->sql_query('UPDATE ' . $this->table_users . ' SET user_meghivo_member = user_meghivo_member - 1 WHERE user_id = ' . (int) $uid);
			$users_count++;
		}

		$sql = 'SELECT user_id
				FROM ' . $this->table_invite_users . '
				WHERE meghivo_uid = ' . (int) $user_id;
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$users_count++;
		}
		$this->db->sql_freeresult($result);

		if ($users_count)
		{
			$this->ext_config->set('total_users', intval($this->ext_config['total_users'] - $users_count));
		}

		$this->db->sql_query('DELETE FROM ' . $this->table_invite_users . '	WHERE user_id = ' . (int) $user_id . ' OR meghivo_uid = ' . (int) $user_id);
		$this->db->sql_query('DELETE FROM ' . $this->table_invite . '			WHERE user_id = ' . (int) $user_id);
		$this->db->sql_query('DELETE FROM ' . $this->table_invite_claimed . '	WHERE user_id = ' . (int) $user_id);

		if ($this->ext_config['meghivo_notification_name'])
		{
			$sql = 'SELECT username
				FROM ' . $this->table_users . '
				WHERE user_id = ' . (int) $user_id;
			$result = $this->db->sql_query($sql);
			$username = $this->db->sql_fetchfield('username_clean');
			$this->db->sql_freeresult($result);

			if (utf8_clean_string($this->ext_config['meghivo_notification_name']) == $username)
			{
				$this->ext_config->set('meghivo_notification_name', '');
			}
		}
	}

	/**
	 * @param string $username
	 * @return array
	 */
	public function user_adat($username)
	{
		$sql = 'SELECT user_id, username, user_meghivo, user_type
			FROM ' . $this->table_users . "
			WHERE username_clean = '" . $this->db->sql_escape(utf8_clean_string($username)) . "'";
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		return $row;
	}

	/**
	 * @return int
	 */
	public function notification_sender()
	{
		if ($this->ext_config['meghivo_notification_name'])
		{
			$user = $this->user_adat($this->ext_config['meghivo_notification_name']);

			if ($user)
			{
				return (int) $user['user_id'];
			}
		}

		return ANONYMOUS;
	}

	/**
	 * @param array $user_ids
	 * @param string $user_colour
	 */
	public function update_default_group($user_ids, $user_colour)
	{
		$sql = 'UPDATE ' . $this->table_invite_users . "
				SET user_colour = '" . $this->db->sql_escape($user_colour) . "'
				WHERE " . $this->db->sql_in_set('user_id', $user_ids);
		$this->db->sql_query($sql);
	}

	/**
	 * @param string $type one of birthday|gift|petition|join
	 * @param array $notification_data
	 */
	public function send_notification($type, array $notification_data = array())
	{
		$notification_data['invite_notification_id'] = $this->config['invite_notification_id'];
		$this->config->increment('invite_notification_id', 1);
		$this->notification_manager->add_notifications('leinad4mind.invitation.notification.type.' . $type, $notification_data);
	}

	/**
	 * @param array $key_ids
	 */
	public function delete_key($key_ids)
	{
		if (!is_array($key_ids))
		{
			$key_ids = array((int) $key_ids);
		}

		$this->ext_config->set('total_pend', $this->ext_config['total_pend'] - sizeof($key_ids));
		$this->db->sql_query('DELETE FROM ' . $this->table_invite . ' WHERE ' . $this->db->sql_in_set('id', array_map('intval', $key_ids)));
	}

	/**
	 *
	 */
	public function expired()
	{
		$delete_ids = array();

		$sql = 'SELECT id, meghivo_time_end
				FROM ' . $this->table_invite . '
				WHERE meghivo_time_end <= ' . (int) $this->ext_config['verify_time'] . '
				ORDER BY meghivo_time_end DESC';

		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$delete_ids[] = $row['id'];
			$next_time = $row['meghivo_time_end'];
		}
		$this->db->sql_freeresult($result);

		if (sizeof($delete_ids) && isset($next_time))
		{
			$this->delete_key($delete_ids);
			$this->ext_config->set('verify_time', $next_time);
		}
		else
		{
			$next_time = (time() + 86400);
			$this->ext_config->set('verify_time', $next_time);
		}
	}

	/**
	 * @param int $user_id
	 * @param bool $user_new
	 */
	public function default_group($user_id, $user_new)
	{
		if (!$this->meghivo_user || !$this->ext_config['invite_group_enabled'] || !$this->ext_config['invite_group'])
		{
			return;
		}

		if ($user_new && $this->config['new_member_post_limit'] && $this->ext_config['new_member_post_limit_ignored'])
		{
			remove_newly_registered($user_id);
		}

		$sql = 'SELECT group_id, group_name
				FROM ' . $this->table_groups . '
				WHERE group_id = ' . (int) $this->ext_config['invite_group'] . '
				AND group_type <> ' . GROUP_SPECIAL;

		$result = $this->db->sql_query_limit($sql, 1);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		if ($row && !in_array($row['group_name'], $this->disabled_groups()))
		{
			group_user_add($row['group_id'], $user_id, false, false, $this->ext_config['default_group']);
		}
	}

	/**
	 * @param string $old_name
	 * @param string $new_name
	 */
	public function update_username($old_name, $new_name)
	{
		$sql = 'UPDATE ' . $this->table_invite_users . "
				SET user_name = '" . $this->db->sql_escape($new_name) . "'
				WHERE user_name = '" . $this->db->sql_escape($old_name) . "'";
		$this->db->sql_query($sql);

		if (utf8_clean_string($this->ext_config['meghivo_notification_name']) == utf8_clean_string($old_name))
		{
			$this->ext_config->set('meghivo_notification_name', $new_name);
		}
	}

	/**
	 * @return array
	 */
	public function disabled_groups()
	{
		return array(
			'BOTS',
			'GUESTS',
			'NEWLY_REGISTERED',
			'REGISTERED_COPPA',
			'REGISTERED',
			'GLOBAL_MODERATORS',
			'ADMINISTRATORS',
			'ADMIN_CSOP',
		);
	}
}
