<?php

/**
 *
 * Staff Notifications. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\staffnotifications\event;

use phpbb\event\data;
use phpbb\group\helper as group_helper;
use phpbb\language\language;
use phpbb\request\request_interface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use leinad4mind\staffnotifications\helper;
use leinad4mind\staffnotifications\settings;

class acp_listener implements EventSubscriberInterface
{
	/** @var request_interface */
	protected $request;

	/* @var language */
	protected $language;

	/** @var group_helper */
	protected $group_helper;

	/** @var settings */
	protected $settings;

	/** @var helper */
	protected $helper;

	/**
	 * @param request_interface	$request
	 * @param language			$language
	 * @param group_helper		$group_helper
	 * @param settings			$settings
	 * @param helper			$helper
	 */
	public function __construct(
		request_interface $request,
		language $language,
		group_helper $group_helper,
		settings $settings,
		helper $helper
	)
	{
		$this->request		= $request;
		$this->language		= $language;
		$this->group_helper	= $group_helper;
		$this->settings		= $settings;
		$this->helper		= $helper;
	}

	/**
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		return [
			'core.acp_board_config_edit_add' => 'acp_board_config_edit_add',
		];
	}

	/**
	 * @param data $event
	 */
	public function acp_board_config_edit_add(data $event)
	{
		if ($event['mode'] == 'features')
		{
			if ($event['submit'])
			{
				$notifications = $this->request->variable('staffnotifications_notifications', ['']);
				$this->settings->set_enabled_notifications($notifications);

				$groups = $this->request->variable('staffnotifications_groups', [0]);
				$this->settings->set_enabled_groups($groups);
			}

			$this->language->add_lang('acp', 'leinad4mind/staffnotifications');

			$config = [
				'staffnotifications_notifications' => [
					'lang'		=> 'STAFFNOTIFICATIONS_NOTIFICATIONS',
					'type'		=> 'custom',
					'function'	=> [$this, 'staffnotifications_notifications'],
					'explain'	=> true,
				],
				'staffnotifications_groups' => [
					'lang'		=> 'STAFFNOTIFICATIONS_GROUPS',
					'type'		=> 'custom',
					'function'	=> [$this, 'staffnotifications_groups'],
					'explain'	=> true,
				],
			];

			$display_vars = $event['display_vars'];
			$display_vars['vars'] = phpbb_insert_config_array($display_vars['vars'], $config, ['after' => 'allow_birthdays']);
			$event['display_vars'] = $display_vars;
		}
	}

	/**
	 * @return string
	 */
	public function staffnotifications_notifications()
	{
		return '<select name="staffnotifications_notifications[]" size="10" multiple>' . $this->notifications_select_options(settings::get_all_notifications(), $this->settings->get_enabled_notifications()) . '</select>';
	}

	/**
	 * @return string
	 */
	public function staffnotifications_groups()
	{
		return '<select name="staffnotifications_groups[]" size="10" multiple>' . $this->group_select_options($this->settings->get_enabled_groups()) . '</select>';
	}

	/**
	 * @param array $selected_group_ids
	 * @return string
	 */
	protected function group_select_options(array $selected_group_ids)
	{
		$groups = $this->helper->query([
			'SELECT'	=> 'g.group_id, g.group_name, g.group_type',
			'FROM'		=> [GROUPS_TABLE => 'g'],
			'ORDER_BY'	=> 'g.group_name ASC',
		]);

		$s_group_options = '';

		foreach ($groups as $group)
		{
			$text = $this->group_helper->get_name($group['group_name']);
			$s_group_options .= $this->build_option($text, $group['group_id'], in_array($group['group_id'], $selected_group_ids), $group['group_type'] == GROUP_SPECIAL);
		}

		return $s_group_options;
	}

	/**
	 * @param array $all_notification_names
	 * @param array $selected_notification_names
	 * @return string
	 */
	protected function notifications_select_options(array $all_notification_names, array $selected_notification_names)
	{
		$s_group_options = '';

		foreach ($all_notification_names as $notification_name)
		{
			$text = $this->language->lang('STAFFNOTIFICATIONS_' . strtoupper($notification_name));
			$s_group_options .= $this->build_option($text, $notification_name, in_array($notification_name, $selected_notification_names));
		}

		return $s_group_options;
	}

	/**
	 * @param string $text
	 * @param string $value
	 * @param bool $selected
	 * @param bool $sepcial
	 * @return string
	 */
	protected function build_option($text, $value, $selected, $sepcial = false)
	{
		return '<option' . ($sepcial ? ' class="sep"' : '') . ' value="' . $value . '"' . ($selected ? ' selected' : '') . '>' . $text . '</option>';
	}
}
