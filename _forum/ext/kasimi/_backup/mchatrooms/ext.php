<?php

/**
 *
 * @package phpBB Extension - mChat Rooms Addon
 * @copyright (c) 2016 kasimi - https://kasimi.net
 * @license proprietary
 *
 */

namespace kasimi\mchatrooms;

use kasimi\mchatrooms\core\constants;
use phpbb\extension\base;

class ext extends base
{
	/**
	 * Determines whether the extension can be enabled
	 *
	 * @return bool
	 * @access public
	 */
	public function is_enableable()
	{
		return phpbb_version_compare(PHPBB_VERSION, '3.2.0', '>=') && phpbb_version_compare(PHP_VERSION, '5.4.7', '>=');
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
				$phpbb_notifications->{$mode . '_notifications'}(constants::NOTIFICATION_TYPE_INVITE);
				return 'notifications';
			break;

			default:
				$step = $mode . '_step';
				return parent::$step($old_state);
			break;
		}
	}
}
