<?php
/**
 * phpBB Gallery - Core Extension tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\album\album;
use phpbbgallery\core\block;
use PHPUnit\Framework\TestCase;

class image_delete_batch_resync_test extends TestCase
{
	public function test_album_image_counts_are_aggregated_in_one_query_per_batch(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$queries = [];
		$db->expects($this->exactly(2))
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
				[
					'image_album_id' => 2,
					'album_images_real' => 7,
					'album_images' => 5,
				],
			],
		];
		$db->method('sql_fetchrow')
			->willReturnCallback(function (int $result) use (&$rows)
			{
				return !empty($rows[$result]) ? array_shift($rows[$result]) : false;
			});
		$db->expects($this->once())->method('sql_freeresult');

		$this->update_image_counts($db, [2, 3, 3]);

		$this->assertCount(2, $queries);
		$this->assertStringContainsString('GROUP BY image_album_id', $queries[0]);
		$this->assertStringContainsString(
			'album_images_real = CASE album_id WHEN 2 THEN 7 WHEN 3 THEN 0 ELSE album_images_real END',
			$queries[1]
		);
		$this->assertStringContainsString(
			'album_images = CASE album_id WHEN 2 THEN 5 WHEN 3 THEN 0 ELSE album_images END',
			$queries[1]
		);
	}

	public function test_image_deletion_resyncs_all_affected_albums_at_once(): void
	{
		$source = file_get_contents(dirname(__DIR__) . '/image/image.php');

		$this->assertStringContainsString('->update_infos($resync_album_ids);', $source);
		$this->assertStringContainsString("->dec('num_views', \$deleted_views, false);", $source);
		$this->assertStringNotContainsString('foreach ($resync_album_ids as $album_id)', $source);
	}

	private function update_image_counts(\phpbb\db\driver\driver_interface $db, array $album_ids): void
	{
		$gallery_album = $this->album_service($db);
		$update = \Closure::bind(function (array $ids): void
		{
			$this->update_image_counts($ids);
		}, $gallery_album, album::class);
		$update($album_ids);
	}

	private function album_service(\phpbb\db\driver\driver_interface $db): album
	{
		$reflection = new \ReflectionClass(album::class);
		$gallery_album = $reflection->newInstanceWithoutConstructor();
		$initialize = \Closure::bind(function ($database): void
		{
			$this->db = $database;
			$this->block = new block();
			$this->albums_table = 'gallery_albums';
			$this->images_table = 'gallery_images';
		}, $gallery_album, album::class);
		$initialize($db);

		return $gallery_album;
	}
}
