<?php
/**
 * BBTags generic moderation tests.
 *
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace sitesplat\bbtags\tests;

use phpbb\db\driver\driver_interface;
use PHPUnit\Framework\TestCase;
use sitesplat\bbtags\provider\provider_interface;
use sitesplat\bbtags\provider\provider_registry;
use sitesplat\bbtags\tags\manager;
use sitesplat\bbtags\tags\moderation;

class moderation_test extends TestCase
{
	public function test_suggestion_is_invisible_catalogue_input_and_deduplicated_by_subject(): void
	{
		$db = $this->createMock(driver_interface::class);
		$manager = $this->createMock(manager::class);
		$manager->method('clean_tag')->willReturn('manhwa');
		$manager->method('canonical_tag')->willReturn('manhwa');
		$manager->method('get_existing_tags')->willReturn([]);
		$db->method('sql_escape')->willReturnArgument(0);
		$db->method('sql_query_limit')->willReturn('dedupe');
		$db->method('sql_fetchrow')->willReturn(false);
		$db->method('sql_build_array')->willReturn('INSERT_DATA');
		$queries = [];
		$db->method('sql_query')->willReturnCallback(static function (string $sql) use (&$queries)
		{
			$queries[] = $sql;
			return true;
		});
		$db->method('sql_nextid')->willReturn(17);

		$id = $this->create_moderation($db, $this->create_provider_registry(), $manager)->suggest('Manhwa', 'forum_topics', 12, 34, 56);

		$this->assertSame(17, $id);
		$this->assertCount(1, $queries);
		$this->assertStringContainsString('INSERT INTO phpbb_bbtags_suggestions', $queries[0]);
		$this->assertStringNotContainsString('INSERT INTO phpbb_bbtags ', $queries[0]);
	}

	public function test_approval_is_atomic_and_requires_provider_attachment(): void
	{
		$db = $this->createMock(driver_interface::class);
		$manager = $this->createMock(manager::class);
		$suggestion = [
			'suggestion_id' => 9,
			'tag' => 'manhwa',
			'provider' => 'forum_topics',
			'scope_id' => 12,
			'item_id' => 34,
			'suggested_by' => 56,
		];
		$db->method('sql_query_limit')->willReturn('pending');
		$db->method('sql_fetchrow')->willReturn($suggestion);
		$db->method('sql_build_array')->willReturn('UPDATE_DATA');
		$db->method('sql_query')->willReturn(true);
		$db->method('sql_affectedrows')->willReturn(1);
		$transactions = [];
		$db->method('sql_transaction')->willReturnCallback(static function (string $status) use (&$transactions)
		{
			$transactions[] = $status;
			return true;
		});
		$provider = $this->createMock(provider_interface::class);
		$provider->method('get_name')->willReturn(manager::FORUM_PROVIDER);
		$provider->method('validate_subject')->with(12, 34)->willReturn(true);
		$provider->expects($this->once())->method('apply_approved_tag')->with(12, 34, 7)->willReturn(true);
		$manager->expects($this->once())->method('ensure_catalog_tag')->with('manhwa', 56)->willReturn(7);
		$manager->expects($this->once())->method('ensure_provider_context')->with(7, 'forum_topics', 'restricted')->willReturn(true);
		$manager->expects($this->once())->method('set_scope_rule')->with(7, 'forum_topics', 12, 'allow')->willReturn(true);

		$this->assertTrue($this->create_moderation($db, new provider_registry([$provider]), $manager)->approve(9, 2));
		$this->assertSame(['begin', 'commit'], $transactions);
	}

	public function test_duplicate_pending_suggestion_reuses_the_existing_identifier(): void
	{
		$db = $this->createMock(driver_interface::class);
		$manager = $this->createMock(manager::class);
		$manager->method('clean_tag')->willReturn('manhwa');
		$manager->method('canonical_tag')->willReturn('manhwa');
		$db->method('sql_escape')->willReturnArgument(0);
		$db->method('sql_query_limit')->willReturn('dedupe');
		$db->method('sql_fetchrow')->willReturn(['suggestion_id' => 23]);
		$db->expects($this->never())->method('sql_query');

		$this->assertSame(23, $this->create_moderation($db, $this->create_provider_registry(), $manager)->suggest('manhwa', 'forum_topics', 12, 34, 56));
	}

	public function test_approval_rolls_back_when_provider_does_not_attach_the_tag(): void
	{
		$db = $this->createMock(driver_interface::class);
		$manager = $this->createMock(manager::class);
		$db->method('sql_query_limit')->willReturn('pending');
		$db->method('sql_fetchrow')->willReturn([
			'tag' => 'manhwa',
			'provider' => 'forum_topics',
			'scope_id' => 12,
			'item_id' => 34,
			'suggested_by' => 56,
		]);
		$transactions = [];
		$db->method('sql_transaction')->willReturnCallback(static function (string $status) use (&$transactions)
		{
			$transactions[] = $status;
			return true;
		});
		$manager->method('ensure_catalog_tag')->willReturn(7);
		$manager->method('ensure_provider_context')->willReturn(true);
		$manager->method('set_scope_rule')->willReturn(true);

		$this->assertFalse($this->create_moderation($db, $this->create_provider_registry(true, false), $manager)->approve(9, 2));
		$this->assertSame(['begin', 'rollback'], $transactions);
	}

	public function test_rejection_keeps_an_auditable_resolved_row(): void
	{
		$db = $this->createMock(driver_interface::class);
		$db->method('sql_query_limit')->willReturn('pending');
		$db->method('sql_fetchrow')->willReturn(['suggestion_id' => 9]);
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
		$db->method('sql_affectedrows')->willReturn(1);

		$moderation = $this->create_moderation(
			$db,
			new provider_registry([]),
			$this->createMock(manager::class)
		);
		$this->assertTrue($moderation->reject(9, 2));
		$this->assertStringContainsString('status,reviewed_by,reviewed_at,dedupe_key', $queries[0]);
		$this->assertStringContainsString('UPDATE phpbb_bbtags_suggestions', $queries[0]);
	}

	public function test_invalid_provider_never_reaches_storage(): void
	{
		$db = $this->createMock(driver_interface::class);
		$db->expects($this->never())->method('sql_query');
		$db->expects($this->never())->method('sql_query_limit');
		$manager = $this->createMock(manager::class);
		$manager->method('clean_tag')->willReturn('manhwa');
		$manager->method('canonical_tag')->willReturn('manhwa');

		$this->assertFalse($this->create_moderation(
			$db,
			new provider_registry([]),
			$manager
		)->suggest('manhwa', '../invalid', 12, 34, 56));
	}

	private function create_moderation(
		driver_interface $db,
		provider_registry $providers,
		manager $manager
	): moderation
	{
		return new moderation($db, $providers, $manager, 'phpbb_bbtags_suggestions');
	}

	private function create_provider_registry(bool $valid = true, bool $applied = true): provider_registry
	{
		$provider = $this->createMock(provider_interface::class);
		$provider->method('get_name')->willReturn(manager::FORUM_PROVIDER);
		$provider->method('validate_subject')->willReturn($valid);
		$provider->method('apply_approved_tag')->willReturn($applied);

		return new provider_registry([$provider]);
	}
}
