<?php
// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound -- ZIP test doubles intentionally share this fixture.
/**
 * phpBB Gallery - ACP Import Extension tests
 *
 * @package   phpbbgallery/acpimport
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\acpimport\tests;

use PHPUnit\Framework\TestCase;
use phpbbgallery\acpimport\acp\archive_importer;
use phpbbgallery\acpimport\acp\import_storage;
use phpbbgallery\core\zip\extractor;

class zip_import_test extends TestCase
{
	private string $directory;
	private import_storage $storage;
	private int $archive_number = 0;

	private const ALLOWED = ['jpg', 'jpeg', 'gif', 'png', 'webp'];

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		if (!class_exists('ZipArchive'))
		{
			$this->markTestSkipped('The ZipArchive extension is required.');
		}

		$this->directory = sys_get_temp_dir() . '/phpbbgallery_zipimport_' . uniqid('', true) . '/';
		$this->assertTrue(mkdir($this->directory, 0700));
		$this->storage = new import_storage($this->directory);
	}

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function tearDown(): void
	{
		$this->remove_directory($this->directory);
	}

	public function test_lists_only_direct_child_archives(): void
	{
		$this->create_archive('holiday.zip', ['photo.png' => $this->png_image()]);
		file_put_contents($this->directory . 'notes.txt', 'text');
		file_put_contents($this->directory . 'photo.png', $this->png_image());
		$this->assertTrue(mkdir($this->directory . 'tmp_abcdef', 0700));
		$this->create_archive('tmp_abcdef/nested.zip', ['photo.png' => $this->png_image()]);

		$this->assertSame(['holiday.zip'], array_keys($this->storage->get_archives()));
	}

	public function test_listing_archives_does_not_disturb_the_unreadable_count(): void
	{
		$this->create_archive('holiday.zip', ['photo.png' => $this->png_image()]);
		file_put_contents($this->directory . 'photo.png', $this->png_image());

		$this->storage->get_images(self::ALLOWED);
		$before = $this->storage->get_ignored_unreadable_files();
		$this->storage->get_archives();

		$this->assertSame($before, $this->storage->get_ignored_unreadable_files());
	}

	public function test_reserved_names_are_flattened_to_a_direct_child(): void
	{
		// Both get_images() and copy_image() only ever accept a direct child.
		$this->assertSame('photo.png', $this->storage->reserve_extracted_name('album/photo.png'));
		$this->assertSame('photo.png', $this->storage->reserve_extracted_name('album\\photo.png'));
		$this->assertSame('photo.png', $this->storage->reserve_extracted_name('a/b/c/photo.png'));
	}

	public function test_reserved_names_avoid_files_already_in_the_folder(): void
	{
		// A display-name collision makes get_images() drop *both* files, so this is
		// about not losing images rather than about tidiness.
		file_put_contents($this->directory . 'photo.png', $this->png_image());

		$this->assertSame('photo_1.png', $this->storage->reserve_extracted_name('photo.png'));
	}

	public function test_reserved_names_avoid_each_other(): void
	{
		$first = $this->storage->reserve_extracted_name('photo.png');
		$second = $this->storage->reserve_extracted_name('photo.png', [$first => true]);
		$third = $this->storage->reserve_extracted_name('photo.png', [$first => true, $second => true]);

		$this->assertSame(['photo.png', 'photo_1.png', 'photo_2.png'], [$first, $second, $third]);
	}

	public function test_reserved_names_never_hide_a_file(): void
	{
		// A leading dot would hide the file and collide with the state-file namespace.
		$this->assertSame('hidden.png', $this->storage->reserve_extracted_name('.hidden.png'));
		$this->assertFalse($this->storage->reserve_extracted_name('.png'));
		$this->assertFalse($this->storage->reserve_extracted_name('noextension'));
		$this->assertFalse($this->storage->reserve_extracted_name(''));
	}

	public function test_extracting_places_readable_names_in_the_import_folder(): void
	{
		$archive = $this->create_archive('holiday.zip', [
			'album/Akira poster.png' => $this->png_image(),
			'album/nested/sunset.jpg' => $this->jpeg_image(),
			'album/readme.txt' => 'skipped',
		]);

		$this->assertSame(2, $this->new_importer()->extract($archive, self::ALLOWED, 1000, 2097152));

		$this->assertSame(
			['Akira poster.png', 'sunset.jpg'],
			array_keys($this->storage->get_images(self::ALLOWED))
		);
	}

	public function test_the_extracted_images_are_importable_like_hand_uploaded_ones(): void
	{
		$archive = $this->create_archive('holiday.zip', ['album/photo.png' => $this->png_image()]);
		$this->new_importer()->extract($archive, self::ALLOWED, 1000, 2097152);

		$images = $this->storage->get_images(self::ALLOWED);
		$this->assertArrayHasKey('photo.png', $images);
		// This is the handover: the untouched import path reads these the same way.
		$this->assertSame('', $this->storage->inspect_image($images['photo.png'])['error']);
	}

	public function test_duplicate_basenames_from_different_folders_both_survive(): void
	{
		$archive = $this->create_archive('holiday.zip', [
			'one/photo.png' => $this->png_image(),
			'two/photo.png' => $this->png_image(),
		]);

		$this->assertSame(2, $this->new_importer()->extract($archive, self::ALLOWED, 1000, 2097152));
		$this->assertSame(['photo.png', 'photo_1.png'], array_keys($this->storage->get_images(self::ALLOWED)));
	}

	public function test_extracting_does_not_overwrite_an_existing_import_file(): void
	{
		file_put_contents($this->directory . 'photo.png', 'existing');
		$archive = $this->create_archive('holiday.zip', ['photo.png' => $this->png_image()]);

		$this->assertSame(1, $this->new_importer()->extract($archive, self::ALLOWED, 1000, 2097152));
		$this->assertSame('existing', file_get_contents($this->directory . 'photo.png'));
		$this->assertFileExists($this->directory . 'photo_1.png');
	}

	public function test_a_refused_archive_leaves_the_import_folder_untouched(): void
	{
		$archive = $this->create_archive('evil.zip', ['../escape.png' => $this->png_image()]);

		$this->assertFalse($this->new_importer()->extract($archive, self::ALLOWED, 1000, 2097152));
		$this->assertSame([], $this->storage->get_images(self::ALLOWED));
		$this->assertFileExists($archive['path'], 'a failed archive is kept so the admin can look at it');
		$this->assertFalse(file_exists($this->directory . 'escape.png'));
	}

	public function test_an_archive_over_the_cap_is_refused_rather_than_truncated(): void
	{
		$entries = [];
		for ($index = 0; $index < 6; $index++)
		{
			$entries['photo_' . $index . '.png'] = $this->png_image();
		}
		$archive = $this->create_archive('many.zip', $entries);

		$this->assertFalse($this->new_importer()->extract($archive, self::ALLOWED, 5, 2097152));
		$this->assertSame([], $this->storage->get_images(self::ALLOWED), 'nothing is half-imported');
	}

	public function test_a_file_that_is_not_an_archive_is_refused(): void
	{
		$archive = $this->directory . 'broken.zip';
		file_put_contents($archive, 'this is not a zip file');

		$importer = $this->new_importer();
		$this->assertFalse($importer->extract(['path' => $archive], self::ALLOWED, 1000, 2097152));
		$this->assertNotSame([], $importer->errors());
	}

	public function test_no_temporary_directory_is_left_behind(): void
	{
		$archive = $this->create_archive('holiday.zip', ['photo.png' => $this->png_image()]);
		$this->new_importer()->extract($archive, self::ALLOWED, 1000, 2097152);

		foreach (array_diff((array) scandir($this->directory), ['.', '..']) as $entry)
		{
			$this->assertStringStartsNotWith('tmp_', $entry);
		}
	}

	public function test_a_failed_archive_leaves_no_temporary_directory_either(): void
	{
		$archive = $this->create_archive('evil.zip', ['../escape.png' => $this->png_image()]);
		$this->new_importer()->extract($archive, self::ALLOWED, 1000, 2097152);

		foreach (array_diff((array) scandir($this->directory), ['.', '..']) as $entry)
		{
			$this->assertStringStartsNotWith('tmp_', $entry);
		}
	}

	private function new_importer(): archive_importer
	{
		return new archive_importer($this->storage, $this->new_extractor(), new zip_import_test_language(), $this->directory);
	}

	private function new_extractor(): extractor
	{
		$reflection = new \ReflectionClass(extractor::class);
		$extractor = $reflection->newInstanceWithoutConstructor();

		$property = $reflection->getProperty('language');
		if (PHP_VERSION_ID < 80100)
		{
		}
		$property->setValue($extractor, new zip_import_test_language());

		return $extractor;
	}

	/**
	 * @return array The archive entry as import_storage::get_archives() reports it
	 */
	private function create_archive(string $name, array $entries): array
	{
		$path = $this->directory . $name;
		$zip = new \ZipArchive();
		$this->assertTrue($zip->open($path, \ZipArchive::CREATE | \ZipArchive::OVERWRITE));
		foreach ($entries as $entry_name => $contents)
		{
			$this->assertTrue($zip->addFromString($entry_name, $contents));
		}
		$this->assertTrue($zip->close());
		$this->archive_number++;

		return ['display_name' => basename($name), 'filename' => basename($name), 'path' => realpath($path)];
	}

	private function png_image(): string
	{
		return base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=');
	}

	private function jpeg_image(): string
	{
		return base64_decode('/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/wAALCAABAAEBAREA/8QAFAABAAAAAAAAAAAAAAAAAAAACf/EABQQAQAAAAAAAAAAAAAAAAAAAAD/2gAIAQEAAD8AKp//2Q==');
	}

	private function remove_directory(string $directory): void
	{
		if (!is_dir($directory))
		{
			return;
		}

		foreach (array_diff((array) scandir($directory), ['.', '..']) as $name)
		{
			$path = $directory . $name;
			if (is_dir($path) && !is_link($path))
			{
				$this->remove_directory($path . '/');
			}
			else
			{
				@unlink($path);
			}
		}

		@rmdir($directory);
	}
}

class zip_import_test_language
{
	public function lang(string $key)
	{
		return $key;
	}
}
