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

namespace leinad4mind\invitation\notification\type;

use leinad4mind\invitation\ext;
use phpbb\notification\type\base;
use phpbb\user_loader;

class petition_request extends base
{
	/** @var user_loader */
	protected $user_loader;

	/**
	 * @param user_loader $user_loader
	 */
	public function set_user_loader(user_loader $user_loader)
	{
		$this->user_loader = $user_loader;
	}

	/**
	 * Get notification type name
	 *
	 * @return string
	 */
	public function get_type()
	{
		return 'leinad4mind.invitation.notification.type.petition_request';
	}

	/**
	 * Notification option data (for outputting to the user)
	 *
	 * @var bool|array False if the service should use it's default data
	 * 					Array of data (including keys 'id', 'lang', and 'group')
	 */
	public static $notification_option = array(
		'lang' => 'NOTIFICATION_TYPE_INVITE_PETITION_REQUEST',
		'group' => 'NOTIFICATION_GROUP_MISCELLANEOUS',
	);

	/**
	 * Is this type available to the current user (defines whether or not it will be shown in the UCP Edit notification options)
	 *
	 * @return bool True/False whether or not this is available to the user
	 */
	public function is_available()
	{
		return $this->auth->acl_get('a_meghivo_igeny') || $this->auth->acl_get('m_meghivo_igeny');
	}

	/**
	 * Get the id of the notification
	 *
	 * @param array $data The type specific data
	 *
	 * @return int Id of the notification
	 */
	public static function get_item_id($data)
	{
		return $data['invite_notification_id'];
	}

	/**
	 * Get the id of the parent
	 *
	 * @param array $data The type specific data
	 *
	 * @return int Id of the parent
	 */
	public static function get_item_parent_id($data)
	{
		return 0;
	}

	/**
	 * Find the users who want to receive notifications
	 *
	 * @param array $data The type specific data
	 * @param array $options Options for finding users for notification
	 * 		ignore_users => array of users and user types that should not receive notifications from this type because they've already been notified
	 * 						e.g.: array(2 => array(''), 3 => array('', 'email'), ...)
	 *
	 * @return array
	 */
	public function find_users_for_notification($data, $options = array())
	{
		$users = $data['petition_request_notify_ids'];
		$this->user_loader->load_users($users);
		return $this->check_user_notification_options($users, $options);
	}

	/**
	 * Users needed to query before this notification can be displayed
	 *
	 * @return array Array of user_ids
	 */
	public function users_to_query()
	{
		return array($this->get_data('petition_request_user_id'));
	}

	/**
	* Get the user's avatar
	*
	* @return string
	*/
	public function get_avatar()
	{
		return $this->user_loader->get_avatar($this->get_data('petition_request_user_id'), false, true);
	}

	/**
	 * Get the HTML formatted title of this notification
	 *
	 * @return string
	 */
	public function get_title()
	{
		$username_full = $this->user_loader->get_username($this->get_data('petition_request_user_id'), 'no_profile');
		return $this->language->lang('MEGHIVO_PETITION_REQUEST', $username_full, $this->get_data('petition_request_count'));
	}

	/**
	 * Get the url to this item
	 *
	 * @return string URL
	 */
	public function get_url()
	{
		if ($this->auth->acl_get('a_meghivo_igeny'))
		{
			return append_sid($this->phpbb_root_path . 'adm/index.' . $this->php_ext, array('i' => ext::get_module_id('acp'), 'mode' => 'igeny'), true, $this->user->session_id);
		}
		else if ($this->auth->acl_get('m_meghivo_igeny'))
		{
			return append_sid($this->phpbb_root_path . 'mcp.' . $this->php_ext, array('i' => ext::get_module_id('mcp'), 'mode' => 'jovahagyas'), true, $this->user->session_id);
		}

		return '';
	}

	/**
	 * Get email template
	 *
	 * @return string|bool
	 */
	public function get_email_template()
	{
		return false;
	}

	/**
	 * Get email template variables
	 *
	 * @return array
	 */
	public function get_email_template_variables()
	{
		return array();
	}

	/**
	 * Function for preparing the data for insertion in an SQL query
	 * (The service handles insertion)
	 *
	 * @param array $data The type specific data
	 * @param array $pre_create_data Data from pre_create_insert_array()
	 *
	 * @return array Array of data ready to be inserted into the database
	 */
	public function create_insert_array($data, $pre_create_data = array())
	{
		$this->set_data('petition_request_user_id', $data['petition_request_user_id']);
		$this->set_data('petition_request_count', $data['petition_request_count']);
		$this->set_data('petition_request_notify_ids', $data['petition_request_notify_ids']);

		parent::create_insert_array($data, $pre_create_data);
	}
}
