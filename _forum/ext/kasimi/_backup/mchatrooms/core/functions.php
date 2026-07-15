<?php

/**
 *
 * @package phpBB Extension - mChat Rooms Addon
 * @copyright (c) 2016 kasimi - https://kasimi.net
 * @license proprietary
 *
 */

namespace kasimi\mchatrooms\core;

use dmzx\mchat\core\settings;
use phpbb\auth\auth;
use phpbb\cache\driver\driver_interface as cache_interface;
use phpbb\config\config;
use phpbb\db\driver\driver_interface as db_interface;
use phpbb\log\log_interface;
use phpbb\notification\manager as notification_manager;
use phpbb\user;

class functions
{
	/** @var constants */
	protected $constants;

	/** @var user */
	protected $user;

	/** @var auth */
	protected $auth;

	/** @var config */
	protected $config;

	/** @var db_interface */
	protected $db;

	/** @var cache_interface */
	protected $cache;

	/** @var notification_manager */
	protected $notification_manager;

	/** @var string */
	protected $table_users;

	/** @var string */
	protected $table_session;

	/** @var string */
	protected $table_notifications;

	/** @var log_interface */
	protected $log;

	/** @var settings */
	protected $mchat_settings;

	/**
	 *  Constructor
	 *
	 * @param constants				$constants
	 * @param user					$user
	 * @param auth					$auth
	 * @param config				$config
	 * @param db_interface			$db
	 * @param cache_interface		$cache
	 * @param notification_manager	$notification_manager
	 * @param log_interface			$log
	 * @param string				$table_users
	 * @param string				$table_session
	 * @param string				$table_notifications
	 * @param settings				$mchat_settings
	 */
	public function __construct(
		constants $constants,
		user $user,
		auth $auth,
		config $config,
		db_interface $db,
		cache_interface $cache,
		notification_manager $notification_manager,
		log_interface $log,
		$table_users,
		$table_session,
		$table_notifications,
		settings $mchat_settings = null
	)
	{
		$this->constants			= $constants;
		$this->user					= $user;
		$this->auth					= $auth;
		$this->config				= $config;
		$this->db					= $db;
		$this->cache				= $cache;
		$this->notification_manager	= $notification_manager;
		$this->log					= $log;
		$this->table_users			= $table_users;
		$this->table_session		= $table_session;
		$this->table_notifications	= $table_notifications;
		$this->mchat_settings		= $mchat_settings;
	}

	/**
	 * @param array $room_data
	 * @return array
	 */
	public function create_room($room_data)
	{
		$sql = 'INSERT INTO ' . $this->constants->table_mchat_rooms . ' ' . $this->db->sql_build_array('INSERT', $room_data);
		$this->db->sql_query($sql);
		$room_id = (int) $this->db->sql_nextid();

		$this->edit_room($room_id, [
			'room_sort' => $room_id,
		]);

		if ($room_data['room_type'] === constants::ROOM_TYPE_PRIVATE)
		{
			$room_user_data = [
				'room_id'	=> $room_id,
				'user_id'	=> (int) $this->user->data['user_id'],
				'join_time'	=> time(),
			];

			$sql = 'INSERT INTO ' . $this->constants->table_mchat_rooms_users . ' ' . $this->db->sql_build_array('INSERT', $room_user_data);
			$this->db->sql_query($sql);
		}

		$this->add_room_session($room_id, false);

		return $this->get_rooms($room_id);
	}

	/**
	 * @param int|array $room_ids
	 * @param array $options
	 * @return array
	 */
	public function get_rooms($room_ids = [], $options = [])
	{
		$sql_array = [
			'SELECT'	=> 'mr.*, u.username, u.user_colour, mrs.session_user_id, mrs.session_id',
			'FROM'		=> [$this->constants->table_mchat_rooms => 'mr'],
			'LEFT_JOIN' => [
				[
					'FROM'	=> [$this->table_users => 'u'],
					'ON'	=> 'u.user_id = mr.user_id',
				],
				[
					'FROM'	=> [$this->constants->table_mchat_rooms_users => 'mru'],
					'ON'	=> 'mru.room_id = mr.room_id AND mru.user_id = ' . (int) $this->user->data['user_id'],
				],
				[
					'FROM'	=> [$this->constants->table_mchat_rooms_sessions => 'mrs'],
					'ON'	=> 'mrs.session_room_id = mr.room_id AND mrs.session_user_id = ' . (int) $this->user->data['user_id'] . ' AND mrs.session_id = ' . $this->quoted_sid(),
				],
			],
			'ORDER_BY'	=> 'mr.room_sort = 0, mr.room_sort ASC, LOWER(mr.room_name) ASC, mr.room_name ASC',
		];

		$sql_where_room_types = ['mr.room_type = ' . (int) constants::ROOM_TYPE_NORMAL];

		if ($this->auth->acl_get('u_mchatrooms_protected'))
		{
			$sql_where_toom_type_protected = 'mr.room_type = ' . (int) constants::ROOM_TYPE_PROTECTED;

			if (in_array(constants::ROOMS_REQUIRE_PROTECTED_SESSION, $options))
			{
				$sql_where_toom_type_protected = '(' . $sql_where_toom_type_protected . ' AND mrs.session_room_id IS NOT NULL)';
			}

			$sql_where_room_types[] = $sql_where_toom_type_protected;
		}

		if (!in_array(constants::ROOMS_EXCLUDE_PRIVATE_ROOMS, $options))
		{
			$sql_where_toom_type_private = 'mr.room_type = ' . (int) constants::ROOM_TYPE_PRIVATE;

			// This options should only be present when displaying room names in invites for private rooms
			if (!in_array(constants::ROOMS_IGNORE_PRIVATE_SESSION, $options))
			{
				$sql_where_toom_type_private = '(' . $sql_where_toom_type_private . ' AND mru.room_id IS NOT NULL)';
			}

			$sql_where_room_types[] = $sql_where_toom_type_private;
		}

		$sql_where = [
			implode(' OR ', $sql_where_room_types),
		];

		if ($room_ids)
		{
			if (!is_array($room_ids))
			{
				$room_ids = [$room_ids];
			}

			$sql_where[] = $this->db->sql_in_set('mr.room_id', $room_ids);
		}
		else
		{
			$sql_where[] = 'mru.join_time IS NULL OR mru.join_time <> 0';
		}

		$sql_array['WHERE'] = '(' . implode(') AND (' , $sql_where) . ')';

		$sql = $this->db->sql_build_query('SELECT', $sql_array);

		return $this->get_sql_rows($sql, 0, 0, 0, 'room_id');
	}

	/**
	 * @return array
	 */
	protected function get_room_types()
	{
		$sql_array = [
			'SELECT'	=> 'mr.room_id, mr.room_type',
			'FROM'		=> [$this->constants->table_mchat_rooms => 'mr'],
		];

		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		return $this->get_sql_rows($sql, 0, 0, 0, 'room_id', 'room_type');
	}

	/**
	 * @param int $room_id
	 * @param int $room_type
	 * @return array
	 */
	public function get_room_users($room_id, $room_type)
	{
		switch ($room_type)
		{
			case constants::ROOM_TYPE_NORMAL:
			case constants::ROOM_TYPE_PROTECTED:

				$sql_array = [
					'SELECT'	=> 's.session_id',
					'FROM'		=> [$this->table_session => 's'],
					'LEFT_JOIN' => [
						[
							'FROM'	=> [$this->table_users => 'u'],
							'ON'	=> 'u.user_id = s.session_user_id',
						],
					],
					'WHERE'		=> 's.session_user_id <> ' . ANONYMOUS . ' AND s.session_last_visit = u.user_lastvisit',
				];

				$sql = $this->db->sql_build_query('SELECT', $sql_array);
				$session_ids = $this->get_sql_rows($sql, 0, 0, 0, false, 'session_id');

				if (!$session_ids)
				{
					return [];
				}

				$sql_array = [
					'SELECT'	=> 'mrs.session_room_id AS room_id, mrs.session_user_id AS user_id, NULL AS join_time, u.username, u.user_colour',
					'FROM'		=> [$this->constants->table_mchat_rooms_sessions => 'mrs'],
					'LEFT_JOIN' => [
						[
							'FROM'	=> [$this->table_users => 'u'],
							'ON'	=> 'u.user_id = mrs.session_user_id',
						],
					],
					'WHERE'		=> 'mrs.session_room_id = ' . (int) $room_id . ' AND ' . $this->db->sql_in_set('mrs.session_id', $session_ids),
					'ORDER_BY'	=> 'u.username ASC',
				];
			break;

			case constants::ROOM_TYPE_PRIVATE:
				$sql_array = [
					'SELECT'	=> 'mru.room_id, mru.user_id, mru.join_time, u.username, u.user_colour',
					'FROM'		=> [$this->constants->table_mchat_rooms_users => 'mru'],
					'LEFT_JOIN' => [
						[
							'FROM'	=> [$this->table_users => 'u'],
							'ON'	=> 'u.user_id = mru.user_id',
						],
					],
					'WHERE'		=> 'mru.room_id = ' . (int) $room_id . ' AND mru.user_id <> ' . ANONYMOUS,
					'ORDER_BY'	=> 'u.username ASC',
				];
			break;

			default:
				return [];
		}

		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		return $this->get_sql_rows($sql, 0, 0, 0, 'user_id');
	}

	/**
	 * @param int $room_id
	 * @param array $room_data
	 */
	public function edit_room($room_id, $room_data)
	{
		$sql = 'UPDATE ' . $this->constants->table_mchat_rooms . '
			SET ' . $this->db->sql_build_array('UPDATE', $room_data) . '
			WHERE room_id = ' . (int) $room_id;
		$this->db->sql_query($sql);
	}

	/**
	 * @param int $room_id
	 */
	public function delete_room($room_id)
	{
		$sql_array = [
			'SELECT'	=> 'm.message_id',
			'FROM'		=> [$this->constants->table_mchat_messages => 'm'],
			'WHERE'		=> 'm.room_id = ' . (int) $room_id,
		];

		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$message_ids = $this->get_sql_rows($sql, 0, 0, 0, false, 'message_id');

		if ($message_ids)
		{
			$sql = 'DELETE FROM ' . $this->constants->table_mchat_messages . ' WHERE room_id = ' . (int) $room_id;
			$this->db->sql_query($sql);

			$sql = 'DELETE FROM ' . $this->constants->table_mchat_log . ' WHERE ' . $this->db->sql_in_set('message_id', $message_ids);
			$this->db->sql_query($sql);
		}

		$this->delete_room_sessions($room_id);

		$sql = 'DELETE FROM ' . $this->constants->table_mchat_rooms . ' WHERE room_id = ' . (int) $room_id;
		$this->db->sql_query($sql);

		$this->delete_invite_notifications('room', $room_id);

		foreach (['post', 'quote', 'edit', 'reply', 'login'] as $mode)
		{
			if ($this->mchat_settings->cfg('mchat_rooms_' . $mode . '_notifications') == $room_id)
			{
				$this->mchat_settings->set_cfg('mchat_rooms_' . $mode . '_notifications', constants::LOBBY_ID);
			}
		}
	}

	/**
	 * Delete all rooms except for the lobby
	 */
	public function delete_rooms()
	{
		$room_ids = array_keys($this->get_room_types());

		foreach ($room_ids as $room_id)
		{
			if ($room_id != constants::LOBBY_ID)
			{
				$this->delete_room($room_id);
			}
		}

		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_MCHATROOMS_DELETED_ALL');
	}

	/**
	 * @param array $room_ids
	 * @param array $user_ids
	 * @param bool $user_negate
	 */
	public function delete_room_sessions($room_ids = [], $user_ids = [], $user_negate = false)
	{
		if (!is_array($room_ids))
		{
			$room_ids = array_filter([$room_ids]);
		}

		if (!is_array($user_ids))
		{
			$user_ids = array_filter([$user_ids]);
		}

		$sql_where = array_filter([
			$room_ids ? $this->db->sql_in_set('session_room_id', $room_ids) : '',
			$user_ids ? $this->db->sql_in_set('session_user_id', $user_ids, $user_negate) : '',
		]);

		$sql = 'DELETE FROM ' . $this->constants->table_mchat_rooms_sessions . '
			WHERE ' . implode(' AND ', $sql_where);
		$this->db->sql_query($sql);

		if (!$user_negate)
		{
			$sql_where = array_filter([
				$room_ids ? $this->db->sql_in_set('room_id', $room_ids) : '',
				$user_ids ? $this->db->sql_in_set('user_id', $user_ids) : '',
			]);

			$sql = 'DELETE FROM ' . $this->constants->table_mchat_rooms_users . '
				WHERE ' . implode(' AND ', $sql_where);
			$this->db->sql_query($sql);
		}
	}

	/**
	 * @param int $room_id
	 * @param bool $can_update
	 */
	public function add_room_session($room_id, $can_update)
	{
		if ($can_update)
		{
			$room_session_data = [
				'session_id' => $this->user->session_id,
			];

			$sql = 'UPDATE ' . $this->constants->table_mchat_rooms_sessions . '
				SET ' . $this->db->sql_build_array('UPDATE', $room_session_data) . '
				WHERE session_user_id = ' . (int) $this->user->data['user_id'] . '
					AND session_room_id = ' . (int) $room_id;
		}
		else
		{
			$room_session_data = [
				'session_id'		=> $this->user->session_id,
				'session_user_id'	=> (int) $this->user->data['user_id'],
				'session_room_id'	=> (int) $room_id,
			];

			$sql = 'INSERT INTO ' . $this->constants->table_mchat_rooms_sessions . ' ' . $this->db->sql_build_array('INSERT', $room_session_data);
		}

		$this->db->sql_query($sql);
	}

	/**
	 * @param array $room
	 * @return int One of the SESSION_ constants
	 */
	public function get_session_status($room)
	{
		if (empty($room['session_id']))
		{
			// If session_user_id is set and session_id is NULL, the database
			// contains an expired session row (as opposed to no session at all)
			if (isset($room['session_user_id']))
			{
				return constants::SESSION_EXPIRED;
			}

			return constants::SESSION_MISSING;
		}

		return constants::SESSION_ACTIVE;
	}

	/**
	 * @return int
	 */
	public function num_rooms()
	{
		return (int) $this->db->get_row_count($this->constants->table_mchat_rooms);
	}

	/**
	 * @return int
	 */
	public function num_private_room_sessions()
	{
		$sql_array = [
			'SELECT'	=> 'COUNT(mrs.session_room_id) AS num_private_sessions',
			'FROM'		=> [
				$this->constants->table_mchat_rooms_sessions => 'mrs',
			],
			'LEFT_JOIN' => [
				[
					'FROM'	=> [$this->constants->table_mchat_rooms => 'mr'],
					'ON'	=> 'mr.room_id = mrs.session_room_id AND mrs.session_user_id = ' . (int) $this->user->data['user_id'],
				],
			],
			'WHERE'		=> 'mrs.session_id = ' . $this->quoted_sid() . ' AND mr.room_type = ' . (int) constants::ROOM_TYPE_PRIVATE,
			'GROUP_BY'	=> 'mrs.session_user_id',
		];

		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$rows = $this->get_sql_rows($sql);

		foreach ($rows as $row)
		{
			return (int) $row['num_private_sessions'];
		}

		return 0;
	}

	/**
	 *
	 */
	public function gc_room_sessions()
	{
		$sql = 'SELECT DISTINCT session_id FROM ' . $this->table_session;
		$session_ids = $this->get_sql_rows($sql, 0, 0, 0, false, 'session_id');

		$sql = 'DELETE FROM ' . $this->constants->table_mchat_rooms_sessions . '
			WHERE ' . $this->db->sql_in_set('session_id', $session_ids, true, true);
		$this->db->sql_query($sql);

		// Find active private rooms
		$sql_array = [
			'SELECT'	=> 'mr.room_id',
			'FROM'		=> [
				$this->constants->table_mchat_rooms => 'mr',
			],
			'LEFT_JOIN' => [
				[
					'FROM'	=> [$this->constants->table_mchat_rooms_users => 'mru'],
					'ON'	=> 'mr.room_id = mru.room_id',
				],
			],
			'WHERE'		=> 'mru.join_time > 0 AND mr.room_type = ' . (int) constants::ROOM_TYPE_PRIVATE,
		];

		$sql = $this->db->sql_build_query('SELECT_DISTINCT', $sql_array);
		$active_private_rooms = $this->get_sql_rows($sql, 0, 0, 0, false, 'room_id');

		// Find inactive private rooms
		$sql_array = [
			'SELECT'	=> 'mr.room_id',
			'FROM'		=> [
				$this->constants->table_mchat_rooms => 'mr',
			],
			'WHERE'		=> 'mr.room_type = ' . (int) constants::ROOM_TYPE_PRIVATE . ' AND ' . $this->db->sql_in_set('mr.room_id', $active_private_rooms, true, true),
		];

		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$inactive_private_rooms = $this->get_sql_rows($sql, 0, 0, 0, false, 'room_id');

		// TODO
		// Remove rooms from $inactive_private_rooms for which there are still active invites.

		// Delete inactive private rooms
		foreach ($inactive_private_rooms as $inactive_private_room)
		{
			$this->delete_room($inactive_private_room);
		}
	}

	/**
	 * Inject WHERE clauses to skip messages for certain rooms when pruning by message time
	 *
	 * @param array $sql_array
	 * @return array
	 */
	public function inject_prune_sql_where($sql_array)
	{
		$sql_excludes = [
			'mchat_prune_skip_lobby'		=> 'm.room_id <> ' . constants::LOBBY_ID,
			'mchat_prune_skip_public'		=> 'mr.room_type <> ' . constants::ROOM_TYPE_NORMAL . ' OR m.room_id = ' . constants::LOBBY_ID,
			'mchat_prune_skip_protected'	=> 'mr.room_type <> ' . constants::ROOM_TYPE_PROTECTED,
			'mchat_prune_skip_private'		=> 'mr.room_type <> ' . constants::ROOM_TYPE_PRIVATE,
		];

		$sql_where = [];

		foreach ($sql_excludes as $cfg => $sql_exclude)
		{
			if ($this->mchat_settings->cfg($cfg))
			{
				$sql_where[] = $sql_exclude;
			}
		}

		if ($sql_where)
		{
			$sql_array['WHERE'] = isset($sql_array['WHERE']) ? '(' . $sql_array['WHERE'] . ') AND ' : '';
			$sql_array['WHERE'] .= '(' . implode(') AND (', $sql_where) . ')';
			$sql_array['LEFT_JOIN'][] = [
				'FROM'	=> [$this->constants->table_mchat_rooms => 'mr'],
				'ON'	=> 'm.room_id = mr.room_id'
			];
		}

		return $sql_array;
	}

	/**
	 * Get IDs of message to be pruned when pruning by number of messages
	 *
	 * @param array $prune_ids
	 * @return array
	 */
	public function prune_messages($prune_ids)
	{
		$prune_mode = (int) $this->mchat_settings->cfg('mchat_prune_mode');

		// Time-based pruning of messages aren't specific to rooms
		if ($this->mchat_settings->prune_modes[$prune_mode] !== 'messages')
		{
			return $prune_ids;
		}

		// Number of messages to retain in each room
		$prune_num = $this->mchat_settings->cfg('mchat_prune_num');

		$new_prune_ids = [];

		foreach ($this->get_room_types() as $room_id => $room_type)
		{
			if ($this->mchat_settings->cfg('mchat_prune_skip_lobby') && $room_id == constants::LOBBY_ID
				|| $this->mchat_settings->cfg('mchat_prune_skip_public') && $room_type == constants::ROOM_TYPE_NORMAL && $room_id != constants::LOBBY_ID
				|| $this->mchat_settings->cfg('mchat_prune_skip_protected') && $room_type == constants::ROOM_TYPE_PROTECTED
				|| $this->mchat_settings->cfg('mchat_prune_skip_private') && $room_type == constants::ROOM_TYPE_PRIVATE
			)
			{
				continue;
			}

			$sql_array = [
				'SELECT'	=> 'message_id',
				'FROM'		=> [$this->constants->table_mchat_messages => 'm'],
				'WHERE'		=> 'm.room_id = ' . (int) $room_id,
				'ORDER_BY'	=> 'm.message_id DESC',
			];

			$sql = $this->db->sql_build_query('SELECT', $sql_array);
			$room_prune_ids = $this->get_sql_rows($sql, 0, $prune_num, 0, false, 'message_id');
			$new_prune_ids = array_merge($new_prune_ids, $room_prune_ids);
		}

		return $new_prune_ids;
	}

	/**
	 * @param int $room_id
	 */
	public function purge_room($room_id)
	{
		$sql_array = [
			'SELECT'	=> 'm.message_id',
			'FROM'		=> [$this->constants->table_mchat_messages => 'm'],
			'WHERE'		=> 'm.room_id = ' . (int) $room_id,
		];

		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$message_purge_ids = $this->get_sql_rows($sql, 0, 0, 0, false, 'message_id');

		if ($message_purge_ids)
		{
			$sql = 'DELETE FROM ' . $this->constants->table_mchat_log . '
				WHERE ' . $this->db->sql_in_set('message_id', $message_purge_ids);
			$this->db->sql_query($sql);

			$sql = 'DELETE FROM ' . $this->constants->table_mchat_messages . '
				WHERE room_id = ' . (int) $room_id;
			$this->db->sql_query($sql);
		}
	}

	/**
	 * Modifies mChat's SQL query that fetches messages
	 *
	 * @param array $sql_array
	 * @param int $room_id
	 * @param int $latest_lobby_message_id
	 * @param array $latest_message_ids
	 * @param array $log_message_ids
	 * @return array
	 */
	public function mchat_get_messages_modify_sql(array $sql_array, $room_id, $latest_lobby_message_id, array $latest_message_ids, array $log_message_ids)
	{
		$sql_where = [];

		if (!empty($sql_array['WHERE']))
		{
			$sql_where_in = $sql_array['WHERE'];

			// Remove message_id condition for lobby
			if ($latest_lobby_message_id)
			{
				$sql_where_in = preg_replace(sprintf('#\(m.message_id > %d\)#', $latest_lobby_message_id), '', $sql_where_in);
				$sql_where_in = preg_replace('#\s*AND\s+AND\s*#', ' ', $sql_where_in);
				$sql_where_in = preg_replace('#^\s*AND\s*#', '', $sql_where_in);
				$sql_where_in = preg_replace('#\s*AND\s*$#', '', $sql_where_in);
			}

			$sql_where[] = $sql_where_in;
		}

		$join_rooms_table = false;

		if ($room_id)
		{
			$sql_where[] = 'm.room_id = ' . (int) $room_id;
		}
		else
		{
			// Restrict messages to rooms for which the user has active sessions
			$sql_array['LEFT_JOIN'][] = [
				'FROM'	=> [$this->constants->table_mchat_rooms_sessions => 'mrs'],
				'ON'	=> 'm.room_id = mrs.session_room_id AND mrs.session_user_id = ' . (int) $this->user->data['user_id'],
			];

			$sql_where_room_id = [
				'm.room_id = ' . (int) constants::LOBBY_ID,
				'mrs.session_id = ' . $this->quoted_sid(),
			];

			if ($this->mchat_settings->cfg('mchat_rooms_enter_all'))
			{
				$join_rooms_table = true;
				$sql_where_room_id[] = "mr.room_password = ''";
			}

			$sql_where[] = '(' . implode(' OR ', $sql_where_room_id) . ')';
		}

		if ($latest_message_ids)
		{
			$sql_where_room_and_id = [];
			$latest_message_ids[constants::LOBBY_ID] = $latest_lobby_message_id;

			foreach ($latest_message_ids as $latest_room_id => $latest_message_id)
			{
				$sql_where_id = [sprintf('m.message_id > %d', (int) $latest_message_id)];

				if ($log_message_ids)
				{
					$sql_where_id[] = $this->db->sql_in_set('m.message_id', $log_message_ids);
				}

				$sql_where_room_and_id[] = sprintf('m.room_id = %d AND (%s)', (int) $latest_room_id, implode(' OR ', $sql_where_id));
			}

			$sql_where[] = '((' . implode(') OR (', $sql_where_room_and_id) . '))';
		}

		// Restrict messages to rooms that are not password protected
		if (!$this->auth->acl_get('u_mchatrooms_protected'))
		{
			$join_rooms_table = true;
			$sql_where[] = "mr.room_password = ''";
		}

		if ($join_rooms_table)
		{
			$sql_array['LEFT_JOIN'][] = [
				'FROM'	=> [$this->constants->table_mchat_rooms => 'mr'],
				'ON'	=> 'm.room_id = mr.room_id',
			];
		}

		$sql_array['WHERE'] = implode(' AND ', array_filter($sql_where));

		return $sql_array;
	}

	/**
	 * @param array $rooms
	 * @return array
	 */
	public function latest_message_ids($rooms)
	{
		$sql_array = [
			'SELECT'	=> 'm.room_id, MAX(m.message_id) as max_message_id',
			'FROM'		=> [
				$this->constants->table_mchat_rooms => 'mr',
			],
			'LEFT_JOIN' => [
				[
					'FROM'	=> [$this->constants->table_mchat_messages => 'm'],
					'ON'	=> 'm.room_id = mr.room_id',
				],
				[
					'FROM'	=> [$this->constants->table_mchat_rooms_sessions => 'mrs'],
					'ON'	=> 'm.room_id = mrs.session_room_id AND mrs.session_user_id = ' . (int) $this->user->data['user_id'],
				],
			],
			'GROUP_BY'	=> 'm.room_id',
		];

		$sql_where_room_id = [
			'm.room_id = ' . (int) constants::LOBBY_ID,
			'mrs.session_id = ' . $this->quoted_sid(),
		];

		$enter_all = $this->mchat_settings->cfg('mchat_rooms_enter_all');

		if ($enter_all)
		{
			$sql_where_room_id[] = "mr.room_password = ''";
		}

		$sql_array['WHERE'] = implode(' OR ', $sql_where_room_id);

		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$latest_message_ids = $this->get_sql_rows($sql, 0, 0, 0, 'room_id', 'max_message_id');

		// Fill empty rooms
		foreach ($rooms as $room_id => $room)
		{
			if (empty($latest_message_ids[$room_id]) && ($enter_all && $room['room_password'] === '' || $this->get_session_status($room) === constants::SESSION_ACTIVE))
			{
				$latest_message_ids[$room_id] = 0;
			}
		}

		return array_map('intval', $latest_message_ids);
	}

	/**
	 * @param bool|int $room_id
	 * @param bool $only_active
	 * @param bool|int|array $user_id
	 * @param bool $post_process
	 * @param bool|int $inviter_id
	 * @return array
	 */
	public function get_invite_notifications($room_id, $only_active, $user_id = false, $post_process = true, $inviter_id = false)
	{
		$sql_where = [
			'n.notification_type_id = ' . $this->notification_manager->get_notification_type_id(constants::NOTIFICATION_TYPE_INVITE),
		];

		$invite_expiration = $this->mchat_settings->cfg('mchat_invite_expiration');
		if ($only_active && $invite_expiration)
		{
			$sql_where[] = 'n.notification_time >= ' . (time() - $invite_expiration * 60);
		}

		if ($user_id)
		{
			if (!is_array($user_id))
			{
				$user_id = [$user_id];
			}

			$sql_where[] = $this->db->sql_in_set('n.user_id', $user_id);
		}

		$sql_array = [
			'SELECT'	=> 'n.*',
			'FROM'		=> [$this->table_notifications => 'n'],
			'WHERE'		=> implode(' AND ', $sql_where),
		];

		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$rows = $this->get_sql_rows($sql);

		if ($post_process)
		{
			foreach ($rows as $i => &$row)
			{
				$row['notification_data'] = @unserialize($row['notification_data']);

				if (
					empty($row['notification_data']) ||
					($room_id !== false && $row['notification_data']['room_id'] != $room_id) ||
					($inviter_id !== false && $row['notification_data']['inviter_id'] != $inviter_id)
				)
				{
					unset($rows[$i]);
				}
			}
		}

		return $rows;
	}

	/**
	 * @param int $invite_id
	 * @return int
	 */
	public function get_room_id_from_invite($invite_id)
	{
		if (!$invite_id)
		{
			return 0;
		}

		$sql_where = [
			'n.item_id = ' . (int) $invite_id,
			'n.user_id = ' . (int) $this->user->data['user_id'],
		];

		$invite_expiration = $this->mchat_settings->cfg('mchat_invite_expiration');
		if ($invite_expiration)
		{
			$sql_where[] = 'n.notification_time >= ' . (time() - $invite_expiration * 60);
		}

		$sql_array = [
			'SELECT'	=> 'n.notification_data',
			'FROM'		=> [$this->table_notifications => 'n'],
			'WHERE'		=> implode(' AND ', $sql_where),
		];

		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$rows = $this->get_sql_rows($sql, 1);

		if (!$rows)
		{
			return 0;
		}

		$row = reset($rows);
		$notification_data = @unserialize($row['notification_data']);

		if (empty($notification_data['room_id']))
		{
			return 0;
		}

		$room_id = (int) $notification_data['room_id'];

		$rooms = $this->get_rooms($room_id);

		if (!empty($rooms[$room_id]) && $rooms[$room_id]['room_type'] == constants::ROOM_TYPE_PRIVATE)
		{
			$sql = 'UPDATE ' . $this->constants->table_mchat_rooms_users . '
				SET join_time = ' . time() . '
					WHERE join_time = 0 AND room_id = ' . (int) $room_id . ' AND user_id = ' . (int) $this->user->data['user_id'];
			$this->db->sql_query($sql);
		}

		return $room_id;
	}

	/**
	 * @param array $room
	 * @param array $invitee_user_ids
	 * @param string $invite_message
	 */
	public function add_invite_notifications($room, $invitee_user_ids, $invite_message)
	{
		$room_user_data = [];

		foreach ($invitee_user_ids as $invitee_user_id)
		{
			$this->config->increment('kasimi.mchatrooms.invite_id', 1);

			$notification_data = [
				'invite_id'		=> (int) $this->config['kasimi.mchatrooms.invite_id'],
				'room_id'		=> (int) $room['room_id'],
				'inviter_id'	=> (int) $this->user->data['user_id'],
				'invitee_id'	=> (int) $invitee_user_id,
				'message'		=> $invite_message,
			];

			$this->notification_manager->add_notifications(constants::NOTIFICATION_TYPE_INVITE, $notification_data);

			if ($room['room_type'] == constants::ROOM_TYPE_PRIVATE)
			{
				$sql_array = [
					'SELECT'	=> 'mru.room_id',
					'FROM'		=> [$this->constants->table_mchat_rooms_users => 'mru'],
					'WHERE'		=> 'mru.room_id = ' . (int) $room['room_id'] . ' AND mru.user_id = ' . (int) $invitee_user_id,
				];

				$sql = $this->db->sql_build_query('SELECT', $sql_array);
				$rows = $this->get_sql_rows($sql, 1);

				if (!$rows)
				{
					$room_user_data[] = [
						'room_id'	=> (int) $room['room_id'],
						'user_id'	=> (int) $invitee_user_id,
						'join_time'	=> 0,
					];
				}
			}
		}

		$this->db->sql_multi_insert($this->constants->table_mchat_rooms_users, $room_user_data);
	}

	/**
	 * @param string $mode one of room|user
	 * @param int|array $ids
	 */
	public function delete_invite_notifications($mode, $ids)
	{
		$notifications = [];

		switch ($mode)
		{
			case 'room':
				$notifications = $this->get_invite_notifications($ids, false, false, false);
				break;

			case 'user':
				$notifications = $this->get_invite_notifications(false, false, $ids, false);
				break;
		}

		$item_ids = [];

		foreach ($notifications as $notification)
		{
			$item_ids[] = $notification['item_id'];
		}

		if ($item_ids)
		{
			$this->notification_manager->delete_notifications(constants::NOTIFICATION_TYPE_INVITE, $item_ids);
		}
	}

	/**
	 * @return string
	 */
	protected function quoted_sid()
	{
		return "'" . $this->db->sql_escape($this->user->session_id) . "'";
	}

	/**
	 * @param string $glue
	 * @param string $last_glue
	 * @param string $prefix
	 * @param string $postfix
	 * @param array $array
	 * @return string
	 */
	public function implode_ex($glue, $last_glue, $prefix, $postfix, array $array)
	{
		switch (sizeof($array))
		{
			case 0:
				return '';
			case 1:
				return $prefix . array_pop($array) . $postfix;
			case 2:
				return $prefix . implode($postfix . $last_glue . $prefix, $array) . $postfix;
			default:
				$last = array_pop($array);
				return $prefix . implode($postfix . $glue . $prefix, $array) . $postfix . $last_glue . $prefix . $last . $postfix;
		}
	}

	/**
	 * @param array $usernames
	 * @param array $user_types
	 * @return array
	 */
	public function load_users_by_username($usernames, $user_types = [])
	{
		$usernames = array_filter(array_map('utf8_clean_string', $usernames));

		if (!$usernames)
		{
			return [];
		}

		$sql_where = [
			$this->db->sql_in_set('username_clean', $usernames),
		];

		if ($user_types)
		{
			$sql_where[] = $this->db->sql_in_set('user_type', $user_types);
		}

		$sql_array = [
			'SELECT'	=> 'u.*',
			'FROM'		=> [$this->table_users => 'u'],
			'WHERE'		=> implode(' AND ', $sql_where),
		];

		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$usernames = $this->get_sql_rows($sql, 0, 0, 0, 'user_id');

		uasort($usernames, function($a, $b)
		{
			strcmp($a['username'], $b['username']);
		});

		return $usernames;
	}

	/**
	 * @param string $sql
	 * @param int $total
	 * @param int $offset
	 * @param int $cache_ttl
	 * @param string|bool $key
	 * @param string|bool $column
	 * @return array
	 */
	protected function get_sql_rows($sql, $total = 0, $offset = 0, $cache_ttl = 0, $key = false, $column = false)
	{
		$result = $this->db->sql_query_limit($sql, $total, $offset, $cache_ttl);
		$db_rows = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		$rows = [];

		foreach ($db_rows as $row)
		{
			$value = $column === false ? $row : $row[$column];

			if ($key === false)
			{
				$rows[] = $value;
			}
			else
			{
				$rows[$row[$key]] = $value;
			}
		}

		return $rows;
	}
}
