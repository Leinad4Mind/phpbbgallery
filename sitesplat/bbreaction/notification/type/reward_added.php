<?php
/**
*
* BBreaction
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbreaction\notification\type;

/**
* BBreaction notification class
*/

class reward_added extends \phpbb\notification\type\base
{
	/**
	* Get notification type name
	*
	* @return string
	*/
	public function get_type()
	{
		return 'sitesplat.bbreaction.notification.type.reward_added';
	}

	/**
	* Language key used to output the text
	*
	* @var string
	*/
	protected $language_key = 'NOTIFICATION_BBREACTIONS';

	/**
	* Notification option data (for outputting to the user)
	*
	* @var bool|array False if the service should use it's default data
	* 					Array of data (including keys 'id', 'lang', and 'group')
	*/
	static public $notification_option = array(
		'lang'	=> 'NOTIFICATION_TYPE_BBREACTIONS_ADD',
		'group'	=> 'NOTIFICATION_GROUP_POSTING',
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
	* Is available
	*/
	public function is_available()
	{
		return true;
	}

	/**
	* Get the id of the item
	*
	* @param array $post The data from the post
	* @return int The post id
	*/
	static public function get_item_id($data)
	{
		return (int) $data['post_id'];
	}

	/**
	* Get the id of the parent
	*
	* @param array $post The data from the post
	* @return int The topic id
	*/
	static public function get_item_parent_id($data)
	{
		return (int) $data['parent_id'];
	}

	/**
	* Find the users who want to receive notifications
	*
	* @param array $post Data from submit_post
	* @param array $options Options for finding users for notification
	*
	* @return array
	*/
	public function find_users_for_notification($data, $options = array())
	{
		$options = array_merge(array(
			'ignore_users'		=> array(),
		), $options);

		$users = array();

		$data['user_ids'] = (!is_array($data['user_ids'])) ? array($data['user_ids']) : $data['user_ids'];

		foreach ($data['user_ids'] as $user_id)
		{
			$users[] = $user_id;
		}

		if (empty($users))
		{
			return array();
		}

		$users = array_unique($users);

		return $this->check_user_notification_options($users, $options);
	}

	/**
	* Get the user's avatar
	*/
	public function get_avatar()
	{
		return $this->user_loader->get_avatar($this->get_data('poster_id'), true, false);
	}

	/**
	* Get the HTML formatted title of this notification
	*
	* @return string
	*/
	public function get_title()
	{
		$sql = 'SELECT username FROM ' . USERS_TABLE . ' WHERE user_id = ' . $this->get_data('poster_id');
		$result = $this->db->sql_query($sql);
		$username = $this->db->sql_fetchfield('username');
		$type1 = (strpos($this->get_data('like_txt'), 'removed') === false) ? 0 : 1;
		
		return $this->user->lang('BBREACTION_NOTI_EVENT_ADDED', (($type1) ? $this->user->lang['REMOVED'] : $this->user->lang['ADDED']), $username);
	}

	/**
	* Get the HTML formatted reference of the notification
	*
	* @return string
	*/
	public function get_reference()
	{
		return ''; //$this->language->lang(
		//	'NOTIFICATION_REFERENCE',
	//		censor_text($this->get_data('topic_title'))
	//	);
	}

	/**
	* Get email template
	*
	* @return string|bool
	*/
	public function get_email_template()
	{
		return '';
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
	* Get the url to this item
	*
	* @return string URL
	*/
	public function get_url()
	{
		return append_sid($this->root_path . 'viewtopic.' . $this->php_ext, 'p=' . $this->get_data('parent_id') . '#p' . $this->get_data('parent_id'));
	}

	/**
	* {inheritDoc}
	*/
	public function get_redirect_url()
	{
		return '';
	}

	/**
	* Users needed to query before this notification can be displayed
	*
	* @return array Array of user_ids
	*/
	public function users_to_query()
	{
		return array();
	}

	/**
	* Trim the user array passed down to 3 users if the array contains
	* more than 4 users.
	*
	* @param array $users Array of users
	* @return array Trimmed array of user_ids
	*/
	public function trim_user_ary($users)
	{
		if (sizeof($users) > 4)
		{
			array_splice($users, 3);
		}
		return $users;
	}

	/**
	* {@inheritdoc}
	*/
	public function create_insert_array($data, $pre_create_data = array())
	{
		$this->set_data('like_txt', $data['like_txt']);
		$this->set_data('poster_id', $data['poster_id']);
		$this->set_data('parent_id', $data['parent_id']);

		return parent::create_insert_array($data, $pre_create_data);
	}
}
