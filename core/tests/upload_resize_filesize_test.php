<?php
// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound -- Test doubles share this focused fixture.
/**
 * phpBB Gallery - Resized upload file-size tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core
{
	function utf8_substr(string $value, int $offset, ?int $length = null): string
	{
		return $length === null ? substr($value, $offset) : substr($value, $offset, $length);
	}

	function utf8_strrpos(string $value, string $search): int|false
	{
		return strrpos($value, $search);
	}

	function utf8_clean_string(string $value): string
	{
		return strtolower($value);
	}
}

namespace phpbbgallery\core\tests
{

use phpbbgallery\core\file\file;
use phpbbgallery\core\upload;
use PHPUnit\Framework\TestCase;

final class upload_resize_filesize_test extends TestCase
{
	public function test_source_limit_equals_stored_limit_when_resize_is_disabled(): void
	{
		$this->assertSame(512000, $this->calculate_source_limit(512000, false));
	}

	public function test_source_limit_scales_with_a_sixty_four_mebibyte_absolute_cap(): void
	{
		$this->assertSame(16384000, $this->calculate_source_limit(512000, true));
		$this->assertSame(67108864, $this->calculate_source_limit(4194304, true));
		$this->assertSame(134217728, $this->calculate_source_limit(134217728, true));
	}

	public function test_setup_applies_the_source_limit_to_phpbb_uploads(): void
	{
		$upload = (new \ReflectionClass(upload::class))->newInstanceWithoutConstructor();
		$file_upload = new resize_test_file_upload();
		$this->set_property($upload, 'file_upload', $file_upload);
		$this->set_property($upload, 'gallery_config', new resize_test_config([
			'allow_resize' => true,
			'max_filesize' => 512000,
		]));
		$this->set_property($upload, 'language', new resize_test_language());
		$this->set_property($upload, 'user', (object) ['data' => ['username' => 'Uploader']]);

		$upload->set_up(42, 3);

		$this->assertSame([], $file_upload->allowed_extensions);
		$this->assertSame(16384000, $file_upload->max_filesize);
		$this->assertSame(512000, $upload->max_filesize);
		$this->assertSame(16384000, $upload->get_source_filesize_limit());
	}

	public function test_large_jpeg_is_reduced_to_the_stored_file_limit(): void
	{
		if (!function_exists('imagecreatetruecolor') || !function_exists('imagejpeg'))
		{
			$this->markTestSkipped('The GD extension with JPEG support is required.');
		}

		$destination = $this->create_noisy_jpeg();
		$file = (new \ReflectionClass(file::class))->newInstanceWithoutConstructor();
		$file->gd_version = file::GDLIB2;
		$file->set_image_data($destination, '', (int) filesize($destination), true);

		try
		{
			$stored_filesize = $file->write_image_with_filesize_limit($destination, 12000, 100, true);

			$this->assertIsInt($stored_filesize);
			$this->assertGreaterThan(0, $stored_filesize);
			$this->assertLessThanOrEqual(12000, $stored_filesize);
			$this->assertSame($stored_filesize, filesize($destination));
			$this->assertNull($file->image);

			$dimensions = getimagesize($destination);
			$this->assertNotFalse($dimensions);
			$this->assertTrue($dimensions[0] < 320 || $dimensions[1] < 240);
		}
		finally
		{
			$file->image = null;
			if (file_exists($destination))
			{
				unlink($destination);
			}
		}
	}

	public function test_failed_size_reduction_does_not_replace_the_original(): void
	{
		if (!function_exists('imagecreatetruecolor') || !function_exists('imagejpeg'))
		{
			$this->markTestSkipped('The GD extension with JPEG support is required.');
		}

		$destination = $this->create_noisy_jpeg();
		$original_hash = hash_file('sha256', $destination);
		$file = (new \ReflectionClass(file::class))->newInstanceWithoutConstructor();
		$file->gd_version = file::GDLIB2;
		$file->set_image_data($destination, '', (int) filesize($destination), true);

		try
		{
			$this->assertFalse($file->write_image_with_filesize_limit($destination, 100, 100, false));
			$this->assertSame($original_hash, hash_file('sha256', $destination));
			$this->assertNull($file->image);
		}
		finally
		{
			$file->image = null;
			if (file_exists($destination))
			{
				unlink($destination);
			}
		}
	}

	public function test_database_row_uses_the_actual_stored_file_size(): void
	{
		$destination = tempnam(sys_get_temp_dir(), 'gallery-upload-size-');
		$this->assertNotFalse($destination);
		file_put_contents($destination, str_repeat('x', 321));

		$upload = (new \ReflectionClass(upload::class))->newInstanceWithoutConstructor();
		$db = new resize_test_database();
		$this->set_property($upload, 'file', new resize_test_filespec($destination));
		$this->set_property($upload, 'db', $db);
		$this->set_property($upload, 'block', new resize_test_block());
		$this->set_property($upload, 'user', (object) [
			'data' => [
				'user_id' => 7,
				'user_colour' => 'abcdef',
				'session_id' => 'test-session',
			],
			'ip' => '127.0.0.1',
		]);
		$this->set_property($upload, 'images_table', 'gallery_images');
		$this->set_property($upload, 'username', 'Uploader');
		$this->set_property($upload, 'album_id', 42);

		try
		{
			$this->assertSame(99, $upload->file_to_database([]));
			$this->assertSame(321, $db->insert_data['filesize_upload']);
			$this->assertSame('stored-name.jpg', $db->insert_data['image_filename']);
		}
		finally
		{
			if (file_exists($destination))
			{
				unlink($destination);
			}
		}
	}

	private function calculate_source_limit(int $stored_filesize, bool $allow_resize): int
	{
		$upload = (new \ReflectionClass(upload::class))->newInstanceWithoutConstructor();
		$method = new \ReflectionMethod(upload::class, 'calculate_source_filesize_limit');

		return $method->invoke($upload, $stored_filesize, $allow_resize);
	}

	private function create_noisy_jpeg(): string
	{
		$image = imagecreatetruecolor(320, 240);
		for ($y = 0; $y < 240; $y++)
		{
			for ($x = 0; $x < 320; $x++)
			{
				$red = ($x * 73 + $y * 151) & 255;
				$green = ($x * 199 + $y * 37) & 255;
				$blue = ($x * 17 + $y * 239) & 255;
				imagesetpixel($image, $x, $y, ($red << 16) | ($green << 8) | $blue);
			}
		}

		$destination = tempnam(sys_get_temp_dir(), 'gallery-upload-resize-');
		$this->assertNotFalse($destination);
		$this->assertTrue(imagejpeg($image, $destination, 100));
		$image = null;
		$this->assertGreaterThan(12000, filesize($destination));

		return $destination;
	}

	private function set_property(object $object, string $property_name, mixed $value): void
	{
		$property = new \ReflectionProperty($object, $property_name);
		$property->setValue($object, $value);
	}
}

final class resize_test_file_upload
{
	public array $allowed_extensions = [];
	public int $max_filesize = 0;

	public function set_allowed_extensions(array $extensions): void
	{
		$this->allowed_extensions = $extensions;
	}

	public function set_max_filesize(int $max_filesize): void
	{
		$this->max_filesize = $max_filesize;
	}
}

final class resize_test_config
{
	public function __construct(private array $values)
	{
	}

	public function get(string $key): mixed
	{
		return $this->values[$key] ?? false;
	}
}

final class resize_test_language
{
	public function lang(string $key): string
	{
		return $key;
	}
}

final class resize_test_filespec
{
	public function __construct(private string $destination)
	{
	}

	public function get(string $property): mixed
	{
		return match ($property)
		{
			'uploadname' => 'original-name.jpg',
			'realname' => 'stored-name.jpg',
			'filesize' => 999999,
			'destination_file' => $this->destination,
			default => null,
		};
	}
}

final class resize_test_database
{
	public array $insert_data = [];

	public function sql_build_array(string $operation, array $data): string
	{
		$this->insert_data = $data;

		return 'values';
	}

	public function sql_query(string $sql): void
	{
	}

	public function sql_nextid(): int
	{
		return 99;
	}
}

final class resize_test_block
{
	public function get_image_status_orphan(): int
	{
		return 3;
	}

	public function get_no_contest(): int
	{
		return 0;
	}
}
}
