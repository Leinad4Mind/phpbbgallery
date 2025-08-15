<?php
/**
*
* BBAwards premium rule PAK.
*
* @copyright (c) 2015 SiteSplat <http://www.sitesplat.com>
* @license SiteSplat 2015 all rights reserved
*
*/

namespace sitesplat\badgepremium;

class ext extends \phpbb\extension\base
{
	public function is_enableable()
	{
		$manager = $this->container->get('ext.manager');

		return $manager->is_enabled('sitesplat/badge') && $manager->is_enabled('phpbb/autogroups');
	}

	public function enable_step($old_state)
	{
		if (empty($old_state))
		{
			global $user;
			$user->add_lang_ext('sitesplat/badgepremium', 'badgepremium');
			$user->lang['EXTENSION_ENABLE_SUCCESS'] .= (isset($user->lang['BADGE_PREMIUM_NOTICE']) ? sprintf($user->lang['BADGE_PREMIUM_NOTICE'], $user->lang['ACP_CAT_USERGROUP'], $user->lang['ACP_GROUPS'], $user->lang['ACP_BADGE_MANAGE']) : '');
		}
		// Run parent enable step method
		return parent::enable_step($old_state);
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
					$autogroups->purge_autogroups_type('sitesplat.badgeautogroups.type.bookmarked');
					$autogroups->purge_autogroups_type('sitesplat.badgeautogroups.type.cross_badge');
					$autogroups->purge_autogroups_type('sitesplat.badgeautogroups.type.polls');
					$autogroups->purge_autogroups_type('sitesplat.badgeautogroups.type.reports');
					$autogroups->purge_autogroups_type('sitesplat.badgeautogroups.type.subscribed');
					$autogroups->purge_autogroups_type('sitesplat.badgeautogroups.type.topics');
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
