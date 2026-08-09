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
		$controls = (string) file_get_contents($root . '/styles/all/template/gallery/image_orientation_controls.html');
		$css = (string) file_get_contents($root . '/styles/all/theme/gallery.css');
		$this->assertStringContainsString('icon fa fa-eraser fa-fw', $controls);
		$this->assertStringContainsString('repeating-conic-gradient', $css);

		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$template = (string) file_get_contents($root . '/styles/' . $style . '/template/gallery/posting_body.html');
			$this->assertStringContainsString('image_orientation_controls.html', $template);
			$this->assertStringContainsString('data-gallery-orientation-preview', $template);
			$this->assertStringNotContainsString('name="rotate[{{ upload_image.S_ROW_COUNT }}]"', $template);
		}
	}

	public function test_sitesplat_upload_helpers_remain_globally_callable_and_match_prosilver_order(): void
	{
		$root = dirname(__DIR__) . '/styles';
		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			$javascript = (string) file_get_contents($root . '/' . $style . '/template/gallery/posting_javascript.html');
			$template = (string) file_get_contents($root . '/' . $style . '/template/gallery/posting_body.html');

			$this->assertStringNotContainsString('head.ready(function ()', $javascript, $style);
			$this->assertStringContainsString('function change_read_write()', $javascript, $style);
			$this->assertStringContainsString('id="desc_length_{{ image.S_ROW_COUNT }}"', $template, $style);
			$this->assertLessThan(
				strpos($template, 'for="image_num"'),
				strpos($template, 'id="same_name"'),
				$style
			);
			$this->assertLessThan(
				strpos($template, 'for="image_name_{{ image.S_ROW_COUNT }}"'),
				strpos($template, 'for="image_num"'),
				$style
			);
		}
	}

	public function test_shared_name_controls_precede_each_style_image_name_field(): void
	{
		$root = dirname(__DIR__) . '/styles';
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$template = (string) file_get_contents($root . '/' . $style . '/template/gallery/posting_body.html');

			$this->assertLessThan(
				strpos($template, 'for="image_name_{{ image.S_ROW_COUNT }}"'),
				strpos($template, 'id="same_name"'),
				$style
			);
		}
	}

	public function test_prosilver_shared_name_text_follows_its_checkbox(): void
	{
		$template = (string) file_get_contents(
			dirname(__DIR__) . '/styles/prosilver/template/gallery/posting_body.html'
		);

		$this->assertStringContainsString(
			'<dd><input type="checkbox" name="same_name" id="same_name" value="1" onchange="change_read_write();" /> <label for="same_name">',
			$template
		);
		$this->assertStringNotContainsString('<dt><label for="same_name">', $template);
	}

	public function test_shared_upload_fields_look_disabled_while_remaining_submittable(): void
	{
		$root = dirname(__DIR__) . '/styles';
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$template = (string) file_get_contents($root . '/' . $style . '/template/gallery/posting_body.html');

			$this->assertSame(1, substr_count($template, 'class="gallery-upload-details-form"'), $style);
		}

		$javascript = (string) file_get_contents($root . '/prosilver/template/gallery/posting_javascript.html');
		$css = (string) file_get_contents($root . '/all/theme/gallery.css');

		$this->assertStringContainsString('element.readOnly = true;', $javascript);
		$this->assertStringContainsString('.gallery-upload-details-form input.readonly', $css);
		$this->assertStringContainsString('.gallery-upload-details-form textarea.readonly', $css);
		$this->assertStringContainsString('background-color: #eef0f3 !important;', $css);
		$this->assertStringContainsString('cursor: not-allowed;', $css);
		$this->assertStringContainsString('opacity: .68;', $css);
	}
}
