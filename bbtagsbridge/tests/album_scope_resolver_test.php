<?php
// phpcs:disable PSR1.Files.SideEffects.FoundWithSymbols -- The focused database test double is loaded beside this test case.
/**
 * Gallery album scope resolver tests.
 *
 * @package   phpbbgallery/bbtagsbridge
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbtagsbridge\tests;

use phpbbgallery\bbtagsbridge\album_scope_resolver;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/fake_db.php';

final class album_scope_resolver_test extends TestCase
{
	public function test_path_contains_current_album_ancestors_and_provider_root(): void
	{
		$db = new fake_db();
		$db->albums = [30 => 20, 20 => 10, 10 => 0];

		$this->assertSame([30, 20, 10, 0], (new album_scope_resolver($db, 'albums'))->get_path(30));
	}

	public function test_missing_and_cyclic_album_trees_fail_closed(): void
	{
		$db = new fake_db();
		$db->albums = [30 => 20, 20 => 30];
		$resolver = new album_scope_resolver($db, 'albums');

		$this->assertSame([], $resolver->get_path(99));
		$this->assertSame([], $resolver->get_path(30));
		$this->assertSame([], $resolver->get_path(0));
	}

	public function test_all_paths_skip_broken_trees_and_preserve_nearest_ancestor_order(): void
	{
		$db = new fake_db();
		$db->albums = [1 => 0, 2 => 1, 3 => 2, 8 => 99, 9 => 9];

		$this->assertSame(
			[
				1 => [1, 0],
				2 => [2, 1, 0],
				3 => [3, 2, 1, 0],
			],
			(new album_scope_resolver($db, 'albums'))->get_all_paths()
		);
	}

	public function test_album_tree_preserves_nested_order_depth_and_skips_broken_rows(): void
	{
		$db = new fake_db();
		$db->album_rows = [
			['album_id' => 10, 'parent_id' => 0, 'album_name' => 'Root', 'left_id' => 1],
			['album_id' => 20, 'parent_id' => 10, 'album_name' => 'Child', 'left_id' => 2],
			['album_id' => 30, 'parent_id' => 20, 'album_name' => 'Grandchild', 'left_id' => 3],
			['album_id' => 40, 'parent_id' => 99, 'album_name' => 'Broken', 'left_id' => 4],
		];

		$this->assertSame(
			[
				['album_id' => 10, 'parent_id' => 0, 'album_name' => 'Root', 'depth' => 0],
				['album_id' => 20, 'parent_id' => 10, 'album_name' => 'Child', 'depth' => 1],
				['album_id' => 30, 'parent_id' => 20, 'album_name' => 'Grandchild', 'depth' => 2],
			],
			(new album_scope_resolver($db, 'albums'))->get_album_tree()
		);
		$this->assertStringContainsString('WHERE album_user_id = 0', $db->last_query);
	}
}
