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
			include_once($this->root_path . 'includes/functions_user.' . $this->php_ext);
			$board_url = generate_board_url();
			
			// grab users
			$sql = 'SELECT p.poster_id, u.username, u.user_colour, u.user_avatar, user_avatar_type, u.user_id, user_avatar_width, user_avatar_height, p.forum_id, l.post_id, p.post_subject, l.like_time 
				FROM ' . $likes_table . ' l
				LEFT JOIN ' . POSTS_TABLE . ' p ON p.post_id = l.post_id
				LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = p.poster_id
				' . $sql_where . '
				' . $sql_and . '
				ORDER BY l.like_time DESC';
			$result = $this->db->sql_query_limit($sql, $howmany);

			while ($row = $this->db->sql_fetchrow($result))
			{
			  $match = array();
			  $avatar = (($row['user_avatar']) ? preg_match( '@src="([^"]+)"@',
						  phpbb_get_user_avatar(
							  array('avatar'			=> $row['user_avatar'], 
							        'user_id'           => $row['user_id'],
									'avatar_type'		=> $row['user_avatar_type'], 
									'avatar_width'	    => $row['user_avatar_width'], 
									'avatar_height'	    => $row['user_avatar_height'])), $match) :
									generate_board_url() . '/styles/prosilver/theme/images/no_avatar.gif');

				$newest_users[] = array(
					'user_id'		=> $row['poster_id'],
					'username'		=> $row['username'],
					'avatar'		=> ((sizeof($match) > 1) ? str_replace('./../../', './', array_pop($match)) : $avatar),
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
