<?php
/**
 *
 * No notice on unread deleted PMs. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2016, javiexin
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace javiexin\nndeletepm\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * No notice on unread deleted PMs Event listener.
 */
class main_listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.delete_pm_before'	=> 'delete_pm_before',
		);
	}

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/**
	 * Constructor
	 *
	 * @param \phpbb\db\driver\driver_interface $db		Database
	 */
	public function __construct(\phpbb\db\driver\driver_interface $db)
	{
		$this->db = $db;
	}

	/**
	 * If the deleted PM is unread, removes the notice on removal
	 *
	 * @param \phpbb\event\data	$event	Event object
	 */
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
