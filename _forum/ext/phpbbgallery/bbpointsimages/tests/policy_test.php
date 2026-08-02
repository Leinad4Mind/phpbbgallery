<?php
/**
 * BBPoints Images policy tests
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbpointsimages\tests;

use phpbb\config\config;
use phpbbgallery\bbpointsimages\policy;
use PHPUnit\Framework\TestCase;

final class policy_test extends TestCase
{
	public function test_nearest_album_values_override_independently_and_inherit_the_rest(): void
	{
		$db = new fake_db();
		$db->rows = [
			['upload_reward' => -1, 'source_cost' => 12],
			['upload_reward' => 8, 'source_cost' => -1],
			['upload_reward' => 3, 'source_cost' => 4],
		];
		$resolver = new policy($db, new config([
			'phpbb_gallery_bbpoints_upload_reward' => 1,
			'phpbb_gallery_bbpoints_source_cost' => 2,
		]), 'albums', 'rules');

		$this->assertSame([
			'upload_reward' => 8,
			'source_cost' => 12,
		], $resolver->resolve(30));
		$this->assertStringContainsString('ORDER BY ancestor.left_id DESC', $db->last_query);
	}

	public function test_global_values_are_used_when_every_album_rule_inherits(): void
	{
		$db = new fake_db();
		$db->rows = [
			['upload_reward' => -1, 'source_cost' => -1],
			['upload_reward' => null, 'source_cost' => null],
		];
		$resolver = new policy($db, new config([
			'phpbb_gallery_bbpoints_upload_reward' => 15,
			'phpbb_gallery_bbpoints_source_cost' => 6,
		]), 'albums', 'rules');

		$this->assertSame([
			'upload_reward' => 15,
			'source_cost' => 6,
		], $resolver->resolve(9));
	}

	public function test_invalid_or_missing_albums_fail_closed(): void
	{
		$resolver = new policy(new fake_db(), new config([]), 'albums', 'rules');

		foreach ([0, 99] as $album_id)
		{
			try
			{
				$resolver->resolve($album_id);
				$this->fail('An invalid album must not resolve a points policy.');
			}
			catch (\OutOfBoundsException)
			{
				$this->addToAssertionCount(1);
			}
		}
	}

	public function test_overrides_accept_inherit_or_non_negative_values_only(): void
	{
		$this->assertSame(policy::INHERIT, policy::normalize_override(-50));
		$this->assertSame(policy::INHERIT, policy::normalize_override(-1));
		$this->assertSame(0, policy::normalize_override(0));
		$this->assertSame(20, policy::normalize_override(20));
		$this->assertSame(policy::MAX_POINTS, policy::normalize_override(PHP_INT_MAX));
		$this->assertSame(0, policy::normalize_amount(-1));
		$this->assertSame(policy::MAX_POINTS, policy::normalize_amount(PHP_INT_MAX));
	}

	public function test_album_rules_include_tree_depth_and_direct_overrides(): void
	{
		$db = new fake_db();
		$db->rows = [
			['album_id' => 1, 'album_name' => 'Root', 'left_id' => 1, 'right_id' => 6,
				'upload_reward' => null, 'source_cost' => null],
			['album_id' => 2, 'album_name' => 'Child', 'left_id' => 2, 'right_id' => 3,
				'upload_reward' => 10, 'source_cost' => -1],
			['album_id' => 3, 'album_name' => 'Sibling', 'left_id' => 4, 'right_id' => 5,
				'upload_reward' => null, 'source_cost' => 20],
		];
		$resolver = new policy($db, new config([]), 'albums', 'rules');

		$rows = $resolver->get_album_rules();

		$this->assertSame([0, 1, 1], array_column($rows, 'depth'));
		$this->assertSame(10, $rows[1]['upload_reward']);
		$this->assertSame(20, $rows[2]['source_cost']);
	}

	public function test_saving_album_rules_ignores_unknown_albums_and_omits_full_inheritance(): void
	{
		$db = new fake_db();
		$db->rows = [
			['album_id' => 2, 'album_name' => 'Two', 'left_id' => 1, 'right_id' => 2,
				'upload_reward' => null, 'source_cost' => null],
			['album_id' => 4, 'album_name' => 'Four', 'left_id' => 3, 'right_id' => 4,
				'upload_reward' => null, 'source_cost' => null],
		];
		$resolver = new policy($db, new config([]), 'albums', 'rules');

		$resolver->save_album_rules([
			2 => ['upload_reward' => -100, 'source_cost' => -1],
			4 => ['upload_reward' => PHP_INT_MAX, 'source_cost' => 9],
			999 => ['upload_reward' => 50, 'source_cost' => 50],
		]);

		$this->assertStringContainsString('album_id IN (2,4)', implode("\n", $db->queries));
		$this->assertSame([[
			'album_id' => 4,
			'upload_reward' => policy::MAX_POINTS,
			'source_cost' => 9,
		]], $db->inserted['rules']);
	}

	public function test_deleted_albums_remove_their_direct_rules(): void
	{
		$db = new fake_db();
		$resolver = new policy($db, new config([]), 'albums', 'rules');

		$resolver->delete_for_albums([7, 7, 0, -1]);

		$this->assertStringContainsString('DELETE FROM rules', $db->last_query);
		$this->assertStringContainsString('album_id IN (7)', $db->last_query);
	}

	public function test_reactivation_removes_rules_for_missing_albums(): void
	{
		$db = new fake_db();
		$db->rows = [['album_id' => 9]];
		$resolver = new policy($db, new config([]), 'albums', 'rules');

		$this->assertSame(1, $resolver->reconcile_orphans());
		$this->assertStringContainsString('album_id IN (9)', $db->last_query);
	}
}
