<?php
/**
 * BBTags global catalogue runtime tests.
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

class manager_catalog_test extends TestCase
{
	public function test_services_wire_the_context_table_and_remove_controller_json_dependency()
	{
		$services = file_get_contents(dirname(__DIR__) . '/config/services.yml');

		$this->assertStringContainsString('%sitesplat.bbtags.tables.bbtags_context%', $services);
		$this->assertStringContainsString('%sitesplat.bbtags.tables.bbtags_scope%', $services);
		$this->assertStringNotContainsString("- '@config_text'", $services);
	}

	public function test_clean_and_canonical_names_are_case_insensitive_and_bounded()
	{
		$db = $this->createMock(driver_interface::class);
		$manager = $this->create_manager($db);
		$tag = str_repeat('Á', 70);

		$this->assertSame(64, mb_strlen($manager->clean_tag($tag), 'UTF-8'));
		$this->assertSame('anime', $manager->canonical_tag('  ANIME., '));
	}

	public function test_predefined_autocomplete_uses_canonical_prefix_and_limit()
	{
		$db = $this->createMock(driver_interface::class);
		$db->method('sql_query')->willReturn('predefined');
		$rows = array(
			array('id' => 1, 'tag' => 'Anime', 'scope_mode' => 'global'),
			array('id' => 2, 'tag' => 'Animation', 'scope_mode' => 'global'),
			array('id' => 3, 'tag' => 'Manga', 'scope_mode' => 'global'),
		);
		$db->method('sql_fetchrow')->willReturnCallback(static function () use (&$rows)
		{
			return array_shift($rows) ?: false;
		});

		$this->assertSame(
			array('Anime', 'Animation'),
			$this->create_manager($db)->get_predefined_tags('ANI', 2)
		);
	}

	public function test_unused_cleanup_preserves_tags_owned_by_another_provider()
	{
		$db = $this->createMock(driver_interface::class);
		$queries = array();
		$db->method('sql_query')->willReturnCallback(static function ($sql) use (&$queries)
		{
			$queries[] = $sql;
			return $sql;
		});
		$db->method('sql_fetchrow')->willReturn(false);

		$this->assertSame(0, $this->create_manager($db)->delete_unused_tags());
		$this->assertStringContainsString('t.is_predefined = 0', $queries[0]);
		$this->assertStringContainsString("tc.provider <> 'forum_topics'", $queries[0]);
		$this->assertStringContainsString('(tc.is_enabled = 1 OR tc.usage_count > 0)', $queries[0]);
	}

	public function test_replacing_predefined_tags_creates_canonical_rows_and_provider_contexts()
	{
		$db = $this->createMock(driver_interface::class);
		$transactions = $multi_inserts = array();
		$catalog_query = 0;
		$db->method('sql_transaction')->willReturnCallback(static function ($status) use (&$transactions)
		{
			$transactions[] = $status;
			return true;
		});
		$db->method('sql_query')->willReturnCallback(static function ($sql) use (&$catalog_query)
		{
			if (strpos($sql, 'SELECT id, tag, tag_clean') !== false)
			{
				$catalog_query++;
				return 'catalog-' . $catalog_query;
			}
			if (strpos($sql, 'SELECT tag_id') !== false)
			{
				return 'contexts';
			}
			return $sql;
		});
		$catalog_rows = array(
			'catalog-1' => array(),
			'catalog-2' => array(
				array('id' => 21, 'tag' => 'c++', 'tag_clean' => 'c++'),
				array('id' => 22, 'tag' => 'c#', 'tag_clean' => 'c#'),
			),
			'contexts' => array(),
		);
		$db->method('sql_fetchrow')->willReturnCallback(static function ($result) use (&$catalog_rows)
		{
			if (strpos($result, 'route-') === 0)
			{
				return false;
			}
			return array_shift($catalog_rows[$result]) ?: false;
		});
		$route_query = 0;
		$db->method('sql_query_limit')->willReturnCallback(static function () use (&$route_query)
		{
			$route_query++;
			return 'route-' . $route_query;
		});
		$db->method('sql_build_array')->willReturnCallback(static function ($type, array $values)
		{
			return $type . ':' . implode(',', array_keys($values));
		});
		$db->method('sql_in_set')->willReturnCallback(static function ($field, array $values)
		{
			return $field . ' IN (' . implode(',', $values) . ')';
		});
		$db->method('sql_multi_insert')->willReturnCallback(static function ($table, array $rows) use (&$multi_inserts)
		{
			$multi_inserts[] = array($table, $rows);
			return true;
		});

		$this->assertTrue($this->create_manager($db)->replace_predefined_tags(array('C++', 'C#'), 7));
		$this->assertSame(array('begin', 'commit'), $transactions);
		$this->assertCount(2, $multi_inserts);
		$this->assertSame('phpbb_bbtags', $multi_inserts[0][0]);
		$this->assertSame('c++', $multi_inserts[0][1][0]['tag_clean']);
		$this->assertSame(7, $multi_inserts[0][1][0]['created_by']);
		$this->assertNotSame($multi_inserts[0][1][0]['route'], $multi_inserts[0][1][1]['route']);
		$this->assertSame('phpbb_bbtags_context', $multi_inserts[1][0]);
		$this->assertSame(manager::FORUM_PROVIDER, $multi_inserts[1][1][0]['provider']);
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
