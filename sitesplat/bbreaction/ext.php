<?php
/**
*
* BBreaction.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbreaction;

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
		$manager = $this->container->get('ext.manager');

		return $manager->is_enabled('sitesplat/BBCore');
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
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet
				if (empty($old_state))
				{
					global $user;
					$user->add_lang_ext('sitesplat/bbreaction', 'info_acp_bbreaction');
					$user->lang['EXTENSION_ENABLE_SUCCESS'] .= (isset($user->lang['BBREACTION_NOTICE']) ? sprintf($user->lang['BBREACTION_NOTICE'], $user->lang['ACP_CAT_GENERAL'], $user->lang['ACP_QUICK_ACCESS'], $user->lang['ACP_BBREACTION']) : '');
				}

				// Enable BB reaction notifications
				return $this->notification_handler('enable', array(
					'sitesplat.bbreaction.notification.type.reward_added',
				));

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
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet

				// Disable BB reaction notifications
				return $this->notification_handler('disable', array(
					'sitesplat.bbreaction.notification.type.reward_added',
				));

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
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet

				// Purge BB reaction notifications
				return $this->notification_handler('purge', array(
					'sitesplat.bbreaction.notification.type.reward_added',
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
