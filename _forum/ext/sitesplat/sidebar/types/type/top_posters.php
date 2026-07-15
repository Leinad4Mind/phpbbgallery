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
 * Top posters class
 */
class top_posters extends \sitesplat\sidebar\types\type\base
{
	/**
	 * Get sidebar block enable
	 *
	 * @return sidebar enabled
	 * @access public
	 */
	public function get_sidebar_enable()
	{
		return true;
	}

	/**
	 * Get sidebar type
	 *
	 * @return string sidebar block type
	 * @access public
	 */
	public function get_sidebar_type()
	{
		return 'sitesplat.sidebar.type.top_posters';
	}

	/**
	 * Get sidebar type name
	 *
	 * @return string sidebar type name
	 * @access public
	 */
	public function get_sidebar_type_name()
	{
		return $this->user->lang('SIDEBAR_TYPE_TOP_POSTERS');
	}

	/**
	* {@inheritdoc}
	*/
	public function get_template_name()
	{
		return '@sitesplat_sidebar/top_posters.html';
	}

	/**
	* {@inheritdoc}
	*/
	public function outputblock()
	{
		$howmany = $this->howmany();
		$sql_where = $this->ignore_users();

		//set two variables for the sql
		$sql_and = $sql_other = '';

		if (($user_posts = $this->cache->get('_sidebar_posters')) === false)
		{
			include_once($this->root_path . 'includes/functions_user.' . $this->php_ext);
			$user_posts = $admin_mod_array = array();
			// quick check for forum moderators and administrators
			// some may not want to show them
			if (!$this->sidebar_settings['ignore_admins_mods'])
			{
				// grab all admins
				$admin_ary = $this->auth->acl_get_list(false, 'a_', false);
				$admin_ary = (!empty($admin_ary[0]['a_'])) ? $admin_ary[0]['a_'] : array();

				//grab all mods
				$mod_ary = $this->auth->acl_get_list(false,'m_', false);
				$mod_ary = (!empty($mod_ary[0]['m_'])) ? $mod_ary[0]['m_'] : array();
				$admin_mod_array = array_unique(array_merge($admin_ary, $mod_ary));
				if (sizeof($admin_mod_array))
				{
					$sql_and = empty($sql_where) ? ' WHERE' : ' AND';
					$sql_and .= ' ' . $this->db->sql_in_set('user_id', $admin_mod_array, true);
				}
			}
			$sql_other = (empty($sql_and) && empty($sql_where)) ? ' WHERE' : ' AND';
			$sql_other .=  ' user_posts <> 0';
			$user_posts[0] = $user_posts[1] = $user_posts[2] = array();

		//  damn phpbb url rewrite and broken driver
		//	$board_url = generate_board_url();
			$board_url = generate_board_url() . '/';
			
			// do the main sql query		
			$sql = 'SELECT user_id, username, user_colour, user_avatar, user_avatar_type, user_avatar_width, user_avatar_height, user_posts
				FROM ' . USERS_TABLE . '
				 ' . $sql_where . ' ' . $sql_and . '
				' . $sql_other . '
				ORDER BY user_posts DESC';

			$result = $this->db->sql_query_limit($sql, $howmany);
			while ($row = $this->db->sql_fetchrow($result))
			{
				  $match = array();
				  $avatar = (($row['user_avatar']) ? preg_match( '@src="([^"]+)"@',
							  phpbb_get_user_avatar(
								  array('avatar'			=> $row['user_avatar'], 
								        'user_id'      => $row['user_id'],
										'avatar_type'		=> $row['user_avatar_type'], 
										'avatar_width'	=> $row['user_avatar_width'], 
										'avatar_height'	=> $row['user_avatar_height'])), $match) :
										generate_board_url() . '/styles/' . $this->user->style['style_path'] . '/theme/images/no-avatar.png');
				
				$user_posts[0][$row['user_id']] = array(
					'user_id'      => $row['user_id'],
					'username'      => $row['username'],
					'user_colour'   => $row['user_colour'],
				//	'avatar'		=> ((sizeof($match) > 1) ? str_replace('./../../', './', array_pop($match)) : $avatar),
					'avatar'	    => ((sizeof($match) > 1) ? str_replace(['./../../', './../', './'], $board_url, array_pop($match)) : $avatar),
					'user_posts'    => $row['user_posts'],
				);
			}
			$this->db->sql_freeresult($result);


			// do the main sql query
			$sql = 'SELECT user_id, username, user_colour, user_avatar, user_avatar_type, user_avatar_width, user_avatar_height, COUNT(p.post_id) AS user_posts
					FROM ' . POSTS_TABLE . ' p
					LEFT JOIN ' . USERS_TABLE . ' ON user_id = p.poster_id
					' . $sql_where . ' ' . $sql_and . '
					' . $sql_other . '
					AND p.post_time > ' . (time() - 86400 ) . '
					GROUP BY p.poster_id
					ORDER BY user_posts DESC';
			$result = $this->db->sql_query_limit($sql, $howmany);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$match = array();
				$avatar = (($row['user_avatar']) ? preg_match( '@src="([^"]+)"@',
							phpbb_get_user_avatar(
								array('avatar'			=> $row['user_avatar'], 
								      'user_id'      => $row['user_id'],
									  'avatar_type'		=> $row['user_avatar_type'], 
									  'avatar_width'	=> $row['user_avatar_width'], 
									  'avatar_height'	=> $row['user_avatar_height'])), $match) :
									  generate_board_url() . '/styles/' . $this->user->style['style_path'] . '/theme/images/no-avatar.png');

				$user_posts[1][$row['user_id']] = array(
					'user_id'      => $row['user_id'],
					'username'      => $row['username'],
					'user_colour'   => $row['user_colour'],
					'avatar'		=> (sizeof($match) > 1) ? array_pop($match) : $avatar,
					'user_posts'    => $row['user_posts'],
				);
			}
			$this->db->sql_freeresult($result);


			// do the main sql query
			$sql = 'SELECT user_id, username, user_colour, user_avatar, user_avatar_type, user_avatar_width, user_avatar_height, COUNT(p.post_id) AS user_posts
					FROM ' . POSTS_TABLE . ' p
					LEFT JOIN ' . USERS_TABLE . ' ON user_id = p.poster_id
					' . $sql_where . ' ' . $sql_and . '
					' . $sql_other . '
					AND p.post_time > ' . (time() - (86400 * 7)) . '
					GROUP BY p.poster_id
					ORDER BY user_posts DESC';
			$result = $this->db->sql_query_limit($sql, $howmany);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$board_url = generate_board_url() . '/';
				$match = array();
				$avatar = (($row['user_avatar']) ? preg_match( '@src="([^"]+)"@',
							phpbb_get_user_avatar(
								array('avatar'			=> $row['user_avatar'], 
								      'user_id'      => $row['user_id'],
									  'avatar_type'		=> $row['user_avatar_type'], 
									  'avatar_width'	=> $row['user_avatar_width'], 
									  'avatar_height'	=> $row['user_avatar_height'])),$match) :
									  generate_board_url() . '/styles/' . $this->user->style['style_path'] . '/theme/images/no-avatar.png');

				$user_posts[2][$row['user_id']] = array(
					'user_id'      => $row['user_id'],
					'username'      => $row['username'],
					'user_colour'   => $row['user_colour'],
					//'avatar'		=> (sizeof($match) > 1) ? array_pop($match) : $avatar,
					'avatar'		=> ((sizeof($match) > 1) ? strtr(array_pop($match), [ 'gallery/../random' => 'random', './../../' => $board_url,  './../' => $board_url, './' => $board_url ]) : $avatar),
					'user_posts'    => $row['user_posts'],
				);
			}
			$this->db->sql_freeresult($result);

			// cache this data for 5 minutes, this improves performance
			$this->cache->put('_sidebar_posters', $user_posts, 300);
		}

		foreach ($user_posts[0] as $row)
		{
			$username_string = ($this->auth->acl_get('u_viewprofile')) ? get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) : 
								get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']);

			$this->template->assign_block_vars('top_posters',array(
				'S_SEARCH_ACTION'	=> append_sid("{$this->root_path}search.$this->php_ext", 'author_id=' . $row['user_id'] . '&amp;sr=posts'),
				'POSTS' 			=> number_format($row['user_posts']),
				'USERNAME_FULL'		=> $username_string,
				'AVATAR'			=> $row['avatar']
			));
		}

		if (isset($user_posts[1]))
		{
			foreach ($user_posts[1] as $row)
			{
				$username_string = ($this->auth->acl_get('u_viewprofile')) ? get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) : 
									get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']);
	
				$this->template->assign_block_vars('top_posters_day',array(
					'S_SEARCH_ACTION'	=> append_sid("{$this->root_path}search.$this->php_ext", 'author_id=' . $row['user_id'] . '&amp;sr=posts'),
					'POSTS' 			=> number_format($row['user_posts']),
					'USERNAME_FULL'		=> $username_string,
					'AVATAR'			=> $row['avatar']
				));
			}
		}

		if (isset($user_posts[2]))
		{
			foreach ($user_posts[2] as $row)
			{
				$username_string = ($this->auth->acl_get('u_viewprofile')) ? get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) : 
									get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']);
	
				$this->template->assign_block_vars('top_posters_week',array(
					'S_SEARCH_ACTION'	=> append_sid("{$this->root_path}search.$this->php_ext", 'author_id=' . $row['user_id'] . '&amp;sr=posts'),
					'POSTS' 			=> number_format($row['user_posts']),
					'USERNAME_FULL'		=> $username_string,
					'AVATAR'			=> $row['avatar']
				));
			}
		}
	}
}
