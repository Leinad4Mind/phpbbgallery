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
use wolfsblvt\advancedpolls\notification\optionsadded;

class optionsadded_notification_test extends TestCase
{
	public function test_metadata_availability_and_revision_payload()
	{
		$notification = $this->create_notification();
		$notification->set_config(new \phpbb\config\config(array(
			'wolfsblvt.advancedpolls.activate_notifications' => 1,
		)));
		$this->assertTrue($notification->is_available());
		$this->assertSame('wolfsblvt.advancedpolls.notification.type.optionsadded', $notification->get_type());
		$this->assertSame(91, optionsadded::get_item_id(array('revision_id' => '91')));
		$this->assertSame(42, optionsadded::get_item_parent_id(array('topic_id' => '42')));
		$this->assertFalse($notification->get_email_template());
		$this->assertSame(array(), $notification->users_to_query());

		$data = array(
			'revision_id' => 91,
			'topic_id' => 42,
			'forum_id' => 5,
			'topic_title' => 'Topic',
			'poll_title' => 'Question',
			'option_count' => 2,
		);
		$notification->create_insert_array($data);
		$insert = $notification->get_insert_array();
		$payload = unserialize($insert['notification_data']);
		$this->assertSame(91, $insert['item_id']);
		$this->assertSame(42, $insert['item_parent_id']);
		$this->assertSame(42, $payload['topic_id']);
		$this->assertSame(5, $payload['forum_id']);
		$this->assertSame(2, $payload['option_count']);
	}

	public function test_finds_registered_voters_across_native_and_multi_page_ballots()
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->exactly(2))->method('sql_query')->willReturnOnConsecutiveCalls('native', 'ballots');
		$rows = array(
			'native' => array(array('vote_user_id' => 2), array('vote_user_id' => 3), array('vote_user_id' => 2), false),
			'ballots' => array(array('vote_user_id' => 4), array('vote_user_id' => 2), false),
		);
		$db->method('sql_fetchrow')->willReturnCallback(function ($result) use (&$rows) {
			return array_shift($rows[$result]);
		});
		$db->expects($this->exactly(2))->method('sql_freeresult');
		$notification = $this->create_notification($db);

		$recipients = $notification->find_users_for_notification(array(
			'topic_id' => 42,
			'forum_id' => 5,
			'actor_user_id' => 3,
		));

		$this->assertSame(array(2, 4), $notification->captured_users);
		$this->assertSame(5, $notification->captured_forum_id);
		$this->assertTrue($notification->captured_sort);
		$this->assertSame(array(2 => array('notification.method.board')), $recipients);
	}

	private function create_notification($db = null)
	{
		$db = $db ?: $this->createMock(\phpbb\db\driver\driver_interface::class);
		$notification = new testable_optionsadded(
			$db,
			$this->createMock(\phpbb\language\language::class),
			$this->createMock(\phpbb\user::class),
			$this->createMock(\phpbb\auth\auth::class),
			'./',
			'php',
			'phpbb_user_notifications'
		);
		$notification->set_table_prefix('phpbb_');
		$manager = $this->createMock(\phpbb\notification\manager::class);
		$manager->method('get_notification_type_id')->willReturn(12);
		$notification->set_notification_manager($manager);
		return $notification;
	}
}
