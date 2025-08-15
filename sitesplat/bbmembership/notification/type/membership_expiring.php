<?php
/**
*
* BBmembership extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbmembership\notification\type;

class membership_expiring extends \phpbb\notification\type\base
{
	protected $helper;
	
	public function __construct(\phpbb\user_loader $user_loader, \phpbb\db\driver\driver_interface $db, \phpbb\cache\driver\driver_interface $cache, $user, \phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\controller\helper $helper, $phpbb_root_path, $php_ext, $notification_types_table, $notifications_table, $user_notifications_table)
	{
		$this->helper = $helper;

		parent::__construct($user_loader, $db, $cache, $user, $auth, $config, $phpbb_root_path, $php_ext, $notification_types_table, $notifications_table, $user_notifications_table);
	}


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
	public function is_available()
	{
		return false;
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
	public static function get_item_parent_id($data)
	{
		return 0;
	}

	/**
	 * {@inheritdoc}
	 */
	public function find_users_for_notification($data, $options = array())
	{
		return array($data['user_id'] => array(''));
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
	public function get_title()
	{
		$this->user_loader->load_users(array($this->get_data('user_id')));

		return $this->user->lang('MEMBERSHIP_NOTIFICATION_EXPIRING', $this->user_loader->get_username($this->get_data('user_id'), 'no_profile'));
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_avatar()
	{
		return $this->user_loader->get_avatar($this->get_data('user_id'));
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_url()
	{
		return $this->helper->route('sitesplat_bbmembership_main_controller');
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
	public function create_insert_array($data, $pre_create_data = array())
	{
		$this->set_data('user_id', $data['user_id']);

		return parent::create_insert_array($data, $pre_create_data);
	}
}
