<?php
/**
*
* phpBB Ajax likeBB.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\likedd\notification\type;

class likedd_added extends \phpbb\notification\type\base
{
	/**
	 * {@inheritdoc}
	 */
	public function get_type()
	{
		return 'sitesplat.likedd.notification.type.likedd_added';
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
		$sql = 'SELECT username FROM ' . USERS_TABLE . ' WHERE user_id = ' . $this->get_data('poster_id');
		$result = $this->db->sql_query($sql);
		$username = $this->db->sql_fetchfield('username');
		$type1 = (strpos($this->get_data('like_txt'), 'REMOVED') === false) ? 0 : 1;
		$type2 = (strpos($this->get_data('like_txt'), 'LIKE') === false) ? 0 : 1;
		
		return $this->user->lang('LIKEDD_NOTIFICATION_EVENT_ADDED', (($type2) ? $this->user->lang['LIKE_USER_INFO_LIKE'] : $this->user->lang['LIKE_USER_INFO_DISLIKE'] ), 
				(($type1) ? $this->user->lang['REMOVED'] : $this->user->lang['ADDED']), $username);
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_url()
	{
		return append_sid($this->root_path . 'viewtopic.' . $this->php_ext, 'p=' . $this->get_data('parent_id') . '#p' . $this->get_data('parent_id'));
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
		$this->set_data('like_txt', $data['like_txt']);
		$this->set_data('poster_id', $data['poster_id']);
		$this->set_data('parent_id', $data['parent_id']);

		return parent::create_insert_array($data, $pre_create_data);
	}
}
