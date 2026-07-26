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

class album_last_image_resync_test extends TestCase
{
	public function test_last_images_are_loaded_and_updated_in_batches(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$queries = [];
		$db->expects($this->exactly(3))
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
		$db->method('sql_escape')
			->willReturnCallback(function (string $value): string
			{
				return str_replace("'", "''", $value);
			});

		$rows = [
			1 => [
				['album_id' => 2, 'album_user_id' => 0],
				['album_id' => 3, 'album_user_id' => 7],
			],
			2 => [
				[
					'image_id' => 91,
					'image_album_id' => 2,
					'image_time' => 1700000000,
					'image_name' => "Owner's image",
					'image_username' => 'Owner',
					'image_user_colour' => 'ABCDEF',
					'image_user_id' => 42,
				],
			],
		];
		$db->method('sql_fetchrow')
			->willReturnCallback(function (int $result) use (&$rows)
			{
				return !empty($rows[$result]) ? array_shift($rows[$result]) : false;
			});
		$db->expects($this->exactly(2))->method('sql_freeresult');

		$this->album_service($db)->update_last_images([2, 3, 3]);

		$this->assertCount(3, $queries);
		$this->assertStringContainsString('NOT EXISTS', $queries[1]);
		$this->assertStringContainsString(
			'album_last_image_id = CASE album_id WHEN 2 THEN 91 WHEN 3 THEN 0 ELSE album_last_image_id END',
			$queries[2]
		);
		$this->assertStringContainsString("WHEN 2 THEN 'Owner''s image' WHEN 3 THEN ''", $queries[2]);
		$this->assertStringContainsString(
			"album_last_user_colour = CASE album_id WHEN 2 THEN 'ABCDEF' ELSE album_last_user_colour END",
			$queries[2]
		);
		$this->assertStringContainsString('WHERE album_id IN (2, 3)', $queries[2]);
	}

	public function test_empty_album_set_does_not_query_the_database(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->never())->method('sql_query');

		$this->album_service($db)->update_last_images([]);
	}

	public function test_acp_collects_album_ids_before_resyncing_last_images(): void
	{
		$source = file_get_contents(dirname(__DIR__) . '/acp/main_module.php');

		$this->assertStringContainsString('$album_ids[] = (int) $row[\'album_id\'];', $source);
		$this->assertStringContainsString('->update_last_images($album_ids);', $source);
		$this->assertStringNotContainsString('->update_info($row[\'album_id\']);', $source);
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
