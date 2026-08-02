<?php
/**
 * phpBB Gallery - Contest finalization tests
 *
 * @package   phpbbgallery/contest
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\contest\tests;

use phpbbgallery\core\config as gallery_config;
use phpbbgallery\contest\manager as contest;
use PHPUnit\Framework\TestCase;

final class manager_finalization_test extends TestCase
{
	public function test_end_ranks_only_eligible_images_in_one_idempotent_update(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$selects = [];
		$updates = [];
		$db->expects($this->exactly(2))
			->method('sql_query_limit')
			->willReturnCallback(static function (string $sql, int $limit) use (&$selects): int
			{
				$selects[] = [$sql, $limit];

				return count($selects) === 1 ? 10 : 20;
			});
		$db->expects($this->exactly(3))
			->method('sql_query')
			->willReturnCallback(static function (string $sql) use (&$updates): int
			{
				$updates[] = $sql;

				return count($updates);
			});
		$db->expects($this->once())
			->method('sql_in_set')
			->with('image_status', [
				\phpbbgallery\core\block::STATUS_APPROVED,
				\phpbbgallery\core\block::STATUS_LOCKED,
			])
			->willReturn('image_status IN (1, 2)');
		$winner_rows = [
			['image_id' => 7],
			['image_id' => 8],
		];
		$db->method('sql_fetchrow')
			->willReturnCallback(static function (int $result) use (&$winner_rows): array|false
			{
				if ($result === 10)
				{
					return [
						'contest_marked' => \phpbbgallery\core\block::IN_CONTEST,
						'contest_first' => 0,
						'contest_second' => 0,
						'contest_third' => 0,
					];
				}

				return $winner_rows ? array_shift($winner_rows) : false;
			});
		$db->expects($this->exactly(2))->method('sql_freeresult');
		$db->expects($this->exactly(2))->method('sql_affectedrows')->willReturn(1);

		$config = new \phpbb\config\config(['phpbb_gallery_contests_ended' => 0]);
		$completed = $this->contest($db, $config)->end(10, 4, 1_500, 1_500);

		$this->assertTrue($completed);
		$this->assertSame(1, $selects[0][1]);
		$this->assertStringContainsString('contest_id = 4', $selects[0][0]);
		$this->assertStringContainsString('contest_album_id = 10', $selects[0][0]);
		$this->assertStringContainsString('contest_start + contest_end <= 1500', $selects[0][0]);
		$this->assertSame(contest::NUM_IMAGES, $selects[1][1]);
		$this->assertStringContainsString('image_status IN (1, 2)', $selects[1][0]);
		$this->assertStringContainsString('contest_marked = 2', $updates[0]);
		$this->assertStringContainsString('contest_first = 7', $updates[0]);
		$this->assertStringContainsString('contest_second = 8', $updates[0]);
		$this->assertStringContainsString('contest_third = 0', $updates[0]);
		$this->assertStringContainsString('image_contest_rank = CASE image_id WHEN 7 THEN 1 WHEN 8 THEN 2 ELSE 0 END', $updates[1]);
		$this->assertStringContainsString('WHEN image_contest = 1', $updates[1]);
		$this->assertStringContainsString('OR image_contest_end = 1500', $updates[1]);
		$this->assertStringContainsString('contest_marked = 0', $updates[2]);
		$this->assertStringContainsString('contest_marked = 2', $updates[2]);
		$this->assertStringNotContainsString('image_id = 0', implode("\n", $updates));
		$this->assertSame(1, (int) $config['phpbb_gallery_contests_ended']);
	}

	public function test_end_does_nothing_when_the_contest_is_not_pending(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->once())->method('sql_query_limit')->willReturn(10);
		$db->expects($this->once())->method('sql_fetchrow')->with(10)->willReturn(false);
		$db->expects($this->once())->method('sql_freeresult')->with(10);
		$db->expects($this->never())->method('sql_query');
		$db->expects($this->never())->method('sql_affectedrows');

		$config = new \phpbb\config\config(['phpbb_gallery_contests_ended' => 3]);
		$completed = $this->contest($db, $config)->end(10, 4, 1_500, 1_500);

		$this->assertFalse($completed);
		$this->assertSame(3, (int) $config['phpbb_gallery_contests_ended']);
	}

	public function test_interrupted_finalization_resumes_from_the_stored_podium(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->once())->method('sql_query_limit')->willReturn(10);
		$db->expects($this->once())->method('sql_fetchrow')->with(10)->willReturn([
			'contest_marked' => 2,
			'contest_first' => 7,
			'contest_second' => 8,
			'contest_third' => 0,
		]);
		$db->expects($this->once())->method('sql_freeresult')->with(10);
		$db->expects($this->never())->method('sql_in_set');
		$db->expects($this->exactly(2))->method('sql_query')->willReturn(1);
		$db->expects($this->once())->method('sql_affectedrows')->willReturn(1);

		$config = new \phpbb\config\config(['phpbb_gallery_contests_ended' => 3]);
		$completed = $this->contest($db, $config)->end(10, 4, 1_500, 1_500);

		$this->assertTrue($completed);
		$this->assertSame(4, (int) $config['phpbb_gallery_contests_ended']);
	}

	public function test_losing_claimer_uses_the_podium_stored_by_the_winner(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$select_count = 0;
		$db->expects($this->exactly(3))
			->method('sql_query_limit')
			->willReturnCallback(static function () use (&$select_count): int
			{
				return [10, 20, 30][$select_count++];
			});
		$local_winners = [['image_id' => 7]];
		$db->method('sql_fetchrow')->willReturnCallback(static function (int $result) use (&$local_winners): array|false
		{
			return match ($result)
			{
				10 => [
					'contest_marked' => \phpbbgallery\core\block::IN_CONTEST,
					'contest_first' => 0,
					'contest_second' => 0,
					'contest_third' => 0,
				],
				20 => $local_winners ? array_shift($local_winners) : false,
				30 => ['contest_first' => 9, 'contest_second' => 0, 'contest_third' => 0],
				default => false,
			};
		});
		$db->expects($this->exactly(3))->method('sql_freeresult');
		$db->method('sql_in_set')->willReturn('image_status IN (1, 2)');
		$updates = [];
		$db->expects($this->exactly(3))
			->method('sql_query')
			->willReturnCallback(static function (string $sql) use (&$updates): int
			{
				$updates[] = $sql;

				return count($updates);
			});
		$db->expects($this->exactly(2))->method('sql_affectedrows')->willReturnOnConsecutiveCalls(0, 0);

		$config = new \phpbb\config\config(['phpbb_gallery_contests_ended' => 3]);
		$completed = $this->contest($db, $config)->end(10, 4, 1_500, 1_500);

		$this->assertTrue($completed);
		$this->assertStringContainsString('WHEN 9 THEN 1', $updates[1]);
		$this->assertStringNotContainsString('WHEN 7 THEN 1', $updates[1]);
		$this->assertSame(3, (int) $config['phpbb_gallery_contests_ended']);
	}

	public function test_completed_podium_is_resynced_after_eligibility_changes(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__, 2) . '/core/image/image.php');
		$approve = $this->method_source($source, 'approve_images', 'unapprove_images');
		$unapprove = $this->method_source($source, 'unapprove_images', 'move_image');
		$lock = $this->method_source($source, 'lock_images', 'get_last_image');

		foreach ([$approve, $unapprove, $lock] as $method)
		{
			$this->assertStringContainsString('image_contest_end', $method);
			$this->assertStringContainsString('$this->contest->resync($album_id);', $method);
		}
	}

	public function test_image_moves_preserve_contest_boundaries_and_repair_the_source(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__, 2) . '/core/image/image.php');
		$move = $this->method_source($source, 'move_image', 'lock_images');

		$this->assertStringContainsString("contest::is_step('upload', \$target_data)", $move);
		$this->assertStringContainsString('image_contest_end', $move);
		$this->assertStringContainsString('image_contest_rank = 0', $move);
		$this->assertStringContainsString('$source_album_id === $album_id', $move);
		$this->assertStringContainsString('$this->contest->resync_albums($resync_contest_albums);', $move);
	}

	private function method_source(string $source, string $method, string $next_method): string
	{
		$start = strpos($source, 'public function ' . $method . '(');
		$end = strpos($source, 'public function ' . $next_method . '(', (int) $start);

		$this->assertNotFalse($start);
		$this->assertNotFalse($end);

		return substr($source, (int) $start, (int) $end - (int) $start);
	}

	private function contest(\phpbb\db\driver\driver_interface $db, \phpbb\config\config $config): contest
	{
		return new contest(
			$db,
			new gallery_config($config),
			'gallery_images',
			'gallery_contests'
		);
	}
}
