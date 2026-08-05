<?php
/**
 * phpBB Gallery - EXIF capture synchronization tests
 *
 * @package   phpbbgallery/exif
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\exif\tests;

use phpbb\db\driver\driver_interface;
use phpbbgallery\core\storage\provider_interface;
use phpbbgallery\core\storage\workspace;
use phpbbgallery\exif\capture_index;
use phpbbgallery\exif\capture_sync;
use PHPUnit\Framework\TestCase;

final class capture_sync_test extends TestCase
{
	public function test_non_jpeg_clears_stale_metadata_and_index_without_reading_storage(): void
	{
		$db = $this->createMock(driver_interface::class);
		$db->method('sql_build_array')->willReturn("image_has_exif = 0, image_exif_data = ''");
		$db->method('sql_in_set')->willReturn('exif_image_id IN (12)');
		$queries = [];
		$db->expects($this->exactly(2))->method('sql_query')->willReturnCallback(
			static function (string $sql) use (&$queries): string
			{
				$queries[] = $sql;

				return 'result';
			}
		);
		$provider = $this->createMock(provider_interface::class);
		$provider->expects($this->never())->method('local_path');
		$provider->expects($this->never())->method('open_stream');
		$sync = $this->new_sync($db, $provider);

		$this->assertFalse($sync->refresh_image(12, 'legacy.png'));
		$this->assertStringStartsWith('UPDATE gallery_images', $queries[0]);
		$this->assertStringStartsWith('DELETE FROM gallery_exif_capture', $queries[1]);
	}

	public function test_temporarily_unavailable_source_is_not_persisted_as_missing_metadata(): void
	{
		$db = $this->createMock(driver_interface::class);
		$db->expects($this->never())->method('sql_query');
		$provider = $this->createMock(provider_interface::class);
		$provider->method('local_path')->willReturn(null);
		$provider->method('open_stream')->willReturn(false);
		$sync = $this->new_sync($db, $provider);

		$this->assertNull($sync->refresh_image(12, 'remote.jpg'));
	}

	public function test_batch_uses_valid_cached_metadata_without_opening_the_source(): void
	{
		$serialized = json_encode(
			['EXIF' => ['DateTimeOriginal' => '2025:02:15 15:26:30']],
			JSON_THROW_ON_ERROR
		);
		$db = $this->createMock(driver_interface::class);
		$db->expects($this->once())->method('sql_query_limit')
			->with($this->stringContains('WHERE image_id > 7'), 26)
			->willReturn('batch');
		$db->expects($this->exactly(2))->method('sql_fetchrow')
			->willReturnOnConsecutiveCalls([
				'image_id' => 9,
				'image_filename' => 'cached.jpg',
				'image_exif_data' => $serialized,
			], false);
		$db->expects($this->once())->method('sql_freeresult')->with('batch');
		$db->method('sql_in_set')->willReturn('exif_image_id IN (9)');
		$db->method('sql_build_array')->willReturn('(exif_image_id, exif_taken_time) VALUES (9, 1739633190)');
		$db->expects($this->exactly(2))->method('sql_query');
		$provider = $this->createMock(provider_interface::class);
		$provider->expects($this->never())->method('local_path');
		$provider->expects($this->never())->method('open_stream');
		$sync = $this->new_sync($db, $provider);

		$this->assertSame([
			'scanned' => 1,
			'indexed' => 1,
			'unavailable' => 0,
			'last_id' => 9,
			'has_more' => false,
		], $sync->run_batch(7));
	}

	private function new_sync(driver_interface $db, provider_interface $provider): capture_sync
	{
		return new capture_sync(
			$db,
			new capture_index($db, 'gallery_exif_capture'),
			new workspace($provider, sys_get_temp_dir() . '/phpbbgallery-exif-tests'),
			'gallery_images'
		);
	}
}
