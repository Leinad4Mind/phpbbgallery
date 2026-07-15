<?php

/**
 *
 * Staff Notifications. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\staffnotifications;

use phpbb\extension\base;

class ext extends base
{
	/**
	 * @return bool
	 */
	public function is_enableable()
	{
		$config = $this->container->get('config');
		return version_compare($config['version'], '3.1.2', '>=');
	}

	public function enable_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet
				$phpbb_notifications = $this->container->get('notification_manager');
				foreach (settings::get_all_notifications() as $notification_name)
				{
					$phpbb_notifications->enable_notifications('leinad4mind.staffnotifications.notification.type.' . $notification_name);
				}
				return 'notifications';
			break;
			default:
				// Run parent enable step method
				return parent::enable_step($old_state);
			break;
		}
	}

	public function disable_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet
				$phpbb_notifications = $this->container->get('notification_manager');
				foreach (settings::get_all_notifications() as $notification_name)
				{
					$phpbb_notifications->disable_notifications('leinad4mind.staffnotifications.notification.type.' . $notification_name);
				}
				return 'notifications';
			break;
			default:
				// Run parent disable step method
				return parent::disable_step($old_state);
			break;
		}
	}

	public function purge_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet
				$phpbb_notifications = $this->container->get('notification_manager');
				foreach (settings::get_all_notifications() as $notification_name)
				{
					$phpbb_notifications->purge_notifications('leinad4mind.staffnotifications.notification.type.' . $notification_name);
				}
				return 'notifications';
			break;
			default:
				// Run parent purge step method
				return parent::purge_step($old_state);
			break;
		}
	}
}
