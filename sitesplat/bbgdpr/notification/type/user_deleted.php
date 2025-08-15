<?php
/**
*
* @package BBgdpr
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*/

namespace sitesplat\bbgdpr\notification\type;

class user_deleted extends \phpbb\notification\type\base
{
	/**
	* Language key used to output the text
	*
	* @var string
	*/
	protected $language_key = 'NOTIFICATION_TYPE_BBGDPR';

	/**
	* Notification option data (for outputting to the user)
	*
	* @var bool|array False if the service should use it's default data
	* 					Array of data (including keys 'id', 'lang', and 'group')
	*/

	public static $notification_option = array(
		'lang'  => 'NOTIFICATION_TYPE_BBGDPR',
		'group' => 'NOTIFICATION_GROUP_MODERATION'
	);
	/**
	 * {@inheritdoc}
	 */
	public function get_type()
	{
		return 'sitesplat.bbgdpr.notification.type.user_deleted';
	}

	/**
	 * {@inheritdoc}
	 */
	public static function get_item_id($data)
	{
		return (int) $data['user_id'];
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
	public function find_users_for_notification($user, $options = array())
	{
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
	public function users_to_query()
	{
		return array();
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_title()
	{
		return $this->language->lang('SITESPLAT_BBGDPR_USER_DELETED', $this->get_data('username'));
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_url()
	{
		return append_sid($this->phpbb_root_path . 'index.' . $this->php_ext);
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
		$this->set_data('username', $data['username']);

		parent::create_insert_array($data, $pre_create_data);
	}
}
