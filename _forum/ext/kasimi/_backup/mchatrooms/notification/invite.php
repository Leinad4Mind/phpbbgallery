<?php

/**
 *
 * @package phpBB Extension - mChat Rooms Addon
 * @copyright (c) 2017 kasimi - https://kasimi.net
 * @license proprietary
 *
 */

namespace kasimi\mchatrooms\notification;

use dmzx\mchat\core\settings;
use kasimi\mchatrooms\core\constants;
use kasimi\mchatrooms\core\functions;
use phpbb\controller\helper;
use phpbb\notification\type\base;
use phpbb\user_loader;

class invite extends base
{
	/** @var helper */
	protected $helper;

	/** @var user_loader */
	protected $user_loader;

	/** @var functions */
	protected $room_functions;

	/** @var settings */
	protected $mchat_settings;

	/** @var bool */
	protected $has_invite_expired = null;

	static public $notification_option = [
		'lang'		=> 'NOTIFICATION_TYPE_ROOM_INVITE',
		'group'		=> 'NOTIFICATION_GROUP_MISCELLANEOUS',
	];

	/**
	 * @param helper $helper
	 */
	public function set_controller_helper(helper $helper)
	{
		$this->helper = $helper;
	}

	/**
	 * @param user_loader $user_loader
	 */
	public function set_user_loader(user_loader $user_loader)
	{
		$this->user_loader = $user_loader;
	}

	/**
	 * @param functions $room_functions
	 */
	public function set_room_functions(functions $room_functions)
	{
		$this->room_functions = $room_functions;
	}

	/**
	 * @param settings $mchat_settings
	 */
	public function set_mchat_settings(settings $mchat_settings)
	{
		$this->mchat_settings = $mchat_settings;
	}

	/**
	 * @return string
	 */
	public function get_type()
	{
		return constants::NOTIFICATION_TYPE_INVITE;
	}

	/**
	 * @param array $data
	 * @return int
	 */
	public static function get_item_id($data)
	{
		return (int) $data['invite_id'];
	}

	/**
	 * @param array $data
	 * @return int
	 */
	public static function get_item_parent_id($data)
	{
		return 0;
	}

	/**
	 * @param array $data
	 * @param array $options
	 * @return array
	 */
	public function find_users_for_notification($data, $options = [])
	{
		$user = [$data['invitee_id']];
		$this->user_loader->load_users($user);
		return $this->check_user_notification_options($user, $options);
	}

	/**
	 * @return array
	 */
	public function users_to_query()
	{
		return [];
	}

	/**
	 * @return string
	 */
	public function get_avatar()
	{
		$inviter = $this->get_data('inviter_id');
		return $this->user_loader->get_avatar($inviter, true, true);
	}

	/**
	 * @return bool
	 */
	protected function has_invite_expired()
	{
		if ($this->has_invite_expired === null)
		{
			$invite_expiration = $this->mchat_settings->cfg('mchat_invite_expiration');
			$invite_has_exired = $this->notification_time < time() - $invite_expiration * 60;
			$this->has_invite_expired = $invite_expiration && $invite_has_exired;
		}

		return $this->has_invite_expired;
	}

	/**
	 * @return string
	 */
	public function get_title()
	{
		$title = '';

		if ($this->mchat_settings === null)
		{
			$title .= ' ' . $this->language->lang('MCHATROOMS_NOTIFICATION_INVITE_UNAVAILABLE_TITLE');
		}
		else if ($this->has_invite_expired())
		{
			$title .= ' ' . $this->language->lang('MCHATROOMS_NOTIFICATION_INVITE_EXPIRED_TITLE');
		}

		$inviter = $this->get_data('inviter_id');
		$username = $this->user_loader->get_username($inviter, $title ? 'full' : 'no_profile', false, false, true);

		$room_id = $this->get_data('room_id');
		$rooms = $this->room_functions->get_rooms($room_id, [constants::ROOMS_IGNORE_PRIVATE_SESSION]);
		$room = reset($rooms);

		$title = $this->language->lang('MCHATROOMS_NOTIFICATION_INVITE_TITLE', $username, $room['room_name']) . $title;

		$message = $this->get_data('message');

		if (!empty($message))
		{
			$title .= '<br><br>' . $message;
		}

		return $title;
	}

	/**
	 * @return string
	 */
	public function get_url()
	{
		if ($this->mchat_settings === null || $this->has_invite_expired())
		{
			return '';
		}

		$params = [
			'invite' => $this->get_data('invite_id'),
		];

		if ($this->mchat_settings->cfg('mchat_custom_page'))
		{
			return $this->helper->route('dmzx_mchat_page_custom_controller', $params);
		}

		return append_sid($this->phpbb_root_path . 'index.' . $this->php_ext, $params);
	}

	/**
	 * @return bool
	 */
	public function get_email_template()
	{
		return false;
	}

	/**
	 * @return array
	 */
	public function get_email_template_variables()
	{
		return [];
	}

	/**
	 * @param array $data
	 * @param array $pre_create_data
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
