<?php
/**
 * phpBB Gallery - Core Extension tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\config as gallery_config;
use phpbbgallery\core\contest;
use PHPUnit\Framework\TestCase;

final class contest_batch_resync_test extends TestCase
{
	public function test_contest_winners_are_resynced_in_one_query_set_per_batch(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$queries = [];
		$db->expects($this->exactly(4))
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
			2 => [
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
		$db->expects($this->once())->method('sql_freeresult')->with(2);

		$this->contest($db)->resync_albums([10, 11, 10, 0]);

		$this->assertStringContainsString('image_album_id IN (10, 11)', $queries[0]);
		$this->assertStringContainsString('image_contest_rank = 0', $queries[0]);
		$this->assertStringContainsString('SELECT COUNT(better.image_id)', $queries[1]);
		$this->assertStringContainsString('ranked.image_status IN (1, 2)', $queries[1]);
		$this->assertStringContainsString('better.image_status IN (1, 2)', $queries[1]);
		$this->assertStringContainsString('better.image_rate_avg > ranked.image_rate_avg', $queries[1]);
		$this->assertStringContainsString('ranked.image_rate_avg DESC', $queries[1]);
		$this->assertStringContainsString('contest_first = CASE contest_album_id WHEN 10 THEN 7 WHEN 11 THEN 9', $queries[2]);
		$this->assertStringContainsString('contest_second = CASE contest_album_id WHEN 10 THEN 8 WHEN 11 THEN 0', $queries[2]);
		$this->assertStringContainsString('contest_third = CASE contest_album_id WHEN 10 THEN 0 WHEN 11 THEN 0', $queries[2]);
		$this->assertStringContainsString('WHEN 7 THEN 1 WHEN 8 THEN 2 WHEN 9 THEN 1', $queries[3]);
	}

	public function test_empty_album_set_does_not_query_the_database(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->never())->method('sql_query');

		$this->contest($db)->resync_albums([0, -1]);
	}

	public function test_single_album_resync_delegates_to_batch_resync(): void
	{
		$source = file_get_contents(dirname(__DIR__) . '/contest.php');

		$this->assertStringContainsString('$this->resync_albums([$album_id]);', $source);
		$this->assertStringNotContainsString('foreach ($album_ids as $album_id)', $source);
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
