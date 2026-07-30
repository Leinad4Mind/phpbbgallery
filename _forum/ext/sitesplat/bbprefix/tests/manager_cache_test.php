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
	private fake_log $log;

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		$this->db = new fake_db();
		$this->cache = new fake_cache();
		$this->log = new fake_log();

		// Matches the REGISTERED group used by the fixtures below, so prefixes
		// are allowed for the test user without a real group_memberships() call.
		$GLOBALS['bbprefix_test_group_memberships'] = [['group_id' => 1]];

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
		$this->db->tables[BBPREFIX_CATEGORIES_TABLE] = [];
	}

	public function test_a_complete_load_is_cached_without_a_shortened_lifetime(): void
	{
		$manager = $this->new_manager();

		$this->assertCount(4, $manager->get_prefixes());
		$this->assertArrayHasKey('_prefixes', $this->cache->writes);
		// Every write path already invalidates its own entry explicitly, so an
		// hourly TTL only added an unneeded database hit - it must not be passed.
		$this->assertSame(
			$this->cache::DEFAULT_TTL,
			$this->cache->writes['_prefixes']['ttl'],
			'put() must be called with phpBB\'s own default, not a shortened one'
		);
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

	public function test_a_short_read_logs_through_the_phpbb_logger(): void
	{
		$this->db->short_rows[BBPREFIX_TABLE] = 2;

		$this->new_manager();

		$this->assertCount(1, $this->log->calls);
		$call = $this->log->calls[0];
		$this->assertSame('critical', $call['mode']);
		$this->assertSame('LOG_BBPREFIX_INCOMPLETE', $call['log_operation']);
		$this->assertSame(['_prefixes', 2, 4], $call['additional_data']);
	}

	public function test_a_repeated_anomaly_in_the_same_request_is_logged_once(): void
	{
		$this->db->short_rows[BBPREFIX_TABLE] = 2;

		$manager = $this->new_manager();
		// Force the same short read again, still within the same request.
		$manager->load_prefixes(true);

		$this->assertCount(1, $this->log->calls, 'a persistent anomaly must not log on every tick');
	}

	public function test_a_throwing_logger_does_not_break_prefix_loading(): void
	{
		$this->db->short_rows[BBPREFIX_TABLE] = 2;
		$this->log->throw_on_add = new \RuntimeException('logger unavailable');

		$prefixes = $this->new_manager()->get_prefixes();

		$this->assertCount(2, $prefixes, 'a broken logger must not prevent serving the short read');
	}

	public function test_no_stray_log_file_is_ever_created(): void
	{
		// This is the concrete bug being fixed: log() used to write to a
		// relative 'file.log', which lands in the web root on a real forum.
		$this->db->short_rows[BBPREFIX_TABLE] = 2;

		$this->new_manager();

		$this->assertFileDoesNotExist(getcwd() . DIRECTORY_SEPARATOR . 'file.log');
	}

	public function test_add_topic_prefix_still_reloads_when_called_standalone(): void
	{
		$manager = $this->new_manager();
		$this->db->queries = [];

		$manager->add_topic_prefix(502, 1, 0);

		$this->assertCount(1, $this->reload_queries(), 'a standalone call keeps reloading, same as before');
	}

	public function test_add_topic_prefix_keeps_the_in_memory_guard_correct_without_reloading(): void
	{
		$manager = $this->new_manager();
		$this->db->queries = [];

		$manager->add_topic_prefix(500, 1, 0, 0, false);
		$manager->add_topic_prefix(500, 2, 0, 0, false);
		$manager->add_topic_prefix(500, 3, 0, 0, false);

		$this->assertSame(3, $manager->count_topic_prefixes(500), 'the in-memory list must reflect all three additions');
		$this->assertCount(0, $this->reload_queries(), 'reload=false must not touch the database for this');
	}

	public function test_add_topic_prefix_in_memory_guard_stops_at_the_allowed_maximum(): void
	{
		$manager = $this->new_manager();

		// All four fixture prefixes belong to group 1, so all four are allowed.
		$manager->add_topic_prefix(501, 1, 0, 0, false);
		$manager->add_topic_prefix(501, 2, 0, 0, false);
		$manager->add_topic_prefix(501, 3, 0, 0, false);
		$manager->add_topic_prefix(501, 4, 0, 0, false);
		$this->assertSame(4, $manager->count_topic_prefixes(501));

		$this->db->queries = [];
		// If the in-memory list had gone stale mid-batch, this guard would
		// under-count and let a fifth prefix through.
		$manager->add_topic_prefix(501, 1, 0, 0, false);

		$this->assertSame(4, $manager->count_topic_prefixes(501), 'the topic is already at its allowed maximum');
		$this->assertSame([], $this->db->queries, 'a refused add must not touch the database at all');
	}

	public function test_remove_topic_prefixes_without_reload_updates_the_in_memory_list(): void
	{
		$manager = $this->new_manager();
		$this->db->queries = [];

		$manager->remove_topic_prefixes(10, 1, false);

		$this->assertCount(0, $this->reload_queries(), 'reload=false must not touch the database');

		$instances = $manager->get_prefix_instances();
		$this->assertArrayNotHasKey(1, $instances, 'instance 1 (topic 10, prefix 1) must be gone');
		$this->assertArrayHasKey(2, $instances, 'instance 2 (topic 11) must be untouched');
	}

	public function test_index_visibility_ignores_an_instance_of_a_deleted_prefix(): void
	{
		$this->db->tables[BBPREFIX_INSTANCES_TABLE][] = [
			'id' => 3,
			'prefix' => 12,
			'topic' => 10,
			'ordered' => 1,
			'token_data' => '',
		];

		$manager = $this->new_manager();

		$this->assertTrue($manager->get_on_index_enabled(['row' => ['topic_id' => 10]]));
	}

	public function test_index_visibility_handles_rows_without_a_last_post_topic(): void
	{
		$manager = $this->new_manager();

		$this->assertTrue($manager->get_on_index_enabled(['row' => ['forum_last_post_id' => 0]]));
	}

	public function test_index_visibility_uses_valid_prefix_rules(): void
	{
		$this->db->tables[BBPREFIX_TABLE][0]['on_index'] = 0;
		$manager = $this->new_manager();

		$this->assertFalse($manager->get_on_index_enabled(['row' => ['topic_id' => 10]]));
	}

	public function test_set_topic_prefixes_issues_a_single_reload_when_adding_several_prefixes(): void
	{
		$manager = $this->new_manager();
		$this->db->queries = [];

		$manager->set_topic_prefixes(503, [1, 2, 3], 0);

		$this->assertCount(1, $this->reload_queries(), 'adding three prefixes must trigger one reload, not one per prefix');

		$inserts = array_filter($this->db->queries, static function ($query) {
			return strpos($query, 'INSERT INTO ' . BBPREFIX_INSTANCES_TABLE) !== false;
		});
		$this->assertCount(3, $inserts, 'all three prefixes are still individually inserted');
	}

	public function test_reorder_prefixes_resequences_weight_in_submitted_order(): void
	{
		$manager = $this->new_manager();
		$this->db->queries = [];

		$manager->reorder_prefixes([3, 1, 4]);

		$this->assertStringContainsString('SET weight = 1 WHERE id = 3', $this->db->queries[0]);
		$this->assertStringContainsString('SET weight = 2 WHERE id = 1', $this->db->queries[1]);
		$this->assertStringContainsString('SET weight = 3 WHERE id = 4', $this->db->queries[2]);
	}

	public function test_group_prefix_ids_by_category_ors_within_and_ands_across(): void
	{
		$this->db->tables[BBPREFIX_TABLE] = [
			$this->prefix_row(1, 'Alpha', '[1]', '[1]', 1), // Resolution
			$this->prefix_row(2, 'Beta', '[1]', '[1]', 1),  // Resolution
			$this->prefix_row(3, 'Gamma', '[1]', '[1]', 2), // Source
			$this->prefix_row(4, 'Delta', '[1]', '[1]', 0), // no category
		];
		$manager = $this->new_manager();

		$groups = $manager->group_prefix_ids_by_category([1, 2, 3, 4]);

		$this->assertContains([1, 2], $groups, 'same-category prefixes share one OR group');
		$this->assertContains([3], $groups);
		$this->assertContains([4], $groups, 'an uncategorised prefix is its own singleton group');
		$this->assertCount(3, $groups);
	}

	public function test_build_prefix_filter_exists_clause_ors_within_and_ands_across_categories(): void
	{
		$this->db->tables[BBPREFIX_TABLE] = [
			$this->prefix_row(1, 'Alpha', '[1]', '[1]', 1),
			$this->prefix_row(2, 'Beta', '[1]', '[1]', 1),
			$this->prefix_row(3, 'Gamma', '[1]', '[1]', 2),
		];
		$manager = $this->new_manager();

		$clause = $manager->build_prefix_filter_exists_clause([1, 2, 3]);

		$this->assertSame(2, substr_count($clause, 'EXISTS'), 'one EXISTS per category group');
		$this->assertStringContainsString('pr.prefix IN (1,2)', $clause);
		$this->assertStringContainsString('pr.prefix IN (3)', $clause);
		$this->assertStringContainsString(' AND ', $clause, 'different category groups are ANDed');
	}

	public function test_get_active_prefix_ids_is_empty_when_nothing_is_active(): void
	{
		$manager = $this->new_manager();

		$this->assertSame([], $manager->get_active_prefix_ids());
	}

	public function test_get_active_prefix_ids_honours_a_legacy_scalar_link(): void
	{
		// Simulates an old bookmarked ?prefix=16 link (no brackets).
		$request = new fake_request();
		$request->raw['prefix'] = '16';

		$manager = $this->new_manager($request);

		$this->assertSame([16], $manager->get_active_prefix_ids());
	}

	public function test_get_active_prefix_ids_reads_the_new_bracket_form(): void
	{
		$request = new fake_request();
		$request->raw['prefix'] = ['16', '17'];

		$manager = $this->new_manager($request);

		$this->assertSame([16, 17], $manager->get_active_prefix_ids());
	}

	public function test_build_viewforum_url_appends_prefixes_in_order(): void
	{
		$manager = $this->new_manager();

		$url = $manager->build_viewforum_url(5, [16, 17]);

		$this->assertStringContainsString('f=5', $url);
		$this->assertStringContainsString('prefix[]=16', $url);
		$this->assertStringContainsString('prefix[]=17', $url);
		$this->assertLessThan(strpos($url, 'prefix[]=17'), strpos($url, 'prefix[]=16'), 'prefixes must appear in the order given');
	}

	public function test_get_allowed_prefixes_exclude_mode_disallows_listed_forums(): void
	{
		$this->db->tables[BBPREFIX_TABLE] = [
			$this->prefix_row(1, 'Alpha', '[1]', '[5]', 0, 0, 1),
		];
		$manager = $this->new_manager();

		$this->assertSame([1], $manager->get_allowed_prefixes(2, 9), 'forum 9 is not in the exclude list, so it is allowed');
		$this->assertSame([], $manager->get_allowed_prefixes(2, 5), 'forum 5 is in the exclude list, so it is disallowed');
	}

	public function test_get_allowed_prefixes_include_mode_allows_only_listed_forums(): void
	{
		$this->db->tables[BBPREFIX_TABLE] = [
			$this->prefix_row(1, 'Alpha', '[1]', '[5]', 0, 0, 0),
		];
		$manager = $this->new_manager();

		$this->assertSame([1], $manager->get_allowed_prefixes(2, 5), 'forum 5 is in the include list, so it is allowed');
		$this->assertSame([], $manager->get_allowed_prefixes(2, 9), 'forum 9 is not in the include list, so it is disallowed');
	}

	public function test_validate_prefix_refuses_an_oversized_forums_list(): void
	{
		$manager = $this->new_manager();

		$error = $manager->validate_prefix([
			'prefix' => 'x',
			'name' => 'y',
			'forums' => json_encode(range(1, 200)),
			'forums_exclude' => 1,
		]);

		$this->assertNotSame([], $error, 'an oversized list must be refused before it ever reaches the database');
	}

	/**
	 * @return array Queries matching the full prefix-instances reload, so a
	 *				test can count reloads regardless of how many INSERT/
	 *				UPDATE/COUNT queries happen alongside them.
	 */
	private function reload_queries(): array
	{
		return array_filter($this->db->queries, static function ($query) {
			return strpos($query, 'SELECT id, prefix, topic, ordered, token_data FROM') !== false;
		});
	}

	private function prefix_row($id, $name, $groups = '[1]', $forums = '[1]', $category_id = 0, $is_suffix = 0, $forums_exclude = 1)
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
			'weight' => $id,
			'category_id' => $category_id,
			'is_suffix' => $is_suffix,
			'forums_exclude' => $forums_exclude,
		];
	}

	/**
	 * The constructor pulls in the whole phpBB container, so it is bypassed and
	 * only the collaborators these paths touch are supplied.
	 *
	 * @param object|null $request Defaults to a double that just echoes back
	 *				whatever default it is given; pass a fake_request when a
	 *				test needs to control what the "user" actually submitted.
	 */
	private function new_manager($request = null): manager
	{
		$reflection = new \ReflectionClass(manager::class);
		$manager = $reflection->newInstanceWithoutConstructor();

		$this->set_property($manager, 'db', $this->db);
		$this->set_property($manager, 'cache', $this->cache);
		$this->set_property($manager, 'log', $this->log);
		$this->set_property($manager, 'user', new manager_test_user());
		$this->set_property($manager, 'request', $request ?? new manager_test_request());
		// calculateTokenDataForInstance() iterates this when an add_topic_prefix()
		// call actually inserts; no token types are needed for these tests.
		$this->set_property($manager, 'tokens', []);

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
		'BBPREFIX_FORUMS_TOO_LONG' => 'forums list too long, try %s instead',
		'BBPREFIX_FORUMS_MODE_INCLUDE' => 'include mode',
		'BBPREFIX_FORUMS_MODE_EXCLUDE' => 'exclude mode',
	];

	public array $data = ['user_id' => 2];

	public string $ip = '127.0.0.1';
}

class manager_test_request
{
	public function variable($name, $default = '', $multibyte = false)
	{
		return $default;
	}
}
