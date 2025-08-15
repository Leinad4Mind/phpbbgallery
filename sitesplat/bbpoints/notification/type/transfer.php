<?php
/**
*
* BBPoints extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbpoints\notification\type;

class transfer extends \phpbb\notification\type\base
{
	/**
	 * {@inheritdoc}
	 */
	public function get_type()
	{
		return 'sitesplat.bbpoints.notification.type.transfer';
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
		return (int) $data['post_id'];
	}

	/**
	 * {@inheritdoc}
	 */
	public static function get_item_parent_id($data)
	{
		return (int) $data['parent_id'];
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
		return $this->get_data('like_txt');
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_url()
	{
		return append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=-sitesplat-bbpoints-ucp-bbpoints_module&mode=bbpoints');
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_email_template()
	{
		return 'bbpoints_notify';
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_email_template_variables()
	{
		return array(
			'AUTHOR_NAME'				=> 1,
			'POST_SUBJECT'				=> 2,
			'TOPIC_TITLE'				=> 3,

			'U_VIEW_POST'				=> 4,
			'U_NEWEST_POST'				=> 5,
			'U_TOPIC'					=> 6,
			'U_VIEW_TOPIC'				=> 7,
			'U_FORUM'					=> 8,
			'U_STOP_WATCHING_TOPIC'		=> 9
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function create_insert_array($data, $pre_create_data = array())
	{
		$this->set_data('like_txt', $data['like_txt']);
		$this->set_data('poster_id', $data['poster_id']);
		$this->set_data('amount', $data['amount']);
		$this->set_data('parent_id', $data['parent_id']);

		return parent::create_insert_array($data, $pre_create_data);
	}
}
