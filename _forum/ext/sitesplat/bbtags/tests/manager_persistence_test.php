<?php
/**
 * BBTags topic persistence tests.
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

class manager_persistence_test extends TestCase
{
	public function test_remove_tags_ignores_an_empty_topic_list()
	{
		$db = $this->createMock(driver_interface::class);
		$db->expects($this->never())->method('sql_query');
		$db->expects($this->never())->method('sql_transaction');

		$this->assertSame(0, $this->create_manager($db)->remove_tags_from_topics(array()));
	}

	public function test_assigning_an_empty_tag_list_never_bulk_inserts()
	{
		$db = $this->createMock(driver_interface::class);
		$transactions = array();
		$db->method('sql_transaction')->willReturnCallback(static function ($status) use (&$transactions)
		{
			$transactions[] = $status;
			return true;
		});
		$db->method('sql_in_set')->willReturn('topic_id = 9');
		$db->method('sql_query')->willReturn(true);
		$db->method('sql_fetchrow')->willReturn(false);
		$db->method('sql_affectedrows')->willReturn(1);
		$db->expects($this->never())->method('sql_multi_insert');

		$this->assertTrue($this->create_manager($db)->assign_tags_to_topic(9, array()));
		$this->assertSame(array('begin', 'commit'), $transactions);
	}

	public function test_assignment_rolls_back_when_relation_insert_fails()
	{
		$db = $this->createMock(driver_interface::class);
		$transactions = array();
		$db->method('sql_transaction')->willReturnCallback(static function ($status) use (&$transactions)
		{
			$transactions[] = $status;
			return true;
		});
		$db->method('sql_in_set')->willReturnCallback(static function ($field)
		{
			return ($field === 'tag_clean') ? "tag_clean = 'anime'" : 'topic_id = 9';
		});
		$db->method('sql_query')->willReturnCallback(static function ($sql)
		{
			return $sql;
		});
		$catalog_rows = array(
			array('id' => 4, 'tag' => 'anime', 'tag_clean' => 'anime'),
			false,
			array('id' => 4, 'tag' => 'anime', 'tag_clean' => 'anime'),
			false,
		);
		$context_queries = 0;
		$db->method('sql_fetchrow')->willReturnCallback(static function ($result) use (&$catalog_rows, &$context_queries)
		{
			if (strpos($result, 'SELECT id, tag, tag_clean') !== false)
			{
				return array_shift($catalog_rows);
			}
			if (strpos($result, 'FROM phpbb_bbtags_context') !== false)
			{
				$context_queries++;
				return ($context_queries === 1)
					? array('tag_id' => 4)
					: (($context_queries === 2) ? false : (($context_queries === 3) ? array('tag_id' => 4, 'scope_mode' => 'global', 'is_enabled' => 1) : false));
			}
			return false;
		});
		$db->method('sql_affectedrows')->willReturn(1);
		$db->expects($this->once())->method('sql_multi_insert')->willReturn(false);

		$this->assertFalse($this->create_manager($db)->assign_tags_to_topic(9, array('anime')));
		$this->assertSame(array('begin', 'rollback'), $transactions);
	}

	public function test_recalculation_resets_stale_counts_before_counting_relations()
	{
		$db = $this->createMock(driver_interface::class);
		$queries = array();
		$db->method('sql_query')->willReturnCallback(static function ($sql) use (&$queries)
		{
			$queries[] = $sql;
			return $sql;
		});
		$rows = array(
			'contexts' => array(array('tag_id' => 4)),
			'counts' => array(array('tag_id' => 4, 'count' => 3)),
		);
		$db->method('sql_fetchrow')->willReturnCallback(static function ($result) use (&$rows)
		{
			if (strpos($result, 'SELECT tag_id') !== false && strpos($result, 'COUNT(') === false)
			{
				return array_shift($rows['contexts']) ?: false;
			}
			if (strpos($result, 'COUNT(topic_id)') !== false)
			{
				return array_shift($rows['counts']) ?: false;
			}
			return false;
		});
		$db->expects($this->never())->method('sql_multi_insert');

		$this->assertTrue($this->create_manager($db)->calc_count_tags());
		$this->assertStringContainsString('SET count = 0', $queries[0]);
		$this->assertStringContainsString('SET usage_count = 0', $queries[1]);
		$this->assertStringContainsString('COUNT(topic_id)', $queries[3]);
		$this->assertStringContainsString('SET count = 3 WHERE id = 4', $queries[4]);
		$this->assertStringContainsString('SET usage_count = 3', $queries[5]);
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
