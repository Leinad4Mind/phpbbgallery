<?php
/**
 * phpBB Gallery - EXIF capture index tests
 *
 * @package   phpbbgallery/exif
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\exif\tests;

use phpbbgallery\exif\capture_index;
use PHPUnit\Framework\TestCase;

final class capture_index_test extends TestCase
{
	public function test_datetime_original_is_parsed_as_utc_without_an_offset(): void
	{
		$timestamp = capture_index::timestamp_from_data([
			'EXIF' => ['DateTimeOriginal' => '2025:02:15 15:26:30'],
		]);

		$this->assertSame(1739633190, $timestamp);
	}

	public function test_explicit_exif_offset_is_normalized_to_utc(): void
	{
		$timestamp = capture_index::timestamp_from_data([
			'EXIF' => [
				'DateTimeOriginal' => '2025:02:15 15:26:30',
				'OffsetTimeOriginal' => '+02:00',
			],
		]);

		$this->assertSame(1739625990, $timestamp);
	}

	/** @dataProvider invalid_capture_offsets */
	public function test_invalid_exif_offsets_are_ignored_safely(string $offset): void
	{
		$timestamp = capture_index::timestamp_from_data([
			'EXIF' => [
				'DateTimeOriginal' => '2025:02:15 15:26:30',
				'OffsetTimeOriginal' => $offset,
			],
		]);

		$this->assertSame(1739633190, $timestamp);
	}

	public static function invalid_capture_offsets(): array
	{
		return [
			'hour above range' => ['+24:00'],
			'minute above range' => ['-02:60'],
			'missing sign' => ['02:00'],
			'non-numeric' => ['UTC'],
		];
	}

	/** @dataProvider invalid_capture_dates */
	public function test_invalid_or_missing_capture_dates_are_not_indexed(array $data): void
	{
		$this->assertNull(capture_index::timestamp_from_data($data));
	}

	public static function invalid_capture_dates(): array
	{
		return [
			'missing EXIF group' => [[]],
			'missing date' => [['EXIF' => []]],
			'array value' => [['EXIF' => ['DateTimeOriginal' => ['2025:01:01 00:00:00']]]],
			'invalid calendar date' => [['EXIF' => ['DateTimeOriginal' => '2025:02:31 12:00:00']]],
			'invalid shape' => [['EXIF' => ['DateTimeOriginal' => '2025-02-15T15:26:30']]],
		];
	}

	public function test_serialized_metadata_is_strictly_validated(): void
	{
		$valid = json_encode(['EXIF' => ['DateTimeOriginal' => '2025:02:15 15:26:30']], JSON_THROW_ON_ERROR);

		$this->assertTrue(capture_index::serialized_is_valid($valid));
		$this->assertSame(1739633190, capture_index::timestamp_from_serialized($valid));
		$this->assertFalse(capture_index::serialized_is_valid('{broken'));
		$this->assertNull(capture_index::timestamp_from_serialized('{broken'));
		$this->assertFalse(capture_index::serialized_is_valid(''));
	}

	public function test_replace_rebuilds_one_index_row_without_duplicates(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->method('sql_in_set')->willReturn('exif_image_id IN (9)');
		$db->method('sql_build_array')->willReturn('(exif_image_id, exif_taken_time) VALUES (9, 1739633190)');
		$queries = [];
		$db->expects($this->exactly(2))->method('sql_query')->willReturnCallback(
			static function (string $sql) use (&$queries): string
			{
				$queries[] = $sql;

				return 'result';
			}
		);
		$index = new capture_index($db, 'gallery_exif_capture');
		$serialized = json_encode(
			['EXIF' => ['DateTimeOriginal' => '2025:02:15 15:26:30']],
			JSON_THROW_ON_ERROR
		);

		$this->assertTrue($index->replace(9, $serialized));
		$this->assertStringStartsWith('DELETE FROM gallery_exif_capture', $queries[0]);
		$this->assertStringStartsWith('INSERT INTO gallery_exif_capture', $queries[1]);
	}

	public function test_replace_removes_a_stale_row_when_capture_date_is_missing(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->method('sql_in_set')->willReturn('exif_image_id IN (9)');
		$db->expects($this->once())->method('sql_query')->with($this->stringStartsWith('DELETE FROM gallery_exif_capture'));
		$index = new capture_index($db, 'gallery_exif_capture');

		$this->assertFalse($index->replace(9, '{broken'));
	}

	public function test_addon_wires_sorting_lifecycle_and_resumable_sync(): void
	{
		$root = dirname(__DIR__);
		$listener = (string) file_get_contents($root . '/event/exif_listener.php');
		$services = (string) file_get_contents($root . '/config/services.yml');
		$migration = (string) file_get_contents($root . '/migrations/m4_capture_sort.php');
		$acp = (string) file_get_contents($root . '/acp/main_module.php');

		foreach ([
			'phpbbgallery.core.image.sort_options',
			'phpbbgallery.core.image.sort_labels',
			'phpbbgallery.core.upload.update_image_after',
			'phpbbgallery.acpimport.insert_image_after',
			'phpbbgallery.core.image_edit_after',
			'phpbbgallery.core.image.delete_images',
		] as $event)
		{
			$this->assertStringContainsString($event, $listener);
		}

		$this->assertStringContainsString('COALESCE(NULLIF(gallery_exif_sort.exif_taken_time, 0), image_time)', $listener);
		$this->assertStringContainsString("(string) \$event['sort_key'] === 'et'", $listener);
		$this->assertStringContainsString('phpbbgallery.exif.capture_sync:', $services);
		$this->assertStringContainsString("'exif_taken_time' => ['BINT', 0]", $migration);
		$this->assertStringContainsString('confirm_box(false', $acp);
		$this->assertStringContainsString('generate_link_hash(self::SYNC_HASH)', $acp);
	}
}
