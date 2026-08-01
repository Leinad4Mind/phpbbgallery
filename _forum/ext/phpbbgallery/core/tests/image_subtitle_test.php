<?php
/**
 * phpBB Gallery - image subtitle tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\controller\image as image_controller;
use phpbbgallery\core\upload;
use PHPUnit\Framework\TestCase;

final class image_subtitle_test extends TestCase
{
	public function test_upload_subtitles_are_plain_text_normalized_and_follow_same_name_numbering(): void
	{
		$upload = (new \ReflectionClass(upload::class))->newInstanceWithoutConstructor();
		$upload->set_names(['Image {NUM}', 'Other']);
		$upload->set_descriptions(['Description {NUM}', 'Other']);
		$upload->set_subtitles(['  Dragon Ball ({NUM})  ', 'Other']);
		$upload->set_image_num(5);
		$upload->use_same_name(true);

		$file_count = new \ReflectionProperty(upload::class, 'file_count');
		$file_count->setValue($upload, 1);

		$this->assertSame('Dragon Ball (6)', $upload->get_subtitle());
		$this->assertSame(255, upload::IMAGE_SUBTITLE_MAX_LENGTH);
	}

	public function test_subtitle_search_terms_remove_parentheses_only_at_request_time(): void
	{
		$controller = (new \ReflectionClass(image_controller::class))->newInstanceWithoutConstructor();
		$method = new \ReflectionMethod(image_controller::class, 'normalize_subtitle_search_terms');

		$this->assertSame('Dragon Ball 1985', $method->invoke($controller, '  Dragon   Ball (1985)  '));
		$this->assertSame('Title - 2026', $method->invoke($controller, 'Title - (2026)'));
		$this->assertSame('', $method->invoke($controller, ' ( ) '));
	}

	public function test_core_persists_edits_and_searches_the_subtitle_without_a_clean_column(): void
	{
		$root = dirname(__DIR__);
		$upload = (string) file_get_contents($root . '/upload.php');
		$upload_controller = (string) file_get_contents($root . '/controller/upload.php');
		$image_controller = (string) file_get_contents($root . '/controller/image.php');
		$search_controller = (string) file_get_contents($root . '/controller/search.php');
		$migration = (string) file_get_contents($root . '/migrations/image_subtitle.php');

		$this->assertStringContainsString("'image_subtitle'", $upload);
		$this->assertStringContainsString('get_subtitle()', $upload);
		$this->assertStringContainsString("variable('image_subtitle', [''], true", $upload_controller);
		$this->assertStringContainsString('set_subtitles($image_subtitles)', $upload_controller);
		$this->assertStringContainsString("'image_subtitle'       =>", $image_controller);
		$this->assertStringContainsString('$image_subtitle,', $image_controller);
		$this->assertStringContainsString('LOWER(i.image_subtitle)', $search_controller);
		$this->assertStringContainsString("'terms' => 'all'", $image_controller);
		$this->assertStringContainsString("'submit' => 1", $image_controller);
		$this->assertStringNotContainsString('image_subtitle_clean', $upload . $upload_controller . $image_controller . $search_controller . $migration);
	}

	public function test_every_style_exposes_editing_and_searchable_presentation(): void
	{
		$root = dirname(__DIR__) . '/styles';
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$posting = (string) file_get_contents($root . '/' . $style . '/template/gallery/posting_body.html');
			$view = (string) file_get_contents($root . '/' . $style . '/template/gallery/viewimage_body.html');
			$javascript = (string) file_get_contents($root . '/' . $style . '/template/gallery/posting_javascript.html');

			$this->assertStringContainsString('name="image_subtitle[{{ image.S_ROW_COUNT }}]"', $posting, $style);
			$this->assertStringContainsString('maxlength="255"', $posting, $style);
			$this->assertStringContainsString('U_IMAGE_SUBTITLE_SEARCH', $view, $style);
			$this->assertStringContainsString("update_all('image_subtitle')", $javascript, $style);
		}
	}

	public function test_every_language_defines_the_subtitle_messages(): void
	{
		$language_root = dirname(__DIR__) . '/language';
		foreach (glob($language_root . '/*', GLOB_ONLYDIR) as $directory)
		{
			$lang = [];
			include $directory . '/gallery.php';

			$this->assertNotSame('', $lang['IMAGE_SUBTITLE'] ?? '', basename($directory));
			$this->assertNotSame('', $lang['IMAGE_SUBTITLE_EXPLAIN'] ?? '', basename($directory));
			$this->assertStringContainsString('%d', $lang['IMAGE_SUBTITLE_TOO_LONG'] ?? '', basename($directory));
		}
	}
}
