<?php
/**
 *
 * Notification_manager for the phpBB Forum Software package.
 *
 * @copyright (c) 2017 ForumHulp.com <http://forumhulp.com>
 * @license Proprietary
 *
 */

namespace forumhulp\notification_manager;

class ext extends \phpbb\extension\base
{
	public function is_enableable(): bool
	{
		if (!class_exists('forumhulp\helper\helper'))
		{
			$this->container->get('user')->add_lang_ext(
				'forumhulp/notification_manager',
				'info_acp_notification_manager'
			);
			trigger_error($this->container->get('user')->lang['FH_HELPER_NOTICE'], E_USER_WARNING);

			return false;
		}

		return $this->container->get('ext.manager')->is_enabled('forumhulp/helper');
	}

	public function enable_step($old_state)
	{
		$state = parent::enable_step($old_state);
		if ($state === false)
		{
			$this->container->get('user')->add_lang_ext(
				'forumhulp/notification_manager',
				'info_acp_notification_manager'
			);
			$this->container->get('template')->assign_var(
				'L_EXTENSION_ENABLE_SUCCESS',
				$this->container->get('user')->lang['EXTENSION_ENABLE_SUCCESS']
					. ($this->container->get('user')->lang['NOTIFICATION_MANAGER_NOTICE'] ?? '')
			);
			$this->restore_config(true);
		}

		return $state;
	}

	public function disable_step($old_state)
	{
		if ($old_state === '')
		{
			$this->restore_config(false);
		}

		return parent::disable_step($old_state);
	}

	private function restore_config(bool $enable_extension): void
	{
		$this->set_module_enabled(
			'UCP_NOTIFICATION_LIST',
			'notification_list',
			!$enable_extension
		);
		$this->set_module_enabled('UCP_NOTIES', 'noties', $enable_extension);
	}

	private function set_module_enabled(string $language_name, string $mode, bool $enabled): void
	{
		$db = $this->container->get('dbal.conn');
		$sql = 'UPDATE ' . MODULES_TABLE . '
			SET ' . $db->sql_build_array('UPDATE', [
				'module_enabled' => $enabled ? 1 : 0,
			]) . "
			WHERE module_class = 'ucp'
				AND module_langname = '" . $db->sql_escape($language_name) . "'
				AND module_mode = '" . $db->sql_escape($mode) . "'";
		$db->sql_query($sql);
	}
}
