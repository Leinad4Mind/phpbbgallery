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
	private function create_migration($class, ?driver_interface $db = null)
	{
		return new $class(
			$this->createMock(config::class),
			$db ?: $this->createMock(driver_interface::class),
			$this->createMock(tools_interface::class),
			'./',
			'php',
			'phpbb_'
		);
	}
}
