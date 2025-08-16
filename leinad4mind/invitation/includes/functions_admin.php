<?php

/**
 *
 * Invite. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2010-2015, KillBill
 * @copyright (c) 2017, kasimi
 * @copyright (c) 2017-2021, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\invitation\includes;

use leinad4mind\invitation\includes\config as ext_config;
use phpbb\db\driver\driver_interface as db_interface;
use phpbb\language\language;
use phpbb\log\log_interface;
use phpbb\user;

class functions_admin
{
	/** @var user */
	protected $user;

	/** @var language */
	protected $language;

	/** @var db_interface */
	protected $db;

	/** @var log_interface */
	protected $log;

	/** @var functions */
	protected $functions;

	/** @var ext_config */
	protected $ext_config;

	/** @var string */
	protected $table_users;

	/** @var string */
	protected $table_groups;

	/** @var string */
	protected $table_user_group;

	/** @var string */
	protected $table_invite;

	/** @var string */
	protected $table_invite_users;

	/** @var string */
	protected $table_invite_claimed;

	/**
	 * @param \phpbb\user                                 $user
	 * @param \phpbb\language\language                    $language
	 * @param \phpbb\db\driver\driver_interface           $db
	 * @param \phpbb\log\log_interface                    $log
	 * @param \leinad4mind\invitation\includes\functions  $functions
	 * @param \leinad4mind\invitation\includes\config     $ext_config
	 * @param string                                      $table_users
	 * @param string                                      $table_groups
	 * @param string                                      $table_user_group
	 * @param string                                      $table_invite
	 * @param string                                      $table_invite_users
	 * @param string                                      $table_invite_claimed
	 */
	public function __construct(user $user, language $language, db_interface $db, log_interface $log, functions $functions,ext_config $ext_config, $table_users, $table_groups, $table_user_group, $table_invite, $table_invite_users, $table_invite_claimed)
	{
		$this->user = $user;
		$this->language = $language;
		$this->db = $db;
		$this->log = $log;
		$this->functions = $functions;
		$this->ext_config = $ext_config;
		$this->table_users = $table_users;
		$this->table_groups = $table_groups;
		$this->table_user_group = $table_user_group;
		$this->table_invite = $table_invite;
		$this->table_invite_users = $table_invite_users;
		$this->table_invite_claimed = $table_invite_claimed;
	}

	/**
	 * @return string
	 */
	public function users_per_days()
	{
		$days = (time() - $this->ext_config['invite_install_time']) / 86400;

		$data_per_day = sprintf('%.2f', $this->ext_config['total_users'] / $days);

		if ($data_per_day > $this->ext_config['total_users'])
		{
			$data_per_day = $this->ext_config['total_users'];
		}

		return $data_per_day;
	}

	/**
	 * @param string $usernames
	 * @return string
	 */
	public function users_verify($usernames)
	{
		$sql = 'SELECT username
				FROM ' . $this->table_users . '
				WHERE ' . $this->db->sql_in_set('username_clean', array_map('utf8_clean_string', explode("\n", $usernames))) . '
				AND ' . $this->db->sql_in_set('user_type', array(USER_NORMAL, USER_FOUNDER));
		$result = $this->db->sql_query($sql);
		$user_names = '';
		while ($row = $this->db->sql_fetchrow($result))
		{
			$user_names .= (!$user_names) ? $row['username'] : "\n" . $row['username'];
		}
		$this->db->sql_freeresult($result);

		return $user_names;
	}

	/**
	 * @param string $mode
	 * @param int $invite
	 * @param string $trigger
	 * @param string|array $usg
	 * @param int $task
	 * @param bool $group_all_users
	 * @return string
	 */
	public function set_invite($mode, $invite, &$trigger, $usg, $task = 5, $group_all_users = true)
	{
		$ss = ($invite == 1) ? '_I' : '_IS';

		switch ($mode)
		{
			case 'user':
				$sql = 'UPDATE ' . $this->table_users . "
						SET user_invite = " . (int) $invite . "
						WHERE username_clean = '" . $this->db->sql_escape(utf8_clean_string($usg)) . "'";
				$this->db->sql_query($sql);
				$ua = $usg;
			break;

			case 'users':
				$ua = str_replace("\n", ", ", $usg);

				if ($task)
				{
					$set_invite = 'user_invite + ' . (int) $invite;
					$ss .= (sizeof(explode("\n", $usg)) == 1) ? 'U' : 'US';
				}
				else
				{
					$set_invite = 0;
					$ss = (sizeof(explode("\n", $usg)) == 1) ? '_DELETE' :  '_DELETES';
				}

				$sql = 'UPDATE ' . $this->table_users . '
						SET user_invite = ' . $set_invite . '
						WHERE ' . $this->db->sql_in_set('username_clean', array_map('utf8_clean_string', explode("\n", $usg)));
				$this->db->sql_query($sql);
			break;

			case 'groups':
				$ua = '';

				$sql = 'SELECT g.group_name, g.group_type, COUNT(ug.user_id) as group_members
						FROM ' . $this->table_user_group . ' ug
						LEFT JOIN ' . $this->table_users . ' u ON u.user_id = ug.user_id
						LEFT JOIN ' . $this->table_groups . ' g ON g.group_id = ug.group_id
						WHERE ' . $this->db->sql_in_set('ug.group_id', $usg) . ($group_all_users ? '' : 'AND u.group_id = g.group_id') . '
						GROUP BY g.group_id';

				$result  = $this->db->sql_query($sql);
				while ($row = $this->db->sql_fetchrow($result))
				{
					$name_var = ($row['group_type'] == GROUP_SPECIAL) ? $this->language->lang('G_' . $row['group_name']) : $row['group_name'];
					$ua.= !$ua ? $name_var : ', ' . $name_var;
				}
				$this->db->sql_freeresult($result);

				if ($task)
				{
					$set_invite = 'user_invite + ' . (int) $invite;
					$ss .= (sizeof($usg) == 1) ?  'G' :  'GS';
				}
				else
				{
					$set_invite = 0;
					$ss = (sizeof($usg) == 1) ? '_DELETE' :  '_DELETES';
				}

				if ($group_all_users)
				{
					$sql_array = array(
						'SELECT'		=> 'u.user_id',
						'FROM'			=> array(
							$this->table_user_group	=> 'ug',
						),
						'LEFT_JOIN'		=> array(
							array(
								'FROM'	=> array(USERS_TABLE => 'u'),
								'ON'	=> 'ug.user_id = u.user_id'
							),
						),
						'WHERE'			=> 'ug.user_id = u.user_id AND ' . $this->db->sql_in_set('ug.group_id', $usg),
					);

					$sql = $this->db->sql_build_query('SELECT_DISTINCT', $sql_array);
					$result = $this->db->sql_query($sql);
					$user_ids = array();
					while ($row = $this->db->sql_fetchrow($result))
					{
						$user_ids[] = $row['user_id'];
					}
					$this->db->sql_freeresult($result);

					$user_ids = array_unique($user_ids);

					if (!sizeof($user_ids))
					{
						return $this->language->lang('ACP_INVITE_USERS_NO_' . ((sizeof($usg) == 1) ? 'GROUP' : 'GROUPS'));
					}

					$this->db->sql_query('UPDATE ' . USERS_TABLE . ' SET user_invite = ' . $set_invite . ' WHERE ' . $this->db->sql_in_set('user_id', $user_ids));
				}
				else
				{
					$this->db->sql_query('UPDATE ' . USERS_TABLE . ' SET user_invite = ' . $set_invite . ' WHERE ' . $this->db->sql_in_set('group_id', $usg));
				}
			break;

			default:
				return '';
		}

		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_INVITE_HANDLING_' . strtoupper($mode) . $ss, false, array($ua, $invite));
		$trigger = $this->language->lang('ACP_INVITE_HANDLING_' . strtoupper($mode) . $ss, $ua, $invite);

		return '';
	}

	/**
	 * @param string $mode
	 * @param array $marked
	 * @param bool $admin
	 */
	public function handling($mode, $marked, $admin)
	{
		$sql = 'SELECT h.*, u.user_id, u.username, u.user_colour, u.user_lang
				FROM ' . $this->table_invite_claimed . ' k
				LEFT JOIN ' . $this->table_users . ' u ON u.user_id = h.user_id
				WHERE ' . $this->db->sql_in_set('h.user_id', $marked);

		$result = $this->db->sql_query($sql);
		while ($invite = $this->db->sql_fetchrow($result))
		{
			$nev = get_username_string('full',$invite['user_id'], $invite['username'], $invite['user_colour']);

			$piece = (int) $invite['db'];

			switch ($mode)
			{
				case 'allocate':
					$sql = 'UPDATE ' . $this->table_users . '
							SET user_invite = user_invite + ' . (int) $piece . '
							WHERE user_id = ' . (int) $invite['user_id'];
					$this->db->sql_query($sql);

					if ($admin)
					{
						$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_INVITE_ALLOCATE', false, array($nev, $piece));
					}
					else
					{
						$this->log->add('mod',  $this->user->data['user_id'], $this->user->ip, 'LOG_INVITE_ALLOCATE', false, array($nev, $piece));
					}
				break;

				case 'deny':
					if ($admin)
					{
						$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_INVITE_SIZE_DELETE', false, array($nev));
					}
					else
					{
						$this->log->add('mod', $this->user->data['user_id'], $this->user->ip, 'LOG_INVITE_SIZE_DELETE', false, array($nev));
					}
				break;
			}

			$this->functions->send_notification('petition', array(
				'petition_user_id'			=> $invite['user_id'],
				'petition_staff_user_id'	=> $this->user->data['user_id'],
				'petition_mode'				=> $mode,
				'petition_piece'			=> $invite['db'],
			));
		}
		$this->db->sql_freeresult($result);

		$this->db->sql_query('DELETE FROM ' . $this->table_invite_claimed . ' WHERE ' . $this->db->sql_in_set('user_id', $marked));
	}

	/**
	 * @param array $message
	 * @param int $petition_count
	 * @param int $limit
	 * @param int $offset
	 * @param int $limit_days
	 * @param string $sort_by
	 */
	public function requesting(&$message, &$petition_count, $limit = 20, $offset = 0, $limit_days = 0, $sort_by = 'h.message_time DESC')
	{
		$sql = 'SELECT COUNT(user_id) AS message_count
				FROM ' . $this->table_invite_claimed . ' ' . (($limit_days) ? ' WHERE message_time >= ' . (int) $limit_days : '');
		$result = $this->db->sql_query($sql);
		$petition_count = (int) $this->db->sql_fetchfield('message_count');
		$this->db->sql_freeresult($result);

		if ($offset >= $petition_count)
		{
			$offset = ($offset - $limit < 0) ? 0 : $offset - $limit;
		}

		$sql = 'SELECT h.*, u.user_id, u.username, u.username_clean, u.user_colour
				FROM ' . $this->table_invite_claimed . ' k
				LEFT JOIN ' . $this->table_users . ' u ON h.user_id = u.user_id ' . (($limit_days) ? ' WHERE h.message_time >= ' . (int) $limit_days : '') . "
				ORDER BY $sort_by";
		$result = $this->db->sql_query_limit($sql, $limit, $offset);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$message[] = $row;
		}
		$this->db->sql_freeresult($result);
	}

	/**
	 * @param array $users
	 * @param int $users_count
	 * @param int $limit
	 * @param int $offset
	 * @param int $limit_days
	 * @param string $sort_by
	 */
	public function users_fun(&$users, &$users_count, $limit = 20, $offset = 0, $limit_days = 0, $sort_by = 'm.user_regdate DESC')
	{
		$sql = 'SELECT COUNT(user_id) AS users_count
				FROM ' . $this->table_invite_users . ' ' . (($limit_days) ? ' WHERE user_regdate >= ' . (int) $limit_days : '');
		$result = $this->db->sql_query($sql);
		$users_count = (int) $this->db->sql_fetchfield('users_count');
		$this->db->sql_freeresult($result);

		if ($offset >= $users_count)
		{
			$offset = ($offset - $limit < 0) ? 0 : $offset - $limit;
		}

		$sql = 'SELECT m.*, u.user_id AS caller_id, u.username, u.username_clean, u.user_colour AS caller_color, u.user_email AS caller_email, u.user_invite_member
				FROM ' . $this->table_invite_users . ' m
				LEFT JOIN ' . $this->table_users . ' u ON m.invite_uid = u.user_id
				' . (($limit_days) ? ' WHERE m.user_regdate >= ' . (int) $limit_days : '') . '
				ORDER BY ' . $sort_by;
		$result = $this->db->sql_query_limit($sql, $limit, $offset);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$users[] = $row;
		}
		$this->db->sql_freeresult($result);
	}

	/**
	 * @param array $invites
	 * @param int $invites_count
	 * @param int $limit
	 * @param int $offset
	 * @param int $limit_days
	 * @param string $sort_by
	 */
	public function pend(&$invites, &$invites_count, $limit = 20, $offset = 0, $limit_days = 0, $sort_by = 'i.invite_time DESC')
	{
		$sql = 'SELECT COUNT(id) AS invite_count
				FROM ' . $this->table_invite;
		$result = $this->db->sql_query($sql);
		$invites_count = (int) $this->db->sql_fetchfield('invite_count');
		$this->db->sql_freeresult($result);

		if ($offset >= $invites_count)
		{
			$offset = ($offset - $limit < 0) ? 0 : $offset - $limit;
		}

		$sql = 'SELECT i.*, u.user_id, u.username, u.username_clean, u.user_colour
				FROM ' . $this->table_invite . ' i
				LEFT JOIN ' . $this->table_users  . ' u ON i.user_id = u.user_id
				ORDER BY ' . $sort_by;
		$result = $this->db->sql_query_limit($sql, $limit, $offset);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$invites[] = $row;
		}
		$this->db->sql_freeresult($result);
	}

	/**
	 * @param string $type
	 */
	public function synchronisation($type)
	{
		switch($type)
		{
			case 'sync_users':
				$uid_ary = array();

				$sql = 'SELECT m.user_id, u.user_id AS caller_id
						FROM ' . $this->table_invite_users . ' m
						LEFT JOIN ' . $this->table_users . ' u ON m.user_id = u.user_id';
				$result = $this->db->sql_query($sql);
				while ($invitett = $this->db->sql_fetchrow($result))
				{
					$uid_ary[$invitett['user_id']] = $invitett['caller_id'] ? '' : $invitett['user_id'];
				}
				$this->db->sql_freeresult($result);

				$sql = 'SELECT m.invite_uid, u.user_id AS caller_id
						FROM ' . $this->table_invite_users . ' m
						LEFT JOIN ' . $this->table_users . ' u ON m.invite_uid = u.user_id';
				$result = $this->db->sql_query($sql);
				while ($invitett = $this->db->sql_fetchrow($result))
				{
					$uid_ary[$invitett['invite_uid']] = ($invitett['caller_id']) ? '' : $invitett['invite_uid'];
				}
				$this->db->sql_freeresult($result);

				if (sizeof($uid_ary))
				{
					$sql = 'DELETE FROM ' . $this->table_invite_users . '
							WHERE ' . $this->db->sql_in_set('user_id', $uid_ary) . '
							OR ' . $this->db->sql_in_set('invite_uid', $uid_ary);
					$this->db->sql_query($sql);
				}

				$sql = 'SELECT COUNT(invite_uid) as total, invite_uid
						FROM ' . $this->table_invite_users . '
						GROUP BY invite_uid';
				$result = $this->db->sql_query($sql);
				$row = $this->db->sql_fetchrowset($result);
				$this->db->sql_freeresult($result);

				$this->db->sql_query('UPDATE ' . $this->table_users . ' SET user_invite_member = 0');

				foreach ($row as $invite)
				{
					$sql = 'UPDATE ' . $this->table_users . '
							SET user_invite_member = ' . (int) $invite['total'] . '
							WHERE user_id = ' . (int) $invite['invite_uid'];
					$this->db->sql_query($sql);
				}
			break;

			case 'sync_data':
				$sql = 'SELECT COUNT(user_id) AS total_users FROM ' . $this->table_invite_users;
				$result = $this->db->sql_query($sql);
				$total_users = (int) $this->db->sql_fetchfield('total_users');
				$this->db->sql_freeresult($result);

				$sql = 'SELECT COUNT(id) AS total_pend FROM ' . $this->table_invite;
				$result = $this->db->sql_query($sql);
				$total_pend = (int) $this->db->sql_fetchfield('total_pend');
				$this->db->sql_freeresult($result);

				$sql = 'SELECT COUNT(user_id) AS total_petition FROM ' . $this->table_invite_claimed;
				$result = $this->db->sql_query($sql);
				$total_petition = (int) $this->db->sql_fetchfield('total_petition');
				$this->db->sql_freeresult($result);

				$configs = array(
					'total_petition'	=> $total_petition,
					'total_pend'		=> $total_pend,
					'total_users'		=> $total_users
				);

				foreach ($configs as $config_name => $config_value)
				{
					$this->ext_config->set($config_name, $config_value);
				}
			break;
		}
	}

	/**
	 * @return array
	 */
	public function groups()
	{
		$sql = 'SELECT group_id, group_type, group_name
				FROM ' . $this->table_groups . '
				WHERE ' . $this->db->sql_in_set('group_name', array('BOTS', 'GUESTS'), true) . '
				ORDER BY group_type DESC, group_name ASC';

		$groups = array();
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$groups[$row['group_id']] = array(
				'group_name' => $row['group_name'],
				'group_type' => $row['group_type']
			);
		}
		$this->db->sql_freeresult($result);

		return $groups;
	}
}
