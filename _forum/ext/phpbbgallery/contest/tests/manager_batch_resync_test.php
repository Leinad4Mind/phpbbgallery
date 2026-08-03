<?php
/**
 * phpBB Gallery - Core Extension tests
 *
 * @package   phpbbgallery/contest
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\contest\tests;

use phpbbgallery\core\config as gallery_config;
use phpbbgallery\contest\manager as contest;
use PHPUnit\Framework\TestCase;

final class manager_batch_resync_test extends TestCase
{
	public function test_contest_winners_are_resynced_in_one_query_set_per_batch(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$queries = [];
		$db->expects($this->exactly(5))
			->method('sql_query')
			->willReturnCallback(function (string $sql) use (&$queries): int
			{
				$queries[] = $sql;

				return count($queries);
			});
		$db->method('sql_in_set')
			->willReturnCallback(function (string $field, array $values): string
			{
				return $field . ' IN (' . implode(', ', $values) . ')';
			});

		$rows = [
			1 => [
				['contest_album_id' => 10, 'contest_start' => 1_000, 'contest_end' => 500],
				['contest_album_id' => 11, 'contest_start' => 1_000, 'contest_end' => 600],
			],
			3 => [
				['image_album_id' => 10, 'image_id' => 7],
				['image_album_id' => 10, 'image_id' => 8],
				['image_album_id' => 11, 'image_id' => 9],
			],
		];
		$db->method('sql_fetchrow')
			->willReturnCallback(function (int $result) use (&$rows)
			{
				return !empty($rows[$result]) ? array_shift($rows[$result]) : false;
			});
		$db->expects($this->exactly(2))->method('sql_freeresult');

		$this->contest($db)->resync_albums([10, 11, 10, 0]);

		$this->assertStringContainsString('contest_album_id IN (10, 11)', $queries[0]);
		$this->assertStringContainsString('contest_marked = 0', $queries[0]);
		$this->assertStringContainsString('image_album_id = 10', $queries[1]);
		$this->assertStringContainsString('image_contest_end = 1500', $queries[1]);
		$this->assertStringContainsString('image_contest_rank = 0', $queries[1]);
		$this->assertStringContainsString('SELECT COUNT(better.image_id)', $queries[2]);
		$this->assertStringContainsString('ranked.image_status IN (1, 2)', $queries[2]);
		$this->assertStringContainsString('better.image_status IN (1, 2)', $queries[2]);
		$this->assertStringContainsString('better.image_contest_end = ranked.image_contest_end', $queries[2]);
		$this->assertStringContainsString('better.image_rate_avg > ranked.image_rate_avg', $queries[2]);
		$this->assertStringContainsString('ranked.image_rate_avg DESC', $queries[2]);
		$this->assertStringContainsString('contest_first = CASE contest_album_id WHEN 10 THEN 7 WHEN 11 THEN 9', $queries[3]);
		$this->assertStringContainsString('contest_second = CASE contest_album_id WHEN 10 THEN 8 WHEN 11 THEN 0', $queries[3]);
		$this->assertStringContainsString('contest_third = CASE contest_album_id WHEN 10 THEN 0 WHEN 11 THEN 0', $queries[3]);
		$this->assertStringContainsString('WHEN 7 THEN 1 WHEN 8 THEN 2 WHEN 9 THEN 1', $queries[4]);
	}

	public function test_empty_album_set_does_not_query_the_database(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->never())->method('sql_query');

		$this->contest($db)->resync_albums([0, -1]);
	}

	public function test_active_contest_batch_does_not_clear_image_markers(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$queries = [];
		$db->expects($this->once())
			->method('sql_query')
			->willReturnCallback(static function (string $sql) use (&$queries): int
			{
				$queries[] = $sql;

				return 1;
			});
		$db->method('sql_in_set')->willReturn('contest_album_id IN (10)');
		$db->expects($this->once())->method('sql_fetchrow')->with(1)->willReturn(false);
		$db->expects($this->once())->method('sql_freeresult')->with(1);

		$this->contest($db)->resync_albums([10]);

		$this->assertCount(1, $queries);
		$this->assertStringContainsString('contest_marked = 0', $queries[0]);
		$this->assertStringNotContainsString('UPDATE gallery_images', $queries[0]);
	}

	public function test_single_album_resync_delegates_to_batch_resync(): void
	{
		$source = file_get_contents(dirname(__DIR__) . '/manager.php');

		$this->assertStringContainsString('$this->resync_albums([$album_id]);', $source);
		$this->assertStringNotContainsString('foreach ($album_ids as $album_id)', $source);
	}

	public function test_contest_rows_are_loaded_for_album_ids_in_one_query(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->once())
			->method('sql_in_set')
			->with('contest_album_id', [7, 9])
			->willReturn('contest_album_id IN (7, 9)');
		$db->expects($this->once())
			->method('sql_query')
			->with($this->stringContains('contest_album_id IN (7, 9)'))
			->willReturn(1);
		$db->expects($this->exactly(3))
			->method('sql_fetchrow')
			->with(1)
			->willReturnOnConsecutiveCalls(
				['contest_id' => 11, 'contest_album_id' => 7],
				['contest_id' => 12, 'contest_album_id' => 9],
				false
			);
		$db->expects($this->once())->method('sql_freeresult')->with(1);

		$rows = $this->contest($db)->get_contests_by_album_ids([9, 7, 9, 0]);

		$this->assertSame(11, $rows[7]['contest_id']);
		$this->assertSame(12, $rows[9]['contest_id']);
	}

	public function test_empty_contest_album_lookup_does_not_query_database(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->never())->method('sql_query');

		$this->assertSame([], $this->contest($db)->get_contests_by_album_ids([0, -1]));
	}

	private function contest(\phpbb\db\driver\driver_interface $db): contest
	{
		return new contest(
			$db,
			new gallery_config(new \phpbb\config\config([])),
			'gallery_images',
			'gallery_contests'
		);
	}
}
