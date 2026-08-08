<?php
/**
 * phpBB Gallery - Image orientation tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\image\orientation;
use PHPUnit\Framework\TestCase;

final class image_orientation_test extends TestCase
{
	public function test_legacy_rotations_map_to_the_same_visible_orientation(): void
	{
		$this->assertSame(orientation::ORIGINAL, orientation::from_legacy_rotation(0));
		$this->assertSame(orientation::ROTATE_LEFT, orientation::from_legacy_rotation(90));
		$this->assertSame(orientation::ROTATE_180, orientation::from_legacy_rotation(180));
		$this->assertSame(orientation::ROTATE_RIGHT, orientation::from_legacy_rotation(270));
		$this->assertSame(90, orientation::to_legacy_rotation(orientation::ROTATE_LEFT));
		$this->assertSame(270, orientation::to_legacy_rotation(orientation::ROTATE_RIGHT));
	}

	public function test_all_orientation_properties_are_normalized(): void
	{
		$this->assertSame(orientation::ORIGINAL, orientation::normalize(0));
		$this->assertSame(orientation::ORIGINAL, orientation::normalize(9));
		$this->assertTrue(orientation::swaps_dimensions(orientation::ROTATE_RIGHT));
		$this->assertTrue(orientation::swaps_dimensions(orientation::MIRROR_HORIZONTAL_ROTATE_LEFT));
		$this->assertFalse(orientation::swaps_dimensions(orientation::MIRROR_VERTICAL));
		$this->assertTrue(orientation::is_mirrored(orientation::MIRROR_HORIZONTAL_ROTATE_RIGHT));
		$this->assertFalse(orientation::is_mirrored(orientation::ROTATE_180));
	}

	public function test_gif_frame_detection_does_not_decode_pixels(): void
	{
		$single = base64_decode('R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==', true);
		$this->assertIsString($single);
		$descriptor = substr($single, strpos($single, ','), -1);
		$animated = substr($single, 0, -1) . $descriptor . ';';
		$single_path = tempnam(sys_get_temp_dir(), 'gallery-gif-single-');
		$animated_path = tempnam(sys_get_temp_dir(), 'gallery-gif-animated-');
		file_put_contents($single_path, $single);
		file_put_contents($animated_path, $animated);

		try
		{
			$this->assertFalse(orientation::is_animated_gif($single_path));
			$this->assertTrue(orientation::is_animated_gif($animated_path));
		}
		finally
		{
			@unlink($single_path);
			@unlink($animated_path);
		}
	}

	public function test_jpeg_exif_orientation_is_read_fail_closed(): void
	{
		if (!function_exists('exif_read_data') || !function_exists('imagejpeg'))
		{
			$this->markTestSkipped('The EXIF and GD JPEG extensions are required.');
		}

		$path = tempnam(sys_get_temp_dir(), 'gallery-exif-orientation-');
		$image = imagecreatetruecolor(2, 1);
		imagejpeg($image, $path, 90);
		$image = null;
		$jpeg = (string) file_get_contents($path);
		$tiff = "II*\0" . pack('V', 8)
			. pack('v', 1)
			. pack('v', 0x0112) . pack('v', 3) . pack('V', 1) . pack('v', 6) . "\0\0"
			. pack('V', 0);
		$payload = "Exif\0\0" . $tiff;
		file_put_contents($path, substr($jpeg, 0, 2) . "\xFF\xE1" . pack('n', strlen($payload) + 2) . $payload . substr($jpeg, 2));

		try
		{
			$this->assertSame(orientation::ROTATE_RIGHT, orientation::from_exif($path));
		}
		finally
		{
			@unlink($path);
		}
	}

	public function test_review_templates_share_the_visual_transform_editor(): void
	{
		$root = dirname(__DIR__);
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$template = (string) file_get_contents($root . '/styles/' . $style . '/template/gallery/posting_body.html');
			$this->assertStringContainsString('image_orientation_controls.html', $template);
			$this->assertStringContainsString('data-gallery-orientation-preview', $template);
			$this->assertStringNotContainsString('name="rotate[{{ upload_image.S_ROW_COUNT }}]"', $template);
		}
	}
}
