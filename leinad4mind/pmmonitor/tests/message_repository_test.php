<?php

namespace leinad4mind\pmmonitor\tests;

use leinad4mind\pmmonitor\core\message_repository;
use phpbb\attachment\manager as attachment_manager;
use phpbb\db\driver\driver_interface;
use phpbb\notification\manager as notification_manager;
use PHPUnit\Framework\TestCase;

class message_repository_test extends TestCase
{
	public function test_message_body_is_fetched_by_exact_recipient_tuple()
	{
		$query = '';
		$db = $this->createMock(driver_interface::class);
		$db->expects($this->once())->method('sql_query')->willReturnCallback(function ($sql) use (&$query)
		{
			$query = $sql;
			return 'result';
		});
		$db->method('sql_fetchrow')->willReturn(array('msg_id' => 10, 'message_text' => 'Private'));
		$repository = $this->repository($db, $this->createMock(notification_manager::class));

		$this->assertSame(10, $repository->fetch_message($this->selection(10, 20, -2))['msg_id']);
		$this->assertStringContainsString('p.msg_id = 10', $query);
		$this->assertStringContainsString('recipient_copy.user_id = 20', $query);
		$this->assertStringContainsString('recipient_copy.folder_id = -2', $query);
	}

	public function test_missing_composite_selection_is_rejected_before_transaction()
	{
		$db = $this->createMock(driver_interface::class);
		$db->method('sql_in_set')->willReturn('msg_id = 10');
		$db->method('sql_query')->willReturn('result');
		$db->method('sql_fetchrow')->willReturn(false);
		$db->expects($this->never())->method('sql_transaction');
		$notifications = $this->createMock(notification_manager::class);
		$notifications->expects($this->never())->method('delete_notifications');

		$repository = $this->repository($db, $notifications);
		$this->assertFalse($repository->delete_recipient_copies(array($this->selection(10, 20, 7))));
	}

	public function test_recipient_deletion_scopes_counters_and_notification_to_owner()
	{
		$queries = array();
		$transactions = array();
		$db = $this->database($queries);
		$db->method('sql_fetchrow')->willReturnOnConsecutiveCalls(
			array('msg_id' => '10', 'user_id' => '20', 'folder_id' => '7', 'pm_unread' => '1', 'pm_new' => '1'),
			false,
			array('msg_id' => '10'),
			false
		);
		$db->method('sql_transaction')->willReturnCallback(function ($mode) use (&$transactions)
		{
			$transactions[] = $mode;
		});
		$notifications = $this->createMock(notification_manager::class);
		$notifications->expects($this->once())
			->method('delete_notifications')
			->with('notification.type.pm', 10, false, 20);
		$attachments = $this->createMock(attachment_manager::class);
		$attachments->expects($this->never())->method('delete');

		$repository = new message_repository($db, $notifications, $attachments, $this->tables());
		$this->assertSame(1, $repository->delete_recipient_copies(array($this->selection(10, 20, 7))));
		$sql = implode(PHP_EOL, $queries);
		$this->assertStringContainsString('DELETE FROM phpbb_privmsgs_to', $sql);
		$this->assertStringContainsString('WHERE user_id = 20', $sql);
		$this->assertStringContainsString('AND folder_id = 7', $sql);
		$this->assertStringContainsString('UPDATE phpbb_users', $sql);
		$this->assertStringContainsString('UPDATE phpbb_privmsgs_folder', $sql);
		$this->assertSame(array('begin', 'commit'), $transactions);
	}

	public function test_outbox_deletion_cancels_delivery_without_touching_admin_state()
	{
		$queries = array();
		$db = $this->database($queries);
		$db->method('sql_fetchrow')->willReturnOnConsecutiveCalls(
			array('msg_id' => '10', 'user_id' => '20', 'folder_id' => (string) PRIVMSGS_OUTBOX, 'pm_unread' => '0', 'pm_new' => '0'),
			false,
			array('msg_id' => '10'),
			false
		);
		$notifications = $this->createMock(notification_manager::class);
		$notifications->expects($this->once())
			->method('delete_notifications')
			->with('notification.type.pm', 10);

		$repository = $this->repository($db, $notifications);
		$this->assertSame(1, $repository->delete_recipient_copies(array($this->selection(10, 20, PRIVMSGS_OUTBOX))));
		$sql = implode(PHP_EOL, $queries);
		$this->assertStringContainsString('SET message_text = \'\'', $sql);
		$this->assertStringContainsString('SET pm_deleted = 1', $sql);
		$this->assertStringNotContainsString('user_unread_privmsg', $sql);
	}

	protected function database(&$queries)
	{
		$db = $this->createMock(driver_interface::class);
		$db->method('sql_in_set')->willReturnCallback(function ($field, $values)
		{
			return $field . ' IN (' . implode(',', array_map('intval', $values)) . ')';
		});
		$db->method('sql_query')->willReturnCallback(function ($sql) use (&$queries)
		{
			$queries[] = $sql;
			return 'result';
		});
		return $db;
	}

	protected function repository(driver_interface $db, notification_manager $notifications)
	{
		return new message_repository($db, $notifications, $this->createMock(attachment_manager::class), $this->tables());
	}

	protected function selection($msg_id, $user_id, $folder_id)
	{
		return array('msg_id' => $msg_id, 'user_id' => $user_id, 'folder_id' => $folder_id);
	}

	protected function tables()
	{
		return array(
			'privmsgs' => 'phpbb_privmsgs',
			'privmsgs_folder' => 'phpbb_privmsgs_folder',
			'privmsgs_to' => 'phpbb_privmsgs_to',
			'sessions' => 'phpbb_sessions',
			'users' => 'phpbb_users',
		);
	}
}
