<?php

/**
 *
 * Invite. An extension for the phpBB Forum Software package.
 *
 * @author 2011-2015 KillBill - killbill@jatek-vilag.com
 * @copyright (c) 2017, kasimi
 * @copyright (c) 2017-2021, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\invitation;

class ext extends \phpbb\extension\base
{
	const ACC_INVITE_DISABLE	= 0;
	const ACC_INVITE_ENABLE		= 1;
	const ACC_INVITE_REGISTER	= 2;

	/**
	 * @return bool
	 * @access public
	 */
	public function is_enableable()
	{
		return phpbb_version_compare(PHPBB_VERSION, '3.2.2', '>=');
	}

	/**
	 * @param string $module one of ucp|mcp|acp
	 * @return string
	 */
	public static function get_module_id($module)
	{
		return '-leinad4mind-invitation-' . strtolower($module) . '-' . strtolower($module) . '_invite_module';
	}

	/**
	 * Enable notifications for the extension
	 *
	 * @param mixed $old_state State returned by previous call of this method
	 *
	 * @return mixed Returns false after last step, otherwise temporary state
	 */
	public function enable_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet

				$phpbb_notifications = $this->container->get('notification_manager');
				$phpbb_notifications->enable_notifications('leinad4mind.invitation.notification.type.birthday');
				$phpbb_notifications->enable_notifications('leinad4mind.invitation.notification.type.gift');
				$phpbb_notifications->enable_notifications('leinad4mind.invitation.notification.type.petition');
				$phpbb_notifications->enable_notifications('leinad4mind.invitation.notification.type.petition_request');
				$phpbb_notifications->enable_notifications('leinad4mind.invitation.notification.type.join');
				return 'notification';

			break;

			default:

				return parent::enable_step($old_state);

			break;
		}
	}

	/**
	 * Disable notifications for the extension
	 *
	 * @param mixed $old_state State returned by previous call of this method
	 *
	 * @return mixed Returns false after last step, otherwise temporary state
	 */
	public function disable_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet

				$phpbb_notifications = $this->container->get('notification_manager');
				$phpbb_notifications->disable_notifications('leinad4mind.invitation.notification.type.birthday');
				$phpbb_notifications->disable_notifications('leinad4mind.invitation.notification.type.gift');
				$phpbb_notifications->disable_notifications('leinad4mind.invitation.notification.type.petition');
				$phpbb_notifications->disable_notifications('leinad4mind.invitation.notification.type.petition_request');
				$phpbb_notifications->disable_notifications('leinad4mind.invitation.notification.type.join');
				return 'notification';

			break;

			default:

				return parent::disable_step($old_state);

			break;
		}
	}

	/**
	 * Purge notifications for the extension
	 *
	 * @param mixed $old_state State returned by previous call of this method
	 *
	 * @return mixed Returns false after last step, otherwise temporary state
	 */
	public function purge_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet

				$phpbb_notifications = $this->container->get('notification_manager');
				$phpbb_notifications->purge_notifications('leinad4mind.invitation.notification.type.birthday');
				$phpbb_notifications->purge_notifications('leinad4mind.invitation.notification.type.gift');
				$phpbb_notifications->purge_notifications('leinad4mind.invitation.notification.type.petition');
				$phpbb_notifications->purge_notifications('leinad4mind.invitation.notification.type.petition_request');
				$phpbb_notifications->purge_notifications('leinad4mind.invitation.notification.type.join');
				return 'notification';

			break;

			default:

				return parent::purge_step($old_state);

			break;
		}
	}
}
