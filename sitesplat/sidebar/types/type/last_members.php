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
 * Last members class
 */
class last_members extends \sitesplat\sidebar\types\type\base
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
	 * Get sidebar block type
	 *
	 * @return string sidebar type
	 * @access public
	 */
	public function get_sidebar_type()
	{
		return 'sitesplat.sidebar.type.last_members';
	}

	/**
	 * Get sidebar type name
	 *
	 * @return string sidebar type name
	 * @access public
	 */
	public function get_sidebar_type_name()
	{
		return $this->user->lang('SIDEBAR_TYPE_LAST_MEMBERS');
	}

	/**
	* {@inheritdoc}
	*/
	public function get_template_name()
	{
		return '@sitesplat_sidebar/newusers.html';
	}

	/**
	* {@inheritdoc}
	*/
	public function outputblock()
	{
		$howmany = $this->howmany();
		$sql_where = $this->ignore_users();

		$sql_and = !empty($sql_where) ? ' AND user_inactive_reason = 0' : ' WHERE user_inactive_reason = 0';
		// latest users
		if (($newest_users = $this->cache->get('_sidebar_newest_users')) === false)
		{
			$newest_users = array();
			// grab users
			$sql = 'SELECT user_id, username, user_colour, user_regdate
				FROM ' . USERS_TABLE . '
				' . $sql_where . '
				' . $sql_and . '
				ORDER BY user_regdate DESC';
			$result = $this->db->sql_query_limit($sql, $howmany);

			while ($row = $this->db->sql_fetchrow($result))
			{
				$newest_users[$row['user_id']] = array(
					'user_id'				=> $row['user_id'],
					'username'				=> $row['username'],
					'user_colour'			=> $row['user_colour'],
					'user_regdate'			=> $row['user_regdate'],
				);
			}
			$this->db->sql_freeresult($result);

			// cache this data for 5 minutes, this improves performance
			$this->cache->put('_sidebar_newest_users', $newest_users, 300);
		}

		foreach ($newest_users as $row)
		{
			$username_string = ($this->auth->acl_get('u_viewprofile')) ? 
								get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) : 
								get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']);

			$this->template->assign_block_vars('newest_users',array(
				'REG_DATE'			=> $this->user->format_date($row['user_regdate']),
				'USERNAME_FULL'		=> $username_string,
			));
		}
	}
}
