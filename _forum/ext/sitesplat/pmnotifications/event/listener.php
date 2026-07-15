<?php
/**
*
* @package PMnotifications
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\pmnotifications\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.page_header_after'	=> 'page_header_after',

			'core.ucp_pm_view_folder_get_pm_from_template'	=> 'ucp_pm_view_folder_get_pm_from_template',
			'core.ucp_pm_view_folder_get_pm_from_sql'		=> 'ucp_pm_view_folder_get_pm_from_sql',
			'core.ucp_pm_view_messsage'						=> 'ucp_pm_view_messsage',

			// No notice delete unread PMs
			'core.delete_pm_before'	=> 'delete_pm_before',
		);
	}

	/* @var \phpbb\notification\manager */
	protected $notification_manager;

	/* @var \phpbb\template\template */
	protected $template;

	/* @var \phpbb\config\config */
	protected $config;

	/* @var \phpbb\user */
	protected $user;

	/* @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\user_loader */
	protected $user_loader;

	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\pagination */
	protected $pagination;

	/** @var string */
	protected $notification_types_table;

	/** @var string */
	protected $notifications_table;

	/** @var string */
	protected $root_path;

	/** @var string */
	protected $php_ext;

	/** @var bool */
	protected $is_31;

	public function __construct(\phpbb\notification\manager $notification_manager, \phpbb\template\template $template, \phpbb\config\config $config, \phpbb\user $user, \phpbb\db\driver\driver_interface $db, \phpbb\user_loader $user_loader, \phpbb\auth\auth $auth, \phpbb\request\request $request, \phpbb\pagination $pagination, $notification_types_table, $notifications_table, $root_path, $php_ext)
	{
		$this->notification_manager = $notification_manager;
		$this->template = $template;
		$this->config = $config;
		$this->user = $user;
		$this->db = $db;
		$this->user_loader = $user_loader;
		$this->auth = $auth;
		$this->request = $request;
		$this->pagination = $pagination;
		$this->notification_types_table = $notification_types_table;
		$this->notifications_table = $notifications_table;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
		$this->is_31 = version_compare($this->config['version'], '3.2.0', '<');
	}

	public function page_header_after()
	{
		if (!$this->config['allow_privmsg'])
		{
			return;
		}

		$this->user->add_lang_ext('sitesplat/pmnotifications', 'common');

		// only produce extra load when necessary
		if ($this->config['load_notifications'] && $this->user->data['user_id'] != ANONYMOUS && $this->user->data['user_type'] != USER_IGNORE)
		{
			// prepare PM notifications variable
			$pms = array(
				'notifications'		=> array(),
				'unread_count'		=> 0,
				'total_count'		=> 0,
			);

			// destroy original notifications
			$this->template->destroy_block_vars('notifications');


			/********
			 * ORIGINAL NOTIFICATIONS
			 ********/
			// load all unread notifications, replenish to be at least 5
			$options = array(
				'all_unread'	=> true,
				'limit'			=> 5,
			);
			$notifications = $this->is_31 ? $this->notification_manager->load_notifications($options) : $this->notification_manager->load_notifications('notification.method.board', $options);

			// only assign non-PM notifications
			foreach ($notifications['notifications'] as $notification)
			{
				if (get_class($notification) != 'phpbb\notification\type\pm')
				{
					$this->template->assign_block_vars('notifications', $notification->prepare_for_display());
				}
				else
				{
					// reuse, assign to PMs notifications
					$pms['notifications'][$notification->notification_id] = $notification;

					// // decrement total original notifications count
					// $notifications['total_count']--;
					// // increment total PM notifications count
					// $pms['total_count']++;

					if (!$notification->notification_read)
					{
						// decrement unread original notifications count only if PM notification is unread
						$notifications['unread_count']--;
						// increment unread PM notifications count only if PM notification is unread
						$pms['unread_count']++;
					}
					
					
				}
			}

			$this->template->assign_vars(array(
				'UNREAD_NOTIFICATIONS_COUNT'	=> $notifications['unread_count'],
				'NOTIFICATIONS_COUNT'			=> $notifications['unread_count'],
			));


			/********
			 * PM NOTIFICATIONS
			 ********/
			$user_ids = array();

			$sql = 'SELECT n.*, nt.notification_type_name
					FROM ' . $this->notifications_table . ' n, ' . $this->notification_types_table . ' nt
					WHERE n.user_id = ' . (int) $this->user->data['user_id'] . '
						AND n.notification_read = 1
						AND nt.notification_type_id = n.notification_type_id
						AND nt.notification_type_enabled = 1
						AND nt.notification_type_name = "notification.type.pm"
					ORDER BY n.notification_time DESC';
			$result = $this->db->sql_query_limit($sql, 5 - $pms['unread_count']);
			while ($row = $this->db->sql_fetchrow($result))
			{
				if (!isset($pms['notifications'][$row['notification_id']]))
				{
					$notification = $this->notification_manager->get_item_type_class($row['notification_type_name'], $row);

					// Array of user_ids to query all at once
					$user_ids = array_merge($user_ids, $notification->users_to_query());

					$pms['notifications'][$row['notification_id']] = $notification;

					// only total count increases. No unread notifications here
					$pms['total_count']++;
				}
			}
			$this->db->sql_freeresult($result);

			$this->user_loader->load_users($user_ids);

			// sort by time
			usort($pms['notifications'], function ($a, $b) {
				return ($a->notification_time > $b->notification_time) ? -1 : 1;
			});

			foreach ($pms['notifications'] as $pm)
			{
				$this->template->assign_block_vars('pms', $pm->prepare_for_display());
			}

			$this->template->assign_vars(array(
				'UNREAD_PMS_COUNT'	=> $pms['unread_count'],
				'PMS_COUNT'			=> $pms['total_count'],
				'S_PMS_DISPLAY'		=> $this->auth->acl_get('u_readpm'),
			));
		}
	}

	public function ucp_pm_view_folder_get_pm_from_template($event)
	{
		$start = $this->request->variable('start', 0);
		$from_author = $this->request->variable('from_author', 0);
		$url_from_author = $sql_from_author = '';
		if ($from_author)
		{
			$url_from_author = '&amp;from_author=' . $from_author;
			$sql_from_author = ' AND p.author_id = ' . $from_author;
		}

		$pm_count_changed = false;
		$pm_count = 0;
		if ($sort_days = $this->request->variable('st', 0))
		{
			$min_post_time = time() - ($sort_days * 86400);

			if ($this->request->is_set_post('sort'))
			{
				$start = 0;
			}

			$sql = 'SELECT COUNT(t.msg_id) AS pm_count
				FROM ' . PRIVMSGS_TO_TABLE . ' t, ' . PRIVMSGS_TABLE . ' p
				WHERE t.folder_id = ' . (int) $event['folder_id'] . "
					$sql_from_author
					AND t.user_id = {$event['user_id']}
					AND t.msg_id = p.msg_id
					AND p.message_time >= $min_post_time";
			$result = $this->db->sql_query_limit($sql, 1);
			$pm_count = (int) $this->db->sql_fetchfield('pm_count', $result);
			$this->db->sql_freeresult($result);

			$pm_count_changed = true;
		}
		else if ($sql_from_author)
		{
			$sql = 'SELECT COUNT(t.msg_id) AS pm_count
				FROM ' . PRIVMSGS_TO_TABLE . ' t, ' . PRIVMSGS_TABLE . ' p
				WHERE t.folder_id = ' . (int) $event['folder_id'] . "
					$sql_from_author
					AND t.user_id = {$event['user_id']}
					AND t.msg_id = p.msg_id";
			$result = $this->db->sql_query_limit($sql, 1);
			$pm_count = (int) $this->db->sql_fetchfield('pm_count', $result);
			$this->db->sql_freeresult($result);

			$pm_count_changed = true;
		}

		if ($pm_count_changed)
		{
			$base_url = $event['base_url'] . $url_from_author;
			$start = $this->pagination->validate_start($start, $this->config['topics_per_page'], $pm_count);
			$this->pagination->generate_template_pagination($base_url, 'pagination', 'start', $pm_count, $this->config['topics_per_page'], $start);

			$template_vars = $event['template_vars'];
			$template_vars['TOTAL_MESSAGES'] = $this->user->lang('VIEW_PM_MESSAGES', (int) $pm_count);
			$event['template_vars'] = $template_vars;
		}
	}

	public function ucp_pm_view_folder_get_pm_from_sql($event)
	{
		$from_author = $this->request->variable('from_author', 0);

		if ($from_author)
		{
			$sql_ary = $event['sql_ary'];
			$sql_ary['WHERE'] .= ' AND p.author_id = ' . $from_author;
			$event['sql_ary'] = $sql_ary;
		}
	}

	public function ucp_pm_view_messsage($event)
	{
		$msg_data = $event['msg_data'];
		$msg_data['U_FROM_AUTHOR_PM_LIST'] = append_sid("{$this->root_path}ucp.{$this->php_ext}", "i=pm&amp;folder={$event['folder_id']}&amp;from_author={$event['message_row']['author_id']}");
		$event['msg_data'] = $msg_data;
	}

	public function delete_pm_before($event)
	{
		$user_id = (int) $event['user_id'];
		$msg_ids = array_map('intval', $event['msg_ids']);
		$folder_id = (int) $event['folder_id'];

		// Only applies to messages deleted from the outbox
		if ($folder_id !== PRIVMSGS_OUTBOX)
		{
			return;
		}

		// Validate that the messages are still pending to be deleted
		$sql = 'SELECT msg_id
			FROM ' . PRIVMSGS_TO_TABLE . '
			WHERE ' . $this->db->sql_in_set('msg_id', $msg_ids) . "
				AND folder_id = $folder_id
				AND user_id = $user_id";
		$result = $this->db->sql_query($sql);

		$delete_rows = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$delete_rows[(int) $row['msg_id']] = 1;
		}
		$this->db->sql_freeresult($result);

		// Nothing left to do, so exit
		if (!sizeof($delete_rows))
		{
			return;
		}

		$this->db->sql_transaction('begin');

		// Delete the private message recipients that are pending, but not the sender
		$sql = 'SELECT user_id
			FROM ' . PRIVMSGS_TO_TABLE . '
			WHERE author_id = ' . $user_id . '
			AND user_id <> ' . $user_id . '
			AND ' . $this->db->sql_in_set('msg_id', array_keys($delete_rows));
		$result = $this->db->sql_query($sql);

		// The new messages counter is set back one and no notice will be shown
		while ($row = $this->db->sql_fetchrow($result))
		{
			$sql = 'UPDATE ' . USERS_TABLE . '
				SET user_new_privmsg = user_new_privmsg - 1, user_unread_privmsg = user_unread_privmsg - 1
				WHERE user_id = ' . (int) $row['user_id'];
			$this->db->sql_query($sql);
		}

		$sql = 'DELETE FROM ' . PRIVMSGS_TO_TABLE . '
			WHERE author_id = ' . $user_id . '
			AND user_id <> ' . $user_id . '
			AND ' . $this->db->sql_in_set('msg_id', array_keys($delete_rows));
		$this->db->sql_query($sql);

		$this->db->sql_transaction('commit');
	}
}
