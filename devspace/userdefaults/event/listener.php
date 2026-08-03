<?php
/**
 * User Defaults extension for phpBB.
 *
 * @copyright (c) 2016 David Wood
 * @copyright (c) 2022 devspace
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace devspace\userdefaults\event;

use devspace\userdefaults\core\notification_defaults;
use devspace\userdefaults\core\settings_policy;
use phpbb\config\config;
use phpbb\extension\manager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	/** @var config */
	protected $config;

	/** @var settings_policy */
	protected $settings;

	/** @var notification_defaults */
	protected $notifications;

	/** @var manager */
	protected $extension_manager;

	/** @var array|null */
	protected $pending_notification_defaults;

	public function __construct(config $config, settings_policy $settings, notification_defaults $notifications, manager $extension_manager)
	{
		$this->config = $config;
		$this->settings = $settings;
		$this->notifications = $notifications;
		$this->extension_manager = $extension_manager;
	}

	public static function getSubscribedEvents()
	{
		return [
			'core.user_add_modify_data' => 'modify_user_defaults',
			'core.user_add_after' => 'apply_notification_defaults',
		];
	}

	public function modify_user_defaults($event)
	{
		$this->pending_notification_defaults = null;
		if ($this->has_conflict())
		{
			return;
		}
		$user_row = $event['user_row'];
		if (defined('USER_IGNORE') && isset($user_row['user_type']) && (int) $user_row['user_type'] === USER_IGNORE)
		{
			return;
		}

		$stored = [];
		foreach ($this->settings->defaults() as $key => $default)
		{
			if (isset($this->config[$key]))
			{
				$stored[$key] = $this->config[$key];
			}
		}
		$settings = $this->settings->normalise_stored($stored);

		if ($event['notifications_data'] === null)
		{
			$this->pending_notification_defaults = $this->notifications->normalise_stored(
				isset($this->config[notification_defaults::CONFIG_KEY]) ? $this->config[notification_defaults::CONFIG_KEY] : null,
				$this->notifications->legacy_values($this->config)
			);
			$event['notifications_data'] = $this->notifications->subscriptions($this->pending_notification_defaults);
		}

		$event['sql_ary'] = array_merge($event['sql_ary'], $this->settings->user_values($settings));
	}

	public function apply_notification_defaults($event)
	{
		if ($this->pending_notification_defaults === null)
		{
			return;
		}

		try
		{
			$this->notifications->apply_to_user((int) $event['user_id'], $this->pending_notification_defaults);
		}
		finally
		{
			$this->pending_notification_defaults = null;
		}
	}

	protected function has_conflict()
	{
		return $this->extension_manager->is_enabled('david63/userdefaults')
			|| $this->extension_manager->is_enabled('forumhulp/userdefault');
	}
}
