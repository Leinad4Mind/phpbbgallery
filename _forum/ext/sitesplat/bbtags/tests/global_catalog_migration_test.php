<?php
/**
 * BBTags global catalogue migration tests.
 *
 * @package sitesplat/bbtags
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace sitesplat\bbtags\tests;

use phpbb\config\config;
use phpbb\db\driver\driver_interface;
use phpbb\db\tools\tools_interface;
use PHPUnit\Framework\TestCase;
use sitesplat\bbtags\migrations\v33x\m7_global_catalog_schema;
use sitesplat\bbtags\migrations\v33x\m8_global_catalog_data;
use sitesplat\bbtags\migrations\v33x\m9_global_catalog_constraints;
use sitesplat\bbtags\migrations\v33x\m10_hierarchical_scopes;
use sitesplat\bbtags\migrations\v33x\m11_tag_moderation;
use sitesplat\bbtags\migrations\v33x\m12_catalog_ready;

class global_catalog_migration_test extends TestCase
{
	public function test_schema_preserves_legacy_tables_and_adds_global_catalog_fields()
	{
		$migration = $this->create_migration(m7_global_catalog_schema::class);
		$schema = $migration->update_schema();

		$this->assertSame(array('VCHAR:64', ''), $schema['change_columns']['phpbb_bbtags']['tag']);
		$this->assertSame(array('VCHAR:64', ''), $schema['change_columns']['phpbb_bbtags']['route']);
		$this->assertArrayHasKey('tag_clean', $schema['add_columns']['phpbb_bbtags']);
		$this->assertArrayHasKey('is_predefined', $schema['add_columns']['phpbb_bbtags']);
		$this->assertSame(
			array('tag_id', 'provider'),
			$schema['add_tables']['phpbb_bbtags_context']['PRIMARY_KEY']
		);
		$this->assertArrayNotHasKey('usage', $schema['add_tables']['phpbb_bbtags_context']['KEYS']);
		$this->assertSame(
			array('INDEX', array('provider', 'usage_count')),
			$schema['add_tables']['phpbb_bbtags_context']['KEYS']['provider_usage']
		);
	}

	public function test_schema_waits_for_all_legacy_storage_and_configuration()
	{
		$this->assertSame(
			array(
				'\sitesplat\bbtags\migrations\v31x\m1_initial_schema',
				'\sitesplat\bbtags\migrations\v31x\m2_initial_config',
				'\sitesplat\bbtags\migrations\v32x\m6_add_cloud_limit',
			),
			m7_global_catalog_schema::depends_on()
		);
	}

	public function test_data_conversion_runs_before_unique_constraints()
	{
		$migration = $this->create_migration(m8_global_catalog_data::class);
		$data = $migration->update_data();

		$this->assertSame(array($migration, 'migrate_catalog'), $data[0][1][0]);
		$this->assertSame(
			array('\sitesplat\bbtags\migrations\v33x\m8_global_catalog_data'),
			m9_global_catalog_constraints::depends_on()
		);
	}

	public function test_constraints_prevent_duplicate_catalog_and_topic_relations()
	{
		$migration = $this->create_migration(m9_global_catalog_constraints::class);
		$schema = $migration->update_schema();

		$this->assertSame(array('tag_clean'), $schema['add_unique_index']['phpbb_bbtags']['tag_clean']);
		$this->assertSame(array('route'), $schema['add_unique_index']['phpbb_bbtags']['route']);
		$this->assertSame(
			array('topic_id', 'tag_id'),
			$schema['add_unique_index']['phpbb_bbtags_topic']['topic_tag']
		);
	}

	public function test_hierarchical_scope_schema_is_generic_for_all_providers()
	{
		$migration = $this->create_migration(m10_hierarchical_scopes::class);
		$schema = $migration->update_schema();

		$this->assertSame(
			array('VCHAR:12', 'global'),
			$schema['add_columns']['phpbb_bbtags_context']['scope_mode']
		);
		$this->assertSame(
			array('UNIQUE', array('tag_id', 'provider', 'scope_id')),
			$schema['add_tables']['phpbb_bbtags_scope']['KEYS']['tag_scope']
		);
		$this->assertSame(
			array('\sitesplat\bbtags\migrations\v33x\m9_global_catalog_constraints'),
			m10_hierarchical_scopes::depends_on()
		);
	}

	public function test_moderation_schema_installs_an_mcp_queue(): void
	{
		$migration = $this->create_migration(m11_tag_moderation::class);
		$table = $migration->update_schema()['add_tables']['phpbb_bbtags_suggestions'];

		$this->assertArrayHasKey('provider', $table['COLUMNS']);
		$this->assertArrayHasKey('scope_id', $table['COLUMNS']);
		$this->assertArrayHasKey('item_id', $table['COLUMNS']);
		$this->assertArrayHasKey('reviewed_by', $table['COLUMNS']);
		$this->assertSame(['UNIQUE', ['dedupe_key']], $table['KEYS']['dedupe_key']);
		$this->assertSame(['\sitesplat\bbtags\migrations\v33x\m10_hierarchical_scopes'], m11_tag_moderation::depends_on());

		$data = $migration->update_data();
		$this->assertSame(['permission.add', ['m_bbtags_moderate', true]], $data[0]);
		$this->assertSame('mcp', $data[3][1][0]);
		$this->assertSame('MCP_QUEUE', $data[3][1][1]);
	}

	public function test_catalog_is_marked_ready_only_after_all_schema_migrations(): void
	{
		$migration = $this->create_migration(m12_catalog_ready::class);

		$this->assertSame(
			['\sitesplat\bbtags\migrations\v33x\m11_tag_moderation'],
			m12_catalog_ready::depends_on()
		);
		$this->assertSame(
			['config.add', ['bbtags_catalog_version', 1]],
			$migration->update_data()[1]
		);
	}

	public function test_catalog_ready_migration_repairs_the_reserved_usage_index_name(): void
	{
		$db_tools = $this->createMock(tools_interface::class);
		$index_checks = [];
		$db_tools->expects($this->exactly(2))
			->method('sql_index_exists')
			->willReturnCallback(static function ($table, $index) use (&$index_checks)
			{
				$index_checks[] = [$table, $index];
				return false;
			});
		$db_tools->expects($this->once())
			->method('sql_create_index')
			->with(
				'phpbb_bbtags_context',
				'provider_usage',
				['provider', 'usage_count']
			);

		$migration = $this->create_migration(m12_catalog_ready::class, null, $db_tools);
		$migration->ensure_provider_usage_index();

		$this->assertSame(
			[
				['phpbb_bbtags_context', 'usage'],
				['phpbb_bbtags_context', 'provider_usage'],
			],
			$index_checks
		);
	}

	public function test_catalog_conversion_is_atomic_and_seeds_forum_provider()
	{
		$db = $this->createMock(driver_interface::class);
		$transactions = $queries = array();
		$rows = array(
			'catalog' => array(
				array('id' => 1, 'tag' => 'Anime', 'route' => 'anime', 'is_predefined' => 0),
				array('id' => 2, 'tag' => 'anime', 'route' => 'anime-old', 'is_predefined' => 1),
			),
			'config' => array(array('config_value' => '["Anime","Manga"]')),
			'current' => array(array('id' => 1, 'tag_clean' => 'anime', 'route' => 'anime')),
			'relations' => array(
				array('id' => 10, 'topic_id' => 5, 'tag_id' => 1),
				array('id' => 11, 'topic_id' => 5, 'tag_id' => 1),
			),
			'counts' => array(
				array('id' => 1, 'usage_count' => 1),
				array('id' => 3, 'usage_count' => 0),
			),
		);

		$db->method('sql_transaction')->willReturnCallback(static function ($status) use (&$transactions)
		{
			$transactions[] = $status;
			return true;
		});
		$db->method('sql_query')->willReturnCallback(static function ($sql) use (&$queries)
		{
			$queries[] = $sql;
			return $sql;
		});
		$db->method('sql_fetchrow')->willReturnCallback(static function ($result) use (&$rows)
		{
			if (strpos($result, 'SELECT id, tag, route') !== false)
			{
				return array_shift($rows['catalog']) ?: false;
			}
			if (strpos($result, 'FROM phpbb_config_text') !== false)
			{
				return array_shift($rows['config']) ?: false;
			}
			if (strpos($result, 'SELECT id, tag_clean, route') !== false)
			{
				return array_shift($rows['current']) ?: false;
			}
			if (strpos($result, 'SELECT id, topic_id, tag_id') !== false)
			{
				return array_shift($rows['relations']) ?: false;
			}
			if (strpos($result, 'COUNT(tt.topic_id)') !== false)
			{
				return array_shift($rows['counts']) ?: false;
			}
			return false;
		});
		$db->method('sql_build_array')->willReturnCallback(static function ($type, array $values)
		{
			return $type . ':' . implode(',', array_keys($values));
		});
		$db->method('sql_in_set')->willReturnCallback(static function ($field, array $values)
		{
			return $field . ' IN (' . implode(',', $values) . ')';
		});
		$db->method('sql_nextid')->willReturn(3);

		$migration = $this->create_migration(m8_global_catalog_data::class, $db);
		$migration->migrate_catalog();

		$this->assertSame(array('begin', 'commit'), $transactions);
		$this->assertNotEmpty(array_filter($queries, static function ($sql)
		{
			return strpos($sql, 'SET tag_id = 1') !== false && strpos($sql, 'WHERE tag_id = 2') !== false;
		}));
		$this->assertNotEmpty(array_filter($queries, static function ($sql)
		{
			return strpos($sql, 'DELETE FROM phpbb_bbtags_topic') !== false && strpos($sql, 'id IN (11)') !== false;
		}));
		$this->assertNotEmpty(array_filter($queries, static function ($sql)
		{
			return strpos($sql, 'INSERT INTO phpbb_bbtags_context') !== false && strpos($sql, 'provider') !== false;
		}));
	}

	/**
	 * Create an isolated migration using the real phpBB migration base class.
	 *
	 * @param string                $class Migration class name
	 * @param driver_interface|null $db    Optional database mock
	 *
	 * @return \phpbb\db\migration\migration
	 */
	private function create_migration($class, ?driver_interface $db = null, ?tools_interface $db_tools = null)
	{
		return new $class(
			$this->createMock(config::class),
			$db ?: $this->createMock(driver_interface::class),
			$db_tools ?: $this->createMock(tools_interface::class),
			'./',
			'php',
			'phpbb_'
		);
	}
}
