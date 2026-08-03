<?php
/**
 * User Defaults extension for phpBB.
 *
 * @copyright (c) 2022 devspace
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace devspace\userdefaults\migrations;

use phpbb\db\migration\migration;

class version_3_3_2 extends migration
{
	const LEGACY_TYPES = [
		'ud_moderation_queue' => 'moderation_queue',
		'ud_type_bookmark' => 'notification.type.bookmark',
		'ud_type_forum_post' => 'notification.type.forum',
		'ud_type_group' => 'notification.type.group_request',
		'ud_type_needs_approval' => 'notification.type.needs_approval',
		'ud_type_pm' => 'notification.type.pm',
		'ud_type_pm_close' => 'notification.type.report_pm_closed',
		'ud_type_pm_report' => 'notification.type.report_pm',
		'ud_type_post' => 'notification.type.post',
		'ud_type_quote' => 'notification.type.quote',
		'ud_type_report' => 'notification.type.report',
		'ud_type_report_close' => 'notification.type.report_post_closed',
		'ud_type_topic' => 'notification.type.topic',
	];

	public static function depends_on()
	{
		return '\\devspace\\userdefaults\\migrations\\version_3_3_1';
	}

	public function update_data()
	{
		$data = [
			['custom', [[$this, 'migrate_notification_defaults']]],
			['config.add', ['ud_allow_viewonline', 1]],
			['config.add', ['ud_notify_type', 0]],
		];
		foreach (array_keys(self::LEGACY_TYPES) as $config_key)
		{
			$data[] = ['config.remove', [$config_key]];
		}
		return $data;
	}

	public function revert_data()
	{
		return [
			['custom', [[$this, 'restore_legacy_notification_defaults']]],
			['config.remove', ['ud_notification_defaults']],
			['config.remove', ['ud_allow_viewonline']],
			['config.remove', ['ud_notify_type']],
		];
	}

	public function migrate_notification_defaults()
	{
		$defaults = [];
		foreach (self::LEGACY_TYPES as $config_key => $type)
		{
			$defaults[$type] = ['notification.method.board'];
			if (!empty($this->config[$config_key]))
			{
				$defaults[$type][] = 'notification.method.email';
			}
		}
		$this->config->set('ud_notification_defaults', json_encode($defaults, JSON_UNESCAPED_SLASHES));
	}

	public function restore_legacy_notification_defaults()
	{
		$stored = isset($this->config['ud_notification_defaults'])
			? json_decode($this->config['ud_notification_defaults'], true)
			: [];
		$stored = is_array($stored) ? $stored : [];
		foreach (self::LEGACY_TYPES as $config_key => $type)
		{
			$enabled = isset($stored[$type]) && in_array('notification.method.email', (array) $stored[$type], true);
			$this->config->set($config_key, $enabled ? 1 : 0);
		}
	}
}
