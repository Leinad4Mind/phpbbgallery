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
 * BB points class
 */
class bbpoints extends \sitesplat\sidebar\types\type\base
{
	/**
	 * Get sidebar block enable
	 *
	 * @return sidebar block enabled
	 * @access public
	 */
	public function get_sidebar_enable()
	{
		$manager = $this->container->get('ext.manager');
		return $manager->is_enabled('sitesplat/bbpoints');
	}

	/**
	 * Get sidebar type
	 *
	 * @return string sidebar type
	 * @access public
	 */
	public function get_sidebar_type()
	{
		return 'sitesplat.sidebar.type.bbpoints';
	}

	/**
	 * Get sidebar type name
	 *
	 * @return string sidebar type name
	 * @access public
	 */
	public function get_sidebar_type_name()
	{
		return $this->user->lang('SIDEBAR_TYPE_BBPOINTS');
	}

	/**
	* {@inheritdoc}
	*/
	public function get_template_name()
	{
		return '@sitesplat_sidebar/bbpoints.html';
	}

	/**
	* {@inheritdoc}
	*/
	public function outputblock()
	{
		$howmany = $this->howmany();
		$sql_where = str_replace('user_id', 'u.user_id', $this->ignore_users());

		$sql_and = !empty($sql_where) ? ' AND user_inactive_reason = 0' : ' WHERE user_inactive_reason = 0';
		// latest users
		if (($newest_users = $this->cache->get('_sidebar_bbpoints')) === false)
		{
			$newest_users = array();
			$bbpoints_table = $this->container->getParameter('sitesplat.bbpoints.table');

			// grab users
			$sql = 'SELECT t1.user_id, SUM(points) as total, u.username, u.user_colour FROM ( 
					SELECT to_id AS user_id, SUM(bbpoints) AS points FROM ' . $bbpoints_table . ' GROUP BY to_id
					UNION
					SELECT from_id AS user_id, SUM(-bbpoints) AS points FROM ' . $bbpoints_table . ' GROUP BY from_id
					UNION
					SELECT topic_poster AS user_id, SUM(bbpoints) AS points FROM ' . TOPICS_TABLE . ' GROUP BY topic_poster
					UNION 
					SELECT poster_id AS user_id, SUM(bbpoints) AS points FROM ' . POSTS_TABLE . ' WHERE post_visibility = 1 GROUP BY poster_id) t1 
					LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = t1.user_id
					' . $sql_where . '
					' . $sql_and . '
					GROUP BY user_id
					ORDER BY total DESC';
			$result = $this->db->sql_query_limit($sql, $howmany);

			while ($row = $this->db->sql_fetchrow($result))
			{
				$newest_users[] = array(
					'user_id'		=> $row['user_id'],
					'username'		=> $row['username'],
					'user_colour'	=> $row['user_colour'],
					'bbpoints'		=> number_format($row['total'], 2)
				);
			}
			$this->db->sql_freeresult($result);

			// cache this data for 5 minutes, this improves performance
			$this->cache->put('_sidebar_bbpoints', $newest_users, 300);
		}

		$this->helper = $this->container->get('controller.helper');
		$this->bbpoints_config = json_decode($this->config['bbpoints_settings'], true);

		foreach ($newest_users as $row)
		{
			$username_string = ($this->auth->acl_get('u_viewprofile')) ? 
							get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) : 
							get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']);
			$this->template->assign_block_vars('bbpoints',array(
				'BBPOINTS'			=> $row['bbpoints'],
				'USERNAME_FULL'		=> $username_string,
				'TRANSFER_URL'		=> ($this->bbpoints_config['transfer_notify'] && $row['user_id'] != $this->user->data['user_id']) ? 
										$this->helper->route('sitesplat_bbpoints_main_controller', array('u' => $row['user_id'])) : ''
			));
		}
	}
}
