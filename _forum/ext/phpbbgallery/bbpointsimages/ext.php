<?php
/**
 * phpBB Gallery - BBPoints Images Extension
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbpointsimages;

use phpbbgallery\bbpointsimages\notification\helper;

class ext extends \phpbb\extension\base
{
	private const DEPENDENCIES = [
		'phpbbgallery/core',
		'sitesplat/bbpoints',
	];
	private const NOTIFICATION_TYPES = [
		helper::REWARD_TYPE,
		helper::SOURCE_PURCHASE_TYPE,
	];

	public function is_enableable(): bool
	{
		$manager = $this->container->get('ext.manager');
		$user = $this->container->get('user');
		$missing = array_values(array_filter(self::DEPENDENCIES, static function (string $dependency) use ($manager): bool
		{
			return !$manager->is_enabled($dependency) && !$manager->is_available($dependency);
		}));
		if (!empty($missing))
		{
			return $this->reject_missing_dependencies($user, $missing);
		}

		foreach (self::DEPENDENCIES as $dependency)
		{
			if (!$manager->is_enabled($dependency))
			{
				$manager->enable($dependency);
			}
		}

		$inactive = array_values(array_filter(self::DEPENDENCIES, static function (string $dependency) use ($manager): bool
		{
			return !$manager->is_enabled($dependency);
		}));
		if (!empty($inactive))
		{
			return $this->reject_missing_dependencies($user, $inactive);
		}

		return true;
	}

	public function enable_step(mixed $old_state): mixed
	{
		if (empty($old_state))
		{
			$this->container->get('template')->assign_var(
				'L_EXTENSION_ENABLE_SUCCESS',
				$this->container->get('user')->lang['EXTENSION_ENABLE_SUCCESS']
			);
			$this->update_notification_types('enable_notifications');
			return 'notifications';
		}

		return parent::enable_step($old_state);
	}

	public function disable_step(mixed $old_state): mixed
	{
		if (empty($old_state))
		{
			$this->update_notification_types('disable_notifications');
			return 'notifications';
		}

		return parent::disable_step($old_state);
	}

	public function purge_step(mixed $old_state): mixed
	{
		if (empty($old_state))
		{
			$this->update_notification_types('purge_notifications');
			return 'notifications';
		}

		return parent::purge_step($old_state);
	}

	private function update_notification_types(string $method): void
	{
		$notification_manager = $this->container->get('notification_manager');
		foreach (self::NOTIFICATION_TYPES as $notification_type)
		{
			$notification_manager->{$method}($notification_type);
		}
	}

	private function reject_missing_dependencies(object $user, array $dependencies): bool
	{
		$user->add_lang_ext('phpbbgallery/bbpointsimages', 'info_acp_bbpointsimages');
		trigger_error($user->lang('BBPOINTSIMAGES_DEPENDENCIES_MISSING', implode(', ', $dependencies)), E_USER_WARNING);
		return false;
	}
}
