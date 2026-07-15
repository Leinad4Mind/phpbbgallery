<?php

/**
 *
 * @package phpBB Extension - mChat Rooms Addon
 * @copyright (c) 2017 kasimi - https://kasimi.net
 * @license proprietary
 *
 */

namespace kasimi\mchatrooms\notification;

use phpbb\auth\auth;
use phpbb\cache\driver\driver_interface as cache_interface;
use phpbb\config\config;
use phpbb\db\driver\driver_interface as db_interface;
use phpbb\language\language;
use phpbb\user;
use phpbb\user_loader;

class factory
{
	/* phpBB 3.1.x constructor arguments */

	/** @var user_loader */
	protected $user_loader;

	/** @var cache_interface */
	protected $cache;

	/** @var config */
	protected $config;

	/** @var string */
	protected $table_notification_types;

	/** @var string */
	protected $table_notifications;

	/* phpBB 3.2.x constructor arguments */

	/** @var db_interface */
	protected $db;

	/** @var user */
	protected $user;

	/** @var auth */
	protected $auth;

	/** @var string */
	protected $root_path;

	/** @var string */
	protected $php_ext;

	/** @var string */
	protected $table_user_notifications;

	/** @var language */
	protected $language;

	/**
	 * Constructor
	 *
	 * @param user_loader		$user_loader
	 * @param cache_interface	$cache
	 * @param config			$config
	 * @param string			$table_notification_types
	 * @param string			$table_notifications
	 * @param db_interface		$db
	 * @param user				$user
	 * @param auth				$auth
	 * @param string			$root_path
	 * @param string			$php_ext
	 * @param string			$table_user_notifications
	 * @param language|null		$language
	 */
	public function __construct(
		user_loader $user_loader,
		cache_interface $cache,
		config $config,
		$table_notification_types,
		$table_notifications,
		db_interface $db,
		user $user,
		auth $auth,
		$root_path,
		$php_ext,
		$table_user_notifications,
		language $language = null
	)
	{
		$this->user_loader					= $user_loader;
		$this->cache						= $cache;
		$this->config						= $config;
		$this->table_notification_types		= $table_notification_types;
		$this->table_notifications			= $table_notifications;
		$this->db							= $db;
		$this->user							= $user;
		$this->auth							= $auth;
		$this->root_path					= $root_path;
		$this->php_ext						= $php_ext;
		$this->table_user_notifications		= $table_user_notifications;
		$this->language						= $language;
	}

	/**
	 * @return invite
	 */
	public function create_invite_notification()
	{
		$invite = null;

		if (phpbb_version_compare(PHPBB_VERSION, '3.2.0@dev', '<'))
		{
			$invite = new invite(
				$this->user_loader,
				$this->db,
				$this->cache,
				$this->user,
				$this->auth,
				$this->config,
				$this->root_path,
				$this->php_ext,
				$this->table_notification_types,
				$this->table_notifications,
				$this->table_user_notifications
			);
		}
		else
		{
			$invite = new invite(
				$this->db,
				$this->language,
				$this->user,
				$this->auth,
				$this->root_path,
				$this->php_ext,
				$this->table_user_notifications
			);
		}

		return $invite;
	}
}
