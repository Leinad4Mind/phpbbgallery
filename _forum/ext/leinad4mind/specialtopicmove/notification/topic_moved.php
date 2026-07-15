<?php

/**
 *
 * Special Topic Move. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\specialtopicmove\notification;

use phpbb\notification\type\base;
use phpbb\user_loader;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class topic_moved extends base
{
	/** @var user_loader */
	protected $user_loader;

	static public $notification_option = [
		'group'		=> 'NOTIFICATION_GROUP_MISCELLANEOUS',
		'lang'		=> 'SPECIAL_TOPIC_MOVED_NOTIFICATION',
	];

	/**
	 * @param user_loader $user_loader
	 */
	public function set_user_loader(user_loader $user_loader)
	{
		$this->user_loader = $user_loader;
	}

	/**
	 * @return string
	 */
	public function get_type()
	{
		return 'leinad4mind.specialtopicmove.notification.type.topic_moved';
	}

	/**
	 * @param array $data
	 * @return int
	 */
	public static function get_item_id($data)
	{
		return (int) $data['topic_id'];
	}

	/**
	 * @param array $data
	 * @return int
	 */
	public static function get_item_parent_id($data)
	{
		return (int) $data['forum_id'];
	}

	/**
	 * @param array $data
	 * @param array $options
	 * @return array
	 */
	public function find_users_for_notification($data, $options = [])
	{
		$users = [$data['topic_poster']];
		$this->user_loader->load_users($users);
		return $this->check_user_notification_options($users, $options);
	}

	/**
	 * @return array
	 */
	public function users_to_query()
	{
		return [$this->get_data('topic_mover')];
	}

	/**
	 * @return string
	 */
	public function get_avatar()
	{
		$mover = $this->get_data('topic_mover');
		return $this->user_loader->get_avatar($mover, true, true);
	}

	/**
	 * @return string
	 */
	public function get_title()
	{
		return $this->language->lang('SPECIAL_TOPIC_MOVED_NOTIFICATION_TITLE', $this->get_topic_title(), $this->get_topic_mover('no_profile'), $this->get_forum_name());
	}

	public function get_reference()
	{
		return $this->get_data('reason');
	}

	/**
	 * @param int $reference_type
	 * @return string
	 */
	public function get_url($reference_type = UrlGeneratorInterface::ABSOLUTE_PATH)
	{
		$params = [
			't' => $this->get_data('topic_id'),
		];

		$script_php = 'viewtopic.' . $this->php_ext;

		if ($reference_type == UrlGeneratorInterface::ABSOLUTE_URL)
		{
			return generate_board_url() . '/' . $script_php . '?' . http_build_query($params);
		}

		return append_sid($this->phpbb_root_path . $script_php, $params);
	}

	/**
	 * @return string
	 */
	public function get_email_template()
	{
		return '@leinad4mind_specialtopicmove/topic_moved';
	}

	/**
	 * @return array
	 */
	public function get_email_template_variables()
	{
		return [
			'TOPIC_TITLE'		=> $this->get_topic_title(),
			'TOPIC_MOVER'		=> htmlspecialchars_decode($this->get_topic_mover('username')),
			'FORUM_NAME'		=> htmlspecialchars_decode($this->get_forum_name()),
			'REASON'			=> htmlspecialchars_decode($this->get_data('reason')),
			'U_NOTIFICATIONS'	=> generate_board_url() . '/ucp.' . $this->php_ext . '?i=ucp_notifications&mode=notification_list',
		];
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

	protected function get_topic_title()
	{
		if (!function_exists('phpbb_get_topic_data'))
		{
			include($this->phpbb_root_path . 'includes/functions_mcp.' . $this->php_ext);
		}

		$topic_id = $this->get_data('topic_id');
		$topic_data = phpbb_get_topic_data([$topic_id], false);
		return isset($topic_data[$topic_id]) ? $topic_data[$topic_id]['topic_title'] : '';
	}

	protected function get_topic_mover($mode)
	{
		$topic_mover = $this->get_data('topic_mover');
		return $this->user_loader->get_username($topic_mover, $mode);
	}

	protected function get_forum_name()
	{
		if (!function_exists('phpbb_get_forum_data'))
		{
			include($this->phpbb_root_path . 'includes/functions_mcp.' . $this->php_ext);
		}

		$forum_id = $this->get_data('forum_id');
		$forum_info = phpbb_get_forum_data([$forum_id], false);
		return isset($forum_info[$forum_id]) ? $forum_info[$forum_id]['forum_name'] : '';
	}
}
