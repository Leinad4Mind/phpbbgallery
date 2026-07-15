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
 * Birthday class
 */
class birthday extends \sitesplat\sidebar\types\type\base
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
		return 'sitesplat.sidebar.type.birthday';
	}

	/**
	 * Get sidebar type name
	 *
	 * @return string sidebar type name
	 * @access public
	 */
	public function get_sidebar_type_name()
	{
		return $this->user->lang('SIDEBAR_TYPE_BIRTHDAY');
	}

	/**
	* {@inheritdoc}
	*/
	public function get_template_name()
	{
		return '@sitesplat_sidebar/birthday.html';
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
		if (($newest_users = $this->cache->get('_sidebar_birthday')) === false)
		{
			$newest_users = array();

			// grab users
			$time = $this->user->create_datetime();
			$now = phpbb_gmgetdate($time->getTimestamp() + $time->getOffset());
		
			// Display birthdays of 29th february on 28th february in non-leap-years
			$leap_year_birthdays = '';
			if ($now['mday'] == 28 && $now['mon'] == 2 && !$time->format('L'))
			{
				$leap_year_birthdays = ' OR u.user_birthday LIKE "' . $this->db->sql_escape(sprintf('%2d-%2d-', 29, 2)) . '%"';
			}
		
			$sql = 'SELECT u.user_id, u.username, u.user_colour, u.user_birthday
				FROM ' . USERS_TABLE . ' u
				LEFT JOIN ' . BANLIST_TABLE . ' b ON (u.user_id = b.ban_userid)
				' . $sql_where . '
				' . $sql_and . '
					AND (b.ban_id IS NULL
					OR b.ban_exclude = 1)
					AND (u.user_birthday LIKE "' . $this->db->sql_escape(sprintf('%2d-%2d-', $now['mday'], $now['mon'])) . '%"' . $leap_year_birthdays . ')
					ORDER BY u.username';
			$result = $this->db->sql_query_limit($sql, $howmany);

			while ($row = $this->db->sql_fetchrow($result))
			{
				$birthday_year		= (int) substr($row['user_birthday'], -4);
				$birthday_age		= ($birthday_year) ? max(0, $now['year'] - $birthday_year) : '';

				$newest_users[$row['user_id']] = array(
					'user_id'				=> $row['user_id'],
					'username'				=> $row['username'],
					'user_colour'			=> $row['user_colour'],
					'user_age'				=> $birthday_age,
					'birthday'				=> $row['user_birthday']
				);
			}
			$this->db->sql_freeresult($result);

			// cache this data for 5 minutes, this improves performance
			$this->cache->put('_sidebar_birthday', $newest_users, 300);
		}

		foreach ($newest_users as $row)
		{
			$username_string = ($this->auth->acl_get('u_viewprofile')) ? 
								get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) : 
								get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']);

			$this->template->assign_block_vars('birthday',array(
				'AGE'			=> $row['user_age'],
				'BIRTHDAY'		=> $row['birthday'],
				'USERNAME_FULL'	=> $username_string,
			));
		}
	}
}
