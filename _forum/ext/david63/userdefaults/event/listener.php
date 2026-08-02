<?php
/**
 *
 * User Defaults extension for phpBB.
 *
 * @copyright (c) 2016 David Wood
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace david63\userdefaults\event;

use david63\userdefaults\core\settings_policy;
use phpbb\config\config;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	/** @var config */
	protected $config;

	/** @var settings_policy */
	protected $policy;

	public function __construct(config $config, settings_policy $policy)
	{
		$this->config = $config;
		$this->policy = $policy;
	}

	public static function getSubscribedEvents()
	{
		return [
			'core.user_add_modify_data' => 'modify_user_defaults',
		];
	}

	public function modify_user_defaults($event)
	{
		$user_row = $event['user_row'];
		if (defined('USER_IGNORE') && isset($user_row['user_type']) && (int) $user_row['user_type'] === USER_IGNORE)
		{
			return;
		}

		$stored = [];
		foreach ($this->policy->defaults() as $key => $default)
		{
			if (isset($this->config[$key]))
			{
				$stored[$key] = $this->config[$key];
			}
		}
		$settings = $this->policy->normalise_stored($stored);

		if ($event['notifications_data'] === null)
		{
			$notifications = [];
			foreach ($this->policy->notification_types() as $config_key => $item_type)
			{
				if ($settings[$config_key] === 1)
				{
					$notifications[] = [
						'item_type' => $item_type,
						'method' => 'notification.method.email',
					];
				}
			}
			$event['notifications_data'] = $notifications;
		}

		$sql_ary = $event['sql_ary'];
		$sql_ary['user_allow_massemail'] = $settings['ud_allow_massemail'];
		$sql_ary['user_allow_pm'] = $settings['ud_allow_pm'];
		$sql_ary['user_allow_viewemail'] = $settings['ud_allow_viewemail'];
		$sql_ary['user_dateformat'] = $settings['ud_date_format'];
		$sql_ary['user_notify'] = $settings['ud_notify'];
		$sql_ary['user_notify_pm'] = $settings['ud_notify_pm'];
		$sql_ary['user_options'] = $settings['ud_options'];
		$sql_ary['user_post_show_days'] = $settings['ud_post_st'];
		$sql_ary['user_post_sortby_dir'] = $settings['ud_post_sd'];
		$sql_ary['user_post_sortby_type'] = $settings['ud_post_sk'];
		$sql_ary['user_topic_show_days'] = $settings['ud_topic_st'];
		$sql_ary['user_topic_sortby_dir'] = $settings['ud_topic_sd'];
		$sql_ary['user_topic_sortby_type'] = $settings['ud_topic_sk'];
		$event['sql_ary'] = $sql_ary;
	}
}
