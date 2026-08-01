<?php
/**
 * BBPoints Images original-source purchase tests
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbpointsimages\tests;

use phpbb\config\config;
use phpbbgallery\bbpointsimages\policy;
use phpbbgallery\bbpointsimages\purchase_manager;
use PHPUnit\Framework\TestCase;
use sitesplat\bbpoints\core\ledger;

final class purchase_manager_test extends TestCase
{
	public function test_author_and_contributors_have_complimentary_access(): void
	{
		[$manager] = $this->manager(10, [9 => [4, 5]]);

		$this->assertTrue($manager->quote($this->image(), 3)['complimentary']);
		$this->assertTrue($manager->quote($this->image(), 4)['complimentary']);
		$this->assertTrue($manager->quote($this->image(), 5)['complimentary']);
		$this->assertTrue($manager->quote($this->image(), 8)['requires_purchase']);
		$this->assertSame([3 => 4, 4 => 3, 5 => 3], $manager->quote($this->image(), 8)['recipients']);
	}

	public function test_purchase_is_permanent_idempotent_and_split_with_the_remainder_for_the_author(): void
	{
		[$manager, $db, $ledger] = $this->manager(10, [9 => [4, 5]]);

		$this->assertSame([
			'amount' => 10,
			'recipients' => [3 => 4, 4 => 3, 5 => 3],
		], $manager->purchase($this->image(), 8));
		$this->assertFalse($manager->purchase($this->image(), 8));
		$key = 'gallery:image:9:source:buyer:8';
		$this->assertSame([3 => 4, 4 => 3, 5 => 3], $ledger->distributions[$key]['recipients']);
		$this->assertSame(10, $db->purchases['9:8']['amount']);
		$this->assertTrue($manager->quote($this->image(), 8)['purchased']);
		$this->assertCount(1, $ledger->distributions);
	}

	public function test_downloads_update_the_global_and_per_purchase_counters(): void
	{
		[$manager, $db] = $this->manager(10);
		$manager->purchase($this->image(), 8);

		$manager->record_download(9, 8);
		$manager->record_download(9, 8);

		$this->assertSame(2, $db->stats[9]['download_count']);
		$this->assertSame(2, $db->purchases['9:8']['download_count']);
		$this->assertGreaterThan(0, $db->purchases['9:8']['last_download_time']);
		$this->assertSame(2, $manager->get_download_count(9));
		$this->assertSame(0, $manager->get_download_count(999));
	}

	public function test_a_free_policy_never_creates_a_purchase_or_distribution(): void
	{
		[$manager, $db, $ledger] = $this->manager(0);

		$this->assertFalse($manager->quote($this->image(), 8)['requires_purchase']);
		$this->assertFalse($manager->purchase($this->image(), 8));
		$manager->record_download(9, 1);
		$this->assertSame([], $db->purchases);
		$this->assertSame([], $ledger->distributions);
		$this->assertSame(1, $db->stats[9]['download_count']);
	}

	private function manager(int $cost, array $contributors = []): array
	{
		$db = new purchase_fake_db();
		$db->policy_rows = [['upload_reward' => -1, 'source_cost' => $cost]];
		$db->contributors = $contributors;
		$ledger = new ledger();
		$policy = new policy($db, new config([
			'phpbb_gallery_bbpoints_upload_reward' => 0,
			'phpbb_gallery_bbpoints_source_cost' => $cost,
		]), 'albums', 'rules');
		return [new purchase_manager($db, $policy, $ledger, 'contributors', 'purchases', 'stats'), $db, $ledger];
	}

	private function image(): array
	{
		return [
			'image_id' => 9,
			'image_album_id' => 7,
			'image_user_id' => 3,
		];
	}
}
