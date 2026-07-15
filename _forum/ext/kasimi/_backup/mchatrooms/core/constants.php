<?php

/**
 *
 * @package phpBB Extension - mChat Rooms Addon
 * @copyright (c) 2016 kasimi - https://kasimi.net
 * @license proprietary
 *
 */

namespace kasimi\mchatrooms\core;

use Symfony\Component\DependencyInjection\ContainerInterface;

class constants
{
	/** @var ContainerInterface */
	protected $container;

	/** @var string */
	public $table_mchat_rooms;

	/** @var string */
	public $table_mchat_rooms_users;

	/** @var string */
	public $table_mchat_rooms_sessions;

	/** @var string */
	public $table_mchat_messages;

	/** @var string */
	public $table_mchat_log;

	/** @const int */
	const LOBBY_ID = 1;

	/** @const string */
	const REQUEST_FORCE_AJAX = 'force_ajax';

	/** @const string */
	const REQUEST_ALLOW_LOBBY = 'allow_lobby';

	/** @const string */
	const REQUEST_NEED_ROOM_ID = 'need_room_id';

	/** @const string */
	const REQUEST_NEED_ROOM_DATA = 'need_room_data';

	/** @const string */
	const REQUEST_NEED_ROOM_SESSIONS = 'need_room_sessions';

	/** @const string */
	const REQUEST_SKIP_ACL = 'skip_acl';

	/** @const string */
	const REQUEST_SKIP_FORM_KEY = 'skip_form_key';

	/** @const string */
	const SESSION_MISSING = 'session_missing';

	/** @const string */
	const SESSION_ACTIVE = 'session_active';

	/** @const string */
	const SESSION_EXPIRED = 'session_expired';

	/** @const string */
	const NOTIFICATION_TYPE_INVITE = 'kasimi.mchatrooms.notification.type.invite';

	/** const int */
	const ROOM_TYPE_NORMAL = 0;

	/** @const int */
	const ROOM_TYPE_PROTECTED = 1;

	/** @const int */
	const ROOM_TYPE_PRIVATE = 2;

	/** @const string */
	const ROOMS_REQUIRE_PROTECTED_SESSION = 'require_protected_session';

	/** @const string */
	const ROOMS_IGNORE_PRIVATE_SESSION = 'ignore_private_session';

	/** @const string */
	const ROOMS_EXCLUDE_PRIVATE_ROOMS = 'exclude_private_rooms';

	/**
	 *  Constructor
	 *
	 * @param ContainerInterface			$container
	 * @param string						$table_mchat_rooms
	 * @param string						$table_mchat_rooms_users
	 * @param string						$table_mchat_rooms_sessions
	 */
	public function __construct(
		ContainerInterface $container,
		$table_mchat_rooms,
		$table_mchat_rooms_users,
		$table_mchat_rooms_sessions
	)
	{
		$this->container					= $container;
		$this->table_mchat_rooms			= $table_mchat_rooms;
		$this->table_mchat_rooms_users		= $table_mchat_rooms_users;
		$this->table_mchat_rooms_sessions	= $table_mchat_rooms_sessions;

		// Parameters (as opposed to services) can't be injected optionally
		// so we need to ask the container for mChat's table names.

		if ($container->hasParameter('dmzx.mchat.table.mchat'))
		{
			$this->table_mchat_messages = $container->getParameter('dmzx.mchat.table.mchat');
		}

		if ($container->hasParameter('dmzx.mchat.table.mchat_log'))
		{
			$this->table_mchat_log = $container->getParameter('dmzx.mchat.table.mchat_log');
		}
	}
}
