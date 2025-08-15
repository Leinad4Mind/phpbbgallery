<?php
/**
*
* BBmembership extension for the phpBB Forum Software package.
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbmembership\notification\type;

/**
* BBmembership notifications class
* This class handles notifications for users
*/

class membership_expiring extends \phpbb\notification\type\base
{
	/**
	* {@inheritdoc}
	*/
	public function get_type()
	{
		return 'sitesplat.bbmembership.notification.type.membership_expiring';
	}

	/**
	* {@inheritdoc}
	*/
	protected $language_key = 'NOTIFICATION_BBMEMBERSHIP';

	/**
	* {@inheritdoc}
	*/
	public static $notification_option = array(
		'lang'	=> 'NOTIFICATION_TYPE_BBMEMBERSHIP',
		'group'	=> 'NOTIFICATION_GROUP_MISCELLANEOUS',
	);

	/** @var \phpbb\user_loader */
	protected $user_loader;

	/** @var \phpbb\config\config */
	protected $config;

	public function set_config(\phpbb\config\config $config)
	{
		$this->config = $config;
	}

	public function set_user_loader(\phpbb\user_loader $user_loader)
	{
		$this->user_loader = $user_loader;
	}

	/**
	* {@inheritdoc}
	*/
	public function is_available()
	{
		return true;
	}

	/**
	* {@inheritdoc}
	*/
	public static function get_item_id($data)
	{
		return (int) $data['txn_id'];
	}

	/**
	* {@inheritdoc}
	*/
	public static function get_item_parent_id($post)
	{
		return 0;
	}

	/**
	* {@inheritdoc}
	*/
	public function find_users_for_notification($data, $options = array())
	{
		$users = array($data['user_id']);
		return $this->check_user_notification_options($users, $options);
	}

	/**
	* {@inheritdoc}
	*/
	public function get_avatar()
	{
		return $this->user_loader->get_avatar($this->get_data('user_id'), true, false);
	}

	/**
	* {@inheritdoc}
	*/
	public function get_title()
	{
		$this->user_loader->load_users(array($this->get_data('user_id')));

		return $this->user->lang('MEMBERSHIP_NOTIFICATION_EXPIRING', $this->user_loader->get_username($this->get_data('user_id'), 'no_profile'));
	}

	/**
	* {@inheritdoc}
	*/
	public function get_email_template()
	{
		return false;
	}

	/**
	* {@inheritdoc}
	*/
	public function get_email_template_variables()
	{
		return array();
	}

	/**
	* {@inheritdoc}
	*/
	public function get_url()
	{
		return '';
	}

	/**
	* {@inheritdoc}
	*/
	public function users_to_query()
	{
		return array();
	}

	/**
	* {@inheritdoc}
	*/
	public function create_insert_array($data, $pre_create_data = array())
	{
		$this->set_data('user_id', $data['user_id']);

		parent::create_insert_array($data, $pre_create_data);
	}
}
