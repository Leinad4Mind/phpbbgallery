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
use leinad4mind\invitation\includes\functions;
use phpbb\config\config as phpbb_config;
use phpbb\notification\type\base;
use phpbb\user_loader;

class gift extends base
{
	/** @var phpbb_config */
	protected $config;

	/** @var user_loader */
	protected $user_loader;

	/** @var functions */
	protected $functions;

	/**
	 * @param phpbb_config $config
	 */
	public function set_config(phpbb_config $config)
	{
		$this->config = $config;
	}

	/**
	 * @param user_loader $user_loader
	 */
	public function set_user_loader(user_loader $user_loader)
	{
		$this->user_loader = $user_loader;
	}

	/**
	 * @param functions $functions
	 */
	public function set_functions(functions $functions)
	{
		$this->functions = $functions;
	}

	/**
	 * Get notification type name
	 *
	 * @return string
	 */
	public function get_type()
	{
		return 'leinad4mind.invitation.notification.type.gift';
	}

	/**
	 * Notification option data (for outputting to the user)
	 *
	 * @var bool|array False if the service should use it's default data
	 * 					Array of data (including keys 'id', 'lang', and 'group')
	 */
	public static $notification_option = array(
		'lang' => 'NOTIFICATION_TYPE_INVITE_GIFT',
		'group' => 'NOTIFICATION_GROUP_MISCELLANEOUS',
	);

	/**
	 * Is this type available to the current user (defines whether or not it will be shown in the UCP Edit notification options)
	 *
	 * @return bool True/False whether or not this is available to the user
	 */
	public function is_available()
	{
		return true;
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
		$user = array($data['gift_user_id']);
		$this->user_loader->load_users($user);
		return $this->check_user_notification_options($user, $options);
	}

	/**
	 * Users needed to query before this notification can be displayed
	 *
	 * @return array Array of user_ids
	 */
	public function users_to_query()
	{
		return array($this->functions->notification_sender());
	}

	/**
	* Get the user's avatar
	*
	* @return string
	*/
	public function get_avatar()
	{
		return $this->user_loader->get_avatar($this->functions->notification_sender(), false, true);
	}

	/**
	 * Get the HTML formatted title of this notification
	 *
	 * @return string
	 */
	public function get_title()
	{
		$lang_key = $this->get_data('gift_count') > 1 ? 'INVITE_GIFT_INVITED_USERS_FURTHER' : 'INVITE_GIFT_INVITED_USERS_FIRST';
		return $this->language->lang($lang_key, $this->get_data('gift_invited_users'), $this->config['sitename'], $this->get_data('gift_invited_users_invitation'));
	}

	/**
	 * Get the url to this item
	 *
	 * @return string URL
	 */
	public function get_url()
	{
		return append_sid($this->phpbb_root_path . 'ucp.' . $this->php_ext, array('i' => ext::get_module_id('ucp'), 'mode' => 'data'));
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
		$this->set_data('gift_user_id', $data['gift_user_id']);
		$this->set_data('gift_invited_user_id', $data['gift_invited_user_id']);
		$this->set_data('gift_count', $data['gift_count']);
		$this->set_data('gift_invited_users', $data['gift_invited_users']);
		$this->set_data('gift_invited_users_invitation', $data['gift_invited_users_invitation']);

		parent::create_insert_array($data, $pre_create_data);
	}
}
