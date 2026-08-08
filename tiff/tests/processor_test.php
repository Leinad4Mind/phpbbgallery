<?php
// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound -- Focused test helper shares this fixture.
/**
 * phpBB Gallery - TIFF processor tests
 *
 * @package   phpbbgallery/tiff
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\tiff\tests;

use phpbbgallery\tiff\processor;
use PHPUnit\Framework\TestCase;

final class processor_test extends TestCase
{
	private string $directory;

	// phpcs:disable PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		$this->directory = sys_get_temp_dir() . '/phpbbgallery-tiff-' . bin2hex(random_bytes(6));
		mkdir($this->directory);
	}

	protected function tearDown(): void
	{
		foreach (glob($this->directory . '/*') ?: [] as $file)
		{
			is_file($file) && unlink($file);
		}
		is_dir($this->directory) && rmdir($this->directory);
	}
	// phpcs:enable PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed

	public function test_runtime_reports_tiff_and_webp_support(): void
	{
		$this->assertTrue(processor::is_supported());
	}

	public function test_inspection_uses_content_and_enforces_extension_and_pixel_limit(): void
	{
		$processor = $this->processor();
		$valid = $this->image('valid.tiff', 800, 600);
		$spoof = $this->directory . '/spoof.tiff';
		file_put_contents($spoof, 'not an image');
		$this->assertSame('image/tiff', $processor->inspect($valid)['mime']);
		$this->assertSame(800, $processor->inspect($valid)['width']);
		$this->assertNull($processor->inspect($spoof));
		if (!(new \ReflectionClass(\Imagick::class))->isInternal())
		{
			$this->assertNull($processor->inspect($this->image('large.tif', 40000001, 1)));
		}
		$this->assertNull($processor->inspect($this->image('wrong.jpg', 10, 10)));
	}

	public function test_source_is_preserved_when_no_transformation_is_required(): void
	{
		$source = $this->image('preserved.tiff', 800, 600);
		$checksum = hash_file('sha256', $source);
		$metadata = $this->processor()->prepare_source($source, $this->options());

		$this->assertNotNull($metadata);
		$this->assertSame($checksum, hash_file('sha256', $source));
	}

	public function test_source_rotation_and_resize_are_verified_before_replacement(): void
	{
		$source = $this->image('transform.tif', 1200, 800);
		$options = $this->options();
		$options['max_width'] = 600;
		$options['max_height'] = 600;
		$options['rotation'] = 90;
		$metadata = $this->processor()->prepare_source($source, $options);

		$this->assertNotNull($metadata);
		$this->assertLessThanOrEqual(600, $metadata['width']);
		$this->assertLessThanOrEqual(600, $metadata['height']);
		$this->assertSame('image/tiff', $metadata['mime']);
	}

	public function test_multipage_source_is_not_flattened_by_a_transformation(): void
	{
		$source = $this->directory . '/multipage.tiff';
		file_put_contents($source, "FAKE:TIFF:120:80:3\n");
		$before = hash_file('sha256', $source);
		$options = $this->options();
		$options['orientation'] = 2;

		$this->assertNull((new processor(new \phpbb\config\config([])))->prepare_source($source, $options));
		$this->assertSame($before, hash_file('sha256', $source));
	}

	public function test_oversized_source_is_rejected_without_resize_and_not_modified(): void
	{
		$source = $this->image('rejected.tiff', 1200, 800);
		$checksum = hash_file('sha256', $source);
		$options = $this->options();
		$options['max_width'] = 600;
		$options['allow_resize'] = false;

		$this->assertNull($this->processor()->prepare_source($source, $options));
		$this->assertSame($checksum, hash_file('sha256', $source));
	}

	public function test_first_frame_derivative_is_a_bounded_webp(): void
	{
		$source = $this->image('source.tiff', 1200, 800);
		$destination = $this->directory . '/source.tiff.webp';
		$metadata = $this->processor()->create_derivative($source, $destination, 300, 200, 70);

		$this->assertNotNull($metadata);
		$this->assertSame('webp', $metadata['extension']);
		$this->assertSame('image/webp', $metadata['mime']);
		$this->assertLessThanOrEqual(300, $metadata['width']);
		$this->assertLessThanOrEqual(200, $metadata['height']);
		$this->assertFileExists($destination);
	}

	private function processor(): processor
	{
		return new processor(new \phpbb\config\config(['phpbb_gallery_tiff_webp_quality' => 82]));
	}

	private function image(string $name, int $width, int $height): string
	{
		$path = $this->directory . '/' . $name;
		if ((new \ReflectionClass(\Imagick::class))->isInternal())
		{
			$image = new \Imagick();
			$image->newImage($width, $height, new \ImagickPixel('white'));
			$image->setImageFormat('TIFF');
			$image->writeImage($path);
			$image->clear();
		}
		else
		{
			file_put_contents($path, "FAKE:TIFF:$width:$height\n");
		}

		return $path;
	}

	private function options(): array
	{
		return [
			'max_width' => 2000,
			'max_height' => 2000,
			'max_filesize' => 1048576,
			'allow_resize' => true,
			'rotation' => 0,
		];
	}
}
