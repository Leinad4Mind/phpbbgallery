<?php
/**
*
* BBAwards AutoGroup Addon.
* @copyright (c) 2015 SiteSplat <http://www.sitesplat.com>
* @license SiteSplat 2015 all rights reserved
*
**/

namespace sitesplat\badgeautogroups;

class ext extends \phpbb\extension\base
{
	public function is_enableable()
	{
		$manager = $this->container->get('ext.manager');
		return $manager->is_enabled('phpbb/autogroups') && $manager->is_enabled('sitesplat/badge');
	}

	/**
	 * Overwrite enable_step to enable Badge Award autogroups
	 * before any included migrations are installed.
	 *
	 * @param mixed $old_state State returned by previous call of this method
	 * @return mixed Returns false after last step, otherwise temporary state
	 * @access public
	 */
	public function enable_step($old_state)
	{
		if (empty($old_state))
		{
			$this->container->get('user')->add_lang_ext('sitesplat/badgeautogroups', 'info_acp_ badgeautogroups');
			$this->container->get('template')->assign_var('L_EXTENSION_ENABLE_SUCCESS', $this->container->get('user')->lang['EXTENSION_ENABLE_SUCCESS'] . 
				(isset($this->container->get('user')->lang['BADGE_AUTOGROUPS_NOTICE']) ?
					sprintf($this->container->get('user')->lang['BADGE_AUTOGROUPS_NOTICE'],
							$this->container->get('user')->lang['ACP_CAT_USERGROUP'],
							$this->container->get('user')->lang['ACP_GROUPS'],
							$this->container->get('user')->lang['ACP_AUTOGROUPS_MANAGE']) : ''));
		// Run parent enable step method
		return parent::enable_step($old_state);
		}
	}

	public function purge_step($old_state)
	{
		switch ($old_state)
		{
			case '':
				try
				{
					// Try to remove this extension from auto groups db tables
					$autogroups = $this->container->get('phpbb.autogroups.manager');
					$autogroups->purge_autogroups_type('sitesplat.badgeautogroups.type.avatar');
					$autogroups->purge_autogroups_type('sitesplat.badgeautogroups.type.badges');
					$autogroups->purge_autogroups_type('sitesplat.badgeautogroups.type.custom');
					$autogroups->purge_autogroups_type('sitesplat.badgeautogroups.type.donations');
					$autogroups->purge_autogroups_type('sitesplat.badgeautogroups.type.likedd');
					$autogroups->purge_autogroups_type('sitesplat.badgeautogroups.type.signature');
					$autogroups->purge_autogroups_type('sitesplat.badgeautogroups.type.zebra_foes');
					$autogroups->purge_autogroups_type('sitesplat.badgeautogroups.type.zebra_friends');
				}
				catch (\InvalidArgumentException $e)
				{
					// Continue
				}
	
				return 'autogroups';
			break;
	
			default:
				return parent::purge_step($old_state);
			break;
		}
	}
}
