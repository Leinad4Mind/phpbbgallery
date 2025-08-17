<?php

/**
 *
 * Staff Notifications. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019-2020, Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\staffnotifications;

use phpbb\config\config;
use Symfony\Component\Finder\Finder;

class settings
{
	/** @var config */
	protected $config;

	/**
	 * @param config $config
	 */
	public function __construct(
		config $config
	)
	{
		$this->config = $config;
	}

	/**
	 * @return array
	 */
	public static function get_all_notifications()
	{
		$finder = Finder::create()
			->files()
			->notName('base.php')
			->in(__DIR__ . '/notification/type');

		$notification_names = [];

		foreach ($finder as $file)
		{
			$notification_names[] = pathinfo($file->getFilename(), PATHINFO_FILENAME);
		}

		sort($notification_names);

		return $notification_names;
	}

	/**
	 * @return array
	 */
	public function get_enabled_notifications()
	{
		return explode(',', $this->config['staffnotifications_notifications']) ?: [];
	}

	/**
	 * @param array $notifications
	 */
	public function set_enabled_notifications(array $notifications)
	{
		$notifications = array_intersect($notifications, static::get_all_notifications());
		$this->config->set('staffnotifications_notifications', implode(',', $notifications));
	}

	/**
	 * @param string $notification_name
	 * @return bool
	 */
	public function is_notification_enabled($notification_name)
	{
		$notifications = $this->get_enabled_notifications();
		return in_array($notification_name, $notifications);
	}

	/**
	 * @return array
	 */
	public function get_enabled_groups()
	{
		return explode(',', $this->config['staffnotifications_groups']);
	}

	/**
	 * @param array $groups
	 */
	public function set_enabled_groups(array $groups)
	{
		$this->config->set('staffnotifications_groups', implode(',', $groups));
	}
}
