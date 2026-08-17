<?php
/**
 * phpBB Gallery - Core Extension tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;

class legacy_image_plugins_test extends TestCase
{
	public function test_obsolete_plugin_templates_and_template_variables_are_removed(): void
	{
		$styles_root = dirname(__DIR__) . '/styles';
		foreach (\gallery_test_existing_styles(dirname(__DIR__)) as $style)
		{
			$this->assertFileDoesNotExist($styles_root . '/' . $style . '/template/gallery/plugins_header.html');
		}

		$iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(
			$styles_root,
			\FilesystemIterator::SKIP_DOTS
		));
		foreach ($iterator as $file)
		{
			if (!$file->isFile() || $file->getExtension() !== 'html')
			{
				continue;
			}

			$template = (string) file_get_contents($file->getPathname());
			$this->assertDoesNotMatchRegularExpression('/S_GP_(?:HIGHSLIDE|LYTEBOX|SHADOWBOX)/', $template, $file->getPathname());
		}
	}

	public function test_obsolete_plugin_language_keys_are_removed_from_every_locale(): void
	{
		$language_root = dirname(__DIR__) . '/language';
		$obsolete_keys = [
			'UC_LINK_HIGHSLIDE',
			'UC_LINK_LYTEBOX',
			'UC_LINK_SHADOWBOX',
			'SLIDE_SHOW_HIGHSLIDE',
			'SLIDE_SHOW_LYTEBOX',
			'SLIDE_SHOW_SHADOWBOX',
		];
		foreach (glob($language_root . '/*', GLOB_ONLYDIR) as $locale)
		{
			foreach (['gallery.php', 'gallery_acp.php'] as $catalog_name)
			{
				$file = $locale . '/' . $catalog_name;
				$catalog = (string) file_get_contents($file);
				foreach ($obsolete_keys as $key)
				{
					$this->assertStringNotContainsString("'" . $key . "'", $catalog, $file);
				}
			}
		}
	}

	public function test_progressive_ajax_navigation_remains_packaged(): void
	{
		$this->assertFileExists(dirname(__DIR__) . '/styles/all/template/js/image_navigation.js');
		$this->assertStringContainsString(
			"'ajax_navigation'",
			(string) file_get_contents(dirname(__DIR__) . '/config.php')
		);
	}
}
