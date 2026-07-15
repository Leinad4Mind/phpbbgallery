<?php
/**
*
* @package BBSidebar
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\sidebar\types\type;

/**
 * BB reaction class
 */
class last_bbreactions extends \sitesplat\sidebar\types\type\base
{
	/**
	 * Get sidebar block enable
	 *
	 * @return sidebar enabled
	 * @access public
	 */
	public function get_sidebar_enable()
	{
		$manager = $this->container->get('ext.manager');
		return $manager->is_enabled('sitesplat/bbreaction');
	}

	/**
	 * Get sidebar block type
	 *
	 * @return string sidebar type
	 * @access public
	 */
	public function get_sidebar_type()
	{
		return 'sitesplat.sidebar.type.last_bbreactions';
	}

	/**
	 * Get sidebar type name
	 *
	 * @return string sidebar type name
	 * @access public
	 */
	public function get_sidebar_type_name()
	{
		return $this->user->lang('SIDEBAR_TYPE_LAST_BBREACTIONS');
	}

	/**
	* {@inheritdoc}
	*/
	public function get_template_name()
	{
		return '@sitesplat_sidebar/last_bbreactions.html';
	}

	/**
	* {@inheritdoc}
	*/
	public function outputblock()
	{
		$howmany = $this->howmany();
		$visibility = $this->container->get('content.visibility');
		$forum_ary = array();
		$forum_read_ary = $this->auth->acl_getf('f_read');

		foreach ($forum_read_ary as $forum_id => $allowed)
		{
			if ($allowed['f_read'])
			{
				$forum_ary[] = (int) $forum_id;
			}
		}
		$forum_ary = array_unique($forum_ary);

		$sql_where = str_replace('user_id', 'b.user_id', $this->ignore_users());

		$sql_and = !empty($sql_where) ? ' AND user_inactive_reason = 0' : ' WHERE user_inactive_reason = 0';
		$sql_and .= (sizeof($forum_ary)) ? ' AND ' . $visibility->get_forums_visibility_sql('post', $forum_ary) : '';
		// latest users
		if (($newest_users = $this->cache->get('_sidebar_last_bbreactions')) === false)
		{
			$newest_users = array();
			$reward_table = $this->container->getParameter('sitesplat.bbreaction.tables.reward');
			$reward_type_table = $this->container->getParameter('sitesplat.bbreaction.tables.reward_type');

			// grab users
			$sql = 'SELECT b.user_id, r.title, r.symbol, r.positive, u.username, u.user_colour, b.like_time, b.post_id, p.forum_id 
				FROM ' . $reward_table . ' b
				LEFT JOIN ' . $reward_type_table . ' r ON r.type_id = b.like_type
				LEFT JOIN ' . POSTS_TABLE . ' p ON p.post_id = b.post_id
				LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = b.user_id
				' . $sql_where . '
				' . $sql_and . '
				ORDER BY b.like_time DESC';
			$result = $this->db->sql_query_limit($sql, $howmany);

			while ($row = $this->db->sql_fetchrow($result))
			{
				$newest_users[] = array(
					'user_id'		=> $row['user_id'],
					'username'		=> $row['username'],
					'user_colour'	=> $row['user_colour'],
					'rule_name'		=> $row['title'],
					'symbol'		=> $row['symbol'],
					'positive'		=> $row['positive'],
					'post_url'		=> append_sid('./viewtopic.' . $this->php_ext . '?f='. $row['forum_id'] . '&amp;p=' . $row['post_id'] . '#p'. $row['post_id']),
					'date'			=> $row['like_time'],
				);
			}
			$this->db->sql_freeresult($result);

			// cache this data for 5 minutes, this improves performance
			$this->cache->put('_sidebar_last_bbreactions', $newest_users, 300);
		}

		foreach ($newest_users as $row)
		{
			$username_string = ($this->auth->acl_get('u_viewprofile')) ? 
								get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) : 
								get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']);

			$this->template->assign_block_vars('last_bbreactions',array(
				'BADGE_DATE'		=> $this->user->format_date($row['date']),
				'USERNAME_FULL'		=> $username_string,
				'TYPE'				=> $row['rule_name'],
				'SYMBOL'			=> $row['symbol'],
				'POSITIVE'			=> $row['positive'],
				'POST_URL'			=> $row['post_url']
			));
		}
	}
}
