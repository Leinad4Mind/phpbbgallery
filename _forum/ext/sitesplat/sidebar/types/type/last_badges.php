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
 * Badge Award class
 */
class last_badges extends \sitesplat\sidebar\types\type\base
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
		return $manager->is_enabled('sitesplat/badge');
	}

	/**
	 * Get sidebar block type
	 *
	 * @return string sidebar type
	 * @access public
	 */
	public function get_sidebar_type()
	{
		return 'sitesplat.sidebar.type.last_badges';
	}

	/**
	 * Get sidebar type name
	 *
	 * @return string sidebar type name
	 * @access public
	 */
	public function get_sidebar_type_name()
	{
		return $this->user->lang('SIDEBAR_TYPE_LAST_BADGES');
	}

	/**
	* {@inheritdoc}
	*/
	public function get_template_name()
	{
		return '@sitesplat_sidebar/last_badges.html';
	}

	/**
	* {@inheritdoc}
	*/
	public function outputblock()
	{
		$howmany = $this->howmany();
		$sql_where = str_replace('user_id', 'b.user_id', $this->ignore_users());

		$sql_and = !empty($sql_where) ? ' AND user_posts > 1 AND user_inactive_reason = 0' : ' WHERE user_posts > 1 AND user_inactive_reason = 0';
		// latest users
		if (($newest_users = $this->cache->get('_sidebar_last_badges')) === false)
		{
			$newest_users = array();
			$badge_event_table = $this->container->getParameter('sitesplat.badge.tables.badge_events');
			$badge_rules_table = $this->container->getParameter('sitesplat.badge.tables.badge_rules');
			$badge_badges_table = $this->container->getParameter('sitesplat.badge.tables.badges');

			// grab users
			$sql = 'SELECT b.user_id, r.rule_name, u.username, u.user_colour, b.date, ba.badge 
				FROM ' . $badge_event_table . ' b
				LEFT JOIN ' . $badge_rules_table . ' r ON r.rule_id = b.rule_id
				INNER JOIN ' . $badge_badges_table . ' ba ON ba.badge_id = r.badge_id 
				INNER JOIN ' . USERS_TABLE . ' u ON u.user_id = b.user_id
				' . $sql_where . '
				' . $sql_and . '
				ORDER BY b.date DESC';
			$result = $this->db->sql_query_limit($sql, $howmany);

			while ($row = $this->db->sql_fetchrow($result))
			{
				$newest_users[] = array(
					'user_id'		=> $row['user_id'],
					'username'		=> $row['username'],
					'user_colour'	=> $row['user_colour'],
					'rule_name'		=> $row['rule_name'],
					'badge'			=> $row['badge'],
					'date'			=> $row['date'],
				);
			}
			$this->db->sql_freeresult($result);

			// cache this data for 30 minutes, this improves performance
			$this->cache->put('_sidebar_last_badges', $newest_users, 1800);
		}

		foreach ($newest_users as $row)
		{
			$username_string = ($this->auth->acl_get('u_viewprofile')) ? 
								get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) : 
								get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']);

			$this->template->assign_block_vars('last_badges',array(
				'BADGE_DATE'		=> $this->user->format_date($row['date']),
				'USERNAME_FULL'		=> $username_string,
				'NAME'				=> $row['rule_name'],
				'BADGE'				=> generate_board_url() . '/ext/sitesplat/badge/badges/' . $row['badge']
			));
		}
	}
}
