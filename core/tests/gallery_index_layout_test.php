<?php
/**
 * phpBB Gallery - Gallery index layout tests.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;

final class gallery_index_layout_test extends TestCase
{
	public function test_every_style_exposes_classic_modern_and_card_layouts(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$index = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/index_body.html');

			$this->assertStringContainsString("GALLERY_INDEX_ALBUM_LAYOUT == 'classic'", $index, $style);
			$this->assertStringContainsString("GALLERY_INDEX_ALBUM_LAYOUT == 'modern'", $index, $style);
			$this->assertStringContainsString("{% include 'gallery/albumlist_body.html' %}", $index, $style);
			$this->assertStringContainsString("{% include '@phpbbgallery_core/gallery/albumlist_modern.html' %}", $index, $style);
			$this->assertStringContainsString("{% include 'gallery/albumlist_polaroid.html' %}", $index, $style);
		}
	}

	public function test_modern_layout_is_responsive_and_preserves_album_information(): void
	{
		$core_root = dirname(__DIR__);
		$template = (string) file_get_contents($core_root . '/styles/all/template/gallery/albumlist_modern.html');
		$css = (string) file_get_contents($core_root . '/styles/all/theme/gallery.css');

		$this->assertStringContainsString('gallery-modern-album-list', $template);
		$this->assertStringContainsString('albumrow.S_UNREAD_ALBUM', $template);
		$this->assertStringContainsString('albumrow.S_LOCKED_ALBUM', $template);
		$this->assertStringContainsString('albumrow.ALBUM_DESC', $template);
		$this->assertStringContainsString('albumrow.MODERATORS', $template);
		$this->assertStringContainsString('albumrow.subalbum|length', $template);
		$this->assertStringContainsString('albumrow.UNAPPROVED_IMAGES', $template);
		$this->assertStringContainsString('albumrow.LAST_USER_FULL', $template);
		$this->assertStringContainsString('grid-template-columns: minmax(0, 1fr) minmax(245px, 32%);', $css);
		$this->assertStringContainsString('@media (max-width: 700px)', $css);
	}

	public function test_index_controller_assigns_only_a_normalized_layout(): void
	{
		$controller = (string) file_get_contents(dirname(__DIR__) . '/controller/index.php');

		$this->assertSame(2, substr_count($controller, '$this->gallery_config->get_index_album_layout()'));
		$this->assertStringNotContainsString("get('index_album_layout')", $controller);
	}

	public function test_modern_layout_uses_the_context_aware_public_album_label(): void
	{
		$template = (string) file_get_contents(dirname(__DIR__) . '/styles/all/template/gallery/albumlist_modern.html');

		$this->assertStringContainsString('GALLERY_PUBLIC_ALBUMS_LABEL', $template);
		$this->assertStringContainsString("lang('PERSONAL_ALBUMS')", $template);
	}

	public function test_bootstrap_card_layouts_are_self_contained_responsive_grids(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			$template = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/albumlist_polaroid.html');

			$this->assertStringContainsString('class="row gallery-album-card-grid"', $template, $style);
			$this->assertStringContainsString('gallery-album-card-column', $template, $style);
			$this->assertStringContainsString('gallery-album-grid-heading', $template, $style);
			$this->assertStringNotContainsString('<span class="clear"></span>', $template, $style);
		}

		$css = (string) file_get_contents($core_root . '/styles/all/theme/gallery.css');
		$this->assertMatchesRegularExpression('/\.gallery-album-card-grid\s*\{[^}]*display:\s*flex;[^}]*flex-wrap:\s*wrap;/s', $css);
		$this->assertMatchesRegularExpression('/\.gallery-album-card-column\s*\{[^}]*display:\s*flex;[^}]*float:\s*none;/s', $css);
	}
}
