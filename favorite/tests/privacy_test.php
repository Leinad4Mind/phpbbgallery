<?php
/**
 * phpBB Gallery - Favorite privacy tests
 *
 * @package   phpbbgallery/favorite
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\favorite\tests;

use PHPUnit\Framework\TestCase;

final class privacy_test extends TestCase
{
	public function test_favorite_rows_use_the_decoupled_core_identity_policy(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/ucp/main_module.php');

		$this->assertStringContainsString("get('phpbbgallery.core.policy.image_visibility')", $source);
		$this->assertStringContainsString('$image_visibility->hides_private_data(', $source);
		$this->assertStringContainsString('$image_visibility->private_data_label(', $source);
		$this->assertStringContainsString("lang('GALLERY_PRIVATE_USER')", $source);
		$this->assertStringNotContainsString('phpbbgallery\\core\\contest', $source);
		$this->assertStringNotContainsString('CONTEST_USERNAME', $source);
	}

	public function test_favorites_are_rendered_inside_the_ucp_and_have_navigation_language(): void
	{
		$root = dirname(__DIR__);
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$template = trim((string) file_get_contents($root . '/styles/' . $style . '/template/gallery/ucp_gallery_favorite.html'));
			$this->assertStringStartsWith("{% include 'ucp_header.html' %}", $template, $style);
			$this->assertStringEndsWith("{% include 'ucp_footer.html' %}", $template, $style);
		}

		foreach (['bg', 'de', 'en', 'es', 'fr', 'it', 'nl', 'pt', 'pt_br', 'pt_preao', 'ru'] as $language)
		{
			$language_file = $root . '/language/' . $language . '/info_ucp_gallery_favorite.php';
			$this->assertFileExists($language_file, $language);
			$this->assertStringContainsString("'UCP_GALLERY_FAVORITES'", (string) file_get_contents($language_file), $language);
		}
	}
}
