<?php
/**
*
* @package BBSidebar
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\sidebar\types\type;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Sidebar base class
 */
abstract class base implements type_interface
{
	protected $container;
	protected $db;
	protected $user;
	protected $config;
	protected $cache;
	protected $auth;
	protected $template;
	protected $sidebar_types_table;
	protected $phpbb_root_path;
	protected $php_ext;

	public function __construct(ContainerInterface $container, \phpbb\db\driver\driver_interface $db, \phpbb\user $user, \phpbb\config\config $config, \phpbb\cache\driver\driver_interface $cache, \phpbb\auth\auth $auth, \phpbb\template\template $template, $sidebar_types_table,  $phpbb_root_path, $php_ext)
	{
		$this->container = $container;
		$this->db = $db;
		$this->user = $user;
		$this->config = $config;
		$this->cache = $cache;
		$this->auth = $auth;
		$this->template = $template;
		$this->sidebar_types_table = $sidebar_types_table;
		$this->root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
		$this->sidebar_settings = json_decode($this->config['sidebar_settings'], true);
	}

 	/** 
 	* {@inheritdoc} 
 	*/ 
	protected function howmany()
	{
		return (int) $this->sidebar_settings['how_many'];;
	}
	
 	/** 
 	* {@inheritdoc} 
 	*/ 
	protected function ignore_users()
	{
		// an array of user types we dont' bother with
		$ignore_users = $ignore_founders = array();
		
		$sql = 'SELECT group_id FROM ' . GROUPS_TABLE . ' WHERE group_name = "BOTS" AND group_type = ' . GROUP_SPECIAL;
		$result = $this->db->sql_query($sql, 3600);
		$bot_group = $this->db->sql_fetchfield('group_id');

		if (!$this->sidebar_settings['ignore_inactive_users'])
		{
			$ignore_users = array(USER_IGNORE, USER_INACTIVE);
		}

		if (!$this->sidebar_settings['ignore_founder'])
		{
			$ignore_founders = array(USER_FOUNDER);
		}

		$ignore_users = array_merge($ignore_users, $ignore_founders);

		// Do we have anyone we want to ignore
		$sql_where = 'WHERE group_id <> ' . $bot_group . ' AND user_id <> ' . ANONYMOUS;
		if (sizeof($ignore_users))
		{
			$sql_where .= ' AND ' . $this->db->sql_in_set('user_type', $ignore_users, true);
		}
		
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
				$sql_where .= empty($sql_where) ? ' WHERE' : ' AND';
				$sql_where .= ' ' . $this->db->sql_in_set('user_id', $admin_mod_array, true);
			}
		}

		return $sql_where;
	}
}
