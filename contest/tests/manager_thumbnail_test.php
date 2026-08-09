<?php
/**
 * phpBB Gallery Contest winner-thumbnail tests.
 *
 * @package   phpbbgallery/contest
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\contest\tests;

use phpbbgallery\contest\manager;
use phpbbgallery\core\block;
use phpbbgallery\core\config as gallery_config;
use PHPUnit\Framework\TestCase;

final class manager_thumbnail_test extends TestCase
{
	public function test_global_default_and_per_contest_overrides_are_resolved_before_one_query(): void
	{
		$db = $this->database([
			['image_id' => 70, 'image_album_id' => 7],
			['image_id' => 90, 'image_album_id' => 999],
			['image_id' => 110, 'image_album_id' => 11],
		], [70, 90, 110]);
		$contest = $this->manager($db, true);

		$result = $contest->get_winner_thumbnails([
			7 => $this->contest(70, manager::THUMBNAIL_INHERIT),
			8 => $this->contest(80, manager::THUMBNAIL_LAST),
			9 => $this->contest(90, manager::THUMBNAIL_WINNER),
			10 => $this->contest(100, manager::THUMBNAIL_WINNER, manager::STATE_ACTIVE),
			11 => $this->contest(110, 99),
		]);

		$this->assertSame([7 => 70, 11 => 110], $result);
	}

	public function test_explicit_winner_can_override_disabled_global_default(): void
	{
		$db = $this->database([
			['image_id' => 80, 'image_album_id' => 8],
		], [80]);
		$contest = $this->manager($db, false);

		$result = $contest->get_winner_thumbnails([
			7 => $this->contest(70, manager::THUMBNAIL_INHERIT),
			8 => $this->contest(80, manager::THUMBNAIL_WINNER),
		]);

		$this->assertSame([8 => 80], $result);
	}

	public function test_no_eligible_policy_avoids_the_image_query(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->never())->method('sql_query');

		$this->assertSame([], $this->manager($db, false)->get_winner_thumbnails([
			7 => $this->contest(70, manager::THUMBNAIL_INHERIT),
		]));
	}

	private function database(array $rows, array $expected_image_ids): \phpbb\db\driver\driver_interface
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->exactly(2))
			->method('sql_in_set')
			->willReturnCallback(function (string $field, array $values) use ($expected_image_ids): string
			{
				if ($field === 'image_id')
				{
					$this->assertSame($expected_image_ids, $values);
					return 'image_id IN (' . implode(', ', $values) . ')';
				}

				$this->assertSame('image_status', $field);
				$this->assertSame([block::STATUS_APPROVED, block::STATUS_LOCKED], $values);
				return 'image_status IN (1, 2)';
			});
		$db->expects($this->once())
			->method('sql_query')
			->with($this->callback(static fn(string $sql): bool =>
				str_contains($sql, 'image_contest = 0')
				&& str_contains($sql, 'image_contest_rank = 1')))
			->willReturn('result');
		$rows[] = false;
		$db->expects($this->exactly(count($rows)))
			->method('sql_fetchrow')
			->with('result')
			->willReturnOnConsecutiveCalls(...$rows);
		$db->expects($this->once())->method('sql_freeresult')->with('result');

		return $db;
	}

	private function manager(\phpbb\db\driver\driver_interface $db, bool $global): manager
	{
		return new manager(
			$db,
			new gallery_config(new \phpbb\config\config([
				'phpbb_gallery_contest_winner_thumbnail' => (int) $global,
			])),
			'gallery_images',
			'gallery_contests'
		);
	}

	private function contest(int $image_id, int $policy, int $state = manager::STATE_INACTIVE): array
	{
		return [
			'contest_first' => $image_id,
			'contest_marked' => $state,
			'contest_winner_thumbnail' => $policy,
		];
	}
}
