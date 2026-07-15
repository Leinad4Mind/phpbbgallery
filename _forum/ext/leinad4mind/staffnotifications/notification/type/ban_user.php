<?php

/**
 *
 * Staff Notifications. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\staffnotifications\notification\type;

class ban_user extends base
{
	const DURATION_PERMANENTLY	= 0;
	const DURATION_MINUTES		= 1;
	const DURATION_DATE			= 2;

	/**
	 * Group & notification lang keys for UCP options
	 *
	 * @var array
	 */
	public static $notification_option = [
		'group'	=> 'NOTIFICATION_GROUP_STAFFNOTIFICATIONS',
		'lang'	=> 'STAFFNOTIFICATIONS_BAN_USER',
	];

	/**
	 * @param array $data
	 * @return int
	 */
	public static function get_item_id($data)
	{
		return (int) $data['user_id'];
	}

	/**
	* @param array $data
	* @return int
	*/
	public static function get_item_parent_id($data)
	{
		return 0;
	}

	/**
	 * @return string
	 */
	public function get_url()
	{
		return append_sid($this->phpbb_root_path . 'mcp.' . $this->php_ext, [
			'i'		=> 'mcp_ban',
			'mode'	=> 'user',
		]);
	}
}
