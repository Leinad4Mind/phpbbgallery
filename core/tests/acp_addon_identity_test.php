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
		$this->assertStringContainsString("'icon' => 'fa-puzzle-piece'", $module);
		$this->assertStringContainsString('setting.icon', $template);
		$this->assertStringContainsString("'kind' => 'addon'", $module);
		$this->assertStringContainsString("'kind' => 'core'", $module);
		$this->assertStringContainsString("'icon' => 'fa-star'", $module);
		$this->assertStringContainsString('data-gallery-setting-source', $template);
		$this->assertStringContainsString('setting.badge', $template);
		$this->assertStringContainsString('GALLERY_ADDON_SETTINGS_LEGEND_EXPLAIN', $template);
		$this->assertStringContainsString('GALLERY_ADDON_SETTINGS_LEGEND_EXPLAIN_SIMPLE', $template);
		$this->assertStringContainsString('border-inline-start', $stylesheet);
		$this->assertStringContainsString('data-gallery-addon-view="simple"', $stylesheet);
		$this->assertStringContainsString('html[data-gallery-addon-view="simple"] .gallery-addon-setting .gallery-addon-badge', $stylesheet);
		$this->assertStringContainsString('html[data-gallery-addon-view="simple"] .gallery-addon-section .gallery-addon-badge', $stylesheet);
		$this->assertStringNotContainsString('html[data-gallery-addon-view="simple"] .gallery-addon-legend__items', $stylesheet);
		$this->assertStringContainsString('@media (prefers-contrast: more)', $stylesheet);
		$this->assertStringContainsString("INCLUDEJS '@phpbbgallery_core/gallery_acp_addons.js'", $template);
		$this->assertStringContainsString("'phpbbgallery.acp.addonSettingsView'", $javascript);
		$this->assertStringContainsString("'phpbbgallery.acp.addonSettingsSources'", $javascript);
		$this->assertStringContainsString("'phpbbgallery.acp.addonSettingsLegend'", $javascript);
		$this->assertStringContainsString('window.localStorage.setItem(storageKey, mode)', $javascript);
		$this->assertStringContainsString('window.localStorage.setItem(storageKey, hiddenMode)', $javascript);
		$this->assertStringContainsString('window.localStorage.removeItem(legacyLegendStorageKey)', $javascript);
		$this->assertStringContainsString('window.localStorage.removeItem(obsoleteSourceStorageKey)', $javascript);
		$this->assertStringNotContainsString('hiddenSources', $javascript);
		$this->assertStringNotContainsString('data-gallery-source-toggle', $javascript);
		$this->assertStringNotContainsString('setting.hidden', $javascript);
		$this->assertStringNotContainsString('.gallery-addon-source-toggle', $stylesheet);
		$this->assertStringContainsString('makeBadge(setting)', $template);
		$this->assertStringContainsString("button.setAttribute('aria-pressed'", $javascript);
		$this->assertStringContainsString("var hiddenMode = 'hidden'", $javascript);
		$this->assertStringContainsString('data-view-hidden-label', $template);
		$this->assertStringContainsString('data-view-hidden-explain', $template);
		$this->assertStringContainsString('GALLERY_ADDON_SETTINGS_LEGEND_EXPLAIN_HIDDEN', $template);
		$this->assertStringContainsString('GALLERY_ADDON_SETTINGS_VIEW_HIDDEN', $template);
		$this->assertStringNotContainsString('gallery-addon-source-toggle', $template);
		$this->assertStringContainsString('data-gallery-addon-view="hidden"', $stylesheet);
		$this->assertStringContainsString('border-inline-start: 0 !important', $stylesheet);
		$this->assertStringNotContainsString('html[data-gallery-addon-view="hidden"] .gallery-addon-legend__title', $stylesheet);
		$this->assertStringContainsString('.gallery-addon-legend__items', $stylesheet);
		$this->assertStringContainsString('populateLegendSources(legend)', $javascript);
		$this->assertStringContainsString('clone = badge.cloneNode(true)', $javascript);
		$this->assertStringContainsString('items.appendChild(clone)', $javascript);
		$this->assertStringContainsString("'data-view-simple-explain'", $javascript);
		$this->assertStringContainsString("'data-view-complete-explain'", $javascript);
		$this->assertStringNotContainsString('html[data-gallery-addon-view="simple"] .gallery-addon-legend__explain', $stylesheet);
	}

	public function test_every_post_3_4_core_setting_has_a_distinct_identity(): void
	{
		$reflection = new \ReflectionClass(\phpbbgallery\core\acp\config_module::class);
		$new_core_settings = $reflection->getReflectionConstant('NEW_CORE_SETTINGS')->getValue();

		$this->assertSame([
			'title',
			'storage_layout',
			'auto_orient',
			'avif_quality',
			'allow_avif',
			'allow_bmp',
			'ajax_navigation',
			'disp_resolution',
			'disp_image_id',
			'forum_index_mode',
			'forum_index_recent_count',
			'forum_index_random_count',
			'forum_index_display',
			'forum_index_personal',
			'disp_new_image_count',
			'viewtopic_icon',
			'viewtopic_images',
			'viewtopic_link',
			'index_album_layout',
			'pegas_index_viewed_count',
			'pegas_index_rated_count',
		], $new_core_settings);
	}

	public function test_album_editor_has_a_shared_addon_legend(): void
	{
		$template = (string) file_get_contents(dirname(__DIR__) . '/adm/style/gallery_albums.html');
		$javascript = (string) file_get_contents(dirname(__DIR__) . '/adm/style/gallery_acp_addons.js');

		$this->assertStringContainsString('gallery_acp_addons', $template);
		$this->assertStringContainsString('gallery-addon-legend', $template);
		$this->assertStringContainsString('GALLERY_NEW_CORE_SETTING', $template);
		$this->assertStringContainsString('data-gallery-setting-source="new-core"', $template);
		$this->assertStringContainsString('fa-star', $template);
		$this->assertStringContainsString('ALBUM_ICON_PICKER', $template);
		$this->assertStringContainsString('GALLERY_ADDON_SETTINGS_VIEW_SIMPLE', $template);
		$this->assertStringContainsString('GALLERY_ADDON_SETTINGS_VIEW_COMPLETE', $template);
		$this->assertStringContainsString('GALLERY_ADDON_SETTINGS_LEGEND_EXPLAIN_SIMPLE', $template);
		$this->assertStringContainsString('GALLERY_ADDON_SETTINGS_VIEW_HIDDEN', $template);
		$this->assertStringContainsString('GALLERY_ADDON_SETTINGS_LEGEND_EXPLAIN_HIDDEN', $template);
		$this->assertStringContainsString('data-view-hidden-explain', $template);
		$this->assertStringNotContainsString('data-gallery-source-toggle', $template);
		$this->assertStringNotContainsString('gallery-addon-source-toggle', $template);
		$this->assertStringContainsString('populateLegendSources(legend)', $javascript);
		$this->assertStringContainsString("INCLUDEJS '@phpbbgallery_core/gallery_acp_addons.js'", $template);
	}

	public function test_album_icon_picker_can_remove_the_configured_icon(): void
	{
		$template = (string) file_get_contents(dirname(__DIR__) . '/adm/style/gallery_albums.html');
		$module = (string) file_get_contents(dirname(__DIR__) . '/acp/albums_module.php');

		$this->assertStringContainsString('value="{{ ICON_PICK_NONE }}"', $template);
		$this->assertStringContainsString('S_NO_ICON_SELECTED', $template);
		$this->assertStringContainsString('name="icon_file[]"', $template);
		$this->assertStringContainsString('multiple="multiple"', $template);
		$this->assertStringContainsString('data-album-image-path="{{ iconrow.ICON_PATH }}"', $template);
		$this->assertStringContainsString("INCLUDEJS '@phpbbgallery_core/gallery_album_icons.js'", $template);
		$this->assertStringContainsString("INCLUDECSS '@phpbbgallery_core/gallery_album_icons.css'", $template);
		$this->assertStringContainsString('class="gallery-icon-picker-image"', $template);
		$this->assertStringContainsString('gallery-addon-setting gallery-icon-picker-row', $template);
		$this->assertStringContainsString('class="gallery-acp-album-list-visual"', $template);
		$this->assertStringContainsString('class="gallery-acp-album-list-icon-link"', $template);
		$this->assertStringContainsString('class="gallery-acp-album-list-icon" src="{{ albums.ALBUM_IMAGE_SRC }}"', $template);
		$this->assertStringContainsString('{% else %}', strstr($template, 'class="gallery-acp-album-list-visual"'));
		$this->assertStringContainsString('{{ albums.FOLDER_IMAGE }}', strstr($template, 'class="gallery-acp-album-list-visual"'));
		$this->assertStringNotContainsString('float: {{ S_CONTENT_FLOW_BEGIN }}', $template);
		$this->assertStringNotContainsString("'ALBUM_IMAGE'\t\t=>", $module);
		$this->assertStringContainsString("private const ICON_PICK_NONE = '__none__';", $module);
		$this->assertStringContainsString('$album_icon_pick === self::ICON_PICK_NONE', $module);
		$this->assertStringContainsString("\$album_data['album_image'] = '';", $module);
		$this->assertStringContainsString('private function upload_icons(', $module);
		$picker_position = strpos($template, '<ul class="gallery-icon-picker">');
		$this->assertIsInt($picker_position);
		$this->assertLessThan($picker_position, strpos($template, 'name="icon_file[]"'));
		$this->assertLessThan(strpos($template, 'id="album_image"'), $picker_position);

		$javascript = (string) file_get_contents(dirname(__DIR__) . '/adm/style/gallery_album_icons.js');
		$this->assertStringContainsString("albumImage.value = choice.getAttribute('data-album-image-path') || '';", $javascript);
		$this->assertStringContainsString("preview.hidden = source === '';", $javascript);
		$this->assertStringContainsString("albumImage.addEventListener('input'", $javascript);
		$this->assertStringContainsString("choice.checked = choice.getAttribute('data-album-image-path') === albumImage.value;", $javascript);

		$css = (string) file_get_contents(dirname(__DIR__) . '/adm/style/gallery_album_icons.css');
		$this->assertMatchesRegularExpression('/\.gallery-icon-picker-image,\s*\.gallery-icon-picker-none\s*\{[^}]*height:\s*48px;[^}]*width:\s*48px;/s', $css);
		$this->assertMatchesRegularExpression('/\.gallery-icon-picker-image\s*\{[^}]*object-fit:\s*contain;/s', $css);
		$this->assertStringContainsString('transform: scale(3);', $css);
		$this->assertStringContainsString('label:focus-within .gallery-icon-picker-image', $css);
		$this->assertMatchesRegularExpression('/\.gallery-icon-picker-row\s*\{[^}]*overflow:\s*visible;[^}]*position:\s*relative;[^}]*z-index:\s*2;/s', $css);
		$this->assertMatchesRegularExpression('/\.gallery-icon-picker-option:hover,[^{]+\.gallery-icon-picker-option:focus-within\s*\{[^}]*z-index:\s*20;/s', $css);
		$this->assertMatchesRegularExpression('/#gallery-album-image-preview-src\s*\{[^}]*max-height:\s*256px;[^}]*max-width:\s*256px;[^}]*object-fit:\s*contain;/s', $css);
		$this->assertMatchesRegularExpression('/\.gallery-acp-album-list-icon-link\s*\{[^}]*height:\s*48px;[^}]*width:\s*48px;/s', $css);
		$this->assertMatchesRegularExpression('/\.gallery-acp-album-list-visual\s*\{[^}]*vertical-align:\s*middle;/s', $css);
		$this->assertStringContainsString('.gallery-acp-album-list-icon-link:hover .gallery-acp-album-list-icon', $css);
	}
}
