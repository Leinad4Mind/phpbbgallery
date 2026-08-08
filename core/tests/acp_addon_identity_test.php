<?php
/**
 * Gallery ACP add-on identity tests.
 *
 * @package   phpbbgallery/core
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;

final class acp_addon_identity_test extends TestCase
{
	public function test_mixed_acp_settings_are_identified_without_relying_on_colour(): void
	{
		$module = (string) file_get_contents(dirname(__DIR__) . '/acp/config_module.php');
		$template = (string) file_get_contents(dirname(__DIR__) . '/adm/style/event/acp_overall_header_head_append.html');
		$stylesheet = (string) file_get_contents(dirname(__DIR__) . '/adm/style/gallery_acp_addons.css');
		$javascript = (string) file_get_contents(dirname(__DIR__) . '/adm/style/gallery_acp_addons.js');

		$this->assertStringContainsString('$vars[\'addon\']', $module);
		$this->assertStringContainsString("preg_match('/^#[0-9a-f]{6}$/i'", $module);
		$this->assertStringContainsString('JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT', $module);
		$this->assertStringContainsString('fa-puzzle-piece', $template);
		$this->assertStringContainsString('setting.badge', $template);
		$this->assertStringContainsString('GALLERY_ADDON_SETTINGS_LEGEND_EXPLAIN', $template);
		$this->assertStringContainsString('border-inline-start', $stylesheet);
		$this->assertStringContainsString('data-gallery-addon-view="simple"', $stylesheet);
		$this->assertStringContainsString('@media (prefers-contrast: more)', $stylesheet);
		$this->assertStringContainsString("INCLUDEJS '@phpbbgallery_core/gallery_acp_addons.js'", $template);
		$this->assertStringContainsString("'phpbbgallery.acp.addonSettingsView'", $javascript);
		$this->assertStringContainsString('window.localStorage.setItem(storageKey, mode)', $javascript);
		$this->assertStringContainsString("button.setAttribute('aria-pressed'", $javascript);
	}

	public function test_album_editor_has_a_shared_addon_legend(): void
	{
		$template = (string) file_get_contents(dirname(__DIR__) . '/adm/style/gallery_albums.html');

		$this->assertStringContainsString('gallery_acp_addons', $template);
		$this->assertStringContainsString('gallery-addon-legend', $template);
		$this->assertStringContainsString('GALLERY_ADDON_SETTING', $template);
		$this->assertStringContainsString('GALLERY_ADDON_SETTINGS_VIEW_SIMPLE', $template);
		$this->assertStringContainsString('GALLERY_ADDON_SETTINGS_VIEW_COMPLETE', $template);
		$this->assertStringContainsString("INCLUDEJS '@phpbbgallery_core/gallery_acp_addons.js'", $template);
	}
}
