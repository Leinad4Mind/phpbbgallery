<?php
/**
 * BBPoints Images reward lifecycle tests
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbpointsimages\tests;

use phpbb\config\config;
use phpbbgallery\bbpointsimages\policy;
use phpbbgallery\bbpointsimages\reward_manager;
use PHPUnit\Framework\TestCase;
use sitesplat\bbpoints\core\ledger;

final class reward_manager_test extends TestCase
{
	private array $temporary_files = [];

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle method.
	protected function tearDown(): void
	{
		foreach ($this->temporary_files as $file)
		{
			@unlink($file);
		}
	}

	public function test_approved_image_rewards_the_final_author_once(): void
	{
		[$manager, $db, $ledger] = $this->manager(10);
		$file = $this->source('original image');

		$this->assertTrue($manager->reward($this->image(9, 3), $file));
		$this->assertFalse($manager->reward($this->image(9, 3), $file));
		$this->assertSame(3, $db->rewards[9]['user_id']);
		$this->assertSame(hash_file('sha256', $file), $db->stats[9]['source_sha256']);
		$this->assertCount(1, $ledger->credits);
		$this->assertSame(10, $ledger->credits['gallery:image:9:reward']['amount']);
	}

	public function test_exact_file_duplicate_is_not_rewarded_twice(): void
	{
		[$manager, $db, $ledger] = $this->manager(10);
		$file = $this->source('same original bytes');

		$this->assertTrue($manager->reward($this->image(9, 3), $file));
		$this->assertFalse($manager->reward($this->image(10, 4), $file));
		$this->assertArrayHasKey(10, $db->stats);
		$this->assertArrayNotHasKey(10, $db->rewards);
		$this->assertCount(1, $ledger->credits);
	}

	public function test_pending_or_free_policy_does_not_issue_a_reward(): void
	{
		[$manager, $db, $ledger] = $this->manager(0);
		$file = $this->source('valid original');

		$this->assertFalse($manager->reward($this->image(9, 3), $file));
		$this->assertFalse($manager->reward($this->image(10, 3, 0), $file));
		$this->assertSame([], $db->rewards);
		$this->assertSame([], $ledger->credits);
	}

	public function test_reward_follows_each_author_change_without_being_reissued(): void
	{
		[$manager, $db, $ledger] = $this->manager(10);
		$file = $this->source('authored original');
		$manager->reward($this->image(9, 3), $file);

		$this->assertSame(1, $manager->reassign([9], 4));
		$this->assertSame(1, $manager->reassign([9], 3));
		$this->assertSame(3, $db->rewards[9]['user_id']);
		$this->assertSame(2, $db->rewards[9]['reassignment_count']);
		$this->assertCount(2, $ledger->transfers);
		$this->assertTrue($ledger->transfers['gallery:image:9:reward:reassign:1']['allow_negative']);
		$this->assertSame([], array_diff([3, 4], array_column($ledger->transfers, 'to_user_id')));
	}

	private function manager(int $reward): array
	{
		$db = new reward_fake_db();
		$db->policy_rows = [['upload_reward' => $reward, 'source_cost' => 0]];
		$ledger = new ledger();
		$policy = new policy($db, new config([
			'phpbb_gallery_bbpoints_upload_reward' => $reward,
			'phpbb_gallery_bbpoints_source_cost' => 0,
		]), 'albums', 'rules');
		return [new reward_manager($db, $policy, $ledger, 'rewards', 'stats'), $db, $ledger];
	}

	private function image(int $image_id, int $user_id, int $status = 1): array
	{
		return [
			'image_id' => $image_id,
			'image_album_id' => 7,
			'image_user_id' => $user_id,
			'image_status' => $status,
		];
	}

	private function source(string $contents): string
	{
		$file = tempnam('C:\\tmp', 'bbpointsimages-');
		file_put_contents($file, $contents);
		$this->temporary_files[] = $file;
		return $file;
	}
}
