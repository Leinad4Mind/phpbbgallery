<?php
/**
 *
 * Mass Notification. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Jakub Senko
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace senky\massnotification\notification\type;

class manual extends \phpbb\notification\type\base
{
	/**
	 * {@inheritDoc}
	 */
	public function get_type()
	{
		return 'senky.massnotification.notification.type.manual';
	}

	/** @var \phpbb\event\dispatcher_interface */
	protected $dispatcher;
	public function set_dispatcher(\phpbb\event\dispatcher_interface $dispatcher)
	{
		$this->dispatcher = $dispatcher;
	}

	/** @var \phpbb\user_loader */
	protected $user_loader;
	public function set_user_loader(\phpbb\user_loader $user_loader)
	{
		$this->user_loader = $user_loader;
	}

	/**
	 * {@inheritDoc}
	 */
	public function is_available()
	{
		return false;
	}

	/**
	 * {@inheritDoc}
	 */
	public static function get_item_id($data)
	{
		return $data['notification_id'];
	}

	/**
	 * {@inheritDoc}
	 */
	public static function get_item_parent_id($data)
	{
		return 0;
	}

	/**
	 * {@inheritDoc}
	 */
	public function find_users_for_notification($data, $options = [])
	{
		$users = [];
		foreach ($data['user_ids'] as $user)
		{
			$users[$user] = ['notification.method.board'];
		}

		/**
		* You can use this event to modify a list of users who will receive manual notification
		* and methods in which they will receive it.
		*
		* @event senky.massnotification.notification_users
		* @var	array	data	Notification data
		* @var	array	options	Notification options
		* @var	array	users	user_id => [notif_methods]
		* @since 1.0.0
		*/
		$vars = [
			'data',
			'options',
			'users',
		];
		extract($this->dispatcher->trigger_event('senky.massnotification.notification_users', compact($vars)));

		return $users;
	}

	/**
	 * {@inheritDoc}
	 */
	public function users_to_query()
	{
		$author_id = $this->get_data('author_id');
		return $author_id ? [$author_id] : [];
	}

	/**
	 * {@inheritDoc}
	 */
	public function get_style_class()
	{
		return 'senky-massnotification';
	}

	/**
	 * {@inheritDoc}
	 */
	public function get_avatar()
	{
		return $this->user_loader->get_avatar($this->get_data('author_id'), false, true);
	}

	/**
	 * {@inheritDoc}
	 */
	public function get_title()
	{
		return '<strong>' . $this->get_data('title') . '</strong>';
	}

	/**
	 * {@inheritDoc}
	 */
	public function get_reference()
	{
		return html_entity_decode($this->get_data('message'));
	}

	/**
	 * {@inheritDoc}
	 */
	public function get_url()
	{
		return $this->get_data('url');
	}

	/**
	 * {@inheritDoc}
	 */
	public function get_email_template()
	{
		return false;
	}

	/**
	 * {@inheritDoc}
	 */
	public function get_email_template_variables()
	{
		return [];
	}

	/**
	* {@inheritdoc}
	*/
	public function create_insert_array($data, $pre_create_data = [])
	{
		$this->set_data('title', $data['title']);
		$this->set_data('message', $data['message']);
		$this->set_data('url', $data['url']);
		$this->set_data('author_id', $data['author_id']);

		parent::create_insert_array($data, $pre_create_data);
	}
}
