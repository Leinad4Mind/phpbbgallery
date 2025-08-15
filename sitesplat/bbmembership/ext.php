<?php
/**
*
* BBmembership extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbmembership;

class ext extends \phpbb\extension\base
{
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
					global $user;
					$user->add_lang_ext('sitesplat/bbmembership', 'info_acp_bbmembership');
					$user->lang['EXTENSION_ENABLE_SUCCESS'] .= (isset($user->lang['BBMEMBERSHIP_NOTICE']) ? sprintf($user->lang['BBMEMBERSHIP_NOTICE'], $user->lang['ACP_CAT_GENERAL'], $user->lang['ACP_QUICK_ACCESS'], $user->lang['ACP_BBMEMBERSHIP_TITLE']) : '');
				}

				// Enable Membership system notifications
				return $this->notification_handler('enable', array(
					'sitesplat.bbmembership.notification.type.membership_bought',
					'sitesplat.bbmembership.notification.type.membership_expiring'
				));

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
				return $this->notification_handler('disable', array(
					'sitesplat.bbmembership.notification.type.membership_bought',
					'sitesplat.bbmembership.notification.type.membership_expiring'
				));

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
				return $this->notification_handler('purge', array(
					'sitesplat.bbmembership.notification.type.membership_bought',
					'sitesplat.bbmembership.notification.type.membership_expiring'
				));

			break;

			default:

				// Run parent purge step method
				return parent::purge_step($old_state);

			break;
		}
	}

	/**
	 * Notification handler to call notification enable/disable/purge steps
	 *
	 * @param string $step               The step (enable, disable, purge)
	 * @param array  $notification_types The notification type names
	 * @return string Return notifications as temporary state
	 * @access protected
	 */
	protected function notification_handler($step, $notification_types)
	{
		$phpbb_notifications = $this->container->get('notification_manager');

		foreach ($notification_types as $notification_type)
		{
			call_user_func(array($phpbb_notifications, $step . '_notifications'), $notification_type);
		}

		return 'notifications';
	}
}
