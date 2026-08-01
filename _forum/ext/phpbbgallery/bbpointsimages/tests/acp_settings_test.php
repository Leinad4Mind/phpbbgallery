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
		$this->assertStringContainsString('name="album_rules[{{ album.ID }}][upload_reward]"', $template);
		$this->assertStringContainsString('name="album_rules[{{ album.ID }}][source_cost]"', $template);
		$this->assertStringContainsString('phpbb_gallery_bbpoints_contributors_enabled', $module);
		$this->assertStringContainsString('name="contributors_enabled"', $template);
		$this->assertSame(2, substr_count($template, '{{ S_FORM_TOKEN }}'));
	}
}
