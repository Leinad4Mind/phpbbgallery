<?php
/**
*
* BBAwards extension for the phpBB Forum Software package.
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\badge;

/**
 * This ext class is optional and can be omitted if left empty.
 * However you can add special (un)installation commands in the
 * methods enable_step(), disable_step() and purge_step(). As it is,
 * these methods are defined in \phpbb\extension\base, which this
 * class extends, but you can overwrite them to give special
 * instructions for those cases.
 */
class ext extends \phpbb\extension\base
{
	public function is_enableable()
	{
		if (!class_exists('sitesplat\BBCore\helper'))
		{
			$this->container->get('user')->add_lang_ext('sitesplat/badge', 'info_acp_badge');
			trigger_error($this->container->get('user')->lang['SS_HELPER_NOTY'], E_USER_WARNING);	
		}
		
		if (!$this->container->get('ext.manager')->is_enabled('sitesplat/BBCore'))
		{
			$this->container->get('ext.manager')->enable('sitesplat/BBCore');
		}

		return class_exists('sitesplat\BBCore\helper');
	}


	/**
	 * Overwrite enable_step to enable Badge Award notifications
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
					$this->container->get('user')->add_lang_ext('sitesplat/badge', 'info_acp_badge');
					$this->container->get('template')->assign_var('L_EXTENSION_ENABLE_SUCCESS', $this->container->get('user')->lang['EXTENSION_ENABLE_SUCCESS'] . 
						(isset($this->container->get('user')->lang['BADGE_NOTICE']) ?
							sprintf($this->container->get('user')->lang['BADGE_NOTICE'],
									$this->container->get('user')->lang['ACP_CAT_USERGROUP'],
									$this->container->get('user')->lang['ACP_CAT_USERS'],
									$this->container->get('user')->lang['ACP_BADGE_MANAGE']) : ''));
				}

				// Enable Badge Award notifications
				$phpbb_notifications = $this->container->get('notification_manager');
				$phpbb_notifications->enable_notifications('sitesplat.badge.notification.type.award_added');
				$phpbb_notifications->enable_notifications('sitesplat.badge.notification.type.award_removed');
				return 'notifications';
			break;

			default:
				// Run parent enable step method
				return parent::enable_step($old_state);

			break;
		}
	}

	/**
	 * Overwrite disable_step to disable Badge Award notifications
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

				$this->extensions = $this->container->get('ext.manager')->all_enabled();
				foreach($this->extensions as $key => $value)
				{
					if (strpos($value, 'sitesplat/badge') === false)
					{
						unset($this->extensions[$key]);	
					}
				}
				
				unset($this->extensions['sitesplat/badge']);	
				if (sizeof($this->extensions))
				{
					$this->user = $this->container->get('user');
					trigger_error(sprintf($this->user->lang['ERROR_BADGE_DISABLE'], implode('<br />» ', array_keys($this->extensions))), E_USER_WARNING);
				}

				// Disable Badge Award notifications
				$phpbb_notifications = $this->container->get('notification_manager');
				$phpbb_notifications->disable_notifications('sitesplat.badge.notification.type.award_added');
				$phpbb_notifications->disable_notifications('sitesplat.badge.notification.type.award_removed');
				return 'notifications';
			break;

			default:

				// Run parent disable step method
				return parent::disable_step($old_state);

			break;
		}
	}

	/**
	 * Overwrite purge_step to purge Badge Award notifications before
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

				// Purge Badge Award notifications
				$phpbb_notifications = $this->container->get('notification_manager');
				$phpbb_notifications->purge_notifications('sitesplat.badge.notification.type.award_added');
				$phpbb_notifications->purge_notifications('sitesplat.badge.notification.type.award_removed');
				return 'notifications';
			break;

			default:

				// Run parent purge step method
				return parent::purge_step($old_state);

			break;
		}
	}
}
