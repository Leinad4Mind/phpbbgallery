<?php
/**
 * phpBB Gallery - Export Extension
 *
 * @package   phpbbgallery/export
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

use PHPUnit\Framework\TestCase;
use phpbbgallery\export\archive;

class manifest_test extends TestCase
{
	private function row(array $overrides = []): array
	{
		return array_merge([
			'image_id' => 1042,
			'author_id' => 2,
			'album_id' => 1,
			'album_name' => 'Capas de Animação Oriental',
			'album_segments' => ['Capas de Animação Oriental'],
			'image_name' => 'Akira poster',
			'image_filename' => 'a3f0c9.jpg',
			'uploader' => 'Leinad4Mind',
			'image_time' => 1785109307,
			'image_view_count' => 42,
			'filesize_upload' => 204800,
			'description' => 'A poster.',
		], $overrides);
	}

	public function test_a_row_carries_the_path_the_archive_actually_used(): void
	{
		$manifest = archive::manifest_rows([$this->row()]);

		self::assertCount(1, $manifest);
		self::assertSame('Capas de Animação Oriental/1042_2_Akira poster.jpg', $manifest[0]['zip_path']);
		self::assertSame('a3f0c9.jpg', $manifest[0]['original_filename']);
		self::assertSame(1042, $manifest[0]['image_id']);
		self::assertSame(42, $manifest[0]['views']);
		self::assertSame(204800, $manifest[0]['filesize']);
	}

	public function test_stored_names_are_decoded_for_the_manifest(): void
	{
		$manifest = archive::manifest_rows([$this->row([
			'image_name' => 'Tom &amp; Jerry',
			'album_name' => 'Cartoons &amp; more',
			'uploader' => 'A &amp; B',
		])]);

		self::assertSame('Tom & Jerry', $manifest[0]['image_name']);
		self::assertSame('Cartoons & more', $manifest[0]['album_name']);
		self::assertSame('A & B', $manifest[0]['uploader']);
	}

	public function test_the_upload_time_is_iso_8601(): void
	{
		$manifest = archive::manifest_rows([$this->row(['image_time' => 0])]);

		self::assertSame('1970-01-01T00:00:00+00:00', $manifest[0]['uploaded_at']);
	}

	public function test_csv_starts_with_a_byte_order_mark_and_a_header(): void
	{
		$csv = archive::manifest_csv(archive::manifest_rows([$this->row()]));

		self::assertStringStartsWith("\xEF\xBB\xBF", $csv, 'spreadsheets need the mark to read accented names as UTF-8');
		self::assertStringContainsString('image_id,album_id,album_name,zip_path,image_name', $csv);
	}

	public function test_csv_escapes_separators_quotes_and_newlines(): void
	{
		$csv = archive::manifest_csv(archive::manifest_rows([$this->row([
			'image_name' => 'A, B',
			'album_name' => 'He said "hi"',
			'description' => "line one\nline two",
		])]));

		self::assertStringContainsString('"A, B"', $csv);
		self::assertStringContainsString('"He said ""hi"""', $csv);
		self::assertStringContainsString("\"line one\nline two\"", $csv);
	}

	public function test_csv_has_one_line_per_image(): void
	{
		$csv = archive::manifest_csv(archive::manifest_rows([
			$this->row(['image_id' => 1]),
			$this->row(['image_id' => 2]),
			$this->row(['image_id' => 3]),
		]));

		self::assertSame(4, substr_count($csv, "\n"), 'a header plus three rows');
	}

	public function test_json_carries_the_rows_under_the_export_metadata(): void
	{
		$json = archive::manifest_json(archive::manifest_rows([$this->row()]), [
			'generated_at' => '2026-07-27T14:30:00+00:00',
			'scope' => 'acp',
			'images' => 1,
		]);

		$decoded = json_decode($json, true);

		self::assertSame('acp', $decoded['export']['scope']);
		self::assertSame(1, $decoded['export']['images']);
		self::assertCount(1, $decoded['images']);
		self::assertSame('Capas de Animação Oriental/1042_2_Akira poster.jpg', $decoded['images'][0]['zip_path']);
	}

	public function test_json_keeps_accents_and_slashes_readable(): void
	{
		$json = archive::manifest_json(archive::manifest_rows([$this->row()]), []);

		self::assertStringContainsString('Animação', $json);
		self::assertStringNotContainsString('\\/', $json);
	}
}
