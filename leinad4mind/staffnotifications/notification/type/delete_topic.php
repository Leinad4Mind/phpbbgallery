<?php

/**
 *
 * Staff Notifications. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019-2020, Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\staffnotifications\notification\type;

class delete_topic extends base
{
	/**
	 * Group & notification lang keys for UCP options
	 *
	 * @var array
	 */
	public static $notification_option = [
		'group'	=> 'NOTIFICATION_GROUP_STAFFNOTIFICATIONS',
		'lang'	=> 'STAFFNOTIFICATIONS_DELETE_TOPIC',
	];

	/**
	 * @param array $data
	 * @return int
	 */
	public static function get_item_id($data)
	{
		return (int) $data['topic_id'];
	}

	/**
	* @param array $data
	* @return int
	*/
	public static function get_item_parent_id($data)
	{
		return (int) $data['forum_id'];
	}

	/**
	 * @return string
	 */
	public function get_url()
	{
		return append_sid($this->phpbb_root_path . 'viewforum.' . $this->php_ext, [
			'f' => $this->get_data('forum_id'),
		]);
	}
}
