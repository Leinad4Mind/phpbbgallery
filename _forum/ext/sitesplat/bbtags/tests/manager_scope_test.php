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

	public function test_classification_keeps_explicit_denials_out_of_moderation(): void
	{
		$db = $this->createMock(driver_interface::class);
		$db->method('sql_escape')->willReturnArgument(0);
		$db->method('sql_in_set')->willReturnCallback(static function (string $field, array $values): string
		{
			return $field . ' IN (' . implode(',', $values) . ')';
		});
		$db->method('sql_query')->willReturnArgument(0);
		$catalogue = [
			['id' => 1, 'tag' => 'allowed', 'tag_clean' => 'allowed'],
			['id' => 2, 'tag' => 'denied', 'tag_clean' => 'denied'],
			['id' => 3, 'tag' => 'restricted', 'tag_clean' => 'restricted'],
			['id' => 4, 'tag' => 'disabled', 'tag_clean' => 'disabled'],
		];
		$contexts = [
			['tag_id' => 1, 'scope_mode' => 'global', 'is_enabled' => 1],
			['tag_id' => 2, 'scope_mode' => 'global', 'is_enabled' => 1],
			['tag_id' => 3, 'scope_mode' => 'restricted', 'is_enabled' => 1],
			['tag_id' => 4, 'scope_mode' => 'global', 'is_enabled' => 0],
		];
		$rules = [['tag_id' => 2, 'scope_id' => 30, 'scope_rule' => 'deny']];
		$db->method('sql_fetchrow')->willReturnCallback(static function (string $result) use (&$catalogue, &$contexts, &$rules)
		{
			if (strpos($result, 'FROM phpbb_bbtags_context') !== false)
			{
				return array_shift($contexts) ?: false;
			}
			if (strpos($result, 'FROM phpbb_bbtags_scope') !== false)
			{
				return array_shift($rules) ?: false;
			}

			return array_shift($catalogue) ?: false;
		});

		$this->assertSame(
			[
				'available' => ['allowed'],
				'suggestible' => ['restricted', 'new tag'],
				'blocked' => ['denied', 'disabled'],
			],
			$this->create_manager($db)->classify_tags(
				['allowed', 'denied', 'restricted', 'disabled', 'new tag'],
				manager::FORUM_PROVIDER,
				[30, 20, 0]
			)
		);
	}

	public function test_topic_subject_must_belong_to_the_declared_forum_scope(): void
	{
		$db = $this->createMock(driver_interface::class);
		$db->method('sql_query_limit')->willReturn('topic');
		$rows = [['forum_id' => 20], ['forum_id' => 20]];
		$db->method('sql_fetchrow')->willReturnCallback(static function () use (&$rows)
		{
			return array_shift($rows);
		});
		$manager = $this->create_manager($db);

		$this->assertTrue($manager->topic_matches_scope(10, 20));
		$this->assertFalse($manager->topic_matches_scope(10, 30));
	}

	public function test_provider_discovery_uses_effective_paths_instead_of_forum_specific_state(): void
	{
		$db = $this->createMock(driver_interface::class);
		$db->method('sql_escape')->willReturnArgument(0);
		$db->method('sql_in_set')->willReturnCallback(static function (string $field, array $values): string
		{
			return $field . ' IN (' . implode(',', $values) . ')';
		});
		$db->method('sql_query')->willReturnArgument(0);
		$catalogue = [
			['id' => 1, 'tag' => 'anime'],
			['id' => 2, 'tag' => 'manga'],
		];
		$contexts = [
			['tag_id' => 1, 'scope_mode' => 'global', 'is_enabled' => 1],
			['tag_id' => 2, 'scope_mode' => 'restricted', 'is_enabled' => 1],
		];
		$rules = [['tag_id' => 2, 'scope_id' => 20, 'scope_rule' => 'allow']];
		$db->method('sql_fetchrow')->willReturnCallback(static function (string $result) use (&$catalogue, &$contexts, &$rules)
		{
			if (strpos($result, 'FROM phpbb_bbtags t') !== false)
			{
				return array_shift($catalogue) ?: false;
			}
			if (strpos($result, 'FROM phpbb_bbtags_context') !== false)
			{
				return array_shift($contexts) ?: false;
			}
			if (strpos($result, 'FROM phpbb_bbtags_scope') !== false)
			{
				return array_shift($rules) ?: false;
			}

			return false;
		});

		$this->assertSame(
			['anime', 'manga'],
			$this->create_manager($db)->get_provider_tags(
				'',
				20,
				'gallery_images',
				[30 => [30, 20, 0], 40 => [40, 0]]
			)
		);
	}

	public function test_approval_reenables_an_existing_provider_context(): void
	{
		$db = $this->createMock(driver_interface::class);
		$db->method('sql_escape')->willReturnArgument(0);
		$db->method('sql_query_limit')->willReturn('context');
		$db->method('sql_fetchrow')->willReturn(['tag_id' => 7, 'is_enabled' => 0]);
		$db->method('sql_build_array')->willReturnCallback(static function (string $type, array $values): string
		{
			return $type . ':' . implode(',', array_keys($values));
		});
		$queries = [];
		$db->method('sql_query')->willReturnCallback(static function (string $sql) use (&$queries)
		{
			$queries[] = $sql;
			return true;
		});

		$this->assertTrue($this->create_manager($db)->ensure_provider_context(7, manager::FORUM_PROVIDER, 'restricted'));
		$this->assertStringContainsString('UPDATE phpbb_bbtags_context', $queries[0]);
		$this->assertStringContainsString('UPDATE:is_enabled,scope_mode', $queries[0]);
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

	public function test_provider_policy_catalogue_includes_tags_without_a_context(): void
	{
		$db = $this->createMock(driver_interface::class);
		$db->method('sql_escape')->willReturnArgument(0);
		$db->method('sql_query')->willReturnArgument(0);
		$rows = [
			['id' => 1, 'tag' => 'Anime', 'tag_clean' => 'anime', 'is_enabled' => 1, 'scope_mode' => 'global'],
			['id' => 2, 'tag' => 'Manga', 'tag_clean' => 'manga', 'is_enabled' => null, 'scope_mode' => null],
		];
		$db->method('sql_fetchrow')->willReturnCallback(static function () use (&$rows)
		{
			return array_shift($rows) ?: false;
		});

		$this->assertSame(
			[
				['id' => 1, 'tag' => 'Anime', 'tag_clean' => 'anime', 'is_enabled' => 1, 'scope_mode' => 'global'],
				['id' => 2, 'tag' => 'Manga', 'tag_clean' => 'manga', 'is_enabled' => 0, 'scope_mode' => 'restricted'],
			],
			$this->create_manager($db)->get_provider_policies('gallery_images')
		);
	}

	public function test_provider_policy_rules_return_only_explicit_allow_and_deny_values(): void
	{
		$db = $this->createMock(driver_interface::class);
		$db->method('sql_escape')->willReturnArgument(0);
		$db->method('sql_query')->willReturnArgument(0);
		$rows = [
			['scope_id' => 10, 'scope_rule' => 'allow'],
			['scope_id' => 20, 'scope_rule' => 'deny'],
			['scope_id' => 30, 'scope_rule' => 'invalid'],
		];
		$db->method('sql_fetchrow')->willReturnCallback(static function () use (&$rows)
		{
			return array_shift($rows) ?: false;
		});

		$this->assertSame(
			[10 => 'allow', 20 => 'deny'],
			$this->create_manager($db)->get_scope_rules(7, 'gallery_images')
		);
	}

	public function test_provider_policy_is_saved_atomically_with_only_explicit_rules(): void
	{
		$db = $this->createMock(driver_interface::class);
		$db->method('sql_escape')->willReturnArgument(0);
		$db->method('sql_query_limit')->willReturnArgument(0);
		$db->method('sql_fetchrow')->willReturnCallback(static function (string $result)
		{
			if (strpos($result, 'FROM phpbb_bbtags WHERE id = 7') !== false)
			{
				return ['id' => 7];
			}

			return false;
		});
		$db->method('sql_build_array')->willReturnCallback(static function (string $type, array $values): string
		{
			return $type . ':' . implode(',', array_keys($values));
		});
		$queries = [];
		$db->method('sql_query')->willReturnCallback(static function (string $sql) use (&$queries)
		{
			$queries[] = $sql;
			return true;
		});
		$transactions = [];
		$db->method('sql_transaction')->willReturnCallback(static function (string $status) use (&$transactions): bool
		{
			$transactions[] = $status;
			return true;
		});
		$inserted = [];
		$db->method('sql_multi_insert')->willReturnCallback(static function (string $table, array $rows) use (&$inserted): bool
		{
			$inserted = $rows;
			return true;
		});

		$this->assertTrue($this->create_manager($db)->save_provider_policy(
			7,
			'gallery_images',
			true,
			'restricted',
			[10 => 'allow', 20 => 'inherit', 30 => 'deny']
		));
		$this->assertSame(['begin', 'commit'], $transactions);
		$this->assertStringContainsString('INSERT INTO phpbb_bbtags_context', $queries[0]);
		$this->assertStringContainsString('DELETE FROM phpbb_bbtags_scope', $queries[1]);
		$this->assertSame(
			[
				['tag_id' => 7, 'provider' => 'gallery_images', 'scope_id' => 10, 'scope_rule' => 'allow'],
				['tag_id' => 7, 'provider' => 'gallery_images', 'scope_id' => 30, 'scope_rule' => 'deny'],
			],
			$inserted
		);
	}

	public function test_provider_policy_rejects_invalid_rules_before_writing(): void
	{
		$db = $this->createMock(driver_interface::class);
		$db->expects($this->never())->method('sql_transaction');

		$this->assertFalse($this->create_manager($db)->save_provider_policy(
			7,
			'gallery_images',
			true,
			'global',
			[10 => 'moderate']
		));
	}

	public function test_allowed_forums_are_resolved_independently_for_each_tag()
	{
		$db = $this->createMock(driver_interface::class);
		$db->method('sql_in_set')->willReturnCallback(static function ($field, array $values)
		{
			return $field . ' IN (' . implode(',', $values) . ')';
		});
		$db->method('sql_escape')->willReturnArgument(0);
		$db->method('sql_query')->willReturnCallback(static function ($sql)
		{
			return $sql;
		});
		$contexts = array(
			array('tag_id' => 1, 'scope_mode' => 'global', 'is_enabled' => 1),
			array('tag_id' => 2, 'scope_mode' => 'restricted', 'is_enabled' => 1),
		);
		$forums = array(
			array('forum_id' => 10, 'forum_left' => 1, 'forum_right' => 10),
			array('forum_id' => 20, 'forum_left' => 2, 'forum_right' => 5),
			array('forum_id' => 30, 'forum_left' => 3, 'forum_right' => 4),
			array('forum_id' => 40, 'forum_left' => 6, 'forum_right' => 9),
		);
		$rules = array(array('tag_id' => 2, 'scope_id' => 20, 'scope_rule' => 'allow'));
		$db->method('sql_fetchrow')->willReturnCallback(static function ($result) use (&$contexts, &$forums, &$rules)
		{
			if (strpos($result, 'FROM phpbb_bbtags_context') !== false)
			{
				return array_shift($contexts) ?: false;
			}
			if (strpos($result, 'SELECT forum_id, forum_left') !== false)
			{
				return array_shift($forums) ?: false;
			}
			return array_shift($rules) ?: false;
		});

		$allowed = $this->create_manager($db)->get_allowed_forum_ids_by_tag(array(1, 2));
		$this->assertSame(array(0, 10, 20, 30, 40), $allowed[1]);
		$this->assertSame(array(20, 30), $allowed[2]);
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
