<?php
/**
 *
 * User Defaults extension for phpBB.
 *
 * @copyright (c) 2016 David Wood
 * @copyright (c) 2022 devspace
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace devspace\userdefaults\controller;

use devspace\userdefaults\core\settings_policy;
use devspace\userdefaults\core\notification_defaults;
use devspace\userdefaults\core\user_sync;
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

	/** @var notification_defaults */
	protected $notifications;

	/** @var user_sync */
	protected $user_sync;

	/** @var string */
	protected $u_action = '';

	public function __construct(config $config, request $request, template $template, user $user, log $log, language $language, settings_policy $policy, notification_defaults $notifications, user_sync $user_sync)
	{
		$this->config = $config;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->log = $log;
		$this->language = $language;
		$this->policy = $policy;
		$this->notifications = $notifications;
		$this->user_sync = $user_sync;
	}

	public function display_options()
	{
		$this->language->add_lang('acp_userdefaults', 'devspace/userdefaults');
		$this->language->add_lang('ucp');
		add_form_key('devspace_userdefaults');

		if ($this->request->is_set_post('sync_users'))
		{
			$this->synchronise_users();
			return;
		}

		$date_formats = $this->language->lang_raw('dateformats');
		if ($this->request->is_set_post('submit'))
		{
			if (!check_form_key('devspace_userdefaults'))
			{
				trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			$settings = $this->policy->normalise_submission(
				$this->submission_data(),
				array_keys($date_formats),
				isset($this->config['ud_options']) ? $this->config['ud_options'] : 230271
			);
			$submitted_notifications = $this->request->variable('notification_defaults', array(0 => array(0 => 0)));
			$settings[notification_defaults::CONFIG_KEY] = $this->notifications->encode(
				$this->notifications->normalise_submission($submitted_notifications)
			);
			$this->persist_changed($settings);
			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'USER_DEFAULTS_LOG');
			trigger_error($this->language->lang('CONFIG_UPDATED') . adm_back_link($this->u_action));
		}

		$settings = $this->stored_settings();
		$notification_settings = $this->notifications->normalise_stored(
			isset($this->config[notification_defaults::CONFIG_KEY]) ? $this->config[notification_defaults::CONFIG_KEY] : null,
			$this->notifications->legacy_values($this->config)
		);
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
			'NOTIFICATION_GROUPS' => $this->notifications->template_groups($this->language, $notification_settings),
			'S_JABBER_DISABLED' => empty($this->config['jab_enable']),
			'SYNC_CURSOR' => max(0, $this->request->variable('sync_cursor', 0)),
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
		foreach (settings_policy::CHOICE_FIELDS as $policy)
		{
			$input[$policy['request']] = $this->request->variable($policy['request'], $policy['default']);
		}
		if (empty($this->config['jab_enable']) && $input['ud_notify_type'] !== 0)
		{
			$input['ud_notify_type'] = 0;
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
			'S_AVATARS' => $this->option_enabled($options, 4),
			'S_BBCODE' => $this->option_enabled($options, 8),
			'S_DISABLE_CENSORS' => $this->option_enabled($options, 5),
			'S_FLASH' => $this->option_enabled($options, 1),
			'S_IMAGES' => $this->option_enabled($options, 0),
			'S_SMILIES' => $this->option_enabled($options, 9),
			'S_SIG' => $this->option_enabled($options, 6),
			'S_POPUP_PM' => $this->option_enabled($options, 10),
			'S_SIG_BBCODE' => $this->option_enabled($options, 15),
			'S_SIG_SMILIES' => $this->option_enabled($options, 16),
			'S_SIG_LINKS' => $this->option_enabled($options, 17),
			'S_SIGS' => $this->option_enabled($options, 3),
			'S_VSMILIES' => $this->option_enabled($options, 2),
			'USER_ALLOW_MASSEMAIL' => $settings['ud_allow_massemail'],
			'USER_ALLOW_PM' => $settings['ud_allow_pm'],
			'USER_ALLOW_VIEWEMAIL' => $settings['ud_allow_viewemail'],
			'USER_ALLOW_VIEWONLINE' => $settings['ud_allow_viewonline'],
			'USER_NOTIFY' => $settings['ud_notify'],
			'USER_NOTIFY_PM' => $settings['ud_notify_pm'],
			'USER_NOTIFY_TYPE' => $settings['ud_notify_type'],
		];
	}

	protected function synchronise_users()
	{
		if (!check_form_key('devspace_userdefaults'))
		{
			$this->send_sync_response(['error' => $this->language->lang('FORM_INVALID')]);
		}
		if ($this->request->variable('sync_confirm', 0) !== 1)
		{
			$this->send_sync_response(['error' => $this->language->lang('SYNC_USERS_CONFIRM_REQUIRED')]);
		}

		$cursor = max(0, $this->request->variable('sync_cursor', 0));
		if ($cursor === 0)
		{
			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'USER_DEFAULTS_SYNC_STARTED');
		}

		$result = $this->user_sync->run_batch($cursor);
		if ($result['done'])
		{
			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'USER_DEFAULTS_SYNC_COMPLETED', false, [$result['total']]);
		}
		$this->send_sync_response($result);
	}

	protected function send_sync_response(array $data)
	{
		if ($this->request->is_ajax())
		{
			$response = new \phpbb\json_response();
			$response->send($data);
		}

		$message = isset($data['error'])
			? $data['error']
			: $this->language->lang('SYNC_USERS_BATCH_COMPLETE', $data['completed'], $data['total']);
		$back_url = $this->u_action;
		if (!isset($data['error']) && empty($data['done']))
		{
			$back_url .= '&amp;sync_cursor=' . (int) $data['next_cursor'];
		}
		trigger_error($message . adm_back_link($back_url), isset($data['error']) ? E_USER_WARNING : E_USER_NOTICE);
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
