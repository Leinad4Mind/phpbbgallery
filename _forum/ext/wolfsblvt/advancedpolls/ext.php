<?php
/**
 *
 * Advanced Polls
 *
 * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
 */

namespace wolfsblvt\advancedpolls;

class ext extends \phpbb\extension\base
{
	/**
	* Checks whether this extension can be enabled on the running phpBB version
	*
	* @return bool
	*/
	public function is_enableable()
	{
		return core\compatibility::supports(PHP_VERSION, PHPBB_VERSION);
	}

	/**
	* Overwrite enable_step to enable advanced polls notifications
	* before any included migrations are installed.
	*
	* @param mixed $old_state State returned by previous call of this method
	* @return mixed Returns false after last step, otherwise temporary state
	*/
	public function enable_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet

				// Enable advanced polls notifications
				$phpbb_notifications = $this->container->get('notification_manager');
				foreach ($this->notification_types() as $notification_type)
				{
					$phpbb_notifications->enable_notifications($notification_type);
				}

				return 'notifications';

			break;

			default:

				// Run parent enable step method
				$state = parent::enable_step($old_state);
				if ($state === false)
				{
					$this->append_enable_notice();
				}

				return $state;

			break;
		}
	}

	/**
	 * Append the required next steps to phpBB's successful enable message.
	 *
	 * @return void
	 */
	protected function append_enable_notice()
	{
		$language = $this->container->get('language');
		$language->add_lang(array('info_acp_advancedpolls', 'permissions_advancedpolls'), 'wolfsblvt/advancedpolls');

		if (!$language->is_set('AP_ENABLE_NOTICE') || !$language->is_set('EXTENSION_ENABLE_SUCCESS'))
		{
			return;
		}

		$notice = $language->lang('AP_ENABLE_NOTICE',
			$language->lang('ACP_CAT_DOT_MODS'),
			$language->lang('AP_TITLE_ACP'),
			$language->lang('AP_SETTINGS_ACP'),
			$language->lang('ACP_CAT_PERMISSIONS'),
			$language->lang('ACP_FORUM_BASED_PERMISSIONS'),
			$language->lang('ACP_FORUM_PERMISSIONS'),
			$language->lang('ACP_FORUM_MODERATORS'),
			$language->lang('ACL_F_SEEVOTERS'),
			$language->lang('ACL_M_SEEVOTERS')
		);

		// acp_ext_enable.html calls lang() directly, so update the loaded key.
		$reflection = new \ReflectionProperty($language, 'lang');
		$reflection->setAccessible(true);
		$lang_array = $reflection->getValue($language);
		$lang_array['EXTENSION_ENABLE_SUCCESS'] .= $notice;
		$reflection->setValue($language, $lang_array);
	}

	/**
	* Overwrite disable_step to disable advanced polls notifications
	* before the extension is disabled.
	*
	* @param mixed $old_state State returned by previous call of this method
	* @return mixed Returns false after last step, otherwise temporary state
	*/
	public function disable_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet

				// Disable advanced polls notifications
				$phpbb_notifications = $this->container->get('notification_manager');
				foreach ($this->notification_types() as $notification_type)
				{
					$phpbb_notifications->disable_notifications($notification_type);
				}

				return 'notifications';

			break;

			default:

				// Run parent disable step method
				return parent::disable_step($old_state);

			break;
		}
	}

	/**
	* Overwrite purge_step to purge advanced polls notifications before
	* any included and installed migrations are reverted.
	*
	* @param mixed $old_state State returned by previous call of this method
	* @return mixed Returns false after last step, otherwise temporary state
	*/
	public function purge_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet

				// Purge advanced polls notifications
				$phpbb_notifications = $this->container->get('notification_manager');
				foreach ($this->notification_types() as $notification_type)
				{
					$phpbb_notifications->purge_notifications($notification_type);
				}

				return 'notifications';

			break;

			default:

				// Run parent purge step method
				return parent::purge_step($old_state);

			break;
		}
	}

	/**
	 * Notification types owned by the extension.
	 *
	 * @return array
	 */
	protected function notification_types()
	{
		return array(
			'wolfsblvt.advancedpolls.notification.type.pollended',
			'wolfsblvt.advancedpolls.notification.type.optionsadded',
		);
	}
}
