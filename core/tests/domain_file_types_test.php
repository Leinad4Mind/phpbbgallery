<?php
/**
 * phpBB Gallery - Core file service tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\file\file;
use phpbbgallery\core\file\types\multiform;
use phpbbgallery\core\image\orientation;
use PHPUnit\Framework\TestCase;

final class domain_file_types_test extends TestCase
{
	public function test_file_service_properties_parameters_and_returns_are_fully_typed(): void
	{
		$this->assert_class_types(file::class);
	}

	public function test_multiform_declared_properties_parameters_and_returns_are_fully_typed(): void
	{
		$this->assert_class_types(multiform::class);
	}

	public function test_filename_type_detection_is_case_insensitive_and_fail_closed(): void
	{
		$this->assertSame('image/jpeg', file::mimetype_by_filename('Photo.JPEG'));
		$this->assertSame('jpg', file::extension_by_filename('Photo.JPEG'));
		$this->assertSame('image/webp', file::mimetype_by_filename('preview.WEBP'));
		$this->assertSame('image/avif', file::mimetype_by_filename('preview.AVIF'));
		$this->assertSame('avif', file::extension_by_filename('preview.AVIF'));
		$this->assertSame('', file::mimetype_by_filename('archive.zip'));
		$this->assertSame('', file::extension_by_filename('archive.zip'));
	}

	public function test_avif_capability_requires_safe_dimensions_and_round_trips_when_available(): void
	{
		if (PHP_VERSION_ID < 80200)
		{
			$this->assertFalse(file::supports_avif());
			$writer = (new \ReflectionClass(file::class))->newInstanceWithoutConstructor();
			$writer->image = imagecreatetruecolor(1, 1);
			$writer->image_type = 'avif';
			$destination = tempnam(sys_get_temp_dir(), 'gallery-avif-disabled-');
			$this->assertFalse($writer->write_image($destination, 75, true));
			$this->assertNull($writer->image);
			$this->assertFileDoesNotExist($destination);
			return;
		}
		if (!file::supports_avif())
		{
			$this->markTestSkipped('This PHP/GD build does not support safe AVIF processing.');
		}

		$gallery_config = new \phpbbgallery\core\config(new \phpbb\config\config([
			'phpbb_gallery_avif_quality' => 75,
		]));
		$writer = (new \ReflectionClass(file::class))->newInstanceWithoutConstructor();
		$writer->gallery_config = $gallery_config;
		$writer->image = imagecreatetruecolor(3, 2);
		$writer->image_type = 'avif';
		$writer->image_size = ['width' => 3, 'height' => 2];
		$destination = tempnam(sys_get_temp_dir(), 'gallery-avif-');

		try
		{
			$this->assertTrue($writer->write_image($destination, 90, true));
			$this->assertNull($writer->image);
			$this->assertGreaterThan(0, filesize($destination));
			$this->assertSame('image/avif', getimagesize($destination)['mime']);

			$reader = (new \ReflectionClass(file::class))->newInstanceWithoutConstructor();
			$reader->set_image_data($destination, '', 0, true);
			$this->assertTrue($reader->read_image(true));
			$this->assertSame('avif', $reader->image_type);
			$this->assertSame(3, $reader->image_size['width']);
			$this->assertSame(2, $reader->image_size['height']);
			$reader->image = null;
		}
		finally
		{
			$writer->image = null;
			if ($destination !== false && file_exists($destination))
			{
				unlink($destination);
			}
		}
	}

	public function test_image_state_can_be_reset_before_reusing_the_service(): void
	{
		$reflection = new \ReflectionClass(file::class);
		$file = $reflection->newInstanceWithoutConstructor();
		$file->image = 'legacy-handle';
		$file->image_content_type = 'image/png';
		$file->image_size = ['file' => 99, 'width' => 10, 'height' => 10];
		$file->image_type = 'png';
		$file->resized = true;
		$file->rotated = true;
		$file->watermarked = true;

		$file->set_image_data('missing.jpg', 'Missing', 12, true);

		$this->assertNull($file->image);
		$this->assertSame('', $file->image_content_type);
		$this->assertSame(['file' => 12], $file->image_size);
		$this->assertSame('', $file->image_type);
		$this->assertFalse($file->resized);
		$this->assertFalse($file->rotated);
		$this->assertFalse($file->watermarked);
		$this->assertFalse($file->read_image());
	}

	public function test_multiform_without_a_form_name_returns_an_empty_upload_collection(): void
	{
		$multiform = (new \ReflectionClass(multiform::class))->newInstanceWithoutConstructor();

		$this->assertSame([], $multiform->upload());
	}

	public function test_rotating_png_preserves_transparency_when_written(): void
	{
		if (!function_exists('imagecreatetruecolor') || !function_exists('imagerotate'))
		{
			$this->markTestSkipped('The GD extension with rotation support is required.');
		}

		$image = imagecreatetruecolor(3, 2);
		imagealphablending($image, false);
		imagesavealpha($image, true);
		$transparent = imagecolorallocatealpha($image, 0, 0, 0, 127);
		imagefill($image, 0, 0, $transparent);
		$opaque_red = imagecolorallocatealpha($image, 255, 0, 0, 0);
		imagesetpixel($image, 0, 0, $opaque_red);

		$file = (new \ReflectionClass(file::class))->newInstanceWithoutConstructor();
		$file->image = $image;
		$file->image_type = 'png';
		$file->image_size = ['width' => 3, 'height' => 2];
		$destination = tempnam(sys_get_temp_dir(), 'gallery-rotate-');
		$written_image = false;

		try
		{
			$file->rotate_image(90, true);
			$this->assertTrue($file->rotated);
			$this->assertSame(['width' => 2, 'height' => 3], $file->image_size);
			$this->assertTrue(imagepng($file->image, $destination));

			$written_image = imagecreatefrompng($destination);
			$this->assertNotFalse($written_image);
			$alpha_values = [];
			for ($y = 0; $y < imagesy($written_image); $y++)
			{
				for ($x = 0; $x < imagesx($written_image); $x++)
				{
					$alpha_values[] = (imagecolorat($written_image, $x, $y) >> 24) & 0x7f;
				}
			}

			$this->assertContains(0, $alpha_values, 'The opaque pixel must remain opaque.');
			$this->assertContains(127, $alpha_values, 'Transparent pixels must remain fully transparent.');
		}
		finally
		{
			$written_image = null;
			$file->image = null;
			if ($destination !== false && file_exists($destination))
			{
				unlink($destination);
			}
		}
	}

	public function test_horizontal_flip_moves_pixels_without_changing_dimensions(): void
	{
		if (!function_exists('imagecreatetruecolor') || !function_exists('imageflip'))
		{
			$this->markTestSkipped('The GD extension with image flipping support is required.');
		}

		$image = imagecreatetruecolor(2, 1);
		$red = imagecolorallocate($image, 255, 0, 0);
		$blue = imagecolorallocate($image, 0, 0, 255);
		imagesetpixel($image, 0, 0, $red);
		imagesetpixel($image, 1, 0, $blue);
		$file = (new \ReflectionClass(file::class))->newInstanceWithoutConstructor();
		$file->image = $image;
		$file->image_type = 'png';
		$file->image_size = ['width' => 2, 'height' => 1];

		$file->transform_image(orientation::MIRROR_HORIZONTAL, true);

		$this->assertTrue($file->rotated);
		$this->assertSame(['width' => 2, 'height' => 1], $file->image_size);
		$this->assertSame($blue, imagecolorat($file->image, 0, 0));
		$this->assertSame($red, imagecolorat($file->image, 1, 0));
		$file->image = null;
	}

	public function test_write_image_releases_gd_reference_when_requested(): void
	{
		if (!function_exists('imagecreatetruecolor'))
		{
			$this->markTestSkipped('The GD extension is required.');
		}

		$file = (new \ReflectionClass(file::class))->newInstanceWithoutConstructor();
		$file->image = imagecreatetruecolor(1, 1);
		$file->image_type = 'png';
		$destination = tempnam(sys_get_temp_dir(), 'gallery-write-');

		try
		{
			$this->assertTrue($file->write_image($destination, 90, true));
			$this->assertNull($file->image);
			$this->assertGreaterThan(0, filesize($destination));
		}
		finally
		{
			$file->image = null;
			if ($destination !== false && file_exists($destination))
			{
				unlink($destination);
			}
		}
	}

	public function test_write_image_fails_closed_when_the_encoder_type_is_unknown(): void
	{
		if (!function_exists('imagecreatetruecolor'))
		{
			$this->markTestSkipped('The GD extension is required.');
		}

		$file = (new \ReflectionClass(file::class))->newInstanceWithoutConstructor();
		$file->image = imagecreatetruecolor(1, 1);
		$file->image_type = 'unknown';
		$destination = tempnam(sys_get_temp_dir(), 'gallery-write-invalid-');

		try
		{
			$this->assertFalse($file->write_image($destination, 90, true));
			$this->assertNull($file->image);
			$this->assertFileDoesNotExist($destination);
		}
		finally
		{
			$file->image = null;
			if ($destination !== false && file_exists($destination))
			{
				unlink($destination);
			}
		}
	}

	private function assert_class_types(string $class_name): void
	{
		$reflection = new \ReflectionClass($class_name);

		foreach ($reflection->getProperties() as $property)
		{
			if ($property->getDeclaringClass()->getName() === $class_name)
			{
				$this->assertNotNull($property->getType(), $class_name . '::$' . $property->getName());
			}
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== $class_name)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), $class_name . '::' . $method->getName() . '($' . $parameter->getName() . ')');
			}

			if (!$method->isConstructor())
			{
				$this->assertNotNull($method->getReturnType(), $class_name . '::' . $method->getName() . '()');
			}
		}
	}
}
