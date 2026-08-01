<?php
/**
 * BBPoints Images historical synchronization tests
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbpointsimages\tests;

use phpbb\config\config;
use phpbbgallery\bbpointsimages\policy;
use phpbbgallery\bbpointsimages\retro_sync;
use phpbbgallery\bbpointsimages\reward_manager;
use phpbbgallery\core\url;
use PHPUnit\Framework\TestCase;
use sitesplat\bbpoints\core\ledger;

final class retro_sync_test extends TestCase
{
	private string $source_path;

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		$this->source_path = sys_get_temp_dir() . '/gallery-bbpoints-sync-' . bin2hex(random_bytes(6)) . '/';
		mkdir($this->source_path);
		file_put_contents($this->source_path . 'one.jpg', 'first original');
		file_put_contents($this->source_path . 'two.jpg', 'second original');
		file_put_contents($this->source_path . 'three.jpg', 'third original');
	}

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function tearDown(): void
	{
		foreach (glob($this->source_path . '*') ?: [] as $file)
		{
			unlink($file);
		}
		if (is_dir($this->source_path))
		{
			rmdir($this->source_path);
		}
	}

	public function test_sync_is_paginated_approved_only_and_idempotent(): void
	{
		$db = new reward_fake_db();
		$db->policy_rows = [['upload_reward' => 10, 'source_cost' => -1]];
		$db->images = [
			$this->image(1, 1, 'one.jpg'),
			$this->image(2, 0, 'two.jpg'),
			$this->image(3, 1, 'two.jpg'),
			$this->image(4, 1, 'three.jpg'),
		];
		$ledger = new ledger();
		$policy = new policy($db, new config([
			'phpbb_gallery_bbpoints_upload_reward' => 0,
			'phpbb_gallery_bbpoints_source_cost' => 0,
		]), 'albums', 'rules');
		$rewards = new reward_manager($db, $policy, $ledger, 'rewards', 'stats');
		$sync = new retro_sync($db, $rewards, new url($this->source_path), 'images');

		$first = $sync->run_batch(0, 2);
		$second = $sync->run_batch($first['last_id'], 2);

		$this->assertSame(['last_id' => 3, 'scanned' => 2, 'rewarded' => 2, 'has_more' => true], $first);
		$this->assertSame(['last_id' => 4, 'scanned' => 1, 'rewarded' => 1, 'has_more' => false], $second);
		$this->assertCount(3, $ledger->credits);
		$this->assertSame(0, $sync->run_batch(0, 10)['rewarded']);
		$this->assertCount(3, $ledger->credits);
	}

	public function test_sync_stops_when_the_source_directory_is_unavailable(): void
	{
		$db = new reward_fake_db();
		$policy = new policy($db, new config([]), 'albums', 'rules');
		$rewards = new reward_manager($db, $policy, new ledger(), 'rewards', 'stats');
		$sync = new retro_sync($db, $rewards, new url($this->source_path . 'missing/'), 'images');

		$this->expectException(\RuntimeException::class);
		$sync->run_batch(0);
	}

	private function image(int $image_id, int $status, string $filename): array
	{
		return [
			'image_id' => $image_id,
			'image_album_id' => 9,
			'image_user_id' => $image_id + 10,
			'image_status' => $status,
			'image_filename' => $filename,
		];
	}
}
