<?php
/**
 * phpBB Gallery - Core Extension tests
 *
 * @package   phpbbgallery/core
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;
use phpbbgallery\core\controller\image;

class image_resolution_test extends TestCase
{
	private string $root;
	private string $upload_path;

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		if (!function_exists('imagecreatetruecolor'))
		{
			$this->markTestSkipped('GD is required to build the test images.');
		}

		$this->root = sys_get_temp_dir() . '/phpbbgallery_resolution_' . uniqid('', true) . '/';
		// Matches what url::path('upload') appends to the gallery file root.
		$this->upload_path = $this->root . 'core/source/';
		mkdir($this->upload_path, 0700, true);
	}

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function tearDown(): void
	{
		$this->remove_directory($this->root);
	}

	public function test_reads_the_dimensions_from_the_stored_file(): void
	{
		// The stored file is the source of truth: the database keeps no dimensions,
		// so a resized or rotated image still reports what it really is.
		$this->write_png('photo.png', 4, 2);

		$this->assertSame('4 × 2 px', $this->resolution_for('photo.png'));
	}

	public function test_works_for_formats_that_carry_no_exif(): void
	{
		// The reason this lives in the core and not in the EXIF add-on: a PNG has no
		// EXIF block at all, but it certainly has a resolution.
		$this->write_png('screenshot.png', 1920, 1080);

		$this->assertSame('1920 × 1080 px', $this->resolution_for('screenshot.png'));
	}

	public function test_returns_nothing_when_the_option_is_disabled(): void
	{
		$this->write_png('photo.png', 4, 2);

		$this->assertSame('', $this->resolution_for('photo.png', false));
	}

	public function test_a_missing_file_does_not_break_the_page(): void
	{
		$this->assertSame('', $this->resolution_for('gone.png'));
	}

	public function test_a_file_that_is_not_an_image_is_ignored(): void
	{
		file_put_contents($this->upload_path . 'broken.png', 'this is not an image');

		$this->assertSame('', $this->resolution_for('broken.png'));
	}

	public function test_an_empty_filename_is_ignored(): void
	{
		$this->assertSame('', $this->resolution_for(''));
	}

	private function resolution_for(string $filename, bool $enabled = true): string
	{
		$controller = (new \ReflectionClass(image::class))->newInstanceWithoutConstructor();

		$this->set_property($controller, 'gallery_config', $this->new_gallery_config($enabled));
		$this->set_property($controller, 'url', $this->new_url());
		$this->set_property($controller, 'language', $this->new_language());

		$method = new \ReflectionMethod(image::class, 'get_image_resolution');
		$this->make_accessible($method);

		return $method->invoke($controller, $filename);
	}

	/**
	 * Real gallery config, carrying only the switch this helper reads.
	 */
	private function new_gallery_config(bool $enabled): \phpbbgallery\core\config
	{
		$config = (new \ReflectionClass(\phpbbgallery\core\config::class))->newInstanceWithoutConstructor();
		$this->set_property($config, 'config', new \phpbb\config\config([
			'phpbb_gallery_disp_resolution' => $enabled ? 1 : 0,
		]));

		return $config;
	}

	/**
	 * Real url service, pointed at the temporary upload directory.
	 */
	private function new_url(): \phpbbgallery\core\url
	{
		$url = (new \ReflectionClass(\phpbbgallery\core\url::class))->newInstanceWithoutConstructor();
		$this->set_property($url, 'phpbb_root_path', $this->root);
		$this->set_property($url, 'phpbb_gallery_file_path', '');

		return $url;
	}

	/**
	 * Real language service holding the shipped format string, so the assertions
	 * check the formatting that actually reaches the template.
	 */
	private function new_language(): \phpbb\language\language
	{
		$language = (new \ReflectionClass(\phpbb\language\language::class))->newInstanceWithoutConstructor();
		$this->set_property($language, 'common_language_files_loaded', true);
		$this->set_property($language, 'lang', [
			'IMAGE_RESOLUTION_VALUE' => '%1$d × %2$d px',
		]);

		return $language;
	}

	private function set_property(object $object, string $name, mixed $value): void
	{
		$property = new \ReflectionProperty($object, $name);
		$this->make_accessible($property);
		$property->setValue($object, $value);
	}

	private function make_accessible($reflection): void
	{
		if (PHP_VERSION_ID < 80100)
		{
			$reflection->setAccessible(true);
		}
	}

	private function write_png(string $filename, int $width, int $height): void
	{
		$image = imagecreatetruecolor($width, $height);
		imagepng($image, $this->upload_path . $filename);
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
