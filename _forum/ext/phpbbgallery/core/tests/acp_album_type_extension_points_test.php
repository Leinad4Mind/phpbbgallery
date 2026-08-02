<?php
/**
 * phpBB Gallery ACP album-type extension point tests.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;

final class acp_album_type_extension_points_test extends TestCase
{
	public function test_album_type_ui_exposes_neutral_extension_points(): void
	{
		$template = (string) file_get_contents(dirname(__DIR__) . '/adm/style/gallery_albums.html');

		$this->assertStringContainsString('{% EVENT phpbbgallery_core_adm_album_type_options %}', $template);
		$this->assertStringContainsString('{% EVENT phpbbgallery_core_adm_album_display_options %}', $template);
		$this->assertStringContainsString('{% EVENT phpbbgallery_core_adm_album_type_warnings %}', $template);
		$this->assertStringNotContainsString('ALBUM_CONTEST', $template);
		$this->assertStringNotContainsString('contest_options', $template);
	}

	public function test_selected_album_type_initializes_visibility_without_replacing_onload(): void
	{
		$template = (string) file_get_contents(dirname(__DIR__) . '/adm/style/gallery_albums.html');

		$this->assertStringContainsString("window.addEventListener('load', function()", $template);
		$this->assertStringContainsString('display_options(album_type.value);', $template);
		$this->assertStringNotContainsString('onload = function()', $template);
	}
}
