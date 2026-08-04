<?php
/**
 * Image revision album policy tests.
 *
 * @package   phpbbgallery/imagerevisions
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\imagerevisions\tests;

use phpbb\config\config;
use phpbbgallery\imagerevisions\policy;
use PHPUnit\Framework\TestCase;

final class policy_test extends TestCase
{
	public function test_nearest_album_values_override_independently(): void
	{
		$db = new fake_db();
		$db->rows = [
			['enabled' => -1, 'revision_limit' => 12],
			['enabled' => 0, 'revision_limit' => -1],
			['enabled' => 1, 'revision_limit' => 3],
		];
		$resolver = $this->resolver($db, 1, 5);

		$this->assertSame(['enabled' => 0, 'revision_limit' => 12], $resolver->resolve(30));
		$this->assertStringContainsString('ORDER BY ancestor.left_id DESC', $db->last_query);
		$this->assertStringContainsString('ancestor.album_user_id = current_album.album_user_id', $db->last_query);
	}

	public function test_global_values_are_used_when_every_album_rule_inherits(): void
	{
		$db = new fake_db();
		$db->rows = [
			['enabled' => -1, 'revision_limit' => -1],
			['enabled' => null, 'revision_limit' => null],
		];

		$this->assertSame(
			['enabled' => 1, 'revision_limit' => 9],
			$this->resolver($db, 1, 9)->resolve(9)
		);
	}

	public function test_invalid_or_missing_albums_fail_closed(): void
	{
		$resolver = $this->resolver(new fake_db(), 1, 5);
		foreach ([0, 99] as $album_id)
		{
			try
			{
				$resolver->resolve($album_id);
				$this->fail('An invalid album must not resolve a revision policy.');
			}
			catch (\OutOfBoundsException)
			{
				$this->addToAssertionCount(1);
			}
		}
	}

	public function test_policy_values_are_normalized(): void
	{
		$this->assertSame(policy::INHERIT, policy::normalize_toggle_override(-2));
		$this->assertSame(policy::INHERIT, policy::normalize_toggle_override(-1));
		$this->assertSame(0, policy::normalize_toggle_override(0));
		$this->assertSame(1, policy::normalize_toggle_override(1));
		$this->assertSame(policy::INHERIT, policy::normalize_toggle_override(2));
		$this->assertSame(policy::INHERIT, policy::normalize_limit_override(0));
		$this->assertSame(policy::INHERIT, policy::normalize_limit_override(-1));
		$this->assertSame(1, policy::normalize_limit_override(1));
		$this->assertSame(50, policy::normalize_limit_override(100));
	}

	public function test_album_overview_follows_the_public_tree_and_effective_values(): void
	{
		$db = new fake_db();
		$db->rows = [
			['album_id' => 1, 'parent_id' => 0, 'album_name' => 'Root', 'left_id' => 1, 'right_id' => 6,
				'enabled' => null, 'revision_limit' => null],
			['album_id' => 2, 'parent_id' => 1, 'album_name' => 'Child', 'left_id' => 2, 'right_id' => 3,
				'enabled' => 0, 'revision_limit' => 8],
			['album_id' => 3, 'parent_id' => 1, 'album_name' => 'Sibling', 'left_id' => 4, 'right_id' => 5,
				'enabled' => null, 'revision_limit' => null],
		];

		$rows = $this->resolver($db, 1, 5)->get_album_rules();

		$this->assertSame([0, 1, 1], array_column($rows, 'depth'));
		$this->assertSame(0, $rows[1]['effective_enabled']);
		$this->assertSame(8, $rows[1]['effective_revision_limit']);
		$this->assertSame(1, $rows[2]['effective_enabled']);
		$this->assertSame(5, $rows[2]['effective_revision_limit']);
		$this->assertStringContainsString('WHERE albums.album_user_id = 0', $db->last_query);
	}

	public function test_saving_one_album_omits_a_fully_inherited_rule(): void
	{
		$db = new fake_db();
		$db->rows = [[
			'album_id' => 4, 'parent_id' => 0, 'album_name' => 'Four', 'left_id' => 1, 'right_id' => 2,
			'enabled' => null, 'revision_limit' => null,
		]];
		$resolver = $this->resolver($db, 0, 5);

		$resolver->save_album_rule(4, ['enabled' => -1, 'revision_limit' => -1]);
		$this->assertStringContainsString('DELETE FROM rules WHERE album_id = 4', $db->last_query);
		$this->assertSame([], $db->inserted);

		$db->rows = [[
			'album_id' => 4, 'parent_id' => 0, 'album_name' => 'Four', 'left_id' => 1, 'right_id' => 2,
			'enabled' => null, 'revision_limit' => null,
		]];
		$resolver->save_album_rule(4, ['enabled' => 1, 'revision_limit' => 20]);
		$this->assertSame([['album_id' => 4, 'enabled' => 1, 'revision_limit' => 20]], $db->inserted);
	}

	public function test_delete_and_reactivation_cleanup_remove_album_rules(): void
	{
		$db = new fake_db();
		$resolver = $this->resolver($db, 0, 5);
		$resolver->delete_for_albums([7, 7, 0, -1]);
		$this->assertStringContainsString('album_id IN (7)', $db->last_query);

		$db->rows = [['album_id' => 9]];
		$this->assertSame(1, $resolver->reconcile_orphans());
		$this->assertStringContainsString('album_id IN (9)', $db->last_query);
	}

	private function resolver(fake_db $db, int $enabled, int $limit): policy
	{
		return new policy($db, new config([
			'phpbb_gallery_imagerevisions_enabled' => $enabled,
			'phpbb_gallery_imagerevisions_limit' => $limit,
		]), 'albums', 'rules');
	}
}
