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

namespace leinad4mind\userdefaults\controller;

use leinad4mind\userdefaults\core\settings_policy;
use phpbb\config\config;
use phpbb\language\language;
use phpbb\log\log;
use phpbb\request\request;
use phpbb\template\template;
use phpbb\user;

class admin_controller
{
	/** @var config */
	protected $config;

	/** @var request */
	protected $request;

	/** @var template */
	protected $template;

	/** @var user */
	protected $user;

	/** @var log */
	protected $log;

	/** @var language */
	protected $language;

	/** @var settings_policy */
	protected $policy;

	/** @var string */
	protected $u_action = '';

	public function __construct(config $config, request $request, template $template, user $user, log $log, language $language, settings_policy $policy)
	{
		$this->config = $config;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->log = $log;
		$this->language = $language;
		$this->policy = $policy;
	}

	public function display_options()
	{
		$this->language->add_lang('acp_userdefaults', 'leinad4mind/userdefaults');
		$this->language->add_lang('ucp');
		add_form_key('leinad4mind_userdefaults');

		$date_formats = $this->language->lang_raw('dateformats');
		if ($this->request->is_set_post('submit'))
		{
			if (!check_form_key('leinad4mind_userdefaults'))
			{
				trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			$settings = $this->policy->normalise_submission(
				$this->submission_data(),
				array_keys($date_formats),
				isset($this->config['ud_options']) ? $this->config['ud_options'] : 230271
			);
			$this->persist_changed($settings);
			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'USER_DEFAULTS_LOG');
			trigger_error($this->language->lang('CONFIG_UPDATED') . adm_back_link($this->u_action));
		}

		$settings = $this->stored_settings();
		$sort_directions = [
			'a' => $this->language->lang('ASCENDING'),
			'd' => $this->language->lang('DESCENDING'),
		];
		$day_options = [
			0 => $this->language->lang('ALL_TOPICS'),
			1 => $this->language->lang('1_DAY'),
			7 => $this->language->lang('7_DAYS'),
			14 => $this->language->lang('2_WEEKS'),
			30 => $this->language->lang('1_MONTH'),
			90 => $this->language->lang('3_MONTHS'),
			180 => $this->language->lang('6_MONTHS'),
			365 => $this->language->lang('1_YEAR'),
		];
		$topic_sort_keys = [
			'a' => $this->language->lang('AUTHOR'),
			't' => $this->language->lang('POST_TIME'),
			'r' => $this->language->lang('REPLIES'),
			's' => $this->language->lang('SUBJECT'),
			'v' => $this->language->lang('VIEWS'),
		];
		$post_sort_keys = [
			'a' => $this->language->lang('AUTHOR'),
			't' => $this->language->lang('POST_TIME'),
			's' => $this->language->lang('SUBJECT'),
		];

		$this->template->assign_vars(array_merge($this->template_values($settings), [
			'DATE_FORMAT_OPTIONS' => $this->date_format_options($date_formats, $settings['ud_date_format']),
			'DEFAULT_DATE_FORMAT' => $this->language->lang('DEFAULT_DATE_FORMAT', $this->user->format_date(time(), 'd M Y H:i', false)),
			'POST_DAY_OPTIONS' => $this->select_options($day_options, $settings['ud_post_st']),
			'POST_DIRECTION_OPTIONS' => $this->select_options($sort_directions, $settings['ud_post_sd']),
			'POST_KEY_OPTIONS' => $this->select_options($post_sort_keys, $settings['ud_post_sk']),
			'TOPIC_DAY_OPTIONS' => $this->select_options($day_options, $settings['ud_topic_st']),
			'TOPIC_DIRECTION_OPTIONS' => $this->select_options($sort_directions, $settings['ud_topic_sd']),
			'TOPIC_KEY_OPTIONS' => $this->select_options($topic_sort_keys, $settings['ud_topic_sk']),
			'U_ACTION' => $this->u_action,
		]));
	}

	protected function submission_data()
	{
		$input = [
			'current_date_format' => isset($this->config['ud_date_format']) ? $this->config['ud_date_format'] : 'd M Y H:i',
			'ud_date_format' => $this->request->variable('ud_date_format', '', true),
		];
		foreach (settings_policy::BOOLEAN_DEFAULTS as $key => $default)
		{
			$input[$key] = $this->request->variable($key, 0);
		}
		foreach (settings_policy::OPTION_BITS as $key => $bit)
		{
			$input[$key] = $this->request->variable($key, 0);
		}
		foreach (settings_policy::SORT_FIELDS as $policy)
		{
			$input[$policy['request']] = $this->request->variable($policy['request'], $policy['default']);
		}
		return $input;
	}

	protected function stored_settings()
	{
		$stored = [];
		foreach ($this->policy->defaults() as $key => $default)
		{
			if (isset($this->config[$key]))
			{
				$stored[$key] = $this->config[$key];
			}
		}
		return $this->policy->normalise_stored($stored);
	}

	protected function persist_changed(array $settings)
	{
		foreach ($settings as $key => $value)
		{
			if (!isset($this->config[$key]) || (string) $this->config[$key] !== (string) $value)
			{
				$this->config->set($key, $value);
			}
		}
	}

	protected function date_format_options(array $formats, $selected)
	{
		$options = [];
		foreach ($formats as $format => $unused)
		{
			$label = $this->user->format_date(time(), $format, false);
			if (strpos($format, '|') !== false)
			{
				$label .= $this->language->lang('VARIANT_DATE_SEPARATOR') . $this->user->format_date(time(), $format, true);
			}
			$options[] = [
				'VALUE' => $format,
				'LABEL' => $label,
				'S_SELECTED' => $format === $selected,
			];
		}
		return $options;
	}

	protected function select_options(array $labels, $selected)
	{
		$options = [];
		foreach ($labels as $value => $label)
		{
			$options[] = [
				'VALUE' => $value,
				'LABEL' => $label,
				'S_SELECTED' => $value === $selected,
			];
		}
		return $options;
	}

	protected function template_values(array $settings)
	{
		$options = $settings['ud_options'];
		return [
			'HEAD_TITLE' => $this->language->lang('USER_DEFAULTS'),
			'HEAD_DESCRIPTION' => $this->language->lang('USER_DEFAULTS_EXPLAIN'),
			'NOTIFY_BOOKMARK' => $settings['ud_type_bookmark'],
			'NOTIFY_FORUM_POST' => $settings['ud_type_forum_post'],
			'NOTIFY_GROUP' => $settings['ud_type_group'],
			'NOTIFY_MODERATOR_APPROVAL' => $settings['ud_type_needs_approval'],
			'NOTIFY_MODERATION_QUEUE' => $settings['ud_moderation_queue'],
			'NOTIFY_PM' => $settings['ud_type_pm'],
			'NOTIFY_PM_CLOSE' => $settings['ud_type_pm_close'],
			'NOTIFY_PM_REPORT' => $settings['ud_type_pm_report'],
			'NOTIFY_QUOTE' => $settings['ud_type_quote'],
			'NOTIFY_REPORT' => $settings['ud_type_report'],
			'NOTIFY_REPORT_CLOSE' => $settings['ud_type_report_close'],
			'NOTIFY_SUBSCRIBED' => $settings['ud_type_post'],
			'NOTIFY_TOPIC' => $settings['ud_type_topic'],
			'S_AVATARS' => $this->option_enabled($options, 4),
			'S_BBCODE' => $this->option_enabled($options, 8),
			'S_DISABLE_CENSORS' => $this->option_enabled($options, 5),
			'S_FLASH' => $this->option_enabled($options, 1),
			'S_IMAGES' => $this->option_enabled($options, 0),
			'S_SMILIES' => $this->option_enabled($options, 9),
			'S_SIG' => $this->option_enabled($options, 6),
			'S_SIGS' => $this->option_enabled($options, 3),
			'S_VSMILIES' => $this->option_enabled($options, 2),
			'USER_ALLOW_MASSEMAIL' => $settings['ud_allow_massemail'],
			'USER_ALLOW_PM' => $settings['ud_allow_pm'],
			'USER_ALLOW_VIEWEMAIL' => $settings['ud_allow_viewemail'],
			'USER_NOTIFY' => $settings['ud_notify'],
			'USER_NOTIFY_PM' => $settings['ud_notify_pm'],
		];
	}

	protected function option_enabled($options, $bit)
	{
		return ((int) $options & (1 << $bit)) !== 0;
	}

	public function set_page_url($u_action)
	{
		$this->u_action = (string) $u_action;
	}
}
