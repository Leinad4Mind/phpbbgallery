<?php
// phpcs:disable PSR1.Files.SideEffects.FoundWithSymbols -- The focused database test double is loaded beside this test case.
/**
 * phpBB Gallery - Favorite tests
 *
 * @package   phpbbgallery/favorite
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\favorite\tests;

use PHPUnit\Framework\TestCase;
use phpbbgallery\favorite\favorite;

require_once __DIR__ . '/fake_db.php';

/**
 * image_favorited must always follow the rows that were really written.
 */
final class counter_test extends TestCase
{
	private function make(array $already_favorited = [], ?array $existing_images = null): array
	{
		$db = new fake_db($already_favorited, $existing_images);

		return [new favorite($db, 'favorites', 'images'), $db];
	}

	public function test_adding_an_image_inserts_it_and_raises_the_counter(): void
	{
		[$favorite, $db] = $this->make();

		$this->assertSame(1, $favorite->add(42, 7));
		$this->assertSame([['user_id' => 7, 'image_id' => 42]], $db->inserted);
		$this->assertCount(1, $db->matching('image_favorited = image_favorited + 1'));
	}

	public function test_favouriting_twice_does_not_double_count(): void
	{
		[$favorite, $db] = $this->make([42]);

		$this->assertSame(0, $favorite->add(42, 7));
		$this->assertSame([], $db->inserted);
		$this->assertSame([], $db->matching('image_favorited = image_favorited + 1'));
	}

	public function test_only_the_new_images_are_counted(): void
	{
		[$favorite, $db] = $this->make([42]);

		$this->assertSame(1, $favorite->add([42, 43], 7));
		$this->assertSame([['user_id' => 7, 'image_id' => 43]], $db->inserted);

		$increment = $db->matching('image_favorited = image_favorited + 1');
		$this->assertCount(1, $increment);
		$this->assertStringContainsString('image_id IN (43)', $increment[0]);
	}

	public function test_album_page_favourite_state_is_loaded_in_one_query(): void
	{
		[$favorite, $db] = $this->make([42, 44]);

		$this->assertSame([42, 44], $favorite->get_favorited_ids([42, 43, 44], 7));
		$selects = $db->matching('SELECT image_id');
		$this->assertCount(1, $selects);
		$this->assertStringContainsString('image_id IN (42,43,44)', $selects[0]);
	}

	public function test_image_deleted_while_being_favourited_leaves_no_relation(): void
	{
		[$favorite, $db] = $this->make([], []);

		$this->assertSame(0, $favorite->add(42, 7));
		$deletes = $db->matching('DELETE FROM favorites');
		$this->assertCount(1, $deletes);
		$this->assertStringContainsString('user_id = 7', $deletes[0]);
		$this->assertStringContainsString('image_id IN (42)', $deletes[0]);
	}

	public function test_removing_a_favourite_deletes_it_and_lowers_the_counter(): void
	{
		[$favorite, $db] = $this->make([42]);

		$this->assertSame(1, $favorite->remove(42, 7));
		$this->assertCount(1, $db->matching('DELETE FROM favorites'));
		$this->assertCount(1, $db->matching('image_favorited = image_favorited - 1'));
	}

	public function test_removing_something_never_favourited_touches_nothing(): void
	{
		// The original implementation decremented unconditionally here, which
		// drove the unsigned counter below zero.
		[$favorite, $db] = $this->make();

		$this->assertSame(0, $favorite->remove(42, 7));
		$this->assertSame([], $db->matching('DELETE FROM favorites'));
		$this->assertSame([], $db->matching('image_favorited = image_favorited - 1'));
	}

	public function test_the_decrement_is_guarded_against_underflow(): void
	{
		[$favorite, $db] = $this->make([42]);
		$favorite->remove(42, 7);

		$this->assertStringContainsString(
			'image_favorited > 0',
			$db->matching('image_favorited = image_favorited - 1')[0]
		);
	}

	public function test_writes_are_wrapped_in_a_transaction(): void
	{
		[$favorite, $db] = $this->make();
		$favorite->add(42, 7);
		$this->assertSame(['begin', 'commit'], $db->transactions);

		[$favorite, $db] = $this->make([42]);
		$favorite->remove(42, 7);
		$this->assertSame(['begin', 'commit'], $db->transactions);
	}

	public function test_ids_are_normalised(): void
	{
		[$favorite, $db] = $this->make();

		// Duplicates, zero and negatives must never reach the database.
		$this->assertSame(2, $favorite->add([42, 42, 0, -1, 43], 7));
		$this->assertSame(
			[['user_id' => 7, 'image_id' => 42], ['user_id' => 7, 'image_id' => 43]],
			$db->inserted
		);
	}

	public function test_guests_and_empty_input_are_rejected(): void
	{
		[$favorite, $db] = $this->make();

		$this->assertSame(0, $favorite->add(42, 0));
		$this->assertSame(0, $favorite->remove(42, 0));
		$this->assertSame(0, $favorite->add([], 7));
		$this->assertSame([], $db->statements);
	}

	public function test_deleting_images_drops_favourites_for_everyone(): void
	{
		[$favorite, $db] = $this->make();
		$favorite->delete_images([42, 43]);

		$deletes = $db->matching('DELETE FROM favorites');
		$this->assertCount(1, $deletes);
		$this->assertStringContainsString('image_id IN (42,43)', $deletes[0]);
		$this->assertStringNotContainsString('user_id', $deletes[0]);
	}

	public function test_deleting_a_member_corrects_the_counters(): void
	{
		[$favorite, $db] = $this->make([42, 43]);
		$favorite->delete_users(7);

		$this->assertCount(1, $db->matching('DELETE FROM favorites'));
		$this->assertCount(2, $db->matching('image_favorited = image_favorited - 1'));
	}

	public function test_reactivation_removes_favourites_for_missing_images(): void
	{
		[$favorite, $db] = $this->make();
		$db->orphan_image_ids = [42, 43];

		$this->assertSame(2, $favorite->reconcile_orphans());
		$this->assertSame([], $db->orphan_image_ids);
		$this->assertCount(2, $db->matching('LEFT JOIN images'));
	}
}
