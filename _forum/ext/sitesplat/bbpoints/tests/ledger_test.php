<?php
/**
 * BBPoints ledger API tests.
 *
 * @package sitesplat/bbpoints
 * @copyright (c) 2015-2026 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace sitesplat\bbpoints\tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use sitesplat\bbpoints\core\ledger;
use sitesplat\bbpoints\exception\insufficient_funds;
use sitesplat\bbpoints\exception\invalid_operation;
use sitesplat\bbpoints\exception\operation_conflict;

final class ledger_test extends TestCase
{
	public function test_balance_aggregates_public_content_and_movements(): void
	{
		$db = new fake_db(
			[2, 3],
			[
				['poster_id' => 2, 'post_visibility' => ITEM_APPROVED, 'bbpoints' => 10],
				['poster_id' => 2, 'post_visibility' => 0, 'bbpoints' => 50],
			],
			[['topic_poster' => 2, 'bbpoints' => 20]],
			[
				['id' => 1, 'from_id' => 0, 'to_id' => 2, 'bbpoints' => 5, 'reason' => '', 'timestamp' => 1],
				['id' => 2, 'from_id' => 2, 'to_id' => 3, 'bbpoints' => 3, 'reason' => '', 'timestamp' => 2],
			]
		);

		$this->assertSame(32, $this->ledger($db)->get_balance(2));
		$this->assertSame(0, $this->ledger($db)->get_balance(ANONYMOUS));
		$this->assertSame(0, $this->ledger($db)->get_balance(0));
	}

	public function test_system_credit_is_retry_safe_and_announced_only_once(): void
	{
		$db = new fake_db([2]);
		$cache = new fake_cache();
		$dispatcher = new fake_dispatcher();
		$ledger = $this->ledger($db, $cache, $dispatcher);

		$created = $ledger->credit(2, 15, 'Gallery upload reward', 'gallery:upload:9');
		$replayed = $ledger->credit(2, 15, 'Translated reason may change', 'gallery:upload:9');

		$this->assertTrue($created->was_created());
		$this->assertFalse($replayed->was_created());
		$this->assertSame($created->get_id(), $replayed->get_id());
		$this->assertSame(15, $ledger->get_balance(2));
		$this->assertCount(1, $db->movements);
		$this->assertSame([['sql', ['points', 'point_operations']]], $cache->destroyed);
		$this->assertCount(1, $dispatcher->events);
		$this->assertSame('sitesplat.bbpoints.operation_recorded', $dispatcher->events[0][0]);
		$this->assertSame($created, $dispatcher->events[0][1]['operation']);
		$this->assertSame(['begin', 'commit'], $db->transactions);
		$this->assertFalse($this->contains_sql($db->statements, 'UPDATE users'), 'System credits do not lock an account.');
	}

	public function test_reusing_an_operation_key_for_different_financial_data_fails_closed(): void
	{
		$ledger = $this->ledger(new fake_db([2, 3]));
		$ledger->credit(2, 15, 'Reward', 'gallery:upload:9');

		$this->expectException(operation_conflict::class);
		$ledger->credit(2, 16, 'Different reward', 'gallery:upload:9');
	}

	public function test_transfer_serializes_the_payer_and_updates_both_balances(): void
	{
		$db = new fake_db(
			[2, 3],
			[['poster_id' => 2, 'post_visibility' => ITEM_APPROVED, 'bbpoints' => 40]],
			[['topic_poster' => 2, 'bbpoints' => 10]]
		);
		$cache = new fake_cache();
		$dispatcher = new fake_dispatcher();
		$ledger = $this->ledger($db, $cache, $dispatcher);

		$operation = $ledger->transfer(2, 3, 30, 'Gallery source purchase', 'gallery:source:8:buyer:2');

		$this->assertTrue($operation->was_created());
		$this->assertSame(20, $ledger->get_balance(2));
		$this->assertSame(30, $ledger->get_balance(3));
		$this->assertSame(['begin', 'commit'], $db->transactions);
		$this->assertTrue($this->contains_sql($db->statements, 'UPDATE users'));
		$this->assertCount(1, $cache->destroyed);
		$this->assertCount(1, $dispatcher->events);
	}

	public function test_system_debit_records_a_spend_without_crediting_another_user(): void
	{
		$db = new fake_db(
			[2],
			[['poster_id' => 2, 'post_visibility' => ITEM_APPROVED, 'bbpoints' => 20]]
		);
		$ledger = $this->ledger($db);

		$operation = $ledger->debit(2, 7, 'Gallery source access', 'gallery:source:11:buyer:2');

		$this->assertTrue($operation->was_created());
		$this->assertSame(2, $operation->get_from_user_id());
		$this->assertSame(ledger::SYSTEM_USER_ID, $operation->get_to_user_id());
		$this->assertSame(7, $operation->get_amount());
		$this->assertSame(13, $ledger->get_balance(2));
		$this->assertSame(['begin', 'commit'], $db->transactions);
	}

	public function test_distribution_is_atomic_canonical_retry_safe_and_announced_once(): void
	{
		$db = new fake_db(
			[2, 3, 4, 5],
			[['poster_id' => 2, 'post_visibility' => ITEM_APPROVED, 'bbpoints' => 100]]
		);
		$cache = new fake_cache();
		$dispatcher = new fake_dispatcher();
		$ledger = $this->ledger($db, $cache, $dispatcher);

		$created = $ledger->distribute(
			2,
			[5 => 3, 3 => 4, 4 => 3],
			'Gallery source purchase',
			'gallery:source:20:buyer:2'
		);
		$replayed = $ledger->distribute(
			2,
			[4 => 3, 5 => 3, 3 => 4],
			'A translated reason may change',
			'gallery:source:20:buyer:2'
		);

		$this->assertTrue($created->was_created());
		$this->assertFalse($replayed->was_created());
		$this->assertSame(10, $created->get_amount());
		$this->assertSame([3, 4, 5], array_map(
			static fn($operation): int => $operation->get_to_user_id(),
			$created->get_operations()
		));
		$this->assertSame(90, $ledger->get_balance(2));
		$this->assertSame(4, $ledger->get_balance(3));
		$this->assertSame(3, $ledger->get_balance(4));
		$this->assertSame(3, $ledger->get_balance(5));
		$this->assertCount(3, $db->movements);
		$this->assertCount(1, $db->distributions);
		$this->assertSame(['begin', 'commit'], $db->transactions);
		$this->assertCount(1, $cache->destroyed);
		$this->assertCount(4, $dispatcher->events);
		$this->assertSame('sitesplat.bbpoints.distribution_recorded', $dispatcher->events[3][0]);
		$this->assertSame($created, $dispatcher->events[3][1]['distribution']);
	}

	public function test_distribution_key_cannot_be_reused_for_different_shares(): void
	{
		$ledger = $this->ledger(new fake_db(
			[2, 3, 4],
			[['poster_id' => 2, 'post_visibility' => ITEM_APPROVED, 'bbpoints' => 100]]
		));
		$ledger->distribute(2, [3 => 6, 4 => 4], 'Purchase', 'gallery:source:21:buyer:2');

		$this->expectException(operation_conflict::class);
		$ledger->distribute(2, [3 => 5, 4 => 5], 'Purchase', 'gallery:source:21:buyer:2');
	}

	public function test_distribution_with_insufficient_funds_leaves_no_partial_records(): void
	{
		$db = new fake_db([2, 3, 4]);
		$ledger = $this->ledger($db);

		try
		{
			$ledger->distribute(2, [3 => 6, 4 => 4], 'Purchase', 'gallery:source:22:buyer:2');
			$this->fail('An account with no balance must not complete a distribution.');
		}
		catch (insufficient_funds $exception)
		{
			$this->assertSame(0, $exception->get_available());
			$this->assertSame(10, $exception->get_required());
		}

		$this->assertSame([], $db->movements);
		$this->assertSame([], $db->operations);
		$this->assertSame([], $db->distributions);
		$this->assertSame(['begin', 'rollback'], $db->transactions);
	}

	public function test_distribution_rolls_back_every_recipient_when_a_later_insert_fails(): void
	{
		$db = new fake_db(
			[2, 3, 4],
			[['poster_id' => 2, 'post_visibility' => ITEM_APPROVED, 'bbpoints' => 100]]
		);
		$db->fail_movement_insert_at = 2;
		$ledger = $this->ledger($db);

		$this->expectException(\RuntimeException::class);
		try
		{
			$ledger->distribute(2, [3 => 6, 4 => 4], 'Purchase', 'gallery:source:23:buyer:2');
		}
		finally
		{
			$this->assertSame([], $db->movements);
			$this->assertSame([], $db->operations);
			$this->assertSame([], $db->distributions);
			$this->assertSame(['begin', 'rollback'], $db->transactions);
		}
	}

	#[DataProvider('invalid_distributions')]
	public function test_invalid_distributions_are_rejected(array $recipients): void
	{
		$ledger = $this->ledger(new fake_db([2, 3]));

		$this->expectException(invalid_operation::class);
		$ledger->distribute(2, $recipients, 'Invalid', 'gallery:source:invalid');
	}

	public static function invalid_distributions(): array
	{
		return [
			'empty'             => [[]],
			'same as payer'     => [[2 => 5]],
			'anonymous'         => [[ANONYMOUS => 5]],
			'zero share'        => [[3 => 0]],
			'negative share'    => [[3 => -1]],
			'non integer share' => [[3 => '5']],
			'oversized share'   => [[3 => 2147483648]],
		];
	}

	public function test_insufficient_funds_roll_back_without_creating_a_movement(): void
	{
		$db = new fake_db([2, 3]);
		$ledger = $this->ledger($db);

		try
		{
			$ledger->transfer(2, 3, 10, 'Purchase', 'gallery:source:9:buyer:2');
			$this->fail('An account with no balance must not complete the transfer.');
		}
		catch (insufficient_funds $exception)
		{
			$this->assertSame(0, $exception->get_available());
			$this->assertSame(10, $exception->get_required());
		}

		$this->assertSame(['begin', 'rollback'], $db->transactions);
		$this->assertSame([], $db->movements);
	}

	public function test_explicit_administrative_transfer_can_allow_a_negative_balance(): void
	{
		$db = new fake_db([2, 3]);
		$ledger = $this->ledger($db);

		$ledger->transfer(2, 3, 10, 'Reassign historical reward', 'gallery:reward:9:reassign:3', true);

		$this->assertSame(-10, $ledger->get_balance(2));
		$this->assertSame(10, $ledger->get_balance(3));
		$this->assertSame(['begin', 'commit'], $db->transactions);
	}

	public function test_database_failure_rolls_back_and_does_not_emit_an_event(): void
	{
		$db = new fake_db(
			[2, 3],
			[['poster_id' => 2, 'post_visibility' => ITEM_APPROVED, 'bbpoints' => 50]]
		);
		$db->fail_next_insert = true;
		$cache = new fake_cache();
		$dispatcher = new fake_dispatcher();
		$ledger = $this->ledger($db, $cache, $dispatcher);

		$this->expectException(\RuntimeException::class);
		try
		{
			$ledger->debit(2, 10, 'Download', 'gallery:source:10:buyer:2');
		}
		finally
		{
			$this->assertSame(['begin', 'rollback'], $db->transactions);
			$this->assertSame([], $db->movements);
			$this->assertSame([], $cache->destroyed);
			$this->assertSame([], $dispatcher->events);
		}
	}

	#[DataProvider('invalid_movements')]
	public function test_invalid_movements_are_rejected(int $from_user_id, int $to_user_id,
		int $amount, string $operation_key): void
	{
		$ledger = $this->ledger(new fake_db([2, 3]));

		$this->expectException(invalid_operation::class);
		if ($from_user_id === ledger::SYSTEM_USER_ID)
		{
			$ledger->credit($to_user_id, $amount, 'Invalid', $operation_key);
			return;
		}
		$ledger->transfer($from_user_id, $to_user_id, $amount, 'Invalid', $operation_key);
	}

	public static function invalid_movements(): array
	{
		return [
			'zero amount'       => [0, 2, 0, 'valid:key'],
			'negative amount'   => [0, 2, -1, 'valid:key'],
			'oversized amount'  => [0, 2, 2147483648, 'valid:key'],
			'same account'      => [2, 2, 1, 'valid:key'],
			'anonymous payer'   => [ANONYMOUS, 2, 1, 'valid:key'],
			'anonymous target'  => [2, ANONYMOUS, 1, 'valid:key'],
			'invalid key'       => [0, 2, 1, 'invalid key'],
			'oversized key'     => [0, 2, 1, str_repeat('a', 192)],
		];
	}

	public function test_missing_registered_user_is_rejected(): void
	{
		$this->expectException(invalid_operation::class);
		$this->ledger(new fake_db([2]))->credit(99, 5, 'Reward', 'gallery:upload:99');
	}

	public function test_operation_lookup_exposes_persisted_result(): void
	{
		$ledger = $this->ledger(new fake_db([2]));
		$created = $ledger->credit(2, 5, 'Reward', 'gallery:upload:42');
		$loaded = $ledger->get_operation('gallery:upload:42');

		$this->assertNotNull($loaded);
		$this->assertSame($created->get_id(), $loaded->get_id());
		$this->assertSame('gallery:upload:42', $loaded->get_operation_key());
		$this->assertSame('Reward', $loaded->get_reason());
		$this->assertFalse($loaded->was_created());
		$this->assertTrue($ledger->has_operation('gallery:upload:42'));
		$this->assertFalse($ledger->has_operation('gallery:upload:404'));
	}

	private function ledger(fake_db $db, ?fake_cache $cache = null,
		?fake_dispatcher $dispatcher = null): ledger
	{
		return new ledger(
			$db,
			$cache ?? new fake_cache(),
			$dispatcher ?? new fake_dispatcher(),
			'points',
			'point_operations',
			'point_distributions',
			'users',
			'posts',
			'topics'
		);
	}

	private function contains_sql(array $statements, string $fragment): bool
	{
		foreach ($statements as $statement)
		{
			if (str_contains($statement, $fragment))
			{
				return true;
			}
		}
		return false;
	}
}
