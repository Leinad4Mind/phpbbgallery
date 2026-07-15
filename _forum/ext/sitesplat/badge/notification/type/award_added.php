<?php
/**
*
* BBAwards extension for the phpBB Forum Software package.
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\badge\notification\type;

class award_added extends \phpbb\notification\type\base
{
	/**
	 * {@inheritdoc}
	 */
	public function get_type()
	{
		return 'sitesplat.badge.notification.type.award_added';
	}

	/**
	* Language key used to output the text
	*
	* @var string
	*/
	protected $language_key = 'NOTIFICATION_BADGE';

	/**
	* Notification option data (for outputting to the user)
	*
	* @var bool|array False if the service should use it's default data
	* 					Array of data (including keys 'id', 'lang', and 'group')
	*/
	static public $notification_option = array(
		'lang'	=> 'NOTIFICATION_TYPE_AWARD_ADDED',
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
		return (int) $data['rule_id'];
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
		$users = array();

		$data['user_ids'] = (!is_array($data['user_ids'])) ? array($data['user_ids']) : $data['user_ids'];

		foreach ($data['user_ids'] as $user_id)
		{
			$users[$user_id] = $user_id;
		}

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
		return $this->user->lang('BADGE_NOTIFICATION_EVENT_ADDED', $this->user->lang[$this->get_data('rule_name')]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_url()
	{
		$url = generate_board_url();
		
		return append_sid($url . '/app.php/badge/index.html', "u={$this->user_id}");
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
		$this->set_data('rule_name', $data['rule_name']);

		parent::create_insert_array($data, $pre_create_data);
	}
}
