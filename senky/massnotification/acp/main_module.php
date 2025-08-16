<?php
/**
 *
 * Mass Notification. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Jakub Senko
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace senky\massnotification\acp;

class main_module
{
	/** string */
	public $page_title;

	/** string */
	public $tpl_name;

	/** string */
	public $u_action;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\notification\manager */
	protected $notifications_manager;

	/** @var \phpbb\event\dispatcher_interface */
	protected $dispatcher;

	/** @var \phpbb\group\helper */
	protected $group_helper;

	/** @var string */
	protected $groups_table;

	/** @var string */
	protected $users_table;

	/** @var string */
	protected $user_group_table;

	/** @var string */
	protected $root_path;

	/** @var string */
	protected $php_ext;

	/** @var string */
	private $form_key = 'senky/massnotification';
	public function __construct()
	{
		global $phpbb_container;

		$this->language = $phpbb_container->get('language');
		$this->request = $phpbb_container->get('request');
		$this->template = $phpbb_container->get('template');
		$this->db = $phpbb_container->get('dbal.conn');
		$this->config = $phpbb_container->get('config');
		$this->notifications_manager = $phpbb_container->get('notification_manager');
		$this->dispatcher = $phpbb_container->get('dispatcher');
		$this->group_helper = $phpbb_container->get('group_helper');
		$this->groups_table = $phpbb_container->getParameter('tables.groups');
		$this->users_table = $phpbb_container->getParameter('tables.users');
		$this->user_group_table = $phpbb_container->getParameter('tables.user_group');
		$this->root_path = $phpbb_container->getParameter('core.root_path');
		$this->php_ext = $phpbb_container->getParameter('core.php_ext');
	}

	public function main($id, $mode)
	{
		$this->language->add_lang('acp', 'senky/massnotification');
		$this->tpl_name = 'acp_mass_notification';
		$this->page_title = $this->language->lang('ACP_SENKY_MASSNOTIFICATION_TITLE');

		add_form_key($this->form_key);

		$error = [];
		$author_id = 0;
		$usernames = $this->request->variable('usernames', '', true);
		$usernames = (!empty($usernames)) ? explode("\n", $usernames) : [];
		$group_id = $this->request->variable('g', 0);
		$title = $this->request->variable('title', '', true);
		$message = $this->request->variable('message', '', true);
		$url = $this->request->variable('url', '', true);
		$author = $this->request->variable('author', '', true);

		if ($this->request->is_set_post('submit'))
		{
			if (!check_form_key($this->form_key))
			{
				$error[] = $this->language->lang('FORM_INVALID');
			}
			if (empty($title))
			{
				$error[] = $this->language->lang('NO_NOTIFICATION_TITLE');
			}
			if (empty($message))
			{
				$error[] = $this->language->lang('NO_NOTIFICATION_MESSAGE');
			}

			if (!empty($author))
			{
				$sql = 'SELECT user_id
					FROM ' . $this->users_table . "
					WHERE username_clean = '" . $this->db->sql_escape(utf8_clean_string($author)) . "'";
				$result = $this->db->sql_query($sql);
				$author_id = $this->db->sql_fetchfield('user_id');
				$this->db->sql_freeresult($result);

				if (!$author_id)
				{
					$error[] = $this->language->lang('NO_NOTIFICATION_AUTHOR');
				}
			}

			if (empty($error))
			{
				if (!empty($usernames))
				{
					$sql_ary = [
						'SELECT'	=> 'u.user_id',
						'FROM'		=> [
							$this->users_table	=> 'u',
						],
						'WHERE'		=> $this->db->sql_in_set('u.username_clean', array_map('utf8_clean_string', $usernames)),
					];
				}
				else
				{
					if ($group_id)
					{
						$sql_ary = [
							'SELECT'	=> 'u.user_id',
							'FROM'		=> [
								$this->users_table		=> 'u',
								$this->user_group_table	=> 'ug',
							],
							'WHERE'		=> 'ug.group_id = ' . (int) $group_id . '
								AND ug.user_pending = 0
								AND u.user_id = ug.user_id',
						];
					}
					else
					{
						$sql_ary = [
							'SELECT'	=> 'u.user_id',
							'FROM'		=> [
								$this->users_table	=> 'u',
							],
						];
					}
				}

				$sql = $this->db->sql_build_query('SELECT', $sql_ary);
				$result = $this->db->sql_query($sql);
				$user_ids = $this->db->sql_fetchrowset($result);
				$this->db->sql_freeresult($result);

				$user_ids = array_column($user_ids, 'user_id');

				$u_action = $this->u_action;
				/**
				* You can use this event to modify a list of users who will receive manual notification
				*
				* @event senky.massnotification.acp_before_send
				* @var	array	usernames	Array of usernames received from the admin
				* @var	int		group_id	Group ID selected by the admin
				* @var	string	title		Title of the notification
				* @var	string	message		Message of the notification
				* @var	string	url			URL of the notification
				* @var	string	author		Username of notification author
				* @var	int		author_id	User ID of notification author
				* @var	array	user_ids	Array of user IDs to send notification to
				* @var	string	u_action	Current page URL
				* @since 1.0.0
				* @changed 1.0.3	Added author and author_id
				*/
				$vars = [
					'usernames',
					'group_id',
					'title',
					'message',
					'url',
					'author',
					'author_id',
					'user_ids',
					'u_action',
				];
				extract($this->dispatcher->trigger_event('senky.massnotification.acp_before_send', compact($vars)));

				$this->config->increment('senky_massnotification_id', 1);
				$this->notifications_manager->add_notifications('senky.massnotification.notification.type.manual', [
					'notification_id'	=> $this->config['senky_massnotification_id'],
					'user_ids'			=> $user_ids,
					'title'				=> $title,
					'message'			=> $message,
					'url'				=> $url,
					'author_id'			=> $author_id,
				]);

				trigger_error($this->language->lang('NOTIFICATION_SEND') . adm_back_link($this->u_action));
			}
		}

		$sql = 'SELECT group_id, group_name
			FROM ' . $this->groups_table . '
			WHERE ' . $this->db->sql_in_set('group_name', ['BOTS', 'GUESTS'], true);
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->template->assign_block_vars('groups', [
				'ID'	=> $row['group_id'],
				'NAME'	=> $this->group_helper->get_name($row['group_name']),
			]);
		}
		$this->db->sql_freeresult($result);

		$this->template->assign_vars([
			'U_ACTION'			=> $this->u_action,
			'S_WARNING'			=> (!empty($error)) ? true : false,
			'WARNING_MSG'		=> (!empty($error)) ? implode('<br />', $error) : '',
			'USERNAMES'			=> implode("\n", $usernames),
			'U_FIND_USERNAME'	=> append_sid("{$this->root_path}memberlist.{$this->php_ext}", 'mode=searchuser&amp;form=acp_notification&amp;field=usernames'),
			'U_FIND_AUTHOR'		=> append_sid("{$this->root_path}memberlist.{$this->php_ext}", 'mode=searchuser&amp;form=acp_notification&amp;field=author'),
			'TITLE'				=> $title,
			'MESSAGE'			=> $message,
			'URL'				=> $url,
			'AUTHOR'			=> $author,
		]);
	}
}
