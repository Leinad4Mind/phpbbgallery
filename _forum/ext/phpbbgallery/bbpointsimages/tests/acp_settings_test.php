<?php
/**
 * BBPoints Images ACP architecture tests
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbpointsimages\tests;

use PHPUnit\Framework\TestCase;

final class acp_settings_test extends TestCase
{
	public function test_settings_and_sync_are_protected_and_use_the_dedicated_services(): void
	{
		$module = file_get_contents(dirname(__DIR__) . '/acp/main_module.php');
		$template = file_get_contents(dirname(__DIR__) . '/adm/style/bbpointsimages_settings.html');

		$this->assertStringContainsString('check_form_key(self::FORM_KEY)', $module);
		$this->assertStringContainsString('confirm_box(true)', $module);
		$this->assertStringContainsString('check_link_hash($hash, self::SYNC_HASH)', $module);
		$this->assertStringContainsString('generate_link_hash(self::SYNC_HASH)', $module);
		$this->assertStringContainsString("get('phpbbgallery.bbpointsimages.retro_sync')", $module);
		$this->assertStringNotContainsString('name="album_rules[', $template);
		$this->assertStringContainsString('album.U_EDIT', $template);
		$this->assertStringContainsString('album.EFFECTIVE_UPLOAD_REWARD', $template);
		$this->assertStringContainsString('name="contributors_bulk"', $template);
		$this->assertStringContainsString('set_all_contributors($value)', $module);
		$this->assertStringContainsString('phpbb_gallery_bbpoints_contributors_enabled', $module);
		$this->assertStringContainsString('name="contributors_enabled"', $template);
		$this->assertSame(3, substr_count($template, '{{ S_FORM_TOKEN }}'));

		$listener = file_get_contents(dirname(__DIR__) . '/event/acp_listener.php');
		$album_template = file_get_contents(dirname(__DIR__) . '/adm/style/event/phpbbgallery_core_adm_album_type_options.html');
		$this->assertStringContainsString('phpbbgallery.core.acp.albums.send_to_template', $listener);
		$this->assertStringContainsString('phpbbgallery.core.album.manage.created', $listener);
		$this->assertStringContainsString('phpbbgallery.core.album.manage.updated', $listener);
		$this->assertStringContainsString('name="bbpointsimages_upload_reward"', $album_template);
		$this->assertStringContainsString('name="bbpointsimages_source_cost"', $album_template);
		$this->assertStringContainsString('name="bbpointsimages_contributors_enabled"', $album_template);
	}
}
