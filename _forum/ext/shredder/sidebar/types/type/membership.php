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
 * Membership class
 */
class membership extends \sitesplat\sidebar\types\type\base
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
		return $manager->is_enabled('sitesplat/bbmembership');
	}

	/**
	 * Get sidebar type
	 *
	 * @return string sidebar type
	 * @access public
	 */
	public function get_sidebar_type()
	{
		return 'sitesplat.sidebar.type.membership';
	}

	/**
	 * Get sidebar type name
	 *
	 * @return string sidebar type name
	 * @access public
	 */
	public function get_sidebar_type_name()
	{
		return $this->user->lang('SIDEBAR_TYPE_MEMBERSHIP');
	}

	/**
	* {@inheritdoc}
	*/
	public function get_template_name()
	{
		return '@sitesplat_sidebar/membership.html';
	}

	/**
	* {@inheritdoc}
	*/
	public function outputblock()
	{
		$howmany = $this->howmany();
		$sql_where = str_replace('user_id', 'm.user_id', $this->ignore_users());
		$sql_and = '';

		$this->groups = json_decode($this->config['bbmembership_groups'], true);
		$this->membership_package = json_decode($this->config['bbmembership_package'], true);

		foreach ($this->membership_package as $key => $package)
		{
			$this->membership_package[$key] += array('total' => 0);
		}
		
		$membership_table = $this->container->getParameter('sitesplat.bbmembership.tables.bbmembership');

		if (($membership = $this->cache->get('_sidebar_membership')) === false)
		{
			include_once($this->root_path . 'includes/functions_user.' . $this->php_ext);
			$admin_mod_array = array();
			$max_membership = 0;
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
					$sql_and .= ' ' . $this->db->sql_in_set('m.user_id', $admin_mod_array, true);
				}
			}

			$board_url = generate_board_url();

			$sql = 'SELECT IF(m.mc_currency = \'BBPOINTS\', m.mc_gross / 100, m.mc_gross) as mc_gross, m.mc_currency, COUNT(m.user_id) AS total
					FROM ' . $membership_table . ' m
					LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = m.user_id
					' . $sql_where . ' ' . $sql_and . " AND m.payment_status = 'Completed' 
					GROUP BY m.mc_gross, m.mc_currency
					ORDER BY m.mc_gross";
			$result = $this->db->sql_query_limit($sql, $howmany);
			while($row = $this->db->sql_fetchrow($result))
			{
				$this->membership_package[(int) $row['mc_gross']]['total'] = $row['total'];
			}
			
			// cache this data for 5 minutes, this improves performance
			$this->cache->put('_sidebar_membership', $this->membership_package, 300);
			$membership = $this->membership_package;
			$this->db->sql_freeresult($result);
		}

		$max_membership = $this->find_max($membership);
		foreach ($membership as $package)
		{
			$option_pct = ($max_membership) ? $package['total'] / $max_membership : 0;
			$data[] = array('name'	=> $package['package'], 'y' => round($option_pct * 100));	
		}

		$this->template->assign_vars(array(
			'MEMBERSTATS'	=> str_replace(array('"name"', '"y"'), array('name', 'y'), json_encode($data, JSON_NUMERIC_CHECK))
		));
	}

	public function find_max($arr)
	{
		$max = -9999999;
		$found_item = null;
		
		foreach ($arr as $k => $v)
		{
			if ((isset($v['total']) ? $v['total'] : 0) > $max)
			{
			   $max = (isset($v['total']) ? $v['total'] : 0);
			   $found_item = $v;
			}
		}
		return $found_item['total'];
	}
}
