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
}
