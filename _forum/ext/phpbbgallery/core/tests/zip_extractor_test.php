<?php
// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound -- ZIP test doubles intentionally share this fixture.
/**
 * phpBB Gallery - Core Extension tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;
use phpbbgallery\core\zip\extractor;

class zip_extractor_test extends TestCase
{
	private string $temporary_directory;
	private int $archive_number = 0;

	/** Every extension the gallery ever enables, so the tests bound themselves instead. */
	private const ALLOWED = ['jpg', 'jpeg', 'gif', 'png', 'webp', 'avif'];

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		if (!class_exists('ZipArchive'))
		{
			$this->markTestSkipped('The ZipArchive extension is required.');
		}

		$this->temporary_directory = sys_get_temp_dir() . '/phpbbgallery_extractor_' . uniqid('', true) . '/';
		$this->assertTrue(mkdir($this->temporary_directory, 0700));
	}

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function tearDown(): void
	{
		$this->remove_directory($this->temporary_directory);
	}

	/**
	 * @dataProvider zip_path_provider
	 */
	public function test_validates_archive_paths(string $path, mixed $expected): void
	{
		$this->assertSame($expected, $this->new_extractor()->validate_path($path));
	}

	public static function zip_path_provider(): array
	{
		return [
			['image.png', 'image.png'],
			['album/image.png', 'album/image.png'],
			['álbum/imagem.png', 'álbum/imagem.png'],
			['album\\image.png', 'album/image.png'],
			['album/', 'album/'],
			['', false],
			['/absolute.png', false],
			['C:\\absolute.png', false],
			['\\\\server\\share.png', false],
			['../escape.png', false],
			['album/../escape.png', false],
			['./image.png', false],
			['album//image.png', false],
			['bad' . chr(0) . '.png', false],
			['bad' . chr(31) . '.png', false],
			['bad?.png', false],
			['trailing./image.png', false],
			['CON.png', false],
			['aux/file.png', false],
			[str_repeat('a', 256) . '.png', false],
			[str_repeat('a', 4097), false],
		];
	}

	public function test_limits_scale_with_the_allowance_and_file_size(): void
	{
		$limits = extractor::limits(100, 1000);
		$this->assertSame(100, $limits['image_count']);
		$this->assertSame(1200, $limits['entry_size']);
		$this->assertSame(120000, $limits['total_size']);
		$this->assertSame(1168576, $limits['archive_size']);
		$this->assertFalse($limits['quota_limited']);

		$limits = extractor::limits(2, 1000, true);
		$this->assertSame(2, $limits['image_count']);
		$this->assertSame(2400, $limits['total_size']);
		$this->assertTrue($limits['quota_limited']);

		// A zero allowance still reports a usable entry size, so the caller can
		// distinguish "nothing allowed" from "misconfigured".
		$limits = extractor::limits(0, 1000);
		$this->assertSame(0, $limits['image_count']);
		$this->assertSame(1200, $limits['total_size']);
	}

	public function test_limits_never_exceed_the_absolute_ceiling(): void
	{
		// A 500 MB per-file setting and a raised image allowance would otherwise
		// authorise gigabytes of extraction.
		$limits = extractor::limits(1000, 500000000);

		$this->assertSame(extractor::MAX_UNCOMPRESSED_SIZE, $limits['entry_size']);
		$this->assertSame(extractor::MAX_UNCOMPRESSED_SIZE, $limits['total_size']);
		$this->assertSame(extractor::MAX_UNCOMPRESSED_SIZE, $limits['archive_size']);
	}

	public function test_extracts_enabled_images_and_ignores_other_files(): void
	{
		$extractor = $this->new_extractor();
		$image = $this->png_image();
		$archive = $this->create_archive([
			'album/photo.png' => $image,
			'album/readme.txt' => 'not an image',
		]);
		$target = $this->create_target_directory('valid');

		$this->assertTrue($this->extract($extractor, $archive, $target));
		$this->assertSame(['image_0.png'], $this->directory_files($target));
		$this->assertSame($image, file_get_contents($target . 'image_0.png'));

		$files = $extractor->get_files();
		$this->assertSame('image/png', $files[$target . 'image_0.png']['type']);
		$this->assertSame(strlen($image), $files[$target . 'image_0.png']['size']);
		$this->assertSame('photo.png', $files[$target . 'image_0.png']['realname']);
	}

	public function test_extracts_an_avif_whose_content_matches_its_extension(): void
	{
		if (!\phpbbgallery\core\file\file::supports_avif())
		{
			$this->markTestSkipped('This PHP/GD build does not support safe AVIF processing.');
		}

		$extractor = $this->new_extractor();
		$image = $this->avif_image();
		$archive = $this->create_archive(['photo.avif' => $image]);
		$target = $this->create_target_directory('avif');

		$this->assertTrue($this->extract($extractor, $archive, $target));
		$this->assertSame(['image_0.avif'], $this->directory_files($target));
		$this->assertSame('image/avif', $extractor->get_files()[$target . 'image_0.avif']['type']);
	}

	public function test_the_caller_names_the_extracted_files(): void
	{
		// The ACP import relies on this to land readable, deduplicated names in the
		// import folder rather than the upload's generated image_N.ext.
		$extractor = $this->new_extractor();
		$archive = $this->create_archive([
			'album/holiday.png' => $this->png_image(),
			'other/sunset.png' => $this->png_image(),
		]);
		$target = $this->create_target_directory('named');

		$this->assertTrue($extractor->extract($archive, $target, self::ALLOWED, $this->limits(), static function (array $entry): string {
			return $entry['realname'];
		}));

		$this->assertSame(['holiday.png', 'sunset.png'], $this->directory_files($target));
	}

	public function test_a_namer_can_skip_an_entry(): void
	{
		$extractor = $this->new_extractor();
		$archive = $this->create_archive([
			'keep.png' => $this->png_image(),
			'skip.png' => $this->png_image(),
		]);
		$target = $this->create_target_directory('skipped');

		$this->assertTrue($extractor->extract($archive, $target, self::ALLOWED, $this->limits(), static function (array $entry): string|false {
			return $entry['realname'] === 'skip.png' ? false : $entry['realname'];
		}));

		$this->assertSame(['keep.png'], $this->directory_files($target));
		$this->assertCount(1, $extractor->get_files());
	}

	public function test_rejects_archive_without_enabled_images(): void
	{
		$extractor = $this->new_extractor();
		$archive = $this->create_archive(['readme.txt' => 'nothing to extract']);
		$target = $this->create_target_directory('empty');

		$this->assertFalse($this->extract($extractor, $archive, $target));
		$this->assert_has_error($extractor, 'ZIP_NO_IMAGES');
	}

	public function test_rejects_image_whose_content_does_not_match_its_extension(): void
	{
		$extractor = $this->new_extractor();
		$archive = $this->create_archive(['disguised.jpg' => $this->png_image()]);
		$target = $this->create_target_directory('disguised');

		$this->assertFalse($this->extract($extractor, $archive, $target));
		$this->assert_has_error($extractor, 'ZIP_INVALID_IMAGE_TYPE');
		$this->assertSame([], $this->directory_files($target));
	}

	public function test_rejects_non_image_with_an_enabled_extension(): void
	{
		$extractor = $this->new_extractor();
		$archive = $this->create_archive(['fake.png' => 'plain text']);
		$target = $this->create_target_directory('non_image');

		$this->assertFalse($this->extract($extractor, $archive, $target));
		$this->assert_has_error($extractor, 'ZIP_INVALID_IMAGE_TYPE');
		$this->assertSame([], $this->directory_files($target));
	}

	public function test_rejects_traversal_before_writing_files(): void
	{
		$extractor = $this->new_extractor();
		$archive = $this->create_archive(['../escape.png' => $this->png_image()]);
		$target = $this->create_target_directory('traversal');

		$this->assertFalse($this->extract($extractor, $archive, $target));
		$this->assert_has_error($extractor, 'ZIP_UNSAFE_PATH');
		$this->assertFalse(file_exists($this->temporary_directory . 'escape.png'));
		$this->assertSame([], $this->directory_files($target));
	}

	public function test_rejects_case_insensitive_duplicate_paths(): void
	{
		$extractor = $this->new_extractor();
		$archive = $this->create_archive([
			'Album/Photo.png' => $this->png_image(),
			'album/photo.PNG' => $this->png_image(),
		]);
		$target = $this->create_target_directory('duplicate');

		$this->assertFalse($this->extract($extractor, $archive, $target));
		$this->assert_has_error($extractor, 'ZIP_DUPLICATE_PATH');
		$this->assertSame([], $this->directory_files($target));
	}

	public function test_rejects_entry_above_the_configured_size_limit(): void
	{
		$extractor = $this->new_extractor();
		$archive = $this->create_archive(['large.png' => $this->png_image()]);
		$target = $this->create_target_directory('entry_size');

		$this->assertFalse($this->extract($extractor, $archive, $target, extractor::limits(100, 20)));
		$this->assert_has_error($extractor, 'ZIP_SIZE_LIMIT_EXCEEDED');
	}

	public function test_rejects_archive_above_the_preflight_size_limit(): void
	{
		$extractor = $this->new_extractor();
		$limits = extractor::limits(100, 1);
		$archive = $this->temporary_directory . 'oversized.zip';
		file_put_contents($archive, str_repeat('x', $limits['archive_size'] + 1));
		$target = $this->create_target_directory('archive_size');

		$this->assertFalse($this->extract($extractor, $archive, $target, $limits));
		$this->assert_has_error($extractor, 'ZIP_SIZE_LIMIT_EXCEEDED');
	}

	public function test_rejects_excessive_compression_ratio(): void
	{
		$extractor = $this->new_extractor();
		$archive = $this->create_archive(['bomb.png' => str_repeat('A', 200000)]);
		$target = $this->create_target_directory('ratio');

		$this->assertFalse($this->extract($extractor, $archive, $target, extractor::limits(100, 500000)));
		$this->assert_has_error($extractor, 'ZIP_COMPRESSION_RATIO_EXCEEDED');
	}

	public function test_rejects_more_images_than_the_allowance(): void
	{
		$entries = [];
		for ($index = 0; $index < 101; $index++)
		{
			$entries['image_' . $index . '.png'] = $this->png_image();
		}

		$extractor = $this->new_extractor();
		$archive = $this->create_archive($entries);
		$target = $this->create_target_directory('image_count');

		$this->assertFalse($this->extract($extractor, $archive, $target, extractor::limits(100, 2097152)));
		$this->assert_has_error($extractor, 'ZIP_TOO_MANY_IMAGES');
		$this->assertSame([], $this->directory_files($target));
	}

	public function test_a_raised_allowance_accepts_a_larger_archive(): void
	{
		// The ACP import raises the cap well above the front-end's 100.
		$entries = [];
		for ($index = 0; $index < 101; $index++)
		{
			$entries['image_' . $index . '.png'] = $this->png_image();
		}

		$extractor = $this->new_extractor();
		$archive = $this->create_archive($entries);
		$target = $this->create_target_directory('raised_allowance');

		$this->assertTrue($this->extract($extractor, $archive, $target, extractor::limits(1000, 2097152)));
		$this->assertCount(101, $this->directory_files($target));
	}

	public function test_rejects_more_than_one_thousand_entries(): void
	{
		$entries = [];
		for ($index = 0; $index < 1001; $index++)
		{
			$entries['entry_' . $index . '.txt'] = 'x';
		}

		$extractor = $this->new_extractor();
		$archive = $this->create_archive($entries);
		$target = $this->create_target_directory('entry_count');

		$this->assertFalse($this->extract($extractor, $archive, $target));
		$this->assert_has_error($extractor, 'ZIP_TOO_MANY_ENTRIES');
	}

	public function test_extracts_only_the_remaining_quota_and_reports_it(): void
	{
		$extractor = $this->new_extractor();
		$archive = $this->create_archive([
			'first.png' => $this->png_image(),
			'second.png' => $this->png_image(),
		]);
		$target = $this->create_target_directory('quota');

		$this->assertTrue($this->extract($extractor, $archive, $target, extractor::limits(1, 2097152, true)));
		$this->assertSame(['image_0.png'], $this->directory_files($target));
		$this->assertTrue($extractor->quota_reached());
		$this->assertSame([], $extractor->errors(), 'a reached quota is not an error, the caller decides how to report it');
	}

	public function test_an_exhausted_allowance_stops_before_the_archive_is_opened(): void
	{
		$extractor = $this->new_extractor();
		$archive = $this->create_archive(['first.png' => $this->png_image()]);
		$target = $this->create_target_directory('exhausted');

		$this->assertFalse($this->extract($extractor, $archive, $target, extractor::limits(0, 2097152, true)));
		$this->assertTrue($extractor->quota_reached());
		$this->assertSame([], $this->directory_files($target));
	}

	public function test_verifies_crc_while_streaming_an_entry(): void
	{
		$extractor = $this->new_extractor();
		$archive = $this->create_archive(['image.png' => $this->png_image()]);
		$target = $this->create_target_directory('crc');

		// Corrupt the stored bytes without touching the central directory, so only a
		// running checksum can notice.
		$this->corrupt_archive_payload($archive);

		$this->assertFalse($this->extract($extractor, $archive, $target));
		$this->assert_has_error($extractor, 'ZIP_EXTRACTION_FAILED');
		$this->assertSame([], $this->directory_files($target));
	}

	public function test_state_is_reset_between_extractions(): void
	{
		$extractor = $this->new_extractor();
		$failing = $this->create_archive(['readme.txt' => 'nothing to extract']);
		$this->assertFalse($this->extract($extractor, $failing, $this->create_target_directory('first_run')));
		$this->assertNotSame([], $extractor->errors());

		$archive = $this->create_archive(['photo.png' => $this->png_image()]);
		$this->assertTrue($this->extract($extractor, $archive, $this->create_target_directory('second_run')));
		$this->assertSame([], $extractor->errors());
		$this->assertFalse($extractor->quota_reached());
		$this->assertCount(1, $extractor->get_files());
	}

	private function extract(extractor $extractor, string $archive, string $target, ?array $limits = null): bool
	{
		return $extractor->extract($archive, $target, self::ALLOWED, $limits ?? $this->limits(), static function (array $entry, int $index): string {
			return 'image_' . $index . '.' . $entry['extension'];
		});
	}

	private function limits(): array
	{
		return extractor::limits(extractor::MAX_IMAGES, 2097152);
	}

	private function new_extractor(): extractor
	{
		$reflection = new \ReflectionClass(extractor::class);
		$extractor = $reflection->newInstanceWithoutConstructor();

		$property = $reflection->getProperty('language');
		if (PHP_VERSION_ID < 80100)
		{
		}
		$property->setValue($extractor, new zip_test_language());

		return $extractor;
	}

	/**
	 * Flip a byte in the compressed payload, leaving the index intact.
	 */
	private function corrupt_archive_payload(string $archive): void
	{
		$contents = file_get_contents($archive);
		$offset = 40;
		$contents[$offset] = chr(ord($contents[$offset]) ^ 0xFF);
		file_put_contents($archive, $contents);
	}

	private function create_archive(array $entries): string
	{
		$path = $this->temporary_directory . 'archive_' . $this->archive_number++ . '.zip';
		$zip = new \ZipArchive();
		$this->assertTrue($zip->open($path, \ZipArchive::CREATE | \ZipArchive::OVERWRITE));
		foreach ($entries as $name => $contents)
		{
			$this->assertTrue($zip->addFromString($name, $contents));
		}
		$this->assertTrue($zip->close());

		return $path;
	}

	private function create_target_directory(string $name): string
	{
		$path = $this->temporary_directory . $name . '/';
		$this->assertTrue(mkdir($path, 0700));

		return $path;
	}

	private function png_image(): string
	{
		return base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=');
	}

	private function avif_image(): string
	{
		$image = imagecreatetruecolor(2, 2);
		ob_start();
		$this->assertTrue(imageavif($image, null, 60));
		$contents = (string) ob_get_clean();
		$image = null;
		$this->assertNotSame('', $contents);

		return $contents;
	}

	private function assert_has_error(extractor $extractor, string $error): void
	{
		foreach ($extractor->errors() as $message)
		{
			if (strpos($message, $error) === 0)
			{
				$this->assertTrue(true);
				return;
			}
		}

		$this->fail('Expected error ' . $error . ', got: ' . implode(', ', $extractor->errors()));
	}

	private function directory_files(string $directory): array
	{
		$files = array_values(array_diff(scandir($directory), ['.', '..']));
		sort($files);

		return $files;
	}

	private function remove_directory(string $directory): void
	{
		if (!is_dir($directory))
		{
			return;
		}

		foreach (array_diff(scandir($directory), ['.', '..']) as $name)
		{
			$path = $directory . $name;
			if (is_dir($path) && !is_link($path))
			{
				$this->remove_directory($path . '/');
			}
			else
			{
				unlink($path);
			}
		}

		rmdir($directory);
	}
}

class zip_test_language
{
	public function lang(string $key)
	{
		$arguments = func_get_args();
		array_shift($arguments);

		return $key . (empty($arguments) ? '' : ':' . implode(',', $arguments));
	}
}
