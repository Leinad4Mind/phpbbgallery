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
}
