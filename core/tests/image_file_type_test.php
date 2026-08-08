<?php
/**
 * phpBB Gallery - image source file-type tests
 *
 * @package   phpbbgallery/core
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;
use phpbbgallery\core\controller\image;

final class image_file_type_test extends TestCase
{
	public function test_preserves_supported_original_extensions(): void
	{
		foreach (['png', 'jpg', 'jpeg', 'gif', 'webp', 'avif', 'bmp', 'tif', 'tiff'] as $extension)
		{
			$this->assertSame(strtoupper($extension), $this->file_type_for('stored-image.' . $extension));
		}
	}

	public function test_reads_distributed_storage_keys_without_file_access(): void
	{
		$this->assertSame('TIFF', $this->file_type_for('7/71/7127abfe9cf6b6d3eb0a523e6158e896.TIFF'));
		$this->assertSame('JPEG', $this->file_type_for('7\\71\\7127abfe9cf6b6d3eb0a523e6158e896.JPEG'));
	}

	public function test_rejects_empty_and_non_image_extensions(): void
	{
		$this->assertSame('', $this->file_type_for(''));
		$this->assertSame('', $this->file_type_for('stored-image.php'));
		$this->assertSame('', $this->file_type_for('stored-image'));
	}

	public function test_all_view_image_styles_render_the_type_only_in_image_details(): void
	{
		$root = dirname(__DIR__);
		$controller = (string) file_get_contents($root . '/controller/image.php');
		$this->assertStringContainsString("'IMAGE_FILE_TYPE'", $controller);
		$this->assertStringContainsString('get_image_file_type', $controller);

		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$style_root = $root . '/styles/' . $style . '/template/gallery/';
			$template = (string) file_get_contents($style_root . 'viewimage_body.html');
			$this->assertStringContainsString("lang('IMAGE_FILE_TYPE')", $template, $style);
			$this->assertStringContainsString('IMAGE_FILE_TYPE', $template, $style);
			$this->assertStringNotContainsString('IMAGE_FILE_TYPE', (string) file_get_contents($style_root . 'album_body.html'), $style);
			$this->assertStringNotContainsString('IMAGE_FILE_TYPE', (string) file_get_contents($style_root . 'search_results.html'), $style);
		}
	}

	private function file_type_for(string $filename): string
	{
		$controller = (new \ReflectionClass(image::class))->newInstanceWithoutConstructor();
		$method = new \ReflectionMethod(image::class, 'get_image_file_type');

		return $method->invoke($controller, $filename);
	}
}
