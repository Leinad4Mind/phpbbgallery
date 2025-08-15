<?php
/**
*
* @package BBajaxnews
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbajaxnews\ajaxnews\type;

class new_topic extends base
{
	public function get_type()
	{
		return 'sitesplat.bbajaxnews.ajaxnews.type.new_topic';
	}

	public function get_lang_array($data)
	{
		$sql = 'SELECT username, user_colour
				FROM ' . $this->users_table . '
				WHERE user_id = ' . (int) $data['poster_id'];
		$result = $this->db->sql_query($sql);
		$user = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		return [
			get_username_string('full', (int) $data['poster_id'], $user['username'], $user['user_colour'], false, $this->url . append_sid('/memberlist.php', 'mode=viewprofile')),
			'<a href="' . $this->url . append_sid('/viewtopic.php', 't=' . $data['topic_id']) . '">' . $data['post_subject'] . '</a>',
			'<a href="' . $this->url . append_sid('/viewforum.php', 'f=' . $data['forum_id']) . '" title="' . $data['forum_desc'] . '">' . $data['forum_name'] . '</a>',
		];
	}

	public function get_receivers($data)
	{
		$sql_ary = $this->get_basic_query();

		$list = $this->auth->acl_get_list(false, 'f_read', $data['forum_id']);
		$sql_ary['WHERE'] .= ' AND ' . $this->db->sql_in_set('u.user_id', $list[$data['forum_id']]['f_read']);

		return $this->query_receivers($sql_ary);
	}

	public function is_special()
	{
		return true;
	}
}
