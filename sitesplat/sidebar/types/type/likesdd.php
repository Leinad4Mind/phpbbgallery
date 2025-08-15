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
 * Likedd class
 */
class likesdd extends \sitesplat\sidebar\types\type\base
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
		return $manager->is_enabled('sitesplat/likedd');
	}

	/**
	 * Get sidebar type
	 *
	 * @return string sidebar block type
	 * @access public
	 */
	public function get_sidebar_type()
	{
		return 'sitesplat.sidebar.type.likesdd';
	}

	/**
	 * Get sidebar type name
	 *
	 * @return string sidebar type name
	 * @access public
	 */
	public function get_sidebar_type_name()
	{
		return $this->user->lang('SIDEBAR_TYPE_LIKEDD');
	}

	/**
	* {@inheritdoc}
	*/
	public function get_template_name()
	{
		return '@sitesplat_sidebar/likesdd.html';
	}

	/**
	* {@inheritdoc}
	*/
	public function outputblock()
	{
		$howmany = $this->howmany();
		$sql_where = str_replace('user_id', 'l.user_id', $this->ignore_users());

		$sql_and = !empty($sql_where) ? ' AND user_inactive_reason = 0' : ' WHERE user_inactive_reason = 0';
		// latest users
		if (($newest_users = $this->cache->get('_sidebar_likes')) === false)
		{
			$newest_users = array();
			$likes_table = $this->container->getParameter('sitesplat.likedd.tables.likes');
			include_once($this->phpbb_root_path . 'includes/functions_user.' . $this->php_ext);
			
			// grab users
			$sql = 'SELECT p.poster_id, u.username, u.user_colour, u.user_avatar, p.forum_id, l.post_id, p.post_subject, l.like_time 
				FROM ' . $likes_table . ' l
				LEFT JOIN ' . POSTS_TABLE . ' p ON p.post_id = l.post_id
				LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = p.poster_id
				' . $sql_where . '
				' . $sql_and . '
				ORDER BY l.like_time DESC';
			$result = $this->db->sql_query_limit($sql, $howmany);

			while ($row = $this->db->sql_fetchrow($result))
			{
				$newest_users[] = array(
					'user_id'		=> $row['poster_id'],
					'username'		=> $row['username'],
					'avatar'		=> ((!phpbb_validate_email($row['user_avatar']) ? '//secure.gravatar.com/avatar/' . md5(strtolower(trim($row['user_avatar']))) . '?d=identicon&amp;s=70':
						  (($row['user_avatar']) ? ((strpos($row['user_avatar'], 'http') === false) ? generate_board_url() . '/download/file.php?avatar=' . $row['user_avatar'] : $row['user_avatar']) : generate_board_url() . '/styles/FLATBOOTS/theme/images/no_avatar.gif'))),
					'user_colour'	=> $row['user_colour'],
					'subject'		=> $row['post_subject'],
					'post_url'		=> append_sid('./viewtopic.' . $this->php_ext . '?f='. $row['forum_id'] . '&amp;p=' . $row['post_id'] . '#p'. $row['post_id']),
					'date'			=> $row['like_time'],
				);
			}
			$this->db->sql_freeresult($result);
			// cache this data for 5 minutes, this improves performance
			$this->cache->put('_sidebar_likes', $newest_users, 300);
		}

		foreach ($newest_users as $row)
		{
			$username_string = ($this->auth->acl_get('u_viewprofile')) ? 
								get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) : 
								get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']);

			$this->template->assign_block_vars('last_likes',array(
				'LIKE_DATE'		=> $this->user->format_date($row['date']),
				'USERNAME_FULL'	=> $username_string,
				'AVATAR'		=> $row['avatar'],
				'SUBJECT'		=> $row['subject'],
				'POST_URL'		=> $row['post_url']
			));
		}
	}
}
