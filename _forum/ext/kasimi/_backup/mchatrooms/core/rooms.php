<?php

/**
 *
 * @package phpBB Extension - mChat Rooms Addon
 * @copyright (c) 2016 kasimi - https://kasimi.net
 * @license proprietary
 *
 */

namespace kasimi\mchatrooms\core;

use dmzx\mchat\core\mchat;
use dmzx\mchat\core\settings;
use phpbb\auth\auth;
use phpbb\controller\helper;
use phpbb\event\data;
use phpbb\exception\http_exception;
use phpbb\language\language;
use phpbb\passwords\manager as passwords_manager;
use phpbb\request\request;
use phpbb\template\template;
use phpbb\user;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class rooms
{
	/** @var functions */
	protected $functions;

	/** @var user */
	protected $user;

	/** @var language */
	protected $lang;

	/** @var request */
	protected $request;

	/** @var auth */
	protected $auth;

	/** @var template */
	protected $template;

	/** @var passwords_manager */
	protected $passwords_manager;

	/** @var helper */
	protected $helper;

	/** @var mchat */
	protected $mchat;

	/** @var settings */
	protected $mchat_settings;

	/** @var int */
	private $room_id = constants::LOBBY_ID;

	/** @var string */
	private $page = '';

	/**
	 * Constructor
	 *
	 * @param functions				$functions
	 * @param user					$user
	 * @param language				$lang
	 * @param request				$request
	 * @param auth					$auth
	 * @param template				$template
	 * @param passwords_manager		$passwords_manager
	 * @param helper				$helper
	 * @param mchat					$mchat
	 * @param settings				$mchat_settings
	 */
	public function __construct(
		functions $functions,
		user $user,
		language $lang,
		request $request,
		auth $auth,
		template $template,
		passwords_manager $passwords_manager,
		helper $helper,
		mchat $mchat = null,
		settings $mchat_settings = null
	)
	{
		$this->functions			= $functions;
		$this->user					= $user;
		$this->lang					= $lang;
		$this->request				= $request;
		$this->auth					= $auth;
		$this->template				= $template;
		$this->passwords_manager	= $passwords_manager;
		$this->helper				= $helper;
		$this->mchat				= $mchat;
		$this->mchat_settings		= $mchat_settings;
	}

	/**
	 * Creates a new room
	 *
	 * @return JsonResponse
	 */
	public function action_create()
	{
		$this->check_request([
			constants::REQUEST_FORCE_AJAX,
		]);

		$new_room = [
			'user_id'			=> (int) $this->user->data['user_id'],
			'room_name'			=> utf8_substr($this->request->variable('name', '', true), 0, 64),
			'room_password'		=> '',
			'room_type'			=> $this->request->variable('type', -1),
			'room_owner_invite'	=> $this->auth->acl_get('u_mchatrooms_invite') && $this->request->variable('owner_invite', false),
		];

		if (!$this->can_create_room($new_room['room_type']))
		{
			throw new http_exception(403, 'NO_AUTH_OPERATION');
		}

		if ($new_room['room_type'] == constants::ROOM_TYPE_PROTECTED)
		{
			$password = $this->request->variable('password', '', true);
			$password_confirm = $this->request->variable('password_confirm', '', true);

			if ($password !== $password_confirm)
			{
				throw new http_exception(403, 'MCHATROOMS_PASSWORD_MISMATCH');
			}

			if ($password === '')
			{
				throw new http_exception(403, 'MCHATROOMS_PASSWORD_EMPTY');
			}

			$new_room['room_password'] = $this->passwords_manager->hash($password);
		}

		$max_global_rooms = $this->mchat_settings->cfg('mchat_max_rooms');

		if ($max_global_rooms && $this->functions->num_rooms() >= $max_global_rooms)
		{
			throw new http_exception(403, 'MCHATROOMS_CREATE_LIMIT_ERROR');
		}

		$max_private_rooms = $this->mchat_settings->cfg('mchat_max_private_rooms');

		if ($new_room['room_type'] == constants::ROOM_TYPE_PRIVATE && $max_private_rooms && $this->functions->num_private_room_sessions() >= $max_private_rooms)
		{
			throw new http_exception(403, 'MCHATROOMS_PRIVATE_CREATE_LIMIT_ERROR');
		}

		$rooms = $this->functions->create_room($new_room);

		$this->assign_global_template_data();
		$this->assign_rooms_template_data($rooms);

		return new JsonResponse([
			'room_create'	=> true,
			'room'			=> $this->mchat->render_template('mchatrooms_rooms.html'),
		]);
	}

	/**
	 * Fetches initial messages for a room
	 *
	 * @return JsonResponse
	 */
	public function action_enter()
	{
		$room = $this->check_request([
			constants::REQUEST_FORCE_AJAX,
			constants::REQUEST_NEED_ROOM_ID,
			constants::REQUEST_NEED_ROOM_DATA,
			constants::REQUEST_NEED_ROOM_SESSIONS,
		]);

		$is_authed = $this->validate_session($room);

		$response = [
			'room_enter'					=> true,
			'room_enter_password_required'	=> !$is_authed,
		];

		if ($is_authed)
		{
			$max_private_rooms = $this->mchat_settings->cfg('mchat_max_private_rooms');

			if ($room['room_type'] == constants::ROOM_TYPE_PRIVATE && $max_private_rooms && $this->functions->num_private_room_sessions() >= $max_private_rooms)
			{
				throw new http_exception(403, 'MCHATROOMS_PRIVATE_JOIN_LIMIT_ERROR');
			}

			$this->lang->add_lang('mchat', 'dmzx/mchat');

			$this->set_page($this->request->variable('page', ''));

			// Temporarily disable live updates to save a query to the mchat_log table when fetching messages
			$this->mchat_settings->set_cfg('mchat_live_updates', 0, true);

			$response = array_merge($response, $this->mchat->action_refresh(true));
		}

		return new JsonResponse($response);
	}

	/**
	 * Edits a room
	 *
	 * @return JsonResponse
	 */
	public function action_edit()
	{
		$room = $this->check_request([
			constants::REQUEST_FORCE_AJAX,
			constants::REQUEST_ALLOW_LOBBY,
			constants::REQUEST_NEED_ROOM_ID,
			constants::REQUEST_NEED_ROOM_DATA,
			constants::REQUEST_NEED_ROOM_SESSIONS,
		]);

		$room_id = $room['room_id'];

		$new_room = [
			'room_name'			=> utf8_substr($this->request->variable('name', '', true), 0, 64),
			'room_owner_invite'	=> $room_id != constants::LOBBY_ID && $this->auth->acl_get('u_mchatrooms_invite') && $this->request->variable('owner_invite', false),
		];

		if ($new_room['room_name'] === '')
		{
			throw new http_exception(403, 'NO_AUTH_OPERATION');
		}

		$is_lobby = $room_id === constants::LOBBY_ID;
		$is_own_room = $room['user_id'] == $this->user->data['user_id'];
		$is_protected = $room['room_type'] == constants::ROOM_TYPE_PROTECTED;

		if (!$this->auth->acl_get('u_mchatrooms_edit_all') && (!$is_own_room || !$this->auth->acl_get('u_mchatrooms_edit_own')) || ($is_protected && !$this->auth->acl_get('u_mchatrooms_protected')))
		{
			throw new http_exception(403, 'NO_AUTH_OPERATION');
		}

		if ($is_protected)
		{
			$current_password = $this->request->variable('current_password', '', true);

			if (!$this->auth->acl_get('u_mchatrooms_masterkey') && !$this->passwords_manager->check($current_password, $room['room_password']))
			{
				throw new http_exception(403, 'MCHATROOMS_PASSWORD_WRONG');
			}

			$new_password = $this->request->variable('new_password', '', true);

			if (!$is_lobby && $new_password !== '')
			{
				$new_password_confirm = $this->request->variable('new_password_confirm', '', true);

				if ($new_password !== $new_password_confirm)
				{
					throw new http_exception(403, 'MCHATROOMS_PASSWORD_MISMATCH');
				}

				if ($new_password !== $current_password)
				{
					// Remove all sessions except for the one of the current user
					$this->functions->delete_room_sessions($room_id, $this->user->data['user_id'], true);
				}

				$new_room['room_password'] = $this->passwords_manager->hash($new_password);
			}
		}

		$this->functions->edit_room($room_id, $new_room);

		$this->assign_global_template_data();
		$this->assign_rooms_template_data([
			$room_id => array_merge($room, $new_room),
		]);

		return new JsonResponse([
			'room_edit' => true,
			'room'		=> $this->mchat->render_template('mchatrooms_rooms.html'),
		]);
	}

	/**
	 * Deletes a room and all its messages
	 *
	 * @return JsonResponse
	 */
	public function action_del()
	{
		$room = $this->check_request([
			constants::REQUEST_FORCE_AJAX,
			constants::REQUEST_NEED_ROOM_ID,
			constants::REQUEST_NEED_ROOM_DATA,
		]);

		$room_id = $room['room_id'];

		$is_own_room = $room['user_id'] == $this->user->data['user_id'];

		if (!$this->auth->acl_get('u_mchatrooms_delete_all') && (!$is_own_room || !$this->auth->acl_get('u_mchatrooms_delete_own')))
		{
			throw new http_exception(403, 'NO_AUTH_OPERATION');
		}

		if ($room['room_type'] == constants::ROOM_TYPE_PROTECTED)
		{
			if (!$this->auth->acl_get('u_mchatrooms_protected'))
			{
				throw new http_exception(403, 'MCHATROOMS_NOT_EXIST');
			}

			if (!$this->auth->acl_get('u_mchatrooms_masterkey'))
			{
				$supplied_password = $this->request->variable('password', '', true);

				if (!$this->passwords_manager->check($supplied_password, $room['room_password']))
				{
					throw new http_exception(403, 'MCHATROOMS_PASSWORD_WRONG');
				}
			}
		}

		$this->functions->delete_room($room_id);

		return new JsonResponse([
			'room_del' => true,
		]);
	}

	/**
	 * Removes the current user from the room's active sessions
	 *
	 * @return JsonResponse
	 */
	public function action_leave()
	{
		$room_id = $this->check_request([
			constants::REQUEST_FORCE_AJAX,
			constants::REQUEST_NEED_ROOM_ID,
		]);

		$this->functions->delete_room_sessions($room_id, $this->user->data['user_id']);

		return new JsonResponse([
			'room_leave' => true,
		]);
	}

	/**
	 * Updates the sorting of the rooms for the current user
	 *
	 * @return JsonResponse
	 */
	public function action_kick()
	{
		$room = $this->check_request([
			constants::REQUEST_FORCE_AJAX,
			constants::REQUEST_NEED_ROOM_SESSIONS,
			constants::REQUEST_NEED_ROOM_ID,
			constants::REQUEST_NEED_ROOM_DATA,
		]);

		if ($this->functions->get_session_status($room) != constants::SESSION_ACTIVE)
		{
			throw new http_exception(403, 'NO_AUTH_OPERATION');
		}

		$user_id = $this->request->variable('user', 0);

		if ($this->is_kickable($room, $user_id))
		{
			$this->functions->delete_room_sessions($room['room_id'], $user_id);
		}

		return new JsonResponse([
			'room_kick'	=> true,
		]);
	}

	/**
	 * Sends a notification to all given users
	 *
	 * @return JsonResponse
	 */
	public function action_invite()
	{
		$room = $this->check_request([
			constants::REQUEST_FORCE_AJAX,
			constants::REQUEST_ALLOW_LOBBY,
			constants::REQUEST_NEED_ROOM_ID,
			constants::REQUEST_NEED_ROOM_DATA,
		]);

		if (!$this->auth->acl_get('u_mchatrooms_invite') || $room['room_owner_invite'] && $room['user_id'] != $this->user->data['user_id'])
		{
			throw new http_exception(403, 'NO_AUTH_OPERATION');
		}

		$usernames = $this->request->variable('usernames', '', true);
		$message = $this->request->variable('message', '', true);
		$message = utf8_substr($message, 0, 255);
		$invited_users = $this->invite_users($room, $usernames, $message);

		$invited_usernames = [];
		foreach ($invited_users as $invited_user)
		{
			$invited_usernames[] = $invited_user['username'];
		}

		$usernames_joined = $this->functions->implode_ex($this->lang->lang('COMMA_SEPARATOR'), $this->lang->lang('MCHATROOMS_AND'), '<strong>', '</strong>', $invited_usernames);

		return new JsonResponse([
			'room_invite'	=> true,
			'title'			=> $this->lang->lang('MCHATROOMS_USERS_INVITED_TITLE', sizeof($invited_users)),
			'message'		=> $this->lang->lang('MCHATROOMS_USERS_INVITED_MESSAGE', $usernames_joined, '<strong>' . $room['room_name'] . '</strong>'),
		]);
	}

	/**
	 * Fetches the users currently present in a room
	 *
	 * @return JsonResponse
	 */
	public function action_users()
	{
		$room = $this->check_request([
			constants::REQUEST_FORCE_AJAX,
			constants::REQUEST_NEED_ROOM_SESSIONS,
			constants::REQUEST_NEED_ROOM_ID,
			constants::REQUEST_NEED_ROOM_DATA,
		]);

		if ($this->functions->get_session_status($room) != constants::SESSION_ACTIVE)
		{
			throw new http_exception(403, 'NO_AUTH_OPERATION');
		}

		$room_users = $this->functions->get_room_users($room['room_id'], $room['room_type']);

		foreach ($room_users as $room_user_id => $room_user)
		{
			$username_line = [$this->get_username_string('full', $room_user['user_id'], $room_user['username'], $room_user['user_colour'])];

			if (!is_null($room_user['join_time']))
			{
				$username_line[] = $this->lang->lang('MCHATROOMS_JOINED_TIME', (int) $room_user['join_time'], $this->user->format_date($room_user['join_time']));
			}

			$this->template->assign_block_vars('mchatroom_users', [
				'USER_ID'		=> $room_user_id,
				'USER_NAME'		=> implode($this->lang->lang('COMMA_SEPARATOR'), $username_line),
				'IS_KICKABLE'	=> $this->is_kickable($room, $room_user_id),
				'ROOM_ID'		=> $room['room_id']
			]);
		}

		return new JsonResponse([
			'room_users'	=> true,
			'title'			=> $this->lang->lang('MCHATROOMS_USERS', sizeof($room_users), $room['room_name']),
			'message'		=> $this->mchat->render_template('mchatrooms_users.html'),
		]);
	}

	/**
	 * Updates the sorting of the rooms for the current user
	 *
	 * @return JsonResponse
	 */
	public function action_sort()
	{
		$rooms = $this->check_request([
			constants::REQUEST_FORCE_AJAX,
			constants::REQUEST_NEED_ROOM_DATA,
		]);

		$old_room_ids = array_keys($rooms);
		$new_room_ids = $this->request->variable('sort', [0]);

		if (!$this->auth->acl_get('u_mchatrooms_sort') || array_diff($old_room_ids, $new_room_ids))
		{
			throw new http_exception(403, 'NO_AUTH_OPERATION');
		}

		foreach ($old_room_ids as $i => $old_room_id)
		{
			if ($old_room_id != $new_room_ids[$i])
			{
				$this->functions->edit_room($new_room_ids[$i], [
					'room_sort' => $rooms[$old_room_id]['room_sort'],
				]);
			}
		}

		return new JsonResponse([
			'room_sort' => true,
		]);
	}

	/**
	 * @param int $room_id
	 * @return Response
	 */
	public function page_archive($room_id)
	{
		if ($room_id == constants::LOBBY_ID)
		{
			redirect($this->get_archive_url(constants::LOBBY_ID));
		}

		$this->room_id = $room_id;

		return $this->mchat->page_archive();
	}

	/**
	 * Assigns the rooms & other data to the template
	 *
	 * @param string $page
	 */
	public function assign_rooms($page)
	{
		if (!$this->can_view_rooms())
		{
			return;
		}

		// Allow guests to enter rooms even if they don't have u_mchat_use permission
		if (!$this->auth->acl_get('u_mchat_use'))
		{
			add_form_key('mchat', '_DMZX_MCHAT');
		}

		$this->set_page($page);

		// Handle invite before fetching rooms
		$invite_id = $this->request->variable('invite', 0);

		$this->template->assign_vars([
			'MCHATROOMS_INVITE_ID'		=> $invite_id,
			'MCHATROOMS_INVITE_ROOM_ID'	=> $this->functions->get_room_id_from_invite($invite_id),
		]);

		$request_options = [
			constants::REQUEST_ALLOW_LOBBY,
			constants::REQUEST_NEED_ROOM_DATA,
			constants::REQUEST_NEED_ROOM_SESSIONS,
		];

		if ($page === 'archive')
		{
			if (!$this->request->is_set_post('password'))
			{
				$request_options[] = constants::REQUEST_SKIP_FORM_KEY;
			}
		}
		else
		{
			$request_options[] = constants::REQUEST_SKIP_ACL;
			$request_options[] = constants::REQUEST_SKIP_FORM_KEY;
		}

		$rooms = $this->check_request($request_options);

		if (empty($rooms[$this->room_id]))
		{
			throw new http_exception(403, 'MCHATROOMS_NOT_EXIST');
		}

		$this->assign_rooms_template_data($rooms);

		$latest_ids = $page !== 'archive' ? $this->functions->latest_message_ids($rooms) : [];
		$this->template->assign_var('MCHATROOMS_LATEST_MESSAGE_IDS', json_encode($latest_ids, JSON_FORCE_OBJECT | JSON_HEX_APOS));

		if ($page === 'archive')
		{
			if (!$this->validate_session($rooms[$this->room_id]))
			{
				throw new http_exception(403, 'NO_AUTH_OPERATION');
			}
		}
		else
		{
			$actions = array_keys(array_filter([
				'enter'		=> true,
				'create'	=> $this->auth->acl_get('u_mchatrooms_create') || $this->auth->acl_get('u_mchatrooms_create_private'),
				'invite'	=> $this->auth->acl_get('u_mchatrooms_invite'),
				'kick'		=> $this->auth->acl_get('u_mchatrooms_kick'),
				'sort'		=> $this->auth->acl_get('u_mchatrooms_sort'),
				'edit'		=> $this->auth->acl_get('u_mchatrooms_edit_own') || $this->auth->acl_get('u_mchatrooms_edit_all'),
				'del'		=> $this->auth->acl_get('u_mchatrooms_delete_own') || $this->auth->acl_get('u_mchatrooms_delete_all'),
				'users'		=> true,
				'leave'		=> true,
			]));

			foreach ($actions as $action)
			{
				$this->template->assign_block_vars('mchatroomsurl', [
					'ACTION'	=> $action,
					'URL'		=> $this->helper->route('kasimi_mchatrooms_action_' . $action),
				]);
			}
		}
	}

	/**
	 *
	 */
	public function assign_global_template_data()
	{
		if (!$this->can_view_rooms())
		{
			return;
		}

		$this->template->assign_vars([
			'MCHATROOMS_LOBBY_ID'				=> constants::LOBBY_ID,
			'MCHATROOMS_ALLOW_VIEW'				=> true,
			'MCHATROOMS_ALLOW_CREATE'			=> $this->can_create_room(constants::ROOM_TYPE_NORMAL),
			'MCHATROOMS_ALLOW_CREATE_PROTECTED'	=> $this->can_create_room(constants::ROOM_TYPE_PROTECTED),
			'MCHATROOMS_ALLOW_CREATE_PRIVATE'	=> $this->can_create_room(constants::ROOM_TYPE_PRIVATE),
			'MCHATROOMS_ALLOW_INVITE'			=> $this->auth->acl_get('u_mchatrooms_invite'),
			'MCHATROOMS_ALLOW_EDIT_OWN'			=> $this->auth->acl_get('u_mchatrooms_edit_own'),
			'MCHATROOMS_ALLOW_EDIT_ALL'			=> $this->auth->acl_get('u_mchatrooms_edit_all'),
			'MCHATROOMS_ALLOW_DEL_OWN'			=> $this->auth->acl_get('u_mchatrooms_delete_own'),
			'MCHATROOMS_ALLOW_DEL_ALL'			=> $this->auth->acl_get('u_mchatrooms_delete_all'),
			'MCHATROOMS_ALLOW_PROTECTED'		=> $this->auth->acl_get('u_mchatrooms_protected'),
			'MCHATROOMS_ALLOW_SORT'				=> $this->auth->acl_get('u_mchatrooms_sort'),
			'MCHATROOMS_MASTERKEY'				=> $this->auth->acl_get('u_mchatrooms_masterkey'),
			'MCHATROOMS_INVITE_EXPIRE_MINUTES'	=> (int) $this->mchat_settings->cfg('mchat_invite_expiration'),
		]);
	}

	/**
	 * @param array $rooms
	 */
	protected function assign_rooms_template_data($rooms)
	{
		$enter_all = $this->mchat_settings->cfg('mchat_rooms_enter_all');

		foreach ($rooms as $room_id => $room)
		{
			$is_lobby = $room['room_id'] == constants::LOBBY_ID;
			$is_protected = $room['room_type'] == constants::ROOM_TYPE_PROTECTED;
			$is_private = $room['room_type'] == constants::ROOM_TYPE_PRIVATE;

			if (empty($room['user_id']))
			{
				$room['user_id'] = ANONYMOUS;
			}

			$is_own_room = $room['user_id'] == $this->user->data['user_id'];

			$this->template->assign_block_vars('mchatroom', [
				'ID'				=> $room_id,
				'NAME'				=> $this->get_room_name($room, $this->page),
				'TYPE'				=> $room['room_type'],
				'IS_LOBBY'			=> $is_lobby,
				'IS_PROTECTED'		=> $is_protected,
				'IS_PRIVATE'		=> $is_private,
				'IS_ENTERED'		=> $is_lobby || !$is_protected && $enter_all || $this->functions->get_session_status($room) == constants::SESSION_ACTIVE,
				'IS_ACTIVE'			=> $room_id == $this->room_id,
				'USER_ID'			=> $room['user_id'],
				'OWNER'				=> htmlspecialchars($this->get_username_string('full', $room['user_id'], $room['username'], $room['user_colour'])),
				'OWNER_INVITE'		=> $room['room_owner_invite'],
				'ALLOW_INVITE'		=> !$room['room_owner_invite'] || $room['user_id'] == $this->user->data['user_id'],
				'ALLOW_EDIT'		=> ($is_own_room && $this->auth->acl_get('u_mchatrooms_edit_own') || $this->auth->acl_get('u_mchatrooms_edit_all')) && (!$is_protected || $this->auth->acl_get('u_mchatrooms_protected')),
				'ALLOW_DEL'			=> !$is_lobby && ($is_own_room && $this->auth->acl_get('u_mchatrooms_delete_own') || $this->auth->acl_get('u_mchatrooms_delete_all')) && (!$is_protected || $this->auth->acl_get('u_mchatrooms_protected')),
				'ALLOW_LEAVE'		=> !$is_lobby && ($is_protected || !$enter_all),
				'U_ARCHIVE'			=> $this->page === 'archive' ? $this->get_archive_url($room_id) : '',
			]);
		}
	}

	/**
	 * @param string $mode
	 * @param int $user_id
	 * @param string $username
	 * @param string $username_colour
	 * @return string
	 */
	protected function get_username_string($mode, $user_id, $username, $username_colour)
	{
		$username_string = get_username_string($mode, $user_id, $username, $username_colour, $this->lang->lang('GUEST'), false);

		// Fix profile link root path by replacing relative paths with absolute board URL
		if ($this->request->is_ajax())
		{
			$username_string = preg_replace('#(?<=href=")[\./]+?/(?=\w)#', generate_board_url() . '/', $username_string);
		}

		return $username_string;
	}

	/**
	 * @param array $room
	 * @param string $page
	 * @return mixed
	 */
	protected function get_room_name($room, $page)
	{
		if ($page === 'archive')
		{
			switch ($room['room_type'])
			{
				case constants::ROOM_TYPE_PROTECTED:
					return $this->lang->lang('MCHATROOMS_ARCHIVE_PROTECTED', $room['room_name']);
				case constants::ROOM_TYPE_PRIVATE:
					return $this->lang->lang('MCHATROOMS_ARCHIVE_PRIVATE', $room['room_name']);
			}
		}

		return $room['room_name'];
	}

	/**
	 * Modifies mChat's SQL query that fetches messages
	 *
	 * @param data $event
	 */
	public function mchat_get_messages_modify_sql(data $event)
	{
		$latest_lobby_message_id = 0;
		$latest_message_ids = [];

		if (!$this->can_view_rooms())
		{
			$room_id = constants::LOBBY_ID;
		}
		else if (empty($this->page))
		{
			// We are checking for new messages (on refresh or add or editing a message)
			$room_id = false;
			$latest_lobby_message_id = (int) $event['last_id'];
			$latest_message_ids = $this->request->variable('ids', [0 => 0]);
			$latest_message_ids = array_intersect_key($latest_message_ids, $this->functions->get_rooms([], [constants::ROOMS_REQUIRE_PROTECTED_SESSION]));
		}
		else
		{
			$this->page = $this->page !== 'custom' && $this->page !== 'archive' ? 'index' : $this->page;
			$room_id = $this->request->variable('room', (int) $this->room_id);
			$event['total'] = $this->mchat_settings->cfg('mchat_message_num_' . $this->page, true);
		}

		$event['sql_array'] = $this->functions->mchat_get_messages_modify_sql($event['sql_array'], $room_id, $latest_lobby_message_id, $latest_message_ids, $event['message_ids']);
	}

	/**
	 * @param array $user_row
	 * @return bool
	 */
	public function can_view_rooms($user_row = null)
	{
		if ($user_row === null || $user_row['user_id'] == $this->user->data['user_id'])
		{
			$user_row = $this->user->data;
			$auth = $this->auth;
		}
		else
		{
			$auth = $this->get_auth_for_user($user_row);
		}

		return $auth->acl_get('u_mchatrooms_view') && $this->mchat_settings->cfg_user('mchat_rooms_enabled', $user_row, $auth);
	}

	/**
	 * @param int $room_type
	 * @return bool
	 */
	protected function can_create_room($room_type)
	{
		$create_permissions = [
			constants::ROOM_TYPE_NORMAL		=> ['u_mchatrooms_create'],
			constants::ROOM_TYPE_PROTECTED	=> ['u_mchatrooms_create', 'u_mchatrooms_protected'],
			constants::ROOM_TYPE_PRIVATE	=> ['u_mchatrooms_create_private'],
		];

		if (!isset($create_permissions[$room_type]))
		{
			return false;
		}

		foreach ($create_permissions[$room_type] as $permission)
		{
			if (!$this->auth->acl_get($permission))
			{
				return false;
			}
		}

		return true;
	}

	/**
	 * @param array $user_data
	 * @return auth
	 */
	protected function get_auth_for_user($user_data)
	{
		$auth = new auth();
		$auth->acl($user_data);
		return $auth;
	}

	/**
	 * @param array $room
	 * @param string $usernames
	 * @param string $invite_message
	 * @return array
	 */
	protected function invite_users($room, $usernames, $invite_message)
	{
		$request_invitee_usernames = explode("\n", $usernames);
		$invitee_usernames = array_filter(array_map('utf8_clean_string', $request_invitee_usernames));
		$invitee_users = $this->functions->load_users_by_username($invitee_usernames, [USER_NORMAL, USER_FOUNDER]);

		if (!$invitee_users)
		{
			throw new http_exception(404, sizeof($invitee_usernames) == 1 ? 'NO_USER' : 'NO_USERS');
		}

		// Don't invite self
		if (isset($invitee_users[$this->user->data['user_id']]))
		{
			throw new http_exception(403, 'MCHATROOMS_INVITE_SELF');
		}

		$invite_expiration = (int) $this->mchat_settings->cfg('mchat_invite_expiration');
		$max_invites = (int) $this->mchat_settings->cfg('mchat_max_invites');

		// Don't invite more users than allowed
		if ($max_invites && $invite_expiration)
		{
			$inviter_notifications = $this->functions->get_invite_notifications(false, true, false, true, $this->user->data['user_id']);

			$invites_left = max(0, $max_invites - sizeof($inviter_notifications));

			if (sizeof($invitee_users) > $invites_left)
			{
				throw new http_exception(403, 'MCHATROOMS_INVITE_MAX', [$invites_left]);
			}
		}

		// Don't invite a user twice to the same room within the given expiration time
		if ($invite_expiration)
		{
			$active_invite_notifications = $this->functions->get_invite_notifications($room['room_id'], true, array_keys($invitee_users));
			$active_invitee_usernames = [];

			foreach ($active_invite_notifications as $active_invite_notification)
			{
				$active_invitee_usernames[] = $invitee_users[$active_invite_notification['user_id']]['username'];
			}

			$active_invitee_usernames = array_unique($active_invitee_usernames);

			if ($active_invitee_usernames)
			{
				natcasesort($active_invitee_usernames);
				$already_invited_joined = $this->functions->implode_ex($this->lang->lang('COMMA_SEPARATOR'), $this->lang->lang('MCHATROOMS_AND'), '<strong>', '</strong>', $active_invitee_usernames);
				throw new http_exception(403, 'MCHATROOMS_INVITE_ACTIVE', [sizeof($active_invitee_usernames), $already_invited_joined]);
			}
		}

		// Check for unidentifiable users
		if (sizeof($invitee_usernames) != sizeof($invitee_users))
		{
			$unknown_usernames = $request_invitee_usernames;

			foreach ($invitee_usernames as $i => $invitee_username)
			{
				foreach ($invitee_users as $invitee_user)
				{
					if ($invitee_username === $invitee_user['username_clean'])
					{
						unset($unknown_usernames[$i]);
						break;
					}
				}
			}

			$unknown_usernames_joined = $this->functions->implode_ex($this->lang->lang('COMMA_SEPARATOR'), $this->lang->lang('MCHATROOMS_AND'), '<strong>', '</strong>', $unknown_usernames);
			throw new http_exception(404, 'MCHATROOMS_INVITE_NOT_FOUND', [sizeof($unknown_usernames), $unknown_usernames_joined]);
		}

		// Check for users who don't have permission to access rooms
		$no_permissions_usernames = [];

		foreach ($invitee_users as $invitee_user_id => $invitee_user)
		{
			if (!$this->can_view_rooms($invitee_user))
			{
				$no_permissions_usernames[] = $invitee_user['username'];
			}
		}

		if ($no_permissions_usernames)
		{
			natcasesort($no_permissions_usernames);
			$no_permissions_joined = $this->functions->implode_ex($this->lang->lang('COMMA_SEPARATOR'), $this->lang->lang('MCHATROOMS_AND'), '<strong>', '</strong>', $no_permissions_usernames);
			throw new http_exception(403, 'MCHATROOMS_INVITE_NO_ROOMS_PERMISSION', [sizeof($no_permissions_usernames), $no_permissions_joined]);
		}

		$this->functions->add_invite_notifications($room, array_keys($invitee_users), $invite_message);

		return $invitee_users;
	}

	/**
	 * @param array $request_options
	 * @return int|array
	 */
	protected function check_request($request_options)
	{
		if ($this->mchat === null)
		{
			throw new http_exception(404, 'EXTENSION_DISABLED', ['mChat']);
		}

		$this->lang->add_lang('mchatrooms', 'kasimi/mchatrooms');

		$request_options = array_flip($request_options);

		$need_room_id = isset($request_options[constants::REQUEST_NEED_ROOM_ID]);
		$room_id = $need_room_id ? $this->request->variable('room', constants::LOBBY_ID) : [];
		$is_lobby = $need_room_id && $room_id == constants::LOBBY_ID;

		if (!isset($request_options[constants::REQUEST_SKIP_ACL]) && !$this->can_view_rooms())
		{
			throw new http_exception(403, $this->user->data['user_id'] == ANONYMOUS ? 'MCHATROOMS_SESSION_EXPIRED' : 'NO_AUTH_OPERATION');
		}

		if (
			!isset($request_options[constants::REQUEST_ALLOW_LOBBY]) && $is_lobby ||
			!isset($request_options[constants::REQUEST_SKIP_FORM_KEY]) && !check_form_key('mchat', -1) ||
			isset($request_options[constants::REQUEST_FORCE_AJAX]) && !$this->request->is_ajax()
		)
		{
			throw new http_exception(403, 'NO_AUTH_OPERATION');
		}

		// Fix avatars & smilies for mChat < 2.1.1
		if (isset($request_options[constants::REQUEST_FORCE_AJAX]) && !defined('PHPBB_USE_BOARD_URL_PATH') && !method_exists($this->mchat, 'messages_need_reversing'))
		{
			define('PHPBB_USE_BOARD_URL_PATH', true);
		}

		if (isset($request_options[constants::REQUEST_NEED_ROOM_DATA]))
		{
			$rooms = $this->functions->get_rooms($room_id);

			if ($need_room_id && empty($rooms[$room_id]))
			{
				throw new http_exception(403, 'MCHATROOMS_NOT_EXIST');
			}

			return $need_room_id ? $rooms[$room_id] : $rooms;
		}

		return $room_id;
	}

	/**
	 * @param array $room
	 * @return bool
	 */
	protected function validate_session($room)
	{
		$session_status = $this->functions->get_session_status($room);

		if ($session_status != constants::SESSION_ACTIVE)
		{
			if ($room['room_type'] == constants::ROOM_TYPE_PROTECTED)
			{
				if (!$this->auth->acl_get('u_mchatrooms_protected'))
				{
					throw new http_exception(403, 'MCHATROOMS_NOT_EXIST');
				}

				if (!$this->auth->acl_get('u_mchatrooms_masterkey'))
				{
					if (!$this->request->is_set_post('password'))
					{
						return false;
					}

					if (!$this->passwords_manager->check($this->request->variable('password', '', true), $room['room_password']))
					{
						throw new http_exception(403, 'MCHATROOMS_PASSWORD_WRONG');
					}
				}
			}

			if ($room['room_id'] != constants::LOBBY_ID)
			{
				$this->functions->add_room_session($room['room_id'], $session_status == constants::SESSION_EXPIRED);
			}
		}

		return true;
	}

	/**
	 * Returns true if the current user can kick $user_id from $room, otherwise false
	 *
	 * @param array $room Room data to kick user from
	 * @param int $user_id User to kick
	 * @return bool
	 */
	protected function is_kickable(array $room, $user_id)
	{
		// Can't kick without permission
		if (!$this->auth->acl_get('u_mchatrooms_kick'))
		{
			return false;
		}

		// Can't kick from public room
		if ($room['room_type'] == constants::ROOM_TYPE_NORMAL)
		{
			return false;
		}

		// Can't kick from password-protected room without permission
		if ($room['room_type'] == constants::ROOM_TYPE_PROTECTED && !$this->auth->acl_get('u_mchatrooms_protected'))
		{
			return false;
		}

		// Can't kick self or room owner
		if (in_array($user_id, [$room['user_id'], $this->user->data['user_id']]))
		{
			return false;
		}

		return $user_id != ANONYMOUS;
	}

	/**
	 *
	 */
	public function gc_room_sessions()
	{
		$this->functions->gc_room_sessions();
	}

	/**
	 * @param int $room_id
	 * @return string
	 */
	public function get_archive_url($room_id)
	{
		if ($room_id == constants::LOBBY_ID)
		{
			return $this->helper->route('dmzx_mchat_page_archive_controller');
		}

		return $this->helper->route('kasimi_mchatrooms_page_archive_auth', ['room_id' => $room_id]);
	}

	/**
	 * @return int
	 */
	public function get_room_id()
	{
		return $this->room_id;
	}

	/**
	 * @param string $page
	 */
	public function set_page($page)
	{
		$this->page = $page;
	}
}
