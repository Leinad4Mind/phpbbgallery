<?php
/**
 * @package PM Monitor
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace leinad4mind\pmmonitor\core;

use phpbb\attachment\manager as attachment_manager;
use phpbb\db\driver\driver_interface;
use phpbb\notification\manager as notification_manager;

class message_repository
{
	protected $db;
	protected $notifications;
	protected $attachments;
	protected $tables;

	public function __construct(driver_interface $db, notification_manager $notifications, attachment_manager $attachments, array $tables)
	{
		$this->db = $db;
		$this->notifications = $notifications;
		$this->attachments = $attachments;
		$this->tables = $tables;
	}

	public function count_messages()
	{
		$sql = 'SELECT COUNT(recipient_copy.msg_id) AS total_messages
			FROM ' . $this->tables['privmsgs_to'] . ' recipient_copy
			INNER JOIN ' . $this->tables['privmsgs'] . ' p
				ON p.msg_id = recipient_copy.msg_id';
		$result = $this->db->sql_query($sql);
		$count = (int) $this->db->sql_fetchfield('total_messages');
		$this->db->sql_freeresult($result);
		return $count;
	}

	public function fetch_page($sort_key, $sort_direction, $limit, $start)
	{
		$sql = 'SELECT p.msg_id, p.message_subject, p.message_time, p.bcc_address, p.to_address, p.author_ip,
				recipient_copy.user_id, recipient_copy.author_id, recipient_copy.folder_id,
				author.username AS author_username, author.user_colour AS author_colour,
				author.user_lastvisit AS author_lastvisit,
				recipient.username AS recipient_username, recipient.user_colour AS recipient_colour,
				recipient.user_lastvisit AS recipient_lastvisit
			FROM ' . $this->tables['privmsgs_to'] . ' recipient_copy
			INNER JOIN ' . $this->tables['privmsgs'] . ' p
				ON p.msg_id = recipient_copy.msg_id
			LEFT JOIN ' . $this->tables['users'] . ' author
				ON author.user_id = recipient_copy.author_id
			LEFT JOIN ' . $this->tables['users'] . ' recipient
				ON recipient.user_id = recipient_copy.user_id
			ORDER BY ' . sort_policy::order_by($sort_key, $sort_direction);
		return $this->fetch_all($this->db->sql_query_limit($sql, max(1, min(100, (int) $limit)), max(0, (int) $start)));
	}

	public function fetch_message(array $selection)
	{
		$sql = 'SELECT p.msg_id, p.message_subject, p.message_text, p.bbcode_uid, p.bbcode_bitfield
			FROM ' . $this->tables['privmsgs'] . ' p
			INNER JOIN ' . $this->tables['privmsgs_to'] . ' recipient_copy
				ON recipient_copy.msg_id = p.msg_id
			WHERE p.msg_id = ' . (int) $selection['msg_id'] . '
				AND recipient_copy.user_id = ' . (int) $selection['user_id'] . '
				AND recipient_copy.folder_id = ' . (int) $selection['folder_id'];
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		return is_array($row) ? $row : null;
	}

	public function active_sessions(array $user_ids, $minimum_time)
	{
		$user_ids = array_values(array_unique(array_filter(array_map('intval', $user_ids))));
		if (empty($user_ids))
		{
			return array();
		}
		$sql = 'SELECT session_user_id, MAX(session_time) AS session_time
			FROM ' . $this->tables['sessions'] . '
			WHERE session_time >= ' . (int) $minimum_time . '
				AND ' . $this->db->sql_in_set('session_user_id', $user_ids) . '
			GROUP BY session_user_id';
		$result = $this->db->sql_query($sql);
		$sessions = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$sessions[(int) $row['session_user_id']] = (int) $row['session_time'];
		}
		$this->db->sql_freeresult($result);
		return $sessions;
	}

	public function delete_recipient_copies(array $selections)
	{
		$rows = $this->selected_rows($selections);
		if ($rows === false)
		{
			return false;
		}

		$this->db->sql_transaction('begin');
		try
		{
			$normal_rows = array();
			$outbox_rows = array();
			foreach ($rows as $row)
			{
				if ($row['folder_id'] === PRIVMSGS_OUTBOX)
				{
					$outbox_rows[] = $row;
				}
				else
				{
					$normal_rows[] = $row;
				}
			}

			$this->delete_normal_rows($normal_rows);
			$this->cancel_outbox_rows($outbox_rows);
			$this->delete_orphaned_messages($rows);
			$this->db->sql_transaction('commit');
		}
		catch (\Throwable $exception)
		{
			$this->db->sql_transaction('rollback');
			throw $exception;
		}
		return count($rows);
	}

	protected function selected_rows(array $selections)
	{
		$wanted = array();
		$msg_ids = array();
		foreach ($selections as $selection)
		{
			$key = $selection['msg_id'] . ':' . $selection['user_id'] . ':' . $selection['folder_id'];
			$wanted[$key] = true;
			$msg_ids[] = (int) $selection['msg_id'];
		}
		if (empty($wanted))
		{
			return false;
		}

		$sql = 'SELECT msg_id, user_id, folder_id, pm_unread, pm_new
			FROM ' . $this->tables['privmsgs_to'] . '
			WHERE ' . $this->db->sql_in_set('msg_id', array_values(array_unique($msg_ids)));
		$result = $this->db->sql_query($sql);
		$rows = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$key = (int) $row['msg_id'] . ':' . (int) $row['user_id'] . ':' . (int) $row['folder_id'];
			if (isset($wanted[$key]))
			{
				foreach (array('msg_id', 'user_id', 'folder_id', 'pm_unread', 'pm_new') as $field)
				{
					$row[$field] = (int) $row[$field];
				}
				$rows[$key] = $row;
			}
		}
		$this->db->sql_freeresult($result);
		return count($rows) === count($wanted) ? array_values($rows) : false;
	}

	protected function delete_normal_rows(array $rows)
	{
		$groups = array();
		$user_counts = array();
		$folder_counts = array();
		foreach ($rows as $row)
		{
			$key = $row['user_id'] . ':' . $row['folder_id'];
			$groups[$key]['user_id'] = $row['user_id'];
			$groups[$key]['folder_id'] = $row['folder_id'];
			$groups[$key]['msg_ids'][] = $row['msg_id'];
			$user_counts[$row['user_id']]['unread'] = isset($user_counts[$row['user_id']]['unread']) ? $user_counts[$row['user_id']]['unread'] + $row['pm_unread'] : $row['pm_unread'];
			$user_counts[$row['user_id']]['new'] = isset($user_counts[$row['user_id']]['new']) ? $user_counts[$row['user_id']]['new'] + $row['pm_new'] : $row['pm_new'];
			if ($row['folder_id'] > PRIVMSGS_INBOX)
			{
				$folder_counts[$key] = isset($folder_counts[$key]) ? $folder_counts[$key] + 1 : 1;
			}
			$this->notifications->delete_notifications('notification.type.pm', $row['msg_id'], false, $row['user_id']);
		}

		foreach ($groups as $group)
		{
			$sql = 'DELETE FROM ' . $this->tables['privmsgs_to'] . '
				WHERE user_id = ' . (int) $group['user_id'] . '
					AND folder_id = ' . (int) $group['folder_id'] . '
					AND ' . $this->db->sql_in_set('msg_id', $group['msg_ids']);
			$this->db->sql_query($sql);
		}
		$this->update_user_counts($user_counts);
		$this->update_folder_counts($folder_counts);
	}

	protected function cancel_outbox_rows(array $rows)
	{
		foreach ($rows as $row)
		{
			$sql = 'DELETE FROM ' . $this->tables['privmsgs_to'] . '
				WHERE msg_id = ' . (int) $row['msg_id'] . '
					AND user_id = ' . (int) $row['user_id'] . '
					AND folder_id = ' . PRIVMSGS_OUTBOX;
			$this->db->sql_query($sql);
			$sql = 'UPDATE ' . $this->tables['privmsgs'] . "
				SET message_text = ''
				WHERE msg_id = " . (int) $row['msg_id'];
			$this->db->sql_query($sql);
			$sql = 'UPDATE ' . $this->tables['privmsgs_to'] . '
				SET pm_deleted = 1
				WHERE msg_id = ' . (int) $row['msg_id'];
			$this->db->sql_query($sql);
			$this->notifications->delete_notifications('notification.type.pm', $row['msg_id']);
		}
	}

	protected function update_user_counts(array $counts)
	{
		foreach ($counts as $user_id => $count)
		{
			$sql = 'UPDATE ' . $this->tables['users'] . '
				SET user_unread_privmsg = CASE
						WHEN user_unread_privmsg >= ' . (int) $count['unread'] . ' THEN user_unread_privmsg - ' . (int) $count['unread'] . '
						ELSE 0
					END,
					user_new_privmsg = CASE
						WHEN user_new_privmsg >= ' . (int) $count['new'] . ' THEN user_new_privmsg - ' . (int) $count['new'] . '
						ELSE 0
					END
				WHERE user_id = ' . (int) $user_id;
			$this->db->sql_query($sql);
		}
	}

	protected function update_folder_counts(array $counts)
	{
		foreach ($counts as $key => $count)
		{
			list($user_id, $folder_id) = array_map('intval', explode(':', $key));
			$sql = 'UPDATE ' . $this->tables['privmsgs_folder'] . '
				SET pm_count = CASE WHEN pm_count >= ' . (int) $count . ' THEN pm_count - ' . (int) $count . ' ELSE 0 END
				WHERE user_id = ' . (int) $user_id . '
					AND folder_id = ' . (int) $folder_id;
			$this->db->sql_query($sql);
		}
	}

	protected function delete_orphaned_messages(array $rows)
	{
		$msg_ids = array_values(array_unique(array_column($rows, 'msg_id')));
		$sql = 'SELECT msg_id
			FROM ' . $this->tables['privmsgs_to'] . '
			WHERE ' . $this->db->sql_in_set('msg_id', $msg_ids);
		$result = $this->db->sql_query($sql);
		$remaining = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$remaining[] = (int) $row['msg_id'];
		}
		$this->db->sql_freeresult($result);
		$orphaned = array_values(array_diff($msg_ids, array_unique($remaining)));
		if (empty($orphaned))
		{
			return;
		}
		$this->attachments->delete('message', $orphaned, false);
		$sql = 'DELETE FROM ' . $this->tables['privmsgs'] . '
			WHERE ' . $this->db->sql_in_set('msg_id', $orphaned);
		$this->db->sql_query($sql);
	}

	protected function fetch_all($result)
	{
		$rows = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$rows[] = $row;
		}
		$this->db->sql_freeresult($result);
		return $rows;
	}
}
