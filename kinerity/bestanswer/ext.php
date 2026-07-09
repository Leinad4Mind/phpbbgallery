<?php
/**
 *
 * Best Answer extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, kinerity, https://www.layer-3.org/
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace kinerity\bestanswer;

/**
 * Best Answer extension base
 *
 * It is recommended to remove this file from
 * an extension if it is not going to be used.
 */
class ext extends \phpbb\extension\base
{
	/**
	 * Check whether or not the extension can be enabled.
	 * The current phpBB version should meet or exceed
	 * the minimum version required by this extension:
	 *
	 * Requires phpBB 3.2.0 and PHP 5.4.7
	 *
	 * @return bool
	 * @access public
	 */
	public function is_enableable()
	{
		$config = $this->container->get('config');

		return phpbb_version_compare($config['version'], '3.2.0', '>=') && version_compare(PHP_VERSION, '5.4.7', '>=');
	}

	/**
	 * Overwrite enable_step to enable notifications
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

				// Enable notifications
				$phpbb_notifications = $this->container->get('notification_manager');
				$phpbb_notifications->enable_notifications('kinerity.bestanswer.notification.type.markanswer');
				$phpbb_notifications->enable_notifications('kinerity.bestanswer.notification.type.unmarkanswer');
				return 'notifications';

			break;

			default:

				// Run parent enable step method
				return parent::enable_step($old_state);

			break;
		}
	}

	/**
	 * Overwrite disable_step to disable notifications
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

				// Disable notifications
				$phpbb_notifications = $this->container->get('notification_manager');
				$phpbb_notifications->disable_notifications('kinerity.bestanswer.notification.type.markanswer');
				$phpbb_notifications->disable_notifications('kinerity.bestanswer.notification.type.unmarkanswer');
				return 'notifications';

			break;

			default:

				// Run parent disable step method
				return parent::disable_step($old_state);

			break;
		}
	}

	/**
	 * Overwrite purge_step to purge notifications before
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

				// Purge notifications
				$phpbb_notifications = $this->container->get('notification_manager');
				$phpbb_notifications->purge_notifications('kinerity.bestanswer.notification.type.markanswer');
				$phpbb_notifications->purge_notifications('kinerity.bestanswer.notification.type.unmarkanswer');
				return 'notifications';

			break;

			default:

				// Run parent purge step method
				return parent::purge_step($old_state);

			break;
		}
	}
}
