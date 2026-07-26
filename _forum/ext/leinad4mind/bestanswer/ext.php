<?php
/**
 *
 * Best Answer extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, kinerity, https://www.layer-3.org/
 * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\bestanswer;

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
	 * Requires phpBB 3.3.0 and PHP 7.1.3
	 *
	 * @return bool
	 * @access public
	 */
	public function is_enableable()
	{
		$config = $this->container->get('config');

		return phpbb_version_compare($config['version'], '3.3.0', '>=') && version_compare(PHP_VERSION, '7.1.3', '>=');
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

				$this->append_enable_notice();

				// Enable notifications
				$phpbb_notifications = $this->container->get('notification_manager');
				$phpbb_notifications->enable_notifications('leinad4mind.bestanswer.notification.type.markanswer');
				$phpbb_notifications->enable_notifications('leinad4mind.bestanswer.notification.type.unmarkanswer');
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
				$phpbb_notifications->disable_notifications('leinad4mind.bestanswer.notification.type.markanswer');
				$phpbb_notifications->disable_notifications('leinad4mind.bestanswer.notification.type.unmarkanswer');
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
				$phpbb_notifications->purge_notifications('leinad4mind.bestanswer.notification.type.markanswer');
				$phpbb_notifications->purge_notifications('leinad4mind.bestanswer.notification.type.unmarkanswer');
				return 'notifications';

			break;

			default:

				// Run parent purge step method
				return parent::purge_step($old_state);

			break;
		}
	}

	/**
	 * Append a notice to the ACP "extension enabled" message pointing the
	 * admin at the new board-features option and the permissions it added.
	 *
	 * The acp_ext_enable.html template only outputs lang('EXTENSION_ENABLE_SUCCESS')
	 * with no template variable or event to hook into, so the language string
	 * itself is extended here via reflection, since \phpbb\language\language
	 * exposes no public setter for an already-loaded key.
	 *
	 * @return void
	 * @access protected
	 */
	protected function append_enable_notice()
	{
		$language = $this->container->get('language');

		$language->add_lang(array('common', 'permissions_bestanswer'), 'leinad4mind/bestanswer');

		if (!$language->is_set('BESTANSWER_ENABLE_NOTICE') || !$language->is_set('EXTENSION_ENABLE_SUCCESS'))
		{
			return;
		}

		$notice = $language->lang('BESTANSWER_ENABLE_NOTICE',
			$language->lang('ACP_CAT_GENERAL'),
			$language->lang('ACP_BOARD_CONFIGURATION'),
			$language->lang('ACP_BOARD_FEATURES'),
			$language->lang('ACP_CAT_PERMISSIONS'),
			$language->lang('ACP_FORUM_BASED_PERMISSIONS'),
			$language->lang('ACP_FORUM_PERMISSIONS'),
			$language->lang('ACP_FORUM_MODERATORS'),
			$language->lang('ACL_F_MARK_ANSWER'),
			$language->lang('ACL_M_MARK_ANSWER')
		);

		$reflection = new \ReflectionProperty($language, 'lang');
		$reflection->setAccessible(true);
		$lang_array = $reflection->getValue($language);
		$lang_array['EXTENSION_ENABLE_SUCCESS'] .= $notice;
		$reflection->setValue($language, $lang_array);
	}
}
