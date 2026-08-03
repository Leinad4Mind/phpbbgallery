<?php
/**
 * User Defaults extension for phpBB.
 *
 * @copyright (c) 2022 devspace
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace devspace\userdefaults\core;

use phpbb\language\language;
use phpbb\notification\manager;

class notification_defaults
{
	const CONFIG_KEY = 'ud_notification_defaults';

	const LEGACY_TYPES = [
		'ud_moderation_queue' => ['type' => 'moderation_queue', 'default' => 0],
		'ud_type_bookmark' => ['type' => 'notification.type.bookmark', 'default' => 0],
		'ud_type_forum_post' => ['type' => 'notification.type.forum', 'default' => 0],
		'ud_type_group' => ['type' => 'notification.type.group_request', 'default' => 0],
		'ud_type_needs_approval' => ['type' => 'notification.type.needs_approval', 'default' => 0],
		'ud_type_pm' => ['type' => 'notification.type.pm', 'default' => 0],
		'ud_type_pm_close' => ['type' => 'notification.type.report_pm_closed', 'default' => 0],
		'ud_type_pm_report' => ['type' => 'notification.type.report_pm', 'default' => 0],
		'ud_type_post' => ['type' => 'notification.type.post', 'default' => 1],
		'ud_type_quote' => ['type' => 'notification.type.quote', 'default' => 0],
		'ud_type_report' => ['type' => 'notification.type.report', 'default' => 0],
		'ud_type_report_close' => ['type' => 'notification.type.report_post_closed', 'default' => 0],
		'ud_type_topic' => ['type' => 'notification.type.topic', 'default' => 1],
	];

	/** @var manager */
	protected $manager;

	/** @var array|null */
	protected $types;

	/** @var array|null */
	protected $methods;

	public function __construct(manager $manager)
	{
		$this->manager = $manager;
	}

	public function normalise_stored($raw, array $legacy_values = [])
	{
		$decoded = is_string($raw) && $raw !== '' ? json_decode($raw, true) : null;
		if (!is_array($decoded))
		{
			$decoded = $this->legacy_defaults($legacy_values);
		}

		return $this->normalise_map($decoded);
	}

	public function normalise_submission(array $submitted)
	{
		$types = $this->type_ids();
		$methods = $this->method_ids();
		$defaults = [];

		foreach ($submitted as $type_index => $submitted_methods)
		{
			$type_index = (int) $type_index;
			if (!isset($types[$type_index]) || !is_array($submitted_methods))
			{
				continue;
			}
			foreach ($submitted_methods as $method_index => $enabled)
			{
				$method_index = (int) $method_index;
				if (isset($methods[$method_index]) && (int) $enabled === 1)
				{
					$defaults[$types[$type_index]][] = $methods[$method_index];
				}
			}
		}

		return $this->normalise_map($defaults);
	}

	public function encode(array $defaults)
	{
		return json_encode($this->normalise_map($defaults), JSON_UNESCAPED_SLASHES);
	}

	public function subscriptions(array $defaults)
	{
		$subscriptions = [];
		foreach ($this->normalise_map($defaults) as $type => $methods)
		{
			foreach ($methods as $method)
			{
				$subscriptions[] = [
					'item_type' => $type,
					'method' => $method,
				];
			}
		}
		return $subscriptions;
	}

	public function apply_to_user($user_id, array $defaults)
	{
		$defaults = $this->normalise_map($defaults);
		foreach ($this->type_ids() as $type)
		{
			foreach ($this->method_ids() as $method)
			{
				if (isset($defaults[$type]) && in_array($method, $defaults[$type], true))
				{
					$this->manager->add_subscription($type, 0, $method, (int) $user_id);
				}
				else
				{
					$this->manager->delete_subscription($type, 0, $method, (int) $user_id);
				}
			}
		}
	}

	public function template_groups(language $language, array $defaults)
	{
		$defaults = $this->normalise_map($defaults);
		$method_ids = $this->method_ids();
		$methods = $this->methods();
		$groups = [];
		$type_index = 0;

		foreach ($this->types() as $group_key => $types)
		{
			$group = [
				'NAME' => $language->lang($group_key),
				'TYPES' => [],
			];
			foreach ($types as $type_id => $type_data)
			{
				$type = [
					'INDEX' => $type_index++,
					'NAME' => $language->lang($type_data['lang']),
					'METHODS' => [],
				];
				foreach ($method_ids as $method_index => $method_id)
				{
					$type['METHODS'][] = [
						'INDEX' => $method_index,
						'NAME' => $language->lang($methods[$method_id]['lang']),
						'S_CHECKED' => isset($defaults[$type_id]) && in_array($method_id, $defaults[$type_id], true),
					];
				}
				$group['TYPES'][] = $type;
			}
			$groups[] = $group;
		}

		return $groups;
	}

	public function legacy_values($config)
	{
		$values = [];
		foreach (self::LEGACY_TYPES as $config_key => $policy)
		{
			if (isset($config[$config_key]))
			{
				$values[$config_key] = $config[$config_key];
			}
		}
		return $values;
	}

	protected function legacy_defaults(array $values)
	{
		$defaults = [];
		foreach (self::LEGACY_TYPES as $config_key => $policy)
		{
			$enabled = isset($values[$config_key]) ? (int) $values[$config_key] === 1 : $policy['default'] === 1;
			$defaults[$policy['type']] = ['notification.method.board'];
			if ($enabled)
			{
				$defaults[$policy['type']][] = 'notification.method.email';
			}
		}
		return $defaults;
	}

	protected function normalise_map(array $defaults)
	{
		$allowed_types = $this->type_ids();
		$allowed_methods = $this->method_ids();
		$normalised = [];
		foreach ($defaults as $type => $methods)
		{
			$type = (string) $type;
			if (!in_array($type, $allowed_types, true) || !is_array($methods))
			{
				continue;
			}
			foreach ($methods as $method)
			{
				$method = (string) $method;
				if (in_array($method, $allowed_methods, true))
				{
					$normalised[$type][] = $method;
				}
			}
			if (isset($normalised[$type]))
			{
				$normalised[$type] = array_values(array_unique($normalised[$type]));
				sort($normalised[$type]);
			}
		}
		ksort($normalised);
		return $normalised;
	}

	protected function type_ids()
	{
		$ids = [];
		foreach ($this->types() as $types)
		{
			foreach ($types as $type_id => $unused)
			{
				$ids[] = (string) $type_id;
			}
		}
		return $ids;
	}

	protected function method_ids()
	{
		return array_keys($this->methods());
	}

	protected function types()
	{
		if ($this->types === null)
		{
			$this->types = $this->manager->get_subscription_types();
		}
		return $this->types;
	}

	protected function methods()
	{
		if ($this->methods === null)
		{
			$this->methods = [];
			foreach ($this->manager->get_subscription_methods() as $method_data)
			{
				$this->methods[(string) $method_data['id']] = $method_data;
			}
		}
		return $this->methods;
	}
}
