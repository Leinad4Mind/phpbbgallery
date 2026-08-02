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

namespace leinad4mind\userdefaults\core;

class settings_policy
{
	const BOOLEAN_DEFAULTS = [
		'ud_allow_massemail' => 1,
		'ud_allow_pm' => 1,
		'ud_allow_viewemail' => 1,
		'ud_notify' => 0,
		'ud_notify_pm' => 1,
		'ud_moderation_queue' => 0,
		'ud_type_bookmark' => 0,
		'ud_type_forum_post' => 0,
		'ud_type_group' => 0,
		'ud_type_needs_approval' => 0,
		'ud_type_pm' => 0,
		'ud_type_pm_close' => 0,
		'ud_type_pm_report' => 0,
		'ud_type_post' => 1,
		'ud_type_quote' => 0,
		'ud_type_report' => 0,
		'ud_type_report_close' => 0,
		'ud_type_topic' => 1,
	];

	const OPTION_BITS = [
		'ud_images' => 0,
		'ud_flash' => 1,
		'ud1_smilies' => 2,
		'ud_sigs' => 3,
		'ud_avatars' => 4,
		'ud_wordcensor' => 5,
		'ud_sig' => 6,
		'ud_bbcode' => 8,
		'ud_smilies' => 9,
	];

	const SORT_FIELDS = [
		'ud_post_sd' => ['request' => 'post_sd', 'default' => 'a', 'allowed' => ['a', 'd']],
		'ud_post_sk' => ['request' => 'post_sk', 'default' => 't', 'allowed' => ['a', 's', 't']],
		'ud_post_st' => ['request' => 'post_st', 'default' => 0, 'allowed' => [0, 1, 7, 14, 30, 90, 180, 365]],
		'ud_topic_sd' => ['request' => 'topic_sd', 'default' => 'd', 'allowed' => ['a', 'd']],
		'ud_topic_sk' => ['request' => 'topic_sk', 'default' => 't', 'allowed' => ['a', 'r', 's', 't', 'v']],
		'ud_topic_st' => ['request' => 'topic_st', 'default' => 0, 'allowed' => [0, 1, 7, 14, 30, 90, 180, 365]],
	];

	const NOTIFICATION_TYPES = [
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

	public function defaults()
	{
		return array_merge(self::BOOLEAN_DEFAULTS, [
			'ud_date_format' => 'd M Y H:i',
			'ud_options' => 230271,
		], array_map(function ($policy)
		{
			return $policy['default'];
		}, self::SORT_FIELDS));
	}

	public function normalise_submission(array $input, array $allowed_date_formats, $current_options)
	{
		$settings = [];
		foreach (self::BOOLEAN_DEFAULTS as $key => $default)
		{
			$settings[$key] = isset($input[$key]) && (int) $input[$key] === 1 ? 1 : 0;
		}

		$current_date_format = isset($input['current_date_format']) ? (string) $input['current_date_format'] : 'd M Y H:i';
		if (!in_array($current_date_format, $allowed_date_formats, true))
		{
			$fallback_date_format = reset($allowed_date_formats);
			$current_date_format = in_array('d M Y H:i', $allowed_date_formats, true) ? 'd M Y H:i' : $fallback_date_format;
			$current_date_format = $current_date_format === false ? 'd M Y H:i' : $current_date_format;
		}
		$date_format = isset($input['ud_date_format']) ? (string) $input['ud_date_format'] : '';
		$settings['ud_date_format'] = in_array($date_format, $allowed_date_formats, true) ? $date_format : $current_date_format;

		$options = max(0, (int) $current_options);
		foreach (self::OPTION_BITS as $request_key => $bit)
		{
			$enabled = isset($input[$request_key]) && (int) $input[$request_key] === 1;
			$options = $enabled ? $options | (1 << $bit) : $options & ~(1 << $bit);
		}
		$settings['ud_options'] = $options;

		foreach (self::SORT_FIELDS as $config_key => $policy)
		{
			$value = isset($input[$policy['request']]) ? $input[$policy['request']] : $policy['default'];
			if (is_int($policy['default']))
			{
				$value = (int) $value;
			}
			$settings[$config_key] = in_array($value, $policy['allowed'], true) ? $value : $policy['default'];
		}

		return $settings;
	}

	public function normalise_stored(array $stored)
	{
		$settings = $this->defaults();
		foreach (self::BOOLEAN_DEFAULTS as $key => $default)
		{
			if (isset($stored[$key]))
			{
				$settings[$key] = (int) $stored[$key] === 1 ? 1 : 0;
			}
		}

		if (isset($stored['ud_date_format']) && is_string($stored['ud_date_format']) && strlen($stored['ud_date_format']) <= 64)
		{
			$settings['ud_date_format'] = $stored['ud_date_format'];
		}
		$settings['ud_options'] = isset($stored['ud_options']) ? max(0, (int) $stored['ud_options']) : $settings['ud_options'];

		foreach (self::SORT_FIELDS as $key => $policy)
		{
			$value = isset($stored[$key]) ? $stored[$key] : $policy['default'];
			if (is_int($policy['default']))
			{
				$value = (int) $value;
			}
			$settings[$key] = in_array($value, $policy['allowed'], true) ? $value : $policy['default'];
		}

		return $settings;
	}

	public function notification_types()
	{
		return self::NOTIFICATION_TYPES;
	}
}
