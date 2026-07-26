<?php
/**
 * phpBB Gallery - Core Extension tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\acp\main_module;
use PHPUnit\Framework\TestCase;

class acp_filesize_resync_test extends TestCase
{
	public function test_filesizes_are_updated_in_one_query_for_the_batch(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->once())
			->method('sql_in_set')
			->with('image_id', [12, 34])
			->willReturn('image_id IN (12, 34)');
		$db->expects($this->once())
			->method('sql_query')
			->with($this->callback(function (string $sql): bool
			{
				$this->assertStringContainsString(
					'filesize_upload = CASE image_id WHEN 12 THEN 100 WHEN 34 THEN 400 ELSE filesize_upload END',
					$sql
				);
				$this->assertStringContainsString(
					'filesize_medium = CASE image_id WHEN 12 THEN 20 WHEN 34 THEN 0 ELSE filesize_medium END',
					$sql
				);
				$this->assertStringContainsString(
					'filesize_cache = CASE image_id WHEN 12 THEN 5 WHEN 34 THEN 40 ELSE filesize_cache END',
					$sql
				);
				$this->assertStringContainsString('WHERE image_id IN (12, 34)', $sql);

				return true;
			}));

		$this->update_filesizes($db, [
			12 => [
				'filesize_upload' => 100,
				'filesize_medium' => 20,
				'filesize_cache' => 5,
			],
			34 => [
				'filesize_upload' => 400,
				'filesize_medium' => 0,
				'filesize_cache' => 40,
			],
		]);
	}

	public function test_empty_filesize_set_does_not_query_the_database(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->never())->method('sql_in_set');
		$db->expects($this->never())->method('sql_query');

		$this->update_filesizes($db, []);
	}

	private function update_filesizes(\phpbb\db\driver\driver_interface $db, array $filesizes): void
	{
		$module = new main_module();
		$update = \Closure::bind(function ($database, array $values): void
		{
			$this->update_image_filesizes($database, 'gallery_images', $values);
		}, $module, main_module::class);
		$update($db, $filesizes);
	}
}
