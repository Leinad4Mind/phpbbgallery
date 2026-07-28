<?php
/**
 * BBPrefix tests.
 *
 * @package BBprefix
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace sitesplat\bbprefix\tests;

use PHPUnit\Framework\TestCase;
use sitesplat\bbprefix\core\manager;

class manager_cache_test extends TestCase
{
	private fake_db $db;
	private fake_cache $cache;

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		$this->db = new fake_db();
		$this->cache = new fake_cache();

		$this->db->tables[BBPREFIX_TABLE] = [
			$this->prefix_row(1, 'Alpha'),
			$this->prefix_row(2, 'Beta'),
			$this->prefix_row(3, 'Gamma'),
			$this->prefix_row(4, 'Delta'),
		];
		$this->db->tables[BBPREFIX_INSTANCES_TABLE] = [
			['id' => 1, 'prefix' => 1, 'topic' => 10, 'ordered' => 0, 'token_data' => ''],
			['id' => 2, 'prefix' => 2, 'topic' => 11, 'ordered' => 0, 'token_data' => ''],
		];
		$this->db->tables[GROUPS_TABLE] = [
			['group_id' => 1, 'group_name' => 'REGISTERED'],
		];
		$this->db->tables[FORUMS_TABLE] = [
			['forum_id' => 1, 'forum_name' => 'General'],
		];
	}

	public function test_a_complete_load_is_cached_with_a_bounded_lifetime(): void
	{
		$manager = $this->new_manager();

		$this->assertCount(4, $manager->get_prefixes());
		$this->assertArrayHasKey('_prefixes', $this->cache->writes);
		// A permanent entry is what made a bad value survive until a manual purge.
		$this->assertLessThanOrEqual(3600, $this->cache->writes['_prefixes']['ttl']);
	}

	public function test_a_valid_cache_is_used_without_touching_the_table(): void
	{
		$this->cache->store['_prefixes'] = [1 => $this->prefix_row(1, 'Alpha')];
		$this->cache->store['_prefixes_used'] = [1 => ['id' => 1]];

		$manager = $this->new_manager();

		$this->assertSame(0, $this->db->queries_against(BBPREFIX_TABLE), 'the cache should still be doing its job');
		$this->assertCount(1, $manager->get_prefixes());
	}

	public function test_an_empty_cached_set_no_longer_perpetuates_itself(): void
	{
		// The old check was `false === $cache->get(...)`, so an empty array counted
		// as a valid answer and the database was never consulted again.
		$this->cache->store['_prefixes'] = [];

		$manager = $this->new_manager();

		$this->assertCount(4, $manager->get_prefixes());
	}

	public function test_a_non_array_cached_value_is_treated_as_a_miss(): void
	{
		$this->cache->store['_prefixes'] = 'not an array';

		$this->assertCount(4, $this->new_manager()->get_prefixes());
	}

	public function test_a_short_result_set_is_used_but_never_cached(): void
	{
		// This is the reported failure: the fetch stops early, so the manager only
		// sees 2 of 4 prefixes. Serving them is fine; keeping them is not.
		$this->db->short_rows[BBPREFIX_TABLE] = 2;

		$manager = $this->new_manager();

		$this->assertCount(2, $manager->get_prefixes(), 'the request still works with what was read');
		$this->assertArrayNotHasKey('_prefixes', $this->cache->writes, 'an unverified set must not be cached');
	}

	public function test_the_next_request_recovers_after_a_short_read(): void
	{
		$this->db->short_rows[BBPREFIX_TABLE] = 2;
		$this->new_manager();

		// Nothing poisoned the cache, so a healthy request sees everything again -
		// no manual cache purge involved.
		$this->db->short_rows = [];
		$this->assertCount(4, $this->new_manager()->get_prefixes());
	}

	public function test_prefix_instances_get_the_same_protection(): void
	{
		$this->db->short_rows[BBPREFIX_INSTANCES_TABLE] = 1;

		$manager = $this->new_manager();

		$this->assertCount(1, $manager->get_prefix_instances());
		$this->assertArrayNotHasKey('_prefixes_used', $this->cache->writes);
	}

	public function test_an_empty_table_is_not_cached(): void
	{
		$this->db->tables[BBPREFIX_TABLE] = [];

		$manager = $this->new_manager();

		$this->assertSame([], $manager->get_prefixes());
		$this->assertArrayNotHasKey('_prefixes', $this->cache->writes);
	}

	public function test_a_throwing_cache_backend_falls_back_to_the_database(): void
	{
		// The old catch(Exception) could never match, because the file declares a
		// namespace and imports nothing.
		$this->cache->throw_on_get = new \RuntimeException('cache backend down');

		$this->assertCount(4, $this->new_manager()->get_prefixes());
	}

	public function test_a_deleted_group_does_not_break_a_prefix(): void
	{
		$this->db->tables[BBPREFIX_TABLE] = [
			$this->prefix_row(1, 'Alpha', json_encode([1, 999])),
		];

		$prefixes = $this->new_manager()->get_prefixes();

		$this->assertCount(1, $prefixes);
		// Group 999 is gone, so it is skipped rather than stored as a null name.
		$this->assertSame(['REGISTERED'], $prefixes[1]['groupnames']);
	}

	public function test_malformed_group_and_forum_json_is_survivable(): void
	{
		$this->db->tables[BBPREFIX_TABLE] = [
			$this->prefix_row(1, 'Alpha', 'not json', 'not json either'),
		];

		$prefixes = $this->new_manager()->get_prefixes();

		$this->assertCount(1, $prefixes);
		$this->assertArrayNotHasKey('groupnames', $prefixes[1]);
	}

	public function test_validate_prefix_escapes_the_submitted_values(): void
	{
		$manager = $this->new_manager();
		$this->db->queries = [];

		$manager->validate_prefix(['prefix' => "O'Brien", 'name' => 'plain']);

		$this->assertNotSame([], $this->db->queries);
		foreach ($this->db->queries as $query)
		{
			$this->assertStringNotContainsString("O'Brien", $query, 'the raw quote must not reach the SQL');
		}
		$this->assertStringContainsString("O''Brien", $this->db->queries[0]);
	}

	private function prefix_row($id, $name, $groups = '[1]', $forums = '[1]')
	{
		return [
			'id' => $id,
			'prefix' => '[b]' . $name . '[/b]',
			'name' => $name,
			'forums' => $forums,
			'groups' => $groups,
			'on_index' => 1,
			'bbcode_uid' => '',
			'bbcode_bitfield' => '',
		];
	}

	/**
	 * The constructor pulls in the whole phpBB container, so it is bypassed and
	 * only the collaborators these paths touch are supplied.
	 */
	private function new_manager(): manager
	{
		$reflection = new \ReflectionClass(manager::class);
		$manager = $reflection->newInstanceWithoutConstructor();

		$this->set_property($manager, 'db', $this->db);
		$this->set_property($manager, 'cache', $this->cache);
		$this->set_property($manager, 'user', new manager_test_user());
		$this->set_property($manager, 'request', new manager_test_request());

		$manager->load_prefixes();
		$manager->load_prefix_instances();

		return $manager;
	}

	private function set_property(object $object, string $name, $value): void
	{
		$property = new \ReflectionProperty(manager::class, $name);
		if (PHP_VERSION_ID < 80100)
		{
			$property->setAccessible(true);
		}
		$property->setValue($object, $value);
	}
}

class manager_test_user
{
	public array $lang = [
		'BBPREFIX_EMPTY_ERROR' => 'empty',
		'BBPREFIX_TITLE_ERROR' => 'title',
		'BBPREFIX_NAME_ERROR' => 'name',
	];
}

class manager_test_request
{
	public function variable($name, $default = '', $multibyte = false)
	{
		return $default;
	}
}
