<?php

/**
 *
 * BBReaction
 * @copyright (c) 2015-2022 SiteSplat All rights reserved
 * @license Proprietary
 *
 */

namespace sitesplat\bbreaction;

use phpbb\extension\base;

/**
 * This ext class is optional and can be omitted if left empty.
 * However you can add special (un)installation commands in the
 * methods enable_step(), disable_step() and purge_step(). As it is,
 * these methods are defined in \phpbb\extension\base, which this
 * class extends, but you can overwrite them to give special
 * instructions for those cases.
 */
class ext extends base
{
	public function is_enableable()
	{
		if (!class_exists('sitesplat\BBCore\helper')) {
			$this->container->get('user')->add_lang_ext('sitesplat/bbreaction', 'info_acp_bbreaction');
			trigger_error($this->container->get('user')->lang['SS_HELPER_NOTY'], E_USER_WARNING);
		}

		if (!$this->container->get('ext.manager')->is_enabled('sitesplat/BBCore')) {
			$this->container->get('ext.manager')->enable('sitesplat/BBCore');
		}

		return class_exists('sitesplat\BBCore\helper');
	}


	/**
	 * Overwrite enable_step to enable BB reaction notifications
	 * before any included migrations are installed.
	 *
	 * @param mixed $old_state State returned by previous call of this method
	 * @return mixed Returns false after last step, otherwise temporary state
	 * @access public
	 */
	public function enable_step($old_state)
	{
		switch ($old_state) {
			case '': // Empty means nothing has run yet
				if (empty($old_state)) {
					$this->container->get('user')->add_lang_ext('sitesplat/bbreaction', 'info_acp_bbreaction');
					$this->container->get('template')->assign_var('L_EXTENSION_ENABLE_SUCCESS', $this->container->get('user')->lang['EXTENSION_ENABLE_SUCCESS'] .
						(isset($this->container->get('user')->lang['BBREACTION_NOTICE']) ?
							sprintf(
								$this->container->get('user')->lang['BBREACTION_NOTICE'],
								$this->container->get('user')->lang['ACP_CAT_GENERAL'],
								$this->container->get('user')->lang['ACP_QUICK_ACCESS'],
								$this->container->get('user')->lang['ACP_BBREACTION']
							) : ''));
				}

				// Enable BB reaction notifications
				$phpbb_notifications = $this->container->get('notification_manager');
				$phpbb_notifications->enable_notifications('sitesplat.bbreaction.notification.type.reward_added');
				return 'notifications';
				break;

			default:
				// Run parent enable step method
				return parent::enable_step($old_state);

				break;
		}
	}

	/**
	 * Overwrite disable_step to disable BB reaction notifications
	 * before the extension is disabled.
	 *
	 * @param mixed $old_state State returned by previous call of this method
	 * @return mixed Returns false after last step, otherwise temporary state
	 * @access public
	 */
	public function disable_step($old_state)
	{
		switch ($old_state) {
			case '': // Empty means nothing has run yet

				// Disable BB reaction notifications
				$phpbb_notifications = $this->container->get('notification_manager');
				$phpbb_notifications->disable_notifications('sitesplat.bbreaction.notification.type.reward_added');
				return 'notifications';
				break;

			default:

				// Run parent disable step method
				return parent::disable_step($old_state);

				break;
		}
	}

	/**
	 * Overwrite purge_step to purge BB reaction notifications before
	 * any included and installed migrations are reverted.
	 *
	 * @param mixed $old_state State returned by previous call of this method
	 * @return mixed Returns false after last step, otherwise temporary state
	 * @access public
	 */
	public function purge_step($old_state)
	{
		switch ($old_state) {
			case '': // Empty means nothing has run yet

				// Purge BB reaction notifications
				$phpbb_notifications = $this->container->get('notification_manager');
				$phpbb_notifications->purge_notifications('sitesplat.bbreaction.notification.type.added');
				return 'notifications';
				break;

			default:

				// Run parent purge step method
				return parent::purge_step($old_state);

				break;
		}
	}
}