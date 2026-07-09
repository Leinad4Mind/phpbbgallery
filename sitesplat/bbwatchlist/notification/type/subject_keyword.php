<?php
/**
 *
 * BBwatchlist. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018 SiteSplat All rights reserved
 * @license Proprietary
 *
 */

namespace sitesplat\bbwatchlist\notification\type;

class subject_keyword extends \phpbb\notification\type\base
{
	public function get_type()
	{
		return 'sitesplat.bbwatchlist.notification.type.subject_keyword';
	}

	public static $notification_option = array(
		'lang'	=> 'NOTIFICATION_TYPE_SUBJECT_KEYWORD',
		'group'	=> 'NOTIFICATION_GROUP_BBWATCHLIST',
	);

	public static function get_item_id($data)
	{
		return (int) $data['topic_id'];
	}

	public static function get_item_parent_id($data)
	{
		return (int) $data['forum_id'];
	}

	public function find_users_for_notification($data, $options = array())
	{
		return $this->check_user_notification_options($data['user_ids']);
	}

	public function users_to_query()
	{
		return array();
	}

	public function get_title()
	{
		return $this->user->lang('SUBJECT_KEYWORD_NOTIFICATION_TITLE');
	}

	public function get_reference()
	{
		return $this->user->lang('SUBJECT_KEYWORD_NOTIFICATION_CONTENT', $this->get_data('keyword'));
	}

	public function get_url()
	{
		return append_sid($this->phpbb_root_path . 'viewtopic.' . $this->php_ext, "t={$this->item_id}");
	}

	public function get_email_template()
	{
		return '@sitesplat_bbwatchlist/subject_keyword';
	}

	public function get_email_template_variables()
	{
		return array(
			'KEYWORD'		=> $this->get_data('keyword'),
			'U_TOPIC_LINK'	=> append_sid($this->phpbb_root_path . 'viewtopic.' . $this->php_ext, "t={$this->item_id}"),
		);
	}

	public function create_insert_array($data, $pre_create_data = array())
	{
		$this->set_data('keyword', $data['keyword']);

		parent::create_insert_array($data, $pre_create_data);
	}
}
