<?php
/**
 * phpBB Gallery - Image Revisions architecture tests
 *
 * @package   phpbbgallery/imagerevisions
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\imagerevisions\tests;

use PHPUnit\Framework\TestCase;

final class architecture_test extends TestCase
{
	private string $root;

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		$this->root = dirname(__DIR__);
	}

	public function test_addon_is_independently_packaged_and_disabled_by_default(): void
	{
		$composer = json_decode((string) file_get_contents($this->root . '/composer.json'), true, 512, JSON_THROW_ON_ERROR);
		$migration = (string) file_get_contents($this->root . '/migrations/m1_init.php');

		$this->assertSame('phpbbgallery/imagerevisions', $composer['name']);
		$this->assertSame('phpbb-extension', $composer['type']);
		$this->assertStringContainsString("['config.add', ['phpbb_gallery_imagerevisions_enabled', 0]]", $migration);
		$this->assertStringContainsString("['config.add', ['phpbb_gallery_imagerevisions_limit', 5]]", $migration);
		$this->assertStringContainsString("['permission.add', ['a_gallery_imagerevisions', true, 'a_board']]", $migration);
	}

	public function test_addon_uses_only_the_generic_core_extension_points(): void
	{
		$listener = (string) file_get_contents($this->root . '/event/main_listener.php');
		$services = (string) file_get_contents($this->root . '/config/services.yml');

		$this->assertStringContainsString("'phpbbgallery.core.image_edit_file' => 'replace_file'", $listener);
		$this->assertStringContainsString("'phpbbgallery.core.image_edit_display' => 'display_revisions'", $listener);
		$this->assertStringContainsString("'phpbbgallery.core.image.delete_images' => 'delete_revisions'", $listener);
		$this->assertStringContainsString('@phpbbgallery.core.upload', $services);
		$this->assertStringContainsString('$this->upload->set_up((int) $event[\'image_data\'][\'image_album_id\'], 1, false);', $listener);
		$this->assertStringContainsString('$this->upload->discard_uploaded_images();', $listener);
	}

	public function test_restore_is_post_only_reauthorized_and_csrf_protected(): void
	{
		$routing = (string) file_get_contents($this->root . '/config/routing.yml');
		$controller = (string) file_get_contents($this->root . '/controller/main.php');

		$this->assertMatchesRegularExpression('/phpbbgallery_imagerevisions_restore:[\s\S]*?methods: \[POST\]/', $routing);
		$this->assertStringContainsString('$this->authorize($image_id);', $controller);
		$this->assertStringContainsString("check_form_key('gallery')", $controller);
		$this->assertStringContainsString('can_manage_image(', $controller);
	}

	public function test_preview_is_private_and_never_serves_an_unresolved_path(): void
	{
		$controller = (string) file_get_contents($this->root . '/controller/main.php');
		$this->assertStringContainsString('resolve_source_file(', $controller);
		$this->assertStringContainsString("'X-Content-Type-Options', 'nosniff'", $controller);
		$this->assertStringContainsString("'Cache-Control', 'private, no-store, max-age=0'", $controller);
	}

	public function test_every_core_locale_has_the_complete_addon_catalog(): void
	{
		$gallery_root = dirname($this->root);
		$core_locales = array_map('basename', glob($gallery_root . '/core/language/*', GLOB_ONLYDIR) ?: []);
		sort($core_locales);
		$addon_locales = array_map('basename', glob($this->root . '/language/*', GLOB_ONLYDIR) ?: []);
		sort($addon_locales);

		$this->assertSame($core_locales, $addon_locales);
		foreach ($addon_locales as $locale)
		{
			$files = array_map('basename', glob($this->root . '/language/' . $locale . '/*.php') ?: []);
			sort($files);
			$this->assertSame(['imagerevisions.php', 'info_acp_imagerevisions.php', 'info_imagerevisions.php'], $files, $locale);
		}
	}

	public function test_all_supported_styles_offer_replacement_and_history_controls(): void
	{
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$template = (string) file_get_contents($this->root . '/styles/' . $style . '/template/event/phpbbgallery_core_edit_addfields.html');
			$this->assertStringContainsString('name="files[]"', $template, $style);
			$this->assertStringContainsString('accept="{{ S_REPLACEMENT_FILETYPES_ACCEPT }}"', $template, $style);
			$this->assertStringContainsString('formaction="{{ revision.U_RESTORE }}"', $template, $style);
			$this->assertStringContainsString('formmethod="post"', $template, $style);
			if ($style !== 'prosilver')
			{
				$this->assertDoesNotMatchRegularExpression('/<\/?(?:dl|dt|dd)\b/i', $template, $style);
			}
		}
	}

	public function test_purge_deletes_only_validated_historical_source_files(): void
	{
		$migration = (string) file_get_contents($this->root . '/migrations/m1_init.php');
		$this->assertStringContainsString("['custom', [[\$this, 'delete_revision_files']]]", $migration);
		$this->assertStringContainsString('realpath($this->phpbb_root_path . \'files/phpbbgallery/core/source\')', $migration);
		$this->assertStringContainsString('strncasecmp($normalized_path, $root_prefix', $migration);
		$this->assertStringContainsString('@unlink($path);', $migration);
	}
}
