<?php
/**
 * BBPoints Images language tests
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbpointsimages\tests;

use PHPUnit\Framework\TestCase;

final class language_test extends TestCase
{
	public function test_every_gallery_locale_has_the_dependency_message_and_placeholder(): void
	{
		$gallery_locales = array_map('basename', glob(dirname(__DIR__, 2) . '/core/language/*', GLOB_ONLYDIR));
		sort($gallery_locales);
		$addon_locales = array_map('basename', glob(dirname(__DIR__) . '/language/*', GLOB_ONLYDIR));
		sort($addon_locales);

		$this->assertSame($gallery_locales, $addon_locales);
		foreach ($addon_locales as $locale)
		{
			$lang = [];
			require dirname(__DIR__) . '/language/' . $locale . '/info_acp_bbpointsimages.php';
			$this->assertArrayHasKey('BBPOINTSIMAGES_DEPENDENCIES_MISSING', $lang, $locale);
			$this->assertSame(1, substr_count($lang['BBPOINTSIMAGES_DEPENDENCIES_MISSING'], '%s'), $locale);
		}
	}
}
