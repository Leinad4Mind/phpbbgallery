<?php
/**
*
* @package BBSidebar
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\sidebar;

class ext extends \phpbb\extension\base
{
	public function is_enableable()
	{
		$manager = $this->container->get('ext.manager');
		return $manager->is_enabled('sitesplat/BBCore');
	}

	function enable_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet
				if (empty($old_state))
				{
					global $user;
					$user->add_lang_ext('sitesplat/sidebar', 'info_acp_sidebar');
					$user->lang['EXTENSION_ENABLE_SUCCESS'] .= (isset($user->lang['SIDEBAR_NOTICE']) ? sprintf($user->lang['SIDEBAR_NOTICE'], $user->lang['ACP_CAT_GENERAL'], $user->lang['ACP_QUICK_ACCESS'], $user->lang['ACP_SIDEBAR_CONFIG']) : '');
				}

				// Run parent enable step method
				return parent::enable_step($old_state);
			
			break;
			
			default:
			
				// Run parent enable step method
				return parent::enable_step($old_state);
				
			break;
		}
	}

	public function purge_step($old_state)
	{
		switch ($old_state)
		{
			case '':
				try
				{
					// Try to remove rest of data
					return $this->sidebar_handler('purge');
				}
				catch (\InvalidArgumentException $e)
				{
					// Continue
				}
	
				return 'sidebar_slot';
			break;
	
			default:
				return parent::purge_step($old_state);
			break;
		}
	}

	/**
	 * sidebar_handler to remove rest of data
	 *
	 * @param string $step               The step (enable, disable, purge)
	 * @return string Return as temporary state
	 * @access protected
	 */
	protected function sidebar_handler($step)
	{
		global $db;
		$sql = 'DELETE FROM ' . CONFIG_TABLE . ' WHERE config_name like "sidebar_slot%"';
		$db->sql_query($sql);
		$sql = 'DELETE FROM ' . CONFIG_TEXT_TABLE . ' WHERE config_name like "sidebar_slot%"';
		$db->sql_query($sql);

		return 'sidebar_slot';
	}
}