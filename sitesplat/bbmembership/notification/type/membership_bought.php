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

class membership_bought extends \phpbb\notification\type\base
{
	/**
	* {@inheritdoc}
	*/
	public function get_type()
	{
		return 'sitesplat.bbmembership.notification.type.membership_bought';
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
		'group'	=> 'NOTIFICATION_GROUP_ADMINISTRATION',
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
		return ($this->auth->acl_get('a_user') && $this->config['require_activation'] == USER_ACTIVATION_ADMIN);
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
		$options = array_merge(array(
			'ignore_users'	=> array(),
		), $options);

		// Grab admins that have permission to administer users.
		$admin_ary = $this->auth->acl_get_list(false, 'a_user', false);
		$users = (!empty($admin_ary[0]['a_user'])) ? $admin_ary[0]['a_user'] : array();

		// Grab founders
		$sql = 'SELECT user_id
			FROM ' . USERS_TABLE . '
			WHERE user_type = ' . USER_FOUNDER;
		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$users[] = (int) $row['user_id'];
		}
		$this->db->sql_freeresult($result);

		if (empty($users))
		{
			return array();
		}
		$users = array_unique($users);

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
		$username = $this->user_loader->get_username($this->get_data('user_id'), 'no_profile');
		return $this->user->lang('MEMBERSHIP_NOTIFICATION_BOUGHT', $username, $this->get_data('amount'));

	}

	/**
	* {@inheritdoc}
	*/
	public function get_email_template()
	{
		return '';
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
		$this->set_data('txn_id', $data['txn_id']);
		$this->set_data('user_id', $data['user_id']);
		$this->set_data('amount', $data['amount']);

		parent::create_insert_array($data, $pre_create_data);
	}
}
