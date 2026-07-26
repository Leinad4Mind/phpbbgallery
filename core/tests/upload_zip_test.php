<?php
// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound -- ZIP test doubles intentionally share this fixture.
/**
 * phpBB Gallery - Core Extension tests
 *
 * @package   phpbbgallery/core
 * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;

class upload_zip_test extends TestCase
{
	private string $temporary_directory;
	private int $archive_number = 0;

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		if (!class_exists('ZipArchive'))
		{
			$this->markTestSkipped('The ZipArchive extension is required.');
		}

		$this->temporary_directory = sys_get_temp_dir() . '/phpbbgallery_zip_' . uniqid('', true) . '/';
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
		$upload = $this->new_upload();

		$this->assertSame($expected, $this->invoke_upload($upload, 'validate_zip_path', [$path]));
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

	public function test_derives_limits_from_size_and_quota(): void
	{
		$upload = $this->new_upload();
		$upload->max_filesize = 1000;

		$limits = $this->invoke_upload($upload, 'get_zip_limits');
		$this->assertSame(100, $limits['image_count']);
		$this->assertSame(1200, $limits['entry_size']);
		$this->assertSame(120000, $limits['total_size']);
		$this->assertSame(1168576, $limits['archive_size']);
		$this->assertFalse($limits['quota_limited']);

		$upload->set_file_limit(3);
		$upload->uploaded_files = 1;
		$limits = $this->invoke_upload($upload, 'get_zip_limits');
		$this->assertSame(2, $limits['image_count']);
		$this->assertSame(2400, $limits['total_size']);
		$this->assertTrue($limits['quota_limited']);

		$upload->uploaded_files = 3;
		$limits = $this->invoke_upload($upload, 'get_zip_limits');
		$this->assertSame(0, $limits['image_count']);
		$this->assertSame(1200, $limits['total_size']);
	}

	public function test_extracts_enabled_images_and_ignores_other_files(): void
	{
		$upload = $this->new_upload();
		$image = $this->png_image();
		$archive = $this->create_archive([
			'album/photo.png' => $image,
			'album/readme.txt' => 'not an image',
		]);
		$target = $this->create_target_directory('valid');

		$this->assertTrue($this->invoke_upload($upload, 'extract_zip', [$archive, $target]));
		$this->assertSame(['image_0.png'], $this->directory_files($target));
		$this->assertSame($image, file_get_contents($target . 'image_0.png'));

		$file_data = $this->get_upload_property($upload, 'zip_file_data');
		$this->assertSame('image/png', $file_data[$target . 'image_0.png']['type']);
		$this->assertSame(strlen($image), $file_data[$target . 'image_0.png']['size']);
		$this->assertSame('photo.png', $file_data[$target . 'image_0.png']['realname']);
	}

	public function test_rejects_archive_without_enabled_images(): void
	{
		$upload = $this->new_upload();
		$archive = $this->create_archive(['readme.txt' => 'nothing to extract']);
		$target = $this->create_target_directory('empty');

		$this->assertFalse($this->invoke_upload($upload, 'extract_zip', [$archive, $target]));
		$this->assert_has_error($upload, 'ZIP_NO_IMAGES');
	}

	public function test_rejects_image_whose_content_does_not_match_its_extension(): void
	{
		$upload = $this->new_upload();
		$archive = $this->create_archive(['disguised.jpg' => $this->png_image()]);
		$target = $this->create_target_directory('disguised');

		$this->assertFalse($this->invoke_upload($upload, 'extract_zip', [$archive, $target]));
		$this->assert_has_error($upload, 'ZIP_INVALID_IMAGE_TYPE');
		$this->assertSame([], $this->directory_files($target));
	}

	public function test_rejects_non_image_with_an_enabled_extension(): void
	{
		$upload = $this->new_upload();
		$archive = $this->create_archive(['fake.png' => 'plain text']);
		$target = $this->create_target_directory('non_image');

		$this->assertFalse($this->invoke_upload($upload, 'extract_zip', [$archive, $target]));
		$this->assert_has_error($upload, 'ZIP_INVALID_IMAGE_TYPE');
		$this->assertSame([], $this->directory_files($target));
	}

	public function test_rejects_traversal_before_writing_files(): void
	{
		$upload = $this->new_upload();
		$archive = $this->create_archive(['../escape.png' => $this->png_image()]);
		$target = $this->create_target_directory('traversal');

		$this->assertFalse($this->invoke_upload($upload, 'extract_zip', [$archive, $target]));
		$this->assert_has_error($upload, 'ZIP_UNSAFE_PATH');
		$this->assertFalse(file_exists($this->temporary_directory . 'escape.png'));
		$this->assertSame([], $this->directory_files($target));
	}

	public function test_rejects_case_insensitive_duplicate_paths(): void
	{
		$upload = $this->new_upload();
		$archive = $this->create_archive([
			'Album/Photo.png' => $this->png_image(),
			'album/photo.PNG' => $this->png_image(),
		]);
		$target = $this->create_target_directory('duplicate');

		$this->assertFalse($this->invoke_upload($upload, 'extract_zip', [$archive, $target]));
		$this->assert_has_error($upload, 'ZIP_DUPLICATE_PATH');
		$this->assertSame([], $this->directory_files($target));
	}

	public function test_rejects_entry_above_the_configured_size_limit(): void
	{
		$upload = $this->new_upload();
		$upload->max_filesize = 20;
		$archive = $this->create_archive(['large.png' => $this->png_image()]);
		$target = $this->create_target_directory('entry_size');

		$this->assertFalse($this->invoke_upload($upload, 'extract_zip', [$archive, $target]));
		$this->assert_has_error($upload, 'ZIP_SIZE_LIMIT_EXCEEDED');
	}

	public function test_rejects_archive_above_the_preflight_size_limit(): void
	{
		$upload = $this->new_upload();
		$upload->max_filesize = 1;
		$limits = $this->invoke_upload($upload, 'get_zip_limits');
		$archive = $this->temporary_directory . 'oversized.zip';
		file_put_contents($archive, str_repeat('x', $limits['archive_size'] + 1));
		$target = $this->create_target_directory('archive_size');

		$this->assertFalse($this->invoke_upload($upload, 'extract_zip', [$archive, $target]));
		$this->assert_has_error($upload, 'ZIP_SIZE_LIMIT_EXCEEDED');
	}

	public function test_rejects_excessive_compression_ratio(): void
	{
		$upload = $this->new_upload();
		$upload->max_filesize = 500000;
		$archive = $this->create_archive(['bomb.png' => str_repeat('A', 200000)]);
		$target = $this->create_target_directory('ratio');

		$this->assertFalse($this->invoke_upload($upload, 'extract_zip', [$archive, $target]));
		$this->assert_has_error($upload, 'ZIP_COMPRESSION_RATIO_EXCEEDED');
	}

	public function test_rejects_more_than_one_hundred_images(): void
	{
		$entries = [];
		for ($index = 0; $index < 101; $index++)
		{
			$entries['image_' . $index . '.png'] = $this->png_image();
		}

		$upload = $this->new_upload();
		$archive = $this->create_archive($entries);
		$target = $this->create_target_directory('image_count');

		$this->assertFalse($this->invoke_upload($upload, 'extract_zip', [$archive, $target]));
		$this->assert_has_error($upload, 'ZIP_TOO_MANY_IMAGES');
		$this->assertSame([], $this->directory_files($target));
	}

	public function test_rejects_more_than_one_thousand_entries(): void
	{
		$entries = [];
		for ($index = 0; $index < 1001; $index++)
		{
			$entries['entry_' . $index . '.txt'] = 'x';
		}

		$upload = $this->new_upload();
		$archive = $this->create_archive($entries);
		$target = $this->create_target_directory('entry_count');

		$this->assertFalse($this->invoke_upload($upload, 'extract_zip', [$archive, $target]));
		$this->assert_has_error($upload, 'ZIP_TOO_MANY_ENTRIES');
	}

	public function test_extracts_only_the_remaining_quota_and_reports_it(): void
	{
		$upload = $this->new_upload();
		$upload->set_file_limit(1);
		$archive = $this->create_archive([
			'first.png' => $this->png_image(),
			'second.png' => $this->png_image(),
		]);
		$target = $this->create_target_directory('quota');

		$this->assertTrue($this->invoke_upload($upload, 'extract_zip', [$archive, $target]));
		$this->assertSame(['image_0.png'], $this->directory_files($target));
		$this->assert_has_error($upload, 'USER_REACHED_QUOTA_SHORT');
	}

	public function test_verifies_crc_while_streaming_an_entry(): void
	{
		$upload = $this->new_upload();
		$archive = $this->create_archive(['image.png' => $this->png_image()]);
		$zip = new \ZipArchive();
		$this->assertTrue($zip->open($archive));
		$entry = $zip->statIndex(0);
		$entry['realname'] = 'image.png';
		$entry['extension'] = 'png';
		$entry['crc'] = $entry['crc'] ^ 1;
		$target = $this->temporary_directory . 'crc.png';

		$this->assertFalse($this->invoke_upload($upload, 'extract_zip_entry', [$zip, $entry, $target, 1000]));
		$zip->close();
		$this->assertFalse(file_exists($target));
		$this->assert_has_error($upload, 'ZIP_EXTRACTION_FAILED');
	}

	public function test_enforces_declared_size_while_streaming_an_entry(): void
	{
		$upload = $this->new_upload();
		$archive = $this->create_archive(['image.png' => $this->png_image()]);
		$zip = new \ZipArchive();
		$this->assertTrue($zip->open($archive));
		$entry = $zip->statIndex(0);
		$entry['realname'] = 'image.png';
		$entry['extension'] = 'png';
		$entry['size']--;
		$target = $this->temporary_directory . 'runtime_size.png';

		$this->assertFalse($this->invoke_upload($upload, 'extract_zip_entry', [$zip, $entry, $target, 1000]));
		$zip->close();
		$this->assertFalse(file_exists($target));
		$this->assert_has_error($upload, 'ZIP_EXTRACTION_FAILED');
	}

	public function test_upload_flow_loads_language_restores_extensions_and_cleans_files(): void
	{
		$archive = $this->create_archive(['photo.png' => $this->png_image()]);
		$subject = $this->new_upload(upload_test_subject::class);
		$zip_file = new upload_test_zip_file($archive);
		$this->set_upload_property($subject, 'zip_file', $zip_file);
		$temporary_path = $this->temporary_directory . 'tmp_successful-flow/';
		$subject->temporary_directory_path = $temporary_path;

		$this->assertTrue($subject->upload_zip());
		$this->assertTrue($subject->read_directory_existed);
		$this->assertSame(['image_0.png'], $subject->read_files);
		$this->assertFalse(file_exists($temporary_path));
		$this->assertFalse(file_exists($archive));
		$this->assertSame(1, $zip_file->remove_calls);
		$this->assertSame([
			['gallery_zip', 'phpbbgallery/core'],
		], $this->get_upload_property($subject, 'language')->loaded);
		$this->assert_extensions_were_restored($subject);
		$this->assertSame([], $this->get_upload_property($subject, 'zip_file_data'));
	}

	public function test_does_not_remove_a_preexisting_temporary_directory(): void
	{
		$archive = $this->create_archive(['photo.png' => $this->png_image()]);
		$subject = $this->new_upload(upload_test_subject::class);
		$this->set_upload_property($subject, 'zip_file', new upload_test_zip_file($archive));
		$temporary_path = $this->temporary_directory . 'tmp_existing-directory/';
		$subject->temporary_directory_path = $temporary_path;
		$this->assertTrue(mkdir($temporary_path, 0700));
		file_put_contents($temporary_path . 'marker.txt', 'keep');

		$this->assertFalse($subject->upload_zip());
		$this->assertSame('keep', file_get_contents($temporary_path . 'marker.txt'));
		$this->assert_has_error($subject, 'ZIP_EXTRACTION_FAILED');
		$this->assert_extensions_were_restored($subject);
	}

	public function test_cleans_and_restores_state_when_extraction_fails(): void
	{
		$archive = $this->create_archive(['readme.txt' => 'nothing to extract']);
		$subject = $this->new_upload(upload_test_subject::class);
		$zip_file = new upload_test_zip_file($archive);
		$this->set_upload_property($subject, 'zip_file', $zip_file);
		$temporary_path = $this->temporary_directory . 'tmp_failed-extraction/';
		$subject->temporary_directory_path = $temporary_path;

		$this->assertFalse($subject->upload_zip());
		$this->assertFalse(file_exists($temporary_path));
		$this->assertFalse(file_exists($archive));
		$this->assertSame(1, $zip_file->remove_calls);
		$this->assert_has_error($subject, 'ZIP_NO_IMAGES');
		$this->assert_extensions_were_restored($subject);
		$this->assertSame([], $this->get_upload_property($subject, 'zip_file_data'));
	}

	public function test_cleans_and_restores_state_when_archive_removal_throws(): void
	{
		$archive = $this->create_archive(['photo.png' => $this->png_image()]);
		$subject = $this->new_upload(upload_test_subject::class);
		$zip_file = new upload_test_zip_file($archive);
		$zip_file->throw_when_removed = true;
		$this->set_upload_property($subject, 'zip_file', $zip_file);
		$temporary_path = $this->temporary_directory . 'tmp_throwing-removal/';
		$subject->temporary_directory_path = $temporary_path;

		$exception = null;
		try
		{
			$subject->upload_zip();
		}
		catch (\RuntimeException $caught)
		{
			$exception = $caught;
		}

		$this->assertInstanceOf(\RuntimeException::class, $exception);
		$this->assertFalse(file_exists($temporary_path));
		$this->assert_extensions_were_restored($subject);
		$this->assertSame([], $this->get_upload_property($subject, 'zip_file_data'));
	}

	public function test_temporary_directory_names_use_random_tokens(): void
	{
		$upload = $this->new_upload();
		$first = $this->invoke_upload($upload, 'create_zip_temp_directory_path');
		$second = $this->invoke_upload($upload, 'create_zip_temp_directory_path');

		$this->assertMatchesRegularExpression('/\/tmp_[0-9a-f]{32}\/$/', $first);
		$this->assertMatchesRegularExpression('/\/tmp_[0-9a-f]{32}\/$/', $second);
		$this->assertNotSame($first, $second);
		$this->assertSame(0, preg_match('/(?<![a-zA-Z0-9_])md5\s*\(/', (string) file_get_contents(dirname(__DIR__) . '/upload.php')));
	}

	private function new_upload(string $class = \phpbbgallery\core\upload::class)
	{
		$reflection = new \ReflectionClass($class);
		$upload = $reflection->newInstanceWithoutConstructor();
		$this->set_upload_property($upload, 'language', new upload_test_language());
		$this->set_upload_property($upload, 'gallery_config', new upload_test_config());
		$this->set_upload_property($upload, 'gallery_url', new upload_test_url($this->temporary_directory));
		$this->set_upload_property($upload, 'file_upload', new upload_test_file_upload());
		$upload->max_filesize = 2097152;

		return $upload;
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

	private function invoke_upload($upload, string $method, array $arguments = [])
	{
		$reflection = new \ReflectionMethod(\phpbbgallery\core\upload::class, $method);
		$this->make_accessible($reflection);

		return $reflection->invokeArgs($upload, $arguments);
	}

	private function set_upload_property($upload, string $name, $value): void
	{
		$property = new \ReflectionProperty(\phpbbgallery\core\upload::class, $name);
		$this->make_accessible($property);
		$property->setValue($upload, $value);
	}

	private function get_upload_property($upload, string $name)
	{
		$property = new \ReflectionProperty(\phpbbgallery\core\upload::class, $name);
		$this->make_accessible($property);

		return $property->getValue($upload);
	}

	private function make_accessible($reflection): void
	{
		if (PHP_VERSION_ID < 80100)
		{
			$reflection->setAccessible(true);
		}
	}

	private function assert_has_error($upload, string $error): void
	{
		foreach ($upload->errors as $message)
		{
			if (strpos($message, $error) === 0)
			{
				$this->assertTrue(true);
				return;
			}
		}

		$this->fail('Expected error ' . $error . ', got: ' . implode(', ', $upload->errors));
	}

	private function assert_extensions_were_restored($upload): void
	{
		$file_upload = $this->get_upload_property($upload, 'file_upload');
		$this->assertCount(2, $file_upload->allowed_extensions);
		$this->assertSame(['jpg', 'jpeg', 'gif', 'png', 'webp'], $file_upload->allowed_extensions[0]);
		$this->assertSame(['jpg', 'jpeg', 'gif', 'png', 'webp', 'zip'], $file_upload->allowed_extensions[1]);
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

class upload_test_subject extends \phpbbgallery\core\upload
{
	/** @var bool */
	public $read_directory_existed = false;

	/** @var array */
	public $read_files = [];

	/** @var string */
	public $temporary_directory_path = '';

	protected function create_zip_temp_directory_path(): string
	{
		return $this->temporary_directory_path;
	}

	public function read_zip_folder(string $current_dir): void
	{
		$this->read_directory_existed = is_dir($current_dir);
		$this->read_files = array_values(array_diff(scandir($current_dir), ['.', '..']));
		sort($this->read_files);
	}
}

class upload_test_language
{
	/** @var array */
	public $loaded = [];

	public function add_lang(string $file, string $extension): void
	{
		$this->loaded[] = [$file, $extension];
	}

	public function lang(string $key)
	{
		$arguments = func_get_args();
		array_shift($arguments);

		return $key . (empty($arguments) ? '' : ':' . implode(',', $arguments));
	}
}

class upload_test_config
{
	/** @var array */
	private $values = [
		'allow_jpg' => true,
		'allow_gif' => true,
		'allow_png' => true,
		'allow_webp' => true,
		'allow_zip' => true,
	];

	public function get(string $key)
	{
		return isset($this->values[$key]) ? $this->values[$key] : null;
	}
}

class upload_test_url
{
	/** @var string */
	private $directory;

	public function __construct(string $directory)
	{
		$this->directory = $directory;
	}

	public function path(string $name): string
	{
		return $this->directory;
	}
}

class upload_test_file_upload
{
	/** @var array */
	public $allowed_extensions = [];

	public function set_allowed_extensions(array $extensions): void
	{
		$this->allowed_extensions[] = $extensions;
	}
}

class upload_test_zip_file
{
	/** @var array */
	public $error = [];

	/** @var bool */
	public $throw_when_removed = false;

	/** @var int */
	public $remove_calls = 0;

	/** @var string */
	private $path;

	public function __construct(string $path)
	{
		$this->path = $path;
	}

	public function clean_filename(string $mode): void
	{
	}

	public function move_file(string $destination, bool $overwrite, bool $skip_image_check, int $chmod): void
	{
	}

	public function get(string $name)
	{
		if ($name === 'destination_file')
		{
			return $this->path;
		}

		return basename($this->path);
	}

	public function remove(): void
	{
		$this->remove_calls++;
		if ($this->throw_when_removed)
		{
			throw new \RuntimeException('Removal failed.');
		}

		if (file_exists($this->path))
		{
			unlink($this->path);
		}
	}
}
