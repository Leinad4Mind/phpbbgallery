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

class filename_test extends TestCase
{
	public function test_reserved_characters_are_replaced_not_dropped(): void
	{
		self::assertSame('AC-DC', archive::sanitize_segment('AC/DC', 'album'));
		self::assertSame('a-b-c-d', archive::sanitize_segment('a:b*c?d', 'album'));
		self::assertSame('-etc-passwd', archive::sanitize_segment('/etc/passwd', 'album'));
	}

	public function test_directory_traversal_cannot_survive(): void
	{
		self::assertSame('album', archive::sanitize_segment('..', 'album'));
		self::assertSame('album', archive::sanitize_segment('.', 'album'));
		self::assertSame('album', archive::sanitize_segment('...', 'album'));
		// A traversal only becomes one through a separator, which is replaced.
		self::assertSame('..-..-..-etc', archive::sanitize_segment('../../../etc', 'album'));
	}

	public function test_control_characters_and_broken_encoding_are_refused(): void
	{
		self::assertSame('abc', archive::sanitize_segment("a\x00b\x1Fc", 'album'));
		self::assertSame('image', archive::sanitize_segment("\xC3\x28", 'image'));
	}

	public function test_trailing_dots_and_spaces_are_trimmed(): void
	{
		// Windows drops these silently, which would merge two distinct names.
		self::assertSame('holiday', archive::sanitize_segment('holiday...', 'image'));
		self::assertSame('holiday', archive::sanitize_segment('holiday   ', 'image'));
	}

	public function test_whitespace_is_collapsed(): void
	{
		self::assertSame('my holiday photo', archive::sanitize_segment("my \t holiday\n\nphoto", 'image'));
	}

	public function test_html_entities_are_decoded(): void
	{
		self::assertSame('Tom &amp; Jerry', 'Tom &amp; Jerry');
		self::assertSame('Tom & Jerry', archive::sanitize_segment('Tom &amp; Jerry', 'image'));
	}

	public function test_empty_result_falls_back(): void
	{
		self::assertSame('image', archive::sanitize_segment('', 'image'));
		self::assertSame('image', archive::sanitize_segment('   ', 'image'));
		self::assertSame('album_7', archive::sanitize_segment('///', 'album_7'));
	}

	public function test_segment_is_capped_in_bytes_on_a_character_boundary(): void
	{
		$segment = archive::sanitize_segment(str_repeat('á', 200), 'image');

		self::assertLessThanOrEqual(archive::MAX_SEGMENT_LENGTH, strlen($segment));
		self::assertSame(1, preg_match('//u', $segment), 'the truncated name is still valid UTF-8');
	}

	public function test_entry_path_restores_name_extension_and_album(): void
	{
		self::assertSame(
			'Capas de Animação Oriental/Akira poster_1042.jpg',
			archive::entry_path(['Capas de Animação Oriental'], 'Akira poster', 'a3f0c9deadbeef.jpg', 1042)
		);
	}

	public function test_entry_path_nests_subalbums(): void
	{
		self::assertSame(
			'Parent/Child/Ghost in the Shell_1051.png',
			archive::entry_path(['Parent', 'Child'], 'Ghost in the Shell', '0badc0ffee.png', 1051)
		);
	}

	public function test_entry_path_disambiguates_identical_names_by_id(): void
	{
		$first = archive::entry_path(['Album'], 'Poster', 'aaa.jpg', 1);
		$second = archive::entry_path(['Album'], 'Poster', 'bbb.jpg', 2);

		self::assertNotSame($first, $second);
		self::assertSame('Album/Poster_1.jpg', $first);
		self::assertSame('Album/Poster_2.jpg', $second);
	}

	public function test_entry_path_leaves_room_for_the_suffix(): void
	{
		$path = archive::entry_path([], str_repeat('a', 400), 'x.webp', 999999);
		$name = basename($path);

		self::assertLessThanOrEqual(archive::MAX_SEGMENT_LENGTH, strlen($name));
		self::assertStringEndsWith('_999999.webp', $name);
	}

	public function test_entry_path_without_a_known_extension(): void
	{
		self::assertSame('Album/Poster_5', archive::entry_path(['Album'], 'Poster', 'no-extension-here', 5));
	}

	public function test_slug_transliterates_and_lowercases(): void
	{
		self::assertSame('capas-de-animacao-oriental', archive::slug('Capas de Animação Oriental'));
		self::assertSame('grusse-aus-koln', archive::slug('Grüße aus Köln'));
		self::assertSame('', archive::slug('!!!'));
	}

	public function test_server_archive_name_is_readable_and_dated(): void
	{
		$timestamp = gmmktime(14, 30, 0, 7, 27, 2026);

		self::assertSame('gallery-export-ferias-2026-07-27-1430.zip', archive::server_archive_name('Férias', $timestamp));
		self::assertSame('gallery-export-2026-07-27-1430.zip', archive::server_archive_name('', $timestamp));
	}

	public function test_generated_archive_names_are_accepted_by_the_storage(): void
	{
		$storage = new \phpbbgallery\export\job_storage(sys_get_temp_dir());

		self::assertTrue($storage->is_valid_archive_name(archive::server_archive_name('Capas de Animação Oriental', time())));
		self::assertTrue($storage->is_valid_archive_name(archive::download_archive_name(str_repeat('a', 32))));
	}
}
