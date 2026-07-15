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
 * Donation class
 */
class donations extends \sitesplat\sidebar\types\type\base
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
		return $manager->is_enabled('sitesplat/donations');
	}

	/**
	 * Get sidebar type
	 *
	 * @return string sidebar block type
	 * @access public
	 */
	public function get_sidebar_type()
	{
		return 'sitesplat.sidebar.type.donations';
	}

	/**
	 * Get sidebar type name
	 *
	 * @return string sidebar type name
	 * @access public
	 */
	public function get_sidebar_type_name()
	{
		return $this->user->lang('SIDEBAR_TYPE_DONATIONS');
	}

	/**
	* {@inheritdoc}
	*/
	public function get_template_name()
	{
		return '@sitesplat_sidebar/donations.html';
	}

	/**
	* {@inheritdoc}
	*/
	public function outputblock()
	{
		$howmany = $this->howmany();
		$sql_where = $this->ignore_users();
		$sql_where = str_replace('user_id', 'u.user_id', $this->ignore_users());

		//set two variables for the sql
		$sql_and = '';
		$donations_table = $this->container->getParameter('sitesplat.donation.tables.donations');
		$currency_symbol = $this->container->get('sitesplat.donations.manager')->currency(0, $this->config['donations_currency']);
		
		if (($donations = $this->cache->get('_sidebar_donations')) === false)
		{
			include_once($this->root_path . 'includes/functions_user.' . $this->php_ext);
			$donations = $donations_ids = $admin_mod_array = array();
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
					$sql_and .= ' ' . $this->db->sql_in_set('u.user_id', $admin_mod_array, true);
				}
			}

		//  damn phpbb url rewrite and broken driver
		//	$board_url = generate_board_url();
			$board_url = generate_board_url() . '/';

			// do the main sql query
			$sql = 'SELECT u.user_id, u.username, u.user_colour, u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height,
				d.mc_gross, d.payment_date, d.payment_status
				FROM ' . $donations_table . ' d
				LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = d.user_id
				 ' . $sql_where . ' ' . $sql_and . '
				 AND d.payment_status LIKE "Completed"
				ORDER BY d.payment_date DESC';
			$result = $this->db->sql_query_limit($sql, $howmany);
			while ($row = $this->db->sql_fetchrow($result))
			{
			  $match = array();
			  $avatar = (($row['user_avatar']) ? preg_match( '@src="([^"]+)"@',
						  phpbb_get_user_avatar(
							  array('avatar'			=> $row['user_avatar'], 
									'avatar_type'		=> $row['user_avatar_type'], 
									'avatar_width'	=> $row['user_avatar_width'], 
									'avatar_height'	=> $row['user_avatar_height'])), $match) :
									generate_board_url() . '/styles/' . $this->user->style['style_path'] . '/theme/images/no-avatar.png');
				
				$donations[$row['user_id']] = array(
					'user_id'  	    => $row['user_id'],
					'username'      => $row['username'],
					'user_colour'   => $row['user_colour'],
				//	'avatar'		=> ((sizeof($match) > 1) ? str_replace('./../../', './', array_pop($match)) : $avatar),
					'avatar'	    => ((sizeof($match) > 1) ? str_replace(['./../../', './../', './'], $board_url, array_pop($match)) : $avatar),
					'mc_gross'    => $row['mc_gross'],
				);
			}
			$this->db->sql_freeresult($result);

			// cache this data for 5 minutes, this improves performance
			$this->cache->put('_sidebar_donations', $donations, 300);
		}

		if (sizeof($donations))
		{
			foreach ($donations as $row)
			{
				$username_string = ($this->auth->acl_get('u_viewprofile')) ? 
								get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) : 
								get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']);
	
				$this->template->assign_block_vars('donations',array(
					'S_SEARCH_ACTION'	=> append_sid("{$this->root_path}search.$this->php_ext", 'author_id=' . $row['user_id'] . '&amp;sr=posts'),
					'CURRENCY_SYMBOL'	=> $currency_symbol,
					'AMOUNT' 			=> ($row['mc_gross']) ? $row['mc_gross'] : $this->user->lang['UNKNOWN'],
					'USERNAME_FULL'		=> $username_string,
					'AVATAR'			=> $row['avatar']
				));
			}
		}
	}
}
