<?php
/**
 * phpBB Gallery - Album polaroid title tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;

final class album_polaroid_title_test extends TestCase
{
	public function test_every_style_uses_the_shared_album_title_layout(): void
	{
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$template = (string) file_get_contents(dirname(__DIR__) . '/styles/' . $style . '/template/gallery/albumlist_polaroid.html');

			$this->assertStringContainsString('<p class="gallery-album-title">', $template, $style);
			$this->assertStringNotContainsString('font-size: 1.2em', $template, $style);
		}
	}

	public function test_title_line_box_leaves_room_for_font_descenders(): void
	{
		$css = (string) file_get_contents(dirname(__DIR__) . '/styles/all/theme/gallery.css');

		$this->assertMatchesRegularExpression(
			'/\.gallery-album-title\s*\{[^}]*font-size:\s*1\.2em;[^}]*line-height:\s*1\.4;[^}]*padding-bottom:\s*\.1em;/s',
			$css
		);
		$this->assertStringContainsString('text-overflow: ellipsis;', $css);
	}

	public function test_gallery_index_separates_public_and_personal_albums(): void
	{
		$display = (string) file_get_contents(dirname(__DIR__) . '/album/display.php');
		$this->assertStringContainsString('$index_section = !$root_data ? \'public\'', $display);
		$this->assertStringContainsString("'S_PUBLIC_SECTION_START'", $display);
		$this->assertStringContainsString("'S_PERSONAL_SECTION_START'", $display);
		$this->assertStringContainsString("'S_PERSONAL_ALBUM'", $display);

		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			foreach (['albumlist_polaroid.html', 'albumlist_body.html'] as $filename)
			{
				$template = (string) file_get_contents(dirname(__DIR__) . '/styles/' . $style . '/template/gallery/' . $filename);
				$this->assertStringContainsString('S_PUBLIC_SECTION_START', $template, $style . '/' . $filename);
				$this->assertStringContainsString('S_PERSONAL_SECTION_START', $template, $style . '/' . $filename);
				$this->assertStringContainsString("lang('PUBLIC_ALBUMS')", $template, $style . '/' . $filename);
				$this->assertStringContainsString("lang('PERSONAL_ALBUMS')", $template, $style . '/' . $filename);
				$this->assertStringContainsString('gallery-personal-album', $template, $style . '/' . $filename);
			}
		}
	}
}
