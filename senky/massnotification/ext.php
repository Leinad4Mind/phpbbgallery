<?php
/**
 *
 * Mass Notification. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Jakub Senko
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace senky\massnotification;

class ext extends \phpbb\extension\base
{
	private $notif_name = 'senky.massnotification.notification.type.manual';

	/**
	* {@inheritdoc}
	*/
	public function enable_step($old_state)
	{
		if ($old_state === false)
		{
			$this->container->get('notification_manager')->enable_notifications($this->notif_name);
			return 'notification';
		}

		return parent::enable_step($old_state);
	}

	/**
	* {@inheritdoc}
	*/
	public function disable_step($old_state)
	{
		if ($old_state === false)
		{
			$this->container->get('notification_manager')->disable_notifications($this->notif_name);
			return 'notification';
		}

		return parent::disable_step($old_state);
	}

	/**
	* {@inheritdoc}
	*/
	public function purge_step($old_state)
	{
		if ($old_state === false)
		{
			$this->container->get('notification_manager')->purge_notifications($this->notif_name);
			return 'notification';
		}

		return parent::purge_step($old_state);
	}
}
