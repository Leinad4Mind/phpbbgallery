<?php
/**
*
* BBAwards extension for the phpBB Forum Software package.
*
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
			$users[$user_id] = array('');
		}

		return $users;
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
		return append_sid($this->root_path . 'badge/index.html', "u={$this->user_id}");
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

		return parent::create_insert_array($data, $pre_create_data);
	}
}
