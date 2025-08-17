<?php

/**
 *
 * Staff Notifications. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019-2020, Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\staffnotifications\notification\type;

use phpbb\user_loader;
use leinad4mind\staffnotifications\settings;

abstract class base extends \phpbb\notification\type\base
{
	/** @var user_loader */
	protected $user_loader;

	/** @var settings */
	protected $settings;

	/**
	 * @param user_loader $user_loader
	 */
	public function set_user_loader(user_loader $user_loader)
	{
		$this->user_loader = $user_loader;
	}

	/**
	 * @param settings $settings
	 */
	public function set_settings(settings $settings)
	{
		$this->settings = $settings;
	}

	/**
	 * @return string
	 */
	public static function get_notification_name()
	{
		$full_class_name = get_called_class();
	 	$class_parts = explode('\\', $full_class_name);
 		return end($class_parts);
	}

	/**
	 * @return string
	 */
	public function get_type()
	{
		return 'leinad4mind.staffnotifications.notification.type.' . static::get_notification_name();
	}

	/**
	 * @return bool
	 */
	public function is_available()
	{
		return $this->settings->is_notification_enabled(static::get_notification_name());
	}

	/**
	 * Find the users who will receive notifications
	 *
	 * @param array $data The type specific data
	 * @param array $options Options for finding users for notification
	 * @return array
	 */
	public function find_users_for_notification($data, $options = [])
	{
		if (!$this->settings->get_enabled_groups())
		{
			return [];
		}

		$sql_ary = [
			'SELECT'	=> 'ug.user_id',
			'FROM'		=> [USER_GROUP_TABLE => 'ug'],
			'WHERE'		=> implode(' AND ', [
				'ug.user_pending = 0',
				'ug.user_id <> ' . $this->user->data['user_id'],
				$this->db->sql_in_set('ug.group_id', $this->settings->get_enabled_groups()),
			]),
		];

		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query($sql);
		$rows = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		$user_ids = array_unique(array_column($rows, 'user_id'));

		if (!empty($data['forum_id']))
		{
			return $this->get_authorised_recipients($user_ids, $data['forum_id'], $options, true);
		}

		return $this->check_user_notification_options($user_ids, $options);
	}

	/**
	* Users needed to query before this notification can be displayed
	*
	* @return array Array of user_ids
	*/
	public function users_to_query()
	{
		return array_unique([
			$this->get_data('sender_id'),
			$this->get_data('user_id'),
		]);
	}

	/**
	* Get the HTML formatted title of this notification
	*
	* @return string
	*/
	public function get_title()
	{
		$lang_key = 'STAFFNOTIFICATIONS_TITLE_' . strtoupper(static::get_notification_name());

		$default_lang_data = [
			$this->user_loader->get_username($this->get_data('sender_id'), 'no_profile'),
			$this->user_loader->get_username($this->get_data('user_id'), 'no_profile'),
		];

		$additional_lang_data = $this->get_data('lang_data') ?: [];

		$lang_data = array_merge($default_lang_data, $additional_lang_data);

		return $this->language->lang_array($lang_key, $lang_data);
	}

	/**
	 * @return string
	 */
	public function get_reference()
	{
		$reference_ary = $this->get_data('reference');

		if (!$reference_ary)
		{
			return parent::get_reference();
		}

		$reference_langs = [];

		foreach ($reference_ary as $ref_key => $ref_values)
		{
			$lang_key = 'STAFFNOTIFICATIONS_REFERENCE_' . strtoupper($ref_key);

			if (!is_array($ref_values))
			{
				$ref_values = [$ref_values];
			}

			array_walk($ref_values, 'censor_text');

			$reference_langs[] = $this->language->lang_array($lang_key, array_values($ref_values));
		}

		return implode('<br>', $reference_langs);
	}

	/**
	* Get the url to this item
	*
	* @return string URL
	*/
	public function get_avatar()
	{
		return $this->user_loader->get_avatar($this->get_data('sender_id'), false, true);
	}

	/**
	* Get email template
	*
	* @return string|bool
	*/
	public function get_email_template()
	{
		return false;
	}

	/**
	* Get email template variables
	*
	* @return array
	*/
	public function get_email_template_variables()
	{
		return [];
	}

	/**
	* Function for preparing the data for insertion in an SQL query
	* (The service handles insertion)
	*
	* @param array $data The data for the updated rules
	* @param array $pre_create_data Data from pre_create_insert_array()
	*/
	public function create_insert_array($data, $pre_create_data = [])
	{
		foreach ($data as $key => $value)
		{
			$this->set_data($key, $value);
		}

		parent::create_insert_array($data, $pre_create_data);
	}
}
