<?php
/**
 * User Defaults extension for phpBB.
 *
 * @copyright (c) 2016 David Wood
 * @copyright (c) 2022 devspace
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace devspace\userdefaults\core;

class settings_policy
{
	const BOOLEAN_DEFAULTS = [
		'ud_allow_massemail' => 1,
		'ud_allow_pm' => 1,
		'ud_allow_viewemail' => 1,
		'ud_allow_viewonline' => 1,
		'ud_notify' => 0,
		'ud_notify_pm' => 1,
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
		'ud_popuppm' => 10,
		'ud_sig_bbcode' => 15,
		'ud_sig_smilies' => 16,
		'ud_sig_links' => 17,
	];

	const SORT_FIELDS = [
		'ud_post_sd' => ['request' => 'post_sd', 'default' => 'a', 'allowed' => ['a', 'd']],
		'ud_post_sk' => ['request' => 'post_sk', 'default' => 't', 'allowed' => ['a', 's', 't']],
		'ud_post_st' => ['request' => 'post_st', 'default' => 0, 'allowed' => [0, 1, 7, 14, 30, 90, 180, 365]],
		'ud_topic_sd' => ['request' => 'topic_sd', 'default' => 'd', 'allowed' => ['a', 'd']],
		'ud_topic_sk' => ['request' => 'topic_sk', 'default' => 't', 'allowed' => ['a', 'r', 's', 't', 'v']],
		'ud_topic_st' => ['request' => 'topic_st', 'default' => 0, 'allowed' => [0, 1, 7, 14, 30, 90, 180, 365]],
	];

	const CHOICE_FIELDS = [
		'ud_notify_type' => ['request' => 'ud_notify_type', 'default' => 0, 'allowed' => [0, 1, 2]],
	];

	public function defaults()
	{
		return array_merge(self::BOOLEAN_DEFAULTS, [
			'ud_date_format' => 'd M Y H:i',
			'ud_options' => 230271,
		], $this->field_defaults(self::SORT_FIELDS), $this->field_defaults(self::CHOICE_FIELDS));
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

		$this->normalise_fields($settings, $input, self::SORT_FIELDS);
		$this->normalise_fields($settings, $input, self::CHOICE_FIELDS);

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

		$this->normalise_fields($settings, $stored, self::SORT_FIELDS, true);
		$this->normalise_fields($settings, $stored, self::CHOICE_FIELDS, true);

		return $settings;
	}

	public function user_values(array $settings, $current_options = null)
	{
		$options = $current_options === null
			? $settings['ud_options']
			: $this->merge_user_options($current_options, $settings['ud_options']);

		return [
			'user_allow_massemail' => $settings['ud_allow_massemail'],
			'user_allow_pm' => $settings['ud_allow_pm'],
			'user_allow_viewemail' => $settings['ud_allow_viewemail'],
			'user_allow_viewonline' => $settings['ud_allow_viewonline'],
			'user_dateformat' => $settings['ud_date_format'],
			'user_notify' => $settings['ud_notify'],
			'user_notify_pm' => $settings['ud_notify_pm'],
			'user_notify_type' => $settings['ud_notify_type'],
			'user_options' => $options,
			'user_post_show_days' => $settings['ud_post_st'],
			'user_post_sortby_dir' => $settings['ud_post_sd'],
			'user_post_sortby_type' => $settings['ud_post_sk'],
			'user_topic_show_days' => $settings['ud_topic_st'],
			'user_topic_sortby_dir' => $settings['ud_topic_sd'],
			'user_topic_sortby_type' => $settings['ud_topic_sk'],
		];
	}

	public function merge_user_options($current_options, $configured_options)
	{
		$mask = $this->managed_option_mask();
		return ((int) $current_options & ~$mask) | ((int) $configured_options & $mask);
	}

	public function managed_option_mask()
	{
		$mask = 0;
		foreach (self::OPTION_BITS as $bit)
		{
			$mask |= 1 << $bit;
		}
		return $mask;
	}

	protected function field_defaults(array $fields)
	{
		return array_map(function ($policy)
		{
			return $policy['default'];
		}, $fields);
	}

	protected function normalise_fields(array &$settings, array $input, array $fields, $stored = false)
	{
		foreach ($fields as $config_key => $policy)
		{
			$request_key = $stored ? $config_key : $policy['request'];
			$value = isset($input[$request_key]) ? $input[$request_key] : $policy['default'];
			if (is_int($policy['default']))
			{
				$value = (int) $value;
			}
			$settings[$config_key] = in_array($value, $policy['allowed'], true) ? $value : $policy['default'];
		}
	}
}
