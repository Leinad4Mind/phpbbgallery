<?php
/**
 *
 * Advanced Polls tests
 *
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace wolfsblvt\advancedpolls\tests;

use PHPUnit\Framework\TestCase;
use wolfsblvt\advancedpolls\cron\task\pollend;
use wolfsblvt\advancedpolls\notification\pollended;

class cron_notification_test extends TestCase
{
	public function test_cron_runnable_schedule_has_safe_minimum_interval()
	{
		$config = new \phpbb\config\config(array(
			'wolfsblvt.advancedpolls.activate_notifications' => 1,
			'wolfsblvt.advancedpolls.pollend_gc' => 1,
			'wolfsblvt.advancedpolls.pollend_last_gc' => time() - 61,
		));
		$task = $this->create_cron($config);

		$this->assertSame('wolfsblvt.advancedpolls.pollend', $task->get_name());
		$this->assertTrue($task->is_runnable());
		$this->assertTrue($task->should_run());
		$config['wolfsblvt.advancedpolls.activate_notifications'] = 0;
		$this->assertFalse($task->is_runnable());
	}

	public function test_cron_notifies_and_marks_each_due_poll_once()
	{
		$config = new \phpbb\config\config(array(
			'wolfsblvt.advancedpolls.activate_notifications' => 1,
			'wolfsblvt.advancedpolls.pollend_gc' => 60,
			'wolfsblvt.advancedpolls.pollend_last_gc' => 0,
		));
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$rows = array(
			array('topic_id' => 10, 'forum_id' => 2, 'topic_title' => 'One', 'poll_title' => 'P1', 'poll_end' => 100),
			array('topic_id' => 11, 'forum_id' => 2, 'topic_title' => 'Two', 'poll_title' => 'P2', 'poll_end' => 200),
			false,
		);
		$db->expects($this->exactly(3))->method('sql_query')->willReturnCallback(function ($sql) {
			if (strpos($sql, 'SELECT topic_id') !== false)
			{
				$this->assertStringContainsString('wolfsblvt_poll_notified = 0', $sql);
				return 'result';
			}
			$this->assertStringContainsString('SET wolfsblvt_poll_notified = 1', $sql);
			return true;
		});
		$db->method('sql_fetchrow')->willReturnCallback(function () use (&$rows) {
			return array_shift($rows);
		});
		$db->expects($this->once())->method('sql_freeresult')->with('result');
		$manager = $this->createMock(\phpbb\notification\manager::class);
		$manager->expects($this->exactly(2))
			->method('add_notifications')
			->with('wolfsblvt.advancedpolls.notification.type.pollended', $this->isType('array'));
		$task = $this->create_cron($config, $db, $manager);

		$task->run();

		$this->assertGreaterThan(0, (int) $config['wolfsblvt.advancedpolls.pollend_last_gc']);
	}

	public function test_notification_metadata_and_persisted_payload()
	{
		$notification = $this->create_notification();
		$notification->set_config(new \phpbb\config\config(array(
			'wolfsblvt.advancedpolls.activate_notifications' => 1,
		)));

		$this->assertTrue($notification->is_available());
		$notification->set_config(new \phpbb\config\config(array(
			'wolfsblvt.advancedpolls.activate_notifications' => 0,
		)));
		$this->assertFalse($notification->is_available());
		$this->assertSame('wolfsblvt.advancedpolls.notification.type.pollended', $notification->get_type());
		$this->assertSame(42, pollended::get_item_id(array('topic_id' => '42')));
		$this->assertSame(7, pollended::get_item_parent_id(array('forum_id' => '7')));
		$this->assertFalse($notification->get_email_template());
		$this->assertSame(array(), $notification->get_email_template_variables());
		$this->assertSame(array(), $notification->users_to_query());

		$data = array(
			'topic_id' => 42,
			'forum_id' => 7,
			'topic_title' => 'Topic',
			'poll_title' => 'Poll',
			'poll_end' => 1234,
		);
		$notification->create_insert_array($data);
		$insert = $notification->get_insert_array();
		$payload = unserialize($insert['notification_data']);
		$this->assertSame(42, $insert['item_id']);
		$this->assertSame(7, $insert['item_parent_id']);
		$this->assertSame('Topic', $payload['topic_title']);
		$this->assertSame('Poll', $payload['poll_title']);
		$this->assertSame(1234, $payload['poll_end']);
	}

	public function test_notification_finds_unique_non_anonymous_voters_with_opt_in()
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->exactly(2))->method('sql_query')->willReturnOnConsecutiveCalls('votes', 'preferences');
		$rows = array(
			'votes' => array(array('vote_user_id' => 2), array('vote_user_id' => 2), array('vote_user_id' => 3), false),
			'preferences' => array(
				array('user_id' => 2, 'method' => 'notification.method.board', 'notify' => 1),
				array('user_id' => 3, 'method' => 'notification.method.board', 'notify' => 1),
				false,
			),
		);
		$db->method('sql_fetchrow')->willReturnCallback(function ($result) use (&$rows) {
			return array_shift($rows[$result]);
		});
		$db->expects($this->exactly(2))->method('sql_freeresult');
		$db->method('sql_in_set')->willReturn('user_id IN (2, 3)');
		$db->method('sql_escape')->willReturnArgument(0);
		$notification = $this->create_notification($db);

		$users = $notification->find_users_for_notification(array('topic_id' => 42));

		$this->assertSame(array(
			2 => array('notification.method.board'),
			3 => array('notification.method.board'),
		), $users);
	}

	private function create_cron(\phpbb\config\config $config, $db = null, $manager = null)
	{
		$db = $db ?: $this->createMock(\phpbb\db\driver\driver_interface::class);
		$manager = $manager ?: $this->createMock(\phpbb\notification\manager::class);
		return new pollend(
			$config,
			$db,
			$this->createMock(\phpbb\log\log::class),
			$this->createMock(\phpbb\user::class),
			$manager
		);
	}

	private function create_notification($db = null)
	{
		$db = $db ?: $this->createMock(\phpbb\db\driver\driver_interface::class);
		$notification = new pollended(
			$db,
			$this->createMock(\phpbb\language\language::class),
			$this->createMock(\phpbb\user::class),
			$this->createMock(\phpbb\auth\auth::class),
			'./',
			'php',
			'phpbb_user_notifications'
		);
		$manager = $this->createMock(\phpbb\notification\manager::class);
		$manager->method('get_notification_type_id')->willReturn(9);
		$manager->method('get_default_methods')->willReturn(array('notification.method.board'));
		$notification->set_notification_manager($manager);

		return $notification;
	}
}
