<?php

namespace leinad4mind\loginredirect\tests;

use leinad4mind\loginredirect\core\topic_repository;
use phpbb\auth\auth;
use phpbb\db\driver\driver_interface;
use PHPUnit\Framework\TestCase;

class topic_repository_test extends TestCase
{
	public function test_unreadable_topic_is_rejected()
	{
		$db = $this->database(array(
			'topic_id' => 9,
			'forum_id' => 4,
			'topic_time' => 100,
			'topic_type' => 0,
			'topic_visibility' => ITEM_APPROVED,
		));
		$auth = $this->createMock(auth::class);
		$auth->expects($this->once())->method('acl_get')->with('f_list', 4)->willReturn(false);

		$repository = new topic_repository($db, $auth, $this->tables());
		$this->assertNull($repository->find_topic(9));
	}

	public function test_readable_topic_is_normalized()
	{
		$db = $this->database(array(
			'topic_id' => '9',
			'forum_id' => '4',
			'topic_time' => '100',
			'topic_type' => '0',
			'topic_visibility' => (string) ITEM_APPROVED,
		));
		$auth = $this->createMock(auth::class);
		$auth->method('acl_get')->willReturn(true);

		$repository = new topic_repository($db, $auth, $this->tables());
		$this->assertSame(9, $repository->find_topic(9)['topic_id']);
	}

	public function test_pending_group_memberships_are_excluded()
	{
		$db = $this->createMock(driver_interface::class);
		$db->expects($this->once())->method('sql_query')->with($this->callback(function ($sql)
		{
			return strpos($sql, 'user_pending = 0') !== false;
		}))->willReturn('result');
		$db->method('sql_fetchrow')->willReturn(false);
		$db->method('sql_freeresult');

		$repository = new topic_repository($db, $this->createMock(auth::class), $this->tables());
		$this->assertFalse($repository->user_in_group(12, 5));
	}

	protected function database($row)
	{
		$db = $this->createMock(driver_interface::class);
		$db->method('sql_query')->willReturn('result');
		$db->method('sql_fetchrow')->willReturn($row);
		$db->method('sql_freeresult');
		return $db;
	}

	protected function tables()
	{
		return array('topics' => 'phpbb_topics', 'groups' => 'phpbb_groups', 'user_group' => 'phpbb_user_group');
	}
}
