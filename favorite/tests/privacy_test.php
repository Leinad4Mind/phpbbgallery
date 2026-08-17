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
		$this->assertStringContainsString('$gallery_auth->get_exclude_zebra()', $source);
		$this->assertStringContainsString('array_values(array_diff(', $source);
	}

	public function test_favorites_are_rendered_inside_the_ucp_and_have_navigation_language(): void
	{
		$root = dirname(__DIR__);
		foreach (\gallery_test_existing_styles(dirname(__DIR__)) as $style)
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

	public function test_bootstrap_favorite_actions_keep_the_select_and_submit_button_together(): void
	{
		$root = dirname(__DIR__) . '/styles/';
		foreach (\gallery_test_existing_styles(dirname(__DIR__), ['BBOOTS', 'FLATBOOTS'], $this) as $style)
		{
			$template = (string) file_get_contents($root . $style . '/template/gallery/ucp_gallery_favorite.html');
			$this->assertStringContainsString('class="input-group col-xs-12 col-sm-8 col-md-6"', $template, $style);
			$this->assertStringContainsString('class="selectpicker" data-container="body" data-width="100%"', $template, $style);
			$this->assertStringContainsString('class="input-group-btn"><button type="submit"', $template, $style);
		}
	}

	public function test_favorite_pagination_uses_each_style_native_container(): void
	{
		$root = dirname(__DIR__) . '/styles/';
		$prosilver = (string) file_get_contents($root . 'prosilver/template/gallery/ucp_gallery_favorite.html');
		$this->assertMatchesRegularExpression(
			'/<div class="pagination">.*\{% include \'pagination.html\' %\}.*<\/div>/s',
			$prosilver
		);
		$this->assertStringContainsString('<dl class="row-item">', $prosilver);
		$this->assertStringContainsString('class="list-inner gallery-favorite-ucp-row"', $prosilver);

		foreach (\gallery_test_existing_styles(dirname(__DIR__), ['BBOOTS', 'FLATBOOTS'], $this) as $style)
		{
			$template = (string) file_get_contents($root . $style . '/template/gallery/ucp_gallery_favorite.html');
			$this->assertMatchesRegularExpression(
				'/<ul class="pagination pagination-sm pull-right">.*\{% include \'pagination.html\' %\}.*<\/ul>/s',
				$template,
				$style
			);
		}
	}
}
