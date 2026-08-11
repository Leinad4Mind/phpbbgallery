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

	public function test_album_types_can_be_locked_without_losing_the_submitted_value(): void
	{
		$template = (string) file_get_contents(dirname(__DIR__) . '/adm/style/gallery_albums.html');
		$module = (string) file_get_contents(dirname(__DIR__) . '/acp/albums_module.php');

		$this->assertStringContainsString('{% if not S_ALBUM_TYPE_LOCKED %}', $template);
		$this->assertStringContainsString('disabled="disabled" aria-describedby="album_type_lock_explain"', $template);
		$this->assertStringContainsString('<input type="hidden" name="album_type" value="{{ ALBUM_TYPE_VALUE }}" />', $template);
		$this->assertStringContainsString('{{ ALBUM_TYPE_LOCK_EXPLAIN }}', $template);
		$this->assertStringContainsString("'album_type_locked'", $module);
		$this->assertStringContainsString("'album_type_lock_explain'", $module);
		$this->assertStringContainsString("'S_ALBUM_TYPE_LOCKED' => \$album_type_locked", $module);
		$this->assertStringContainsString("'original_type' => \$old_album_type", $module);
		$this->assertStringContainsString("!empty(\$album_type_definitions[\$old_album_type]['immutable'])", $module);
		$this->assertStringContainsString("\$album_data['album_type'] = \$old_album_type", $module);
	}

	public function test_album_icon_accept_filter_is_runtime_capability_aware(): void
	{
		$template = (string) file_get_contents(dirname(__DIR__) . '/adm/style/gallery_albums.html');
		$module = (string) file_get_contents(dirname(__DIR__) . '/acp/albums_module.php');

		$this->assertStringContainsString('accept="{{ S_ICON_ACCEPT }}"', $template);
		$this->assertStringContainsString('name="MAX_FILE_SIZE" value="{{ S_ICON_MAX_FILESIZE }}"', $template);
		$this->assertStringContainsString('{{ L_ICON_UPLOAD_LIMITS }}', $template);
		$this->assertStringContainsString("'S_ICON_ACCEPT'", $module);
		$this->assertStringContainsString("'S_ICON_MAX_FILESIZE'", $module);
		$this->assertStringContainsString("'L_ICON_UPLOAD_LIMITS'", $module);
		$this->assertStringContainsString('file::supports_avif()', $module);
	}
}
