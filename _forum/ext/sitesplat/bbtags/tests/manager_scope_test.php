<?php
/**
 * BBTags hierarchical scope tests.
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

class manager_scope_test extends TestCase
{
	public function test_nearest_explicit_rule_overrides_ancestors()
	{
		$manager = $this->create_manager($this->createMock(driver_interface::class));
		$path = array(30, 20, 10, 0);

		$this->assertFalse($manager->scope_allows('global', array(30 => 'deny', 20 => 'allow'), $path));
		$this->assertTrue($manager->scope_allows('restricted', array(20 => 'allow'), $path));
		$this->assertFalse($manager->scope_allows('restricted', array(), $path));
		$this->assertTrue($manager->scope_allows('global', array(), $path));
	}

	public function test_forum_path_is_ordered_from_current_forum_to_root()
	{
		$db = $this->createMock(driver_interface::class);
		$db->method('sql_query')->willReturnCallback(static function ($sql)
		{
			return $sql;
		});
		$bounds = array(array('forum_left' => 8, 'forum_right' => 13));
		$ancestors = array(
			array('forum_id' => 30),
			array('forum_id' => 20),
			array('forum_id' => 10),
		);
		$db->method('sql_fetchrow')->willReturnCallback(static function ($result) use (&$bounds, &$ancestors)
		{
			return (strpos($result, 'SELECT forum_left') !== false)
				? (array_shift($bounds) ?: false)
				: (array_shift($ancestors) ?: false);
		});

		$this->assertSame(array(30, 20, 10, 0), $this->create_manager($db)->get_forum_scope_path(30));
	}

	public function test_filter_rejects_disabled_and_restricted_without_allow_rule()
	{
		$db = $this->createMock(driver_interface::class);
		$db->method('sql_escape')->willReturnArgument(0);
		$db->method('sql_in_set')->willReturnCallback(static function ($field, array $values)
		{
			return $field . ' IN (' . implode(',', $values) . ')';
		});
		$db->method('sql_query')->willReturnCallback(static function ($sql)
		{
			return $sql;
		});
		$contexts = array(
			array('tag_id' => 1, 'scope_mode' => 'global', 'is_enabled' => 0),
			array('tag_id' => 2, 'scope_mode' => 'restricted', 'is_enabled' => 1),
			array('tag_id' => 3, 'scope_mode' => 'global', 'is_enabled' => 1),
		);
		$rules = array(array('tag_id' => 2, 'scope_id' => 20, 'scope_rule' => 'allow'));
		$db->method('sql_fetchrow')->willReturnCallback(static function ($result) use (&$contexts, &$rules)
		{
			return (strpos($result, 'FROM phpbb_bbtags_context') !== false)
				? (array_shift($contexts) ?: false)
				: (array_shift($rules) ?: false);
		});

		$this->assertSame(
			array(2, 3),
			$this->create_manager($db)->filter_available_tag_ids(array(1, 2, 3), manager::FORUM_PROVIDER, array(30, 20, 0))
		);
	}

	public function test_scope_mutations_validate_modes_rules_and_provider_names()
	{
		$db = $this->createMock(driver_interface::class);
		$db->expects($this->never())->method('sql_query');
		$manager = $this->create_manager($db);

		$this->assertFalse($manager->set_scope_mode(1, 'Invalid Provider', 'global'));
		$this->assertFalse($manager->set_scope_mode(1, manager::FORUM_PROVIDER, 'unknown'));
		$this->assertFalse($manager->set_scope_rule(1, manager::FORUM_PROVIDER, 2, 'unknown'));
	}

	public function test_scope_mutations_store_modes_explicit_rules_and_inheritance()
	{
		$db = $this->createMock(driver_interface::class);
		$queries = array();
		$db->method('sql_escape')->willReturnArgument(0);
		$db->method('sql_build_array')->willReturnCallback(static function ($type, array $values)
		{
			return $type . ':' . implode(',', array_keys($values));
		});
		$db->method('sql_query_limit')->willReturn('scope_lookup');
		$db->method('sql_fetchrow')->willReturn(false);
		$db->method('sql_query')->willReturnCallback(static function ($sql) use (&$queries)
		{
			$queries[] = $sql;
			return true;
		});
		$manager = $this->create_manager($db);

		$this->assertTrue($manager->set_scope_mode(4, manager::FORUM_PROVIDER, 'restricted'));
		$this->assertTrue($manager->set_scope_rule(4, manager::FORUM_PROVIDER, 20, 'allow'));
		$this->assertTrue($manager->set_scope_rule(4, manager::FORUM_PROVIDER, 30, 'inherit'));
		$this->assertStringContainsString('UPDATE phpbb_bbtags_context', $queries[0]);
		$this->assertStringContainsString('INSERT INTO phpbb_bbtags_scope', $queries[1]);
		$this->assertStringContainsString('DELETE FROM phpbb_bbtags_scope', $queries[2]);
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
