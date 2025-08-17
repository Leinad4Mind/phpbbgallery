<?php

/**
 *
 * Special Topic Move. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\specialtopicmove;

use phpbb\extension\base;

class ext extends base
{
	const SPECIAL_TOPIC_MOVED_BIT_FIRST		= 0x01;
	const SPECIAL_TOPIC_MOVED_BIT_LAST		= 0x02;
	const SPECIAL_TOPIC_MOVED_BIT_MOVED		= 0x04;
	const SPECIAL_TOPIC_MOVED_BIT_SHADOW	= 0x08;

	/**
	 * @return bool
	 */
	public function is_enableable()
	{
		return phpbb_version_compare(PHPBB_VERSION, '3.2.2', '>=') && phpbb_version_compare(PHP_VERSION, '5.4.7', '>=');
	}

	/**
	 * @param mixed $old_state
	 * @return false|string
	 */
	public function enable_step($old_state)
	{
		return $this->trigger_notifications('enable', $old_state);
	}

	/**
	 * @param mixed $old_state
	 * @return false|string
	 */
	public function disable_step($old_state)
	{
		return $this->trigger_notifications('disable', $old_state);
	}

	/**
	 * @param mixed $old_state
	 * @return false|string
	 */
	public function purge_step($old_state)
	{
		return $this->trigger_notifications('purge', $old_state);
	}

	/**
	 * @param string $mode
	 * @param mixed $old_state
	 * @return false|string
	 */
	protected function trigger_notifications($mode, $old_state)
	{
		switch ($old_state)
		{
			case '':
				$phpbb_notifications = $this->container->get('notification_manager');
				$phpbb_notifications->{$mode . '_notifications'}('leinad4mind.specialtopicmove.notification.type.topic_moved');
				return 'notifications';
			break;

			default:
				$step = $mode . '_step';
				return parent::$step($old_state);
			break;
		}
	}
}
