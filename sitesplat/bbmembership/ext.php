<?php
/**
*
* BBmembership extension for the phpBB Forum Software package.
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbmembership;

class ext extends \phpbb\extension\base
{
	public function is_enableable()
	{
		if (!class_exists('sitesplat\BBCore\helper'))
		{
			$this->container->get('user')->add_lang_ext('sitesplat/bbmembership', 'info_acp_bbmembership');
			trigger_error($this->container->get('user')->lang['SS_HELPER_NOTY'], E_USER_WARNING);	
		}
		
		if (!$this->container->get('ext.manager')->is_enabled('sitesplat/BBCore'))
		{
			$this->container->get('ext.manager')->enable('sitesplat/BBCore');
		}

		return class_exists('sitesplat\BBCore\helper');
	}

	/**
	 * Overwrite enable_step to enable BBmembership system notifications
	 * before any included migrations are installed.
	 *
	 * @param mixed $old_state State returned by previous call of this method
	 * @return mixed Returns false after last step, otherwise temporary state
	 * @access public
	 */
	public function enable_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet

				if (empty($old_state))
				{
					$this->container->get('user')->add_lang_ext('sitesplat/bbmembership', 'info_acp_bbmembership');
					$this->container->get('template')->assign_var('L_EXTENSION_ENABLE_SUCCESS', $this->container->get('user')->lang['EXTENSION_ENABLE_SUCCESS'] .
						(isset($this->container->get('user')->lang['BBMEMBERSHIP_NOTICE']) ?
							sprintf($this->container->get('user')->lang['BBMEMBERSHIP_NOTICE'],
											$this->container->get('user')->lang['ACP_CAT_GENERAL'],
											$this->container->get('user')->lang['ACP_QUICK_ACCESS'],
											$this->container->get('user')->lang['ACP_BBMEMBERSHIP_TITLE'])  : ''));
				}

				// Enable Membership system notifications
				$phpbb_notifications = $this->container->get('notification_manager');
				$phpbb_notifications->enable_notifications('sitesplat.bbmembership.notification.type.membership_bought');
				$phpbb_notifications->enable_notifications('sitesplat.bbmembership.notification.type.membership_expiring');
				return 'notifications';
			break;

			default:

				// Run parent enable step method
				return parent::enable_step($old_state);

			break;
		}
	}

	/**
	 * Overwrite disable_step to disable BBmembership system notifications
	 * before the extension is disabled.
	 *
	 * @param mixed $old_state State returned by previous call of this method
	 * @return mixed Returns false after last step, otherwise temporary state
	 * @access public
	 */
	public function disable_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet

				// Disable Membership system notifications
				$phpbb_notifications = $this->container->get('notification_manager');
				$phpbb_notifications->disable_notifications('sitesplat.bbmembership.notification.type.membership_bought');
				$phpbb_notifications->disable_notifications('sitesplat.bbmembership.notification.type.membership_expiring');
				return 'notifications';
			break;

			default:

				// Run parent disable step method
				return parent::disable_step($old_state);

			break;
		}
	}

	/**
	 * Overwrite purge_step to purge BBmembership system notifications before
	 * any included and installed migrations are reverted.
	 *
	 * @param mixed $old_state State returned by previous call of this method
	 * @return mixed Returns false after last step, otherwise temporary state
	 * @access public
	 */
	public function purge_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet

				// Purge Forum Membership system notifications
				$phpbb_notifications = $this->container->get('notification_manager');
				$phpbb_notifications->purge_notifications('sitesplat.bbmembership.notification.type.membership_bought');
				$phpbb_notifications->purge_notifications('sitesplat.bbmembership.notification.type.membership_expiring');
				return 'notifications';
			break;

			default:

				// Run parent purge step method
				return parent::purge_step($old_state);

			break;
		}
	}
}
