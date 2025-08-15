<?php
/**
 *
* Badge Award extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
 *
 */

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
					global $user;
					$user->add_lang_ext('sitesplat/badgeautogroups', 'info_acp_ badgeautogroups');
					$user->lang['EXTENSION_ENABLE_SUCCESS'] .= (isset($user->lang['BADGE_AUTOGROUPS_NOTICE']) ? sprintf($user->lang['BADGE_AUTOGROUPS_NOTICE'], $user->lang['ACP_CAT_USERGROUP'], $user->lang['ACP_GROUPS'], $user->lang['ACP_AUTOGROUPS_MANAGE']) : '');
	
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
