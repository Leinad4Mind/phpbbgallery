<?php
/**
 * BBPoints Images contributor manager tests
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbpointsimages\tests;

use phpbbgallery\bbpointsimages\contributor_manager;
use PHPUnit\Framework\TestCase;

final class contributor_manager_test extends TestCase
{
	private contributor_fake_db $db;
	private contributor_manager $manager;

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		$this->db = new contributor_fake_db();
		$this->db->users = [
			2 => ['user_id' => 2, 'username' => 'Alice', 'username_clean' => 'alice', 'user_colour' => 'AA0000', 'user_type' => 0],
			3 => ['user_id' => 3, 'username' => 'Bob Smith', 'username_clean' => 'bob smith', 'user_colour' => '', 'user_type' => 3],
			4 => ['user_id' => 4, 'username' => 'Inactive', 'username_clean' => 'inactive', 'user_colour' => '', 'user_type' => 1],
		];
		$this->manager = new contributor_manager($this->db, 'contributors', 'users');
	}

	public function test_resolve_preserves_first_seen_order_and_deduplicates_names(): void
	{
		$this->assertSame([3, 2], array_column($this->manager->resolve(" Bob Smith \nAlice\nalice\n"), 'user_id'));
	}

	public function test_resolve_rejects_unknown_and_inactive_users(): void
	{
		try
		{
			$this->manager->resolve("Missing\nInactive");
			$this->fail('Expected invalid contributors to be rejected.');
		}
		catch (\InvalidArgumentException $exception)
		{
			$this->assertSame('Missing, Inactive', $exception->getMessage());
		}
	}

	public function test_resolve_enforces_the_hard_limit(): void
	{
		$this->expectException(\LengthException::class);
		$this->manager->resolve(implode("\n", array_map(
			static fn (int $index): string => 'User ' . $index,
			range(1, contributor_manager::MAX_CONTRIBUTORS + 1)
		)));
	}

	public function test_replace_excludes_the_author_and_formats_the_stored_order(): void
	{
		$this->manager->replace(10, 2, [
			['user_id' => 2],
			['user_id' => 3],
			['user_id' => 3],
		]);

		$this->assertSame([3], array_column($this->db->contributors[10], 'user_id'));
		$this->assertSame('Bob Smith', $this->manager->format_for_image(10));
	}

	public function test_author_changes_and_image_deletion_clean_relations(): void
	{
		$this->db->contributors = [
			10 => [['image_id' => 10, 'user_id' => 2, 'contributor_order' => 0], ['image_id' => 10, 'user_id' => 3, 'contributor_order' => 1]],
			11 => [['image_id' => 11, 'user_id' => 2, 'contributor_order' => 0]],
		];
		$this->manager->remove_author([10, 11, 10], 2);
		$this->assertSame([3], array_column($this->db->contributors[10], 'user_id'));
		$this->assertSame([], $this->db->contributors[11]);
		$this->manager->delete_for_images([10]);
		$this->assertArrayNotHasKey(10, $this->db->contributors);
	}
}
