<?php

namespace leinad4mind\officialtopicindex\tests;

use kasimi\topicindexbridge\event\main_listener;
use leinad4mind\officialtopicindex\migrations\officialtopicindex_1_0_3;
use leinad4mind\officialtopicindex\migrations\officialtopicindex_2_0_0;
use leinad4mind\officialtopicindex\migrations\officialtopicindex_schema;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionProperty;

class migration_compatibility_test extends TestCase
{
	public function test_schema_rollback_targets_topics_table()
	{
		$migration = (new ReflectionClass(officialtopicindex_schema::class))->newInstanceWithoutConstructor();
		$property = new ReflectionProperty(\phpbb\db\migration\migration::class, 'table_prefix');
		$property->setAccessible(true);
		$property->setValue($migration, 'phpbb_');

		$schema = $migration->revert_schema();

		$this->assertArrayHasKey('phpbb_topics', $schema['drop_columns']);
		$this->assertArrayNotHasKey('phpbb_posts', $schema['drop_columns']);
	}

	public function test_permission_migration_copies_dmzx_assignments()
	{
		$migration = (new ReflectionClass(officialtopicindex_1_0_3::class))->newInstanceWithoutConstructor();
		$data = $migration->update_data();

		$this->assertSame(
			['permission.add', ['u_officialtopicindex_view', true, 'u_topicindex_view']],
			$data[0]
		);
	}

	public function test_version_two_depends_on_complete_official_install()
	{
		$dependencies = officialtopicindex_2_0_0::depends_on();

		$this->assertContains('\leinad4mind\officialtopicindex\migrations\officialtopicindex_1_0_3', $dependencies);
		$this->assertContains('\leinad4mind\officialtopicindex\migrations\officialtopicindex_module', $dependencies);
		$this->assertContains('\leinad4mind\officialtopicindex\migrations\officialtopicindex_schema', $dependencies);
	}

	public function test_bridge_supports_official_and_transition_events()
	{
		$events = main_listener::getSubscribedEvents();

		$this->assertSame('enrich_topics', $events['leinad4mind.officialtopicindex.enrich_topiclist']);
		$this->assertSame('enrich_topics', $events['dmzx.topicindex.enrich_topiclist']);
		$this->assertSame('acp_save', $events['leinad4mind.officialtopicindex.acp_save']);
	}

	public function test_templates_keep_original_official_event_names()
	{
		$root = dirname(__DIR__);
		$rows = file_get_contents($root . '/styles/all/template/topicindex_rows.html');
		$filters = file_get_contents($root . '/styles/all/template/topicindex_filters.html');

		$this->assertStringContainsString('EVENT leinad4mind_topic_index_topic_before', $rows);
		$this->assertStringContainsString('EVENT leinad4mind_topic_index_topic_filter_container_before', $filters);
	}
}
