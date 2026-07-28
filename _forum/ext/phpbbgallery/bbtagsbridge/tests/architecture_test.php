<?php
/**
 * phpBB Gallery BBTags Bridge architecture tests.
 *
 * @package   phpbbgallery/bbtagsbridge
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbtagsbridge\tests;

use PHPUnit\Framework\TestCase;

final class architecture_test extends TestCase
{
	private string $root;

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		$this->root = dirname(__DIR__);
	}

	public function test_addon_requires_and_auto_enables_both_extensions(): void
	{
		$composer = json_decode((string) file_get_contents($this->root . '/composer.json'), true, 512, JSON_THROW_ON_ERROR);
		$extension = (string) file_get_contents($this->root . '/ext.php');

		$this->assertSame('phpbbgallery/bbtagsbridge', $composer['name']);
		$this->assertStringContainsString("'phpbbgallery/core'", $extension);
		$this->assertStringContainsString("'sitesplat/bbtags'", $extension);
		$this->assertSame(2, substr_count($extension, '$manager->is_enabled($dependency)'));
		$this->assertStringContainsString('$manager->enable($dependency)', $extension);
	}

	public function test_schema_owns_only_image_relations_to_the_shared_catalogue(): void
	{
		$migration = (string) file_get_contents($this->root . '/migrations/m1_init.php');

		$this->assertStringContainsString("gallery_image_tags'", $migration);
		$this->assertStringContainsString("'PRIMARY_KEY' => ['image_id', 'tag_id']", $migration);
		$this->assertStringContainsString('sitesplat\\bbtags\\migrations\\v33x\\m11_tag_moderation', $migration);
		$this->assertStringNotContainsString("gallery_tags'", $migration);
		$this->assertFileDoesNotExist($this->root . '/tag_parser.php');
	}

	public function test_gallery_provider_is_registered_through_the_bbtags_api(): void
	{
		$services = (string) file_get_contents($this->root . '/config/services.yml');
		$provider = (string) file_get_contents($this->root . '/provider/image_provider.php');

		$this->assertStringContainsString('name: sitesplat.bbtags.provider', $services);
		$this->assertStringContainsString('implements provider_interface', $provider);
		$this->assertStringContainsString("PROVIDER = 'gallery_images'", (string) file_get_contents($this->root . '/image_tag_manager.php'));
	}

	public function test_listener_loads_provider_language_and_cleans_deleted_images(): void
	{
		$listener = (string) file_get_contents($this->root . '/event/main_listener.php');

		$this->assertStringContainsString("'core.user_setup'", $listener);
		$this->assertStringContainsString("'phpbbgallery.core.viewimage'", $listener);
		$this->assertStringContainsString("'phpbbgallery.core.search.configure'", $listener);
		$this->assertStringContainsString("'phpbbgallery.core.search.results'", $listener);
		$this->assertStringContainsString("'phpbbgallery.core.image_edit_file'", $listener);
		$this->assertStringContainsString("'phpbbgallery.core.image_edit_display'", $listener);
		$this->assertStringContainsString("'phpbbgallery.core.image_edit_after'", $listener);
		$this->assertStringContainsString("'phpbbgallery.core.upload.review_validate'", $listener);
		$this->assertStringContainsString("'phpbbgallery.core.upload.review_display'", $listener);
		$this->assertStringContainsString("'phpbbgallery.core.upload.update_image_after'", $listener);
		$this->assertStringContainsString("'phpbbgallery.core.image.delete_images'", $listener);
		$this->assertStringContainsString("'ext_name' => 'phpbbgallery/bbtagsbridge'", $listener);
		$this->assertStringContainsString("acl_get('u_bbtags')", $listener);
		$this->assertStringContainsString("acl_get('m_bbtags_moderate')", $listener);
		$this->assertStringContainsString('classify_tags(', $listener);
		$this->assertStringContainsString('sync_item_suggestions(', $listener);
		$this->assertStringContainsString('cancel_items(', $listener);
	}

	public function test_all_supported_styles_integrate_editing_and_viewing_without_legacy_markup_in_modern_styles(): void
	{
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$event_root = $this->root . '/styles/' . $style . '/template/event/';
			$edit = (string) file_get_contents($event_root . 'phpbbgallery_core_edit_addfields.html');
			$view = (string) file_get_contents($event_root . 'phpbbgallery_core_viewimage_details.html');
			$search = (string) file_get_contents($event_root . 'phpbbgallery_core_search_fields.html');
			$facets = (string) file_get_contents($event_root . 'phpbbgallery_core_search_results_facets.html');

			$this->assertStringContainsString('bbtagsbridge_tags[{{ image.S_ROW_COUNT }}]', $edit, $style);
			$this->assertStringContainsString('BBTAGSBRIDGE_PENDING_NOTICE', $edit, $style);
			$this->assertStringContainsString('bbtagsbridge_tags', $view, $style);
			$this->assertStringContainsString('tag.U_SEARCH', $view, $style);
			$this->assertStringContainsString('name="tag_operator"', $search, $style);
			$this->assertStringContainsString('U_BBTAGSBRIDGE_AUTOCOMPLETE', $search, $style);
			$this->assertStringContainsString('bbtagsbridge_facets', $facets, $style);
			if ($style !== 'prosilver')
			{
				$this->assertStringNotContainsString('<dl', $search . $facets, $style);
			}
			if ($style !== 'prosilver')
			{
				$this->assertDoesNotMatchRegularExpression('/<(?:dl|dt|dd)\b/i', $edit . $view, $style);
			}
		}
	}

	public function test_autocomplete_is_ajax_read_only_and_permission_scoped(): void
	{
		$controller = (string) file_get_contents($this->root . '/controller/tag_controller.php');
		$routing = (string) file_get_contents($this->root . '/config/routing.yml');
		$javascript = (string) file_get_contents($this->root . '/styles/all/template/js/gallery_tag_search.js');

		$this->assertStringContainsString('is_ajax()', $controller);
		$this->assertStringContainsString("acl_get('u_search')", $controller);
		$this->assertStringContainsString("acl_get('u_bbtags_read')", $controller);
		$this->assertStringContainsString("acl_album_ids('i_view')", $controller);
		$this->assertStringContainsString('get_provider_tags(', $controller);
		$this->assertStringContainsString('methods: [POST]', $routing);
		$this->assertStringContainsString("'X-Requested-With': 'XMLHttpRequest'", $javascript);
		$this->assertStringNotContainsString('innerHTML', $javascript);
	}

	public function test_every_core_locale_has_complete_bridge_catalogues(): void
	{
		$core_locales = array_map('basename', glob(dirname($this->root) . '/core/language/*', GLOB_ONLYDIR) ?: []);
		sort($core_locales);
		$addon_locales = array_map('basename', glob($this->root . '/language/*', GLOB_ONLYDIR) ?: []);
		sort($addon_locales);

		$this->assertSame($core_locales, $addon_locales);
		foreach ($addon_locales as $locale)
		{
			$files = array_map('basename', glob($this->root . '/language/' . $locale . '/*.php') ?: []);
			sort($files);
			$this->assertSame(['bbtagsbridge.php', 'info_bbtagsbridge.php'], $files, $locale);
			foreach ($files as $file)
			{
				$this->assertSame(
					$this->language_keys($this->root . '/language/en/' . $file),
					$this->language_keys($this->root . '/language/' . $locale . '/' . $file),
					$locale . '/' . $file
				);
			}
		}
	}

	private function language_keys(string $path): array
	{
		preg_match_all("/^\\s*'([A-Z0-9_]+)'\\s*=>/m", (string) file_get_contents($path), $matches);
		$keys = array_values(array_unique($matches[1]));
		sort($keys);

		return $keys;
	}
}
