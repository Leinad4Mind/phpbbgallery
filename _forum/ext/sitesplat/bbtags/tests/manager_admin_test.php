<?php
/**
 * BBTags manager administration tests.
 *
 * @package sitesplat/bbtags
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace sitesplat\bbtags\tests;

use phpbb\auth\auth;
use phpbb\config\config;
use phpbb\db\driver\driver_interface;
use PHPUnit\Framework\TestCase;
use sitesplat\bbtags\tags\manager;

class manager_admin_test extends TestCase
{
	public function test_delete_tag_rejects_invalid_identifier()
	{
		$db = $this->createMock(driver_interface::class);
		$db->expects($this->never())->method('sql_query');

		$manager = $this->create_manager($db);
		$this->assertFalse($manager->delete_tag(0));
	}

	public function test_delete_tag_removes_relations_and_tag_in_transaction()
	{
		$db = $this->createMock(driver_interface::class);
		$transactions = array();
		$queries = array();
		$db->method('sql_transaction')->willReturnCallback(static function ($status) use (&$transactions)
		{
			$transactions[] = $status;
			return true;
		});
		$db->method('sql_query')->willReturnCallback(static function ($sql) use (&$queries)
		{
			$queries[] = $sql;
			return true;
		});

		$manager = $this->create_manager($db);
		$this->assertTrue($manager->delete_tag(12));
		$this->assertSame(array('begin', 'commit'), $transactions);
		$this->assertCount(4, $queries);
		$this->assertStringContainsString('DELETE FROM phpbb_bbtags_topic', $queries[0]);
		$this->assertStringContainsString('tag_id = 12', $queries[0]);
		$this->assertStringContainsString('DELETE FROM phpbb_bbtags_scope', $queries[1]);
		$this->assertStringContainsString('tag_id = 12', $queries[1]);
		$this->assertStringContainsString('DELETE FROM phpbb_bbtags_context', $queries[2]);
		$this->assertStringContainsString('tag_id = 12', $queries[2]);
		$this->assertStringContainsString('DELETE FROM phpbb_bbtags', $queries[3]);
		$this->assertStringContainsString('id = 12', $queries[3]);
	}

	public function test_delete_tag_rolls_back_when_a_query_fails()
	{
		$db = $this->createMock(driver_interface::class);
		$transactions = array();
		$db->method('sql_transaction')->willReturnCallback(static function ($status) use (&$transactions)
		{
			$transactions[] = $status;
			return true;
		});
		$db->expects($this->once())->method('sql_query')->willReturn(false);

		$manager = $this->create_manager($db);
		$this->assertFalse($manager->delete_tag(12));
		$this->assertSame(array('begin', 'rollback'), $transactions);
	}

	public function test_rename_tag_uses_database_update_builder()
	{
		$db = $this->createMock(driver_interface::class);
		$built_arrays = array();
		$db->method('sql_build_array')->willReturnCallback(static function ($type, array $values) use (&$built_arrays)
		{
			$built_arrays[] = array($type, $values);
			return $type . ':' . implode(',', array_keys($values));
		});
		$db->expects($this->exactly(2))->method('sql_query_limit')->willReturnOnConsecutiveCalls('name_result', 'route_result');
		$db->method('sql_fetchrow')->willReturn(false);
		$db->expects($this->once())
			->method('sql_query')
			->with($this->callback(static function ($sql)
			{
				return strpos($sql, 'UPDATE phpbb_bbtags') !== false
					&& strpos($sql, 'WHERE id = 7') !== false;
			}))
			->willReturn(true);

		$manager = $this->create_manager($db);
		$this->assertTrue($manager->rename_tag(7, " Owner's tag "));
		$this->assertSame(array('SELECT', array('route' => 'owner-s-tag')), $built_arrays[0]);
		$this->assertSame(
			array('UPDATE', array('tag' => "owner's tag", 'tag_clean' => "owner's tag", 'route' => 'owner-s-tag')),
			$built_arrays[1]
		);
	}

	public function test_rename_tag_rejects_an_existing_destination_name()
	{
		$db = $this->createMock(driver_interface::class);
		$db->method('sql_query_limit')->willReturn('existing');
		$db->method('sql_fetchrow')->willReturn(array('id' => 9));
		$db->expects($this->never())->method('sql_query');

		$this->assertFalse($this->create_manager($db)->rename_tag(7, 'existing tag'));
	}

	public function test_merge_rejects_the_same_source_and_destination_without_queries()
	{
		$db = $this->createMock(driver_interface::class);
		$db->expects($this->never())->method('sql_query');
		$db->expects($this->never())->method('sql_query_limit');
		$db->expects($this->never())->method('sql_transaction');

		$this->assertFalse($this->create_manager($db)->merge_tags(7, 7));
	}

	public function test_merge_rolls_back_when_source_is_used_by_external_provider()
	{
		$db = $this->createMock(driver_interface::class);
		$transactions = array();
		$db->method('sql_transaction')->willReturnCallback(static function ($status) use (&$transactions)
		{
			$transactions[] = $status;
			return true;
		});
		$db->method('sql_query_limit')->willReturnCallback(static function ($sql)
		{
			return strpos($sql, 'id = 7') !== false ? 'source' : 'destination';
		});
		$db->method('sql_query')->willReturn('providers');
		$rows = array(
			'source' => array(array('id' => 7, 'tag' => 'typo', 'tag_clean' => 'typo', 'route' => 'typo', 'count' => 1, 'is_predefined' => 0)),
			'destination' => array(array('id' => 8, 'tag' => 'phpbb', 'tag_clean' => 'phpbb', 'route' => 'phpbb', 'count' => 7, 'is_predefined' => 1)),
			'providers' => array(array('provider' => 'gallery_items')),
		);
		$db->method('sql_fetchrow')->willReturnCallback(static function ($result) use (&$rows)
		{
			return array_shift($rows[$result]) ?: false;
		});

		$this->assertFalse($this->create_manager($db)->merge_tags(7, 8));
		$this->assertSame(array('begin', 'rollback'), $transactions);
	}

	public function test_merge_topic_relations_deduplicates_destination_topics()
	{
		$db = $this->createMock(driver_interface::class);
		$db->method('sql_in_set')->willReturn('tag_id IN (7, 8)');
		$db->method('sql_query')->willReturnOnConsecutiveCalls('relations', true);
		$rows = array(
			array('topic_id' => 10, 'tag_id' => 7),
			array('topic_id' => 11, 'tag_id' => 7),
			array('topic_id' => 11, 'tag_id' => 8),
		);
		$db->method('sql_fetchrow')->willReturnCallback(static function ($result) use (&$rows)
		{
			return $result === 'relations' ? (array_shift($rows) ?: false) : false;
		});
		$db->expects($this->once())
			->method('sql_multi_insert')
			->with('phpbb_bbtags_topic', array(array('topic_id' => 10, 'tag_id' => 8)))
			->willReturn(true);

		$method = new \ReflectionMethod(manager::class, 'merge_topic_relations');

		$this->assertTrue($method->invoke($this->create_manager($db), 7, 8));
	}

	private function create_manager(driver_interface $db)
	{
		return new manager(
			$db,
			$this->createMock(config::class),
			$this->createMock(auth::class),
			'phpbb_bbtags',
			'phpbb_bbtags_context',
			'phpbb_bbtags_scope',
			'phpbb_bbtags_topic'
		);
	}
}
