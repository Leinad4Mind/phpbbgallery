<?php
/**
 * phpBB Gallery - ACP contest settings visibility tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;

final class acp_contest_settings_visibility_test extends TestCase
{
	public function test_contest_fields_are_server_hidden_until_contest_mode_is_selected(): void
	{
		$template = (string) file_get_contents(dirname(__DIR__) . '/adm/style/gallery_albums.html');

		$this->assertStringContainsString(
			'id="album_contest_options"{% if not S_ALBUM_CONTEST %} hidden{% endif %}',
			$template
		);
		$this->assertStringContainsString(
			'contest_options.hidden = Number(value) !== {{ ALBUM_CONTEST }};',
			$template
		);
	}

	public function test_selected_album_type_initializes_visibility_without_replacing_onload(): void
	{
		$template = (string) file_get_contents(dirname(__DIR__) . '/adm/style/gallery_albums.html');

		$this->assertStringContainsString("window.addEventListener('load', function()", $template);
		$this->assertStringContainsString('display_options(album_type.value);', $template);
		$this->assertStringNotContainsString('onload = function()', $template);
		$this->assertStringNotContainsString("dE('album_contest_options'", $template);
	}
}
