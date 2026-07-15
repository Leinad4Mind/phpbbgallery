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
 * Staff class
 */
class staff extends \sitesplat\sidebar\types\type\base
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
		return 'sitesplat.sidebar.type.staff';
	}

	/**
	 * Get sidebar type name
	 *
	 * @return string sidebar type name
	 * @access public
	 */
	public function get_sidebar_type_name()
	{
		return $this->user->lang('SIDEBAR_TYPE_STAFF');
	}

	/**
	* {@inheritdoc}
	*/
	public function get_template_name()
	{
		return '@sitesplat_sidebar/staff.html';
	}

	/**
	* {@inheritdoc}
	*/
	public function outputblock()
	{
		if (($staff_online = $this->cache->get('_sidebar_staff')) === false)
		{
//			include_once($this->root_path . 'includes/functions_user.' . $this->php_ext);
			$staff_online = $staff_ids = $admin_mod_array = array();

			// damn phpbb url rewrite and broken driver
			$board_url = generate_board_url() . '/';

			// do the main sql query
			$staff_ids = $staff_online = [];
			$sql = 'SELECT u.user_id
					FROM ' . GROUPS_TABLE . ' g, ' . USER_GROUP_TABLE . " u
					WHERE u.group_id = g.group_id AND u.group_id = 15";
					// WHERE LOWER(g.group_name) LIKE '%staff%' AND u.group_id = g.group_id";
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$staff_ids[] = (int) $row['user_id'];
			}

			if (count($staff_ids)) {
				$howmany = $this->howmany();
				$sql_and =  'AND ' . $this->db->sql_in_set('u.user_id', $staff_ids);

				// quick check for forum moderators and administrators
				// some may not want to show them
				//
				// WARNING!!! this setting may cause server issues!
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
						$sql_and .= ' AND ' . $this->db->sql_in_set('user_id', $admin_mod_array, true);
					}
				}

				$sql = 'SELECT u.user_id, u.username, u.user_colour, u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height, s.session_time
					FROM ' . USERS_TABLE . ' u, ' . SESSIONS_TABLE . " s
					WHERE s.session_user_id = u.user_id
					$sql_and
					AND s.session_viewonline = 1
					ORDER BY s.session_time DESC";

				$result = $this->db->sql_query_limit($sql, $howmany);
				while ($row = $this->db->sql_fetchrow($result))
				{
					$user_id = (int) $row['user_id'];
					$session_time = (int) $row['session_time'];
					if (empty($staff_online[$user_id]))
					{
						$match = array();
						$avatar = (($row['user_avatar']) ? preg_match( '@src="([^"]+)"@', phpbb_get_user_avatar([
							'avatar'			=> $row['user_avatar'],
							'avatar_type'		=> $row['user_avatar_type'],
							'avatar_width'	=> $row['user_avatar_width'],
							'avatar_height'	=> $row['user_avatar_height']
						]), $match) : "{$board_url}styles/" . $this->user->style['style_path'] . '/theme/images/no-avatar.png');
	
						if (count($match) > 1) {
							$avatar = array_pop($match);
							// fix an issue with BBrandom
							if (strpos($avatar, "{$this->config['avatar_gallery_path']}/../random/") === false) {
								$avatar = str_replace(['./../../', './../', './'], $board_url, $avatar);
							}
						}

						$staff_online[$user_id] = array(
							'user_id'  	    => $user_id,
							'username'      => $row['username'],
							'user_colour'   => $row['user_colour'],
						//	'avatar'	    => ((sizeof($match) > 1) ? str_replace(['./../../', './../', './'], $board_url, array_pop($match)) : $avatar),
							'avatar'		=> $avatar,
							'last_visit'    => $session_time,
						);
					}
					else if ($session_time > $staff_online[$user_id]['last_visit'])
					{
						$staff_online[$user_id]['last_visit'] = $session_time;
					}
				}

				$this->db->sql_freeresult($result);
			}

			// cache this data for 5 minutes, this improves performance
			$this->cache->put('_sidebar_staff', $staff_online, 300);
		}

		if (sizeof($staff_online))
		{
			foreach ($staff_online as $row)
			{
				$last_visit = $this->user->format_date($row['last_visit'], '|d M Y|, H:i');
				$last_active = (!empty($row['last_active'])) ? $this->user->format_date($row['last_active'], '|d M Y|, H:i') : $this->user->lang['STAFF_UNKNOWN'];
				$username_string = ($this->auth->acl_get('u_viewprofile')) ? get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) :
									get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']);

				$this->template->assign_block_vars('staff',array(
					'S_SEARCH_ACTION'	=> append_sid("{$this->root_path}search.$this->php_ext", 'author_id=' . $row['user_id'] . '&amp;sr=posts'),
					'TIME'	 			=> (!empty($row['last_visit'])) ? $last_visit : $last_active,
					'USERNAME_FULL'		=> $username_string,
					'AVATAR'			=> $row['avatar']
				));
			}
		}
	}
}
