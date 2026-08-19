<?php
/**
 * phpBB Gallery - independent album-list navigation tests.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;

final class album_list_navigation_test extends TestCase
{
	public function test_index_uses_independent_public_and_personal_pages(): void
	{
		$source = $this->read('controller/index.php');

		$this->assertStringContainsString("variable('public_page', 1)", $source);
		$this->assertStringContainsString("variable('personal_page', 1)", $source);
		$this->assertStringContainsString("get('albums_per_page')", $source);
		$this->assertStringContainsString("false, 'public_albumrow'", $source);
		$this->assertStringContainsString("false, 'personal_albumrow'", $source);
		$this->assertStringContainsString("'public_pagination', 'public_page'", $source);
		$this->assertStringContainsString("'personal_pagination', 'personal_page'", $source);
		$this->assertStringContainsString("['personal_page' => \$personal_page]", $source);
		$this->assertStringContainsString("['public_page' => \$public_page]", $source);
		$this->assertStringContainsString("['first_char' => \$first_char]", $source);
	}

	public function test_personal_directory_uses_the_album_limit_and_personal_rendering_mode(): void
	{
		$source = $this->read('controller/index.php');

		$this->assertStringContainsString("max(1, (int) \$this->gallery_config->get('albums_per_page'))", $source);
		$this->assertStringContainsString("'S_PERSONAL_GALLERY' => true", $source);
		$this->assertStringContainsString("\$this->display->album_mode = 'personal'", $source);
		$this->assertStringContainsString("'pagination', 'page'", $source);
	}

	public function test_album_keeps_subalbum_and_image_pages_independent(): void
	{
		$source = $this->read('controller/album.php');

		$this->assertStringContainsString("variable('subalbum_page', 1)", $source);
		$this->assertStringContainsString("false, 'subalbumrow'", $source);
		$this->assertStringContainsString("'subalbum_pagination', 'subalbum_page'", $source);
		$this->assertStringContainsString("\$image_pagination_params['subalbum_page']", $source);
		$this->assertStringContainsString("'S_AJAX_LIST_NAVIGATION'", $source);
	}

	public function test_templates_expose_replaceable_sections_in_every_style(): void
	{
		$index_sections = $this->read('styles/all/template/gallery/albumlist_index_sections.html');
		$this->assertStringContainsString('data-gallery-list-section="public-albums"', $index_sections);
		$this->assertStringContainsString('data-gallery-list-section="personal-albums"', $index_sections);
		$this->assertStringContainsString('pagination: public_pagination', $index_sections);
		$this->assertStringContainsString('data-gallery-list-section="personal-directory"', $index_sections);
		$this->assertStringContainsString('albumrow: albumrow', $index_sections);
		$this->assertStringContainsString('pagination: pagination', $index_sections);
		$this->assertStringContainsString('pagination: personal_pagination', $index_sections);
		$this->assertStringNotContainsString("include 'pagination.html'", $index_sections);

		$pagination = $this->read('styles/all/template/gallery/list_pagination.html');
		$this->assertStringContainsString('{% for page in pagination %}', $pagination);
		$this->assertStringContainsString('page.PAGE_URL', $pagination);
		$this->assertStringNotContainsString('BEGIN pagination', $pagination);
		$this->assertStringContainsString('albumrow: public_albumrow', $index_sections);
		$this->assertStringContainsString('albumrow: personal_albumrow', $index_sections);

		foreach (\gallery_test_existing_styles(dirname(__DIR__)) as $style)
		{
			$index = $this->read('styles/' . $style . '/template/gallery/index_body.html');
			$album = $this->read('styles/' . $style . '/template/gallery/album_body.html');
			$footer = $this->read('styles/' . $style . '/template/gallery/gallery_footer.html');

			$this->assertStringContainsString('albumlist_index_sections.html', $index, $style);
			$this->assertStringContainsString('data-gallery-list-section="subalbums"', $album, $style);
			$this->assertStringContainsString('albumrow: subalbumrow', $album, $style);
			$this->assertStringContainsString('subalbum_pagination', $album, $style);
			$this->assertStringContainsString('list_pagination.html', $album, $style);
			$this->assertStringContainsString('S_AJAX_LIST_NAVIGATION', $footer, $style);
			$this->assertStringContainsString('gallery-album-list-total', $album, $style);
			$this->assertStringContainsString('list_navigation.js', $footer, $style);
			if ($style === 'prosilver')
			{
				$this->assertStringNotContainsString("include 'pagination.html'", $index, $style);
			}
		}
		$css = $this->read('styles/all/theme/gallery.css');
		$this->assertMatchesRegularExpression('/\.gallery-album-list-pagination\s*\{[^}]*clear:\s*both;[^}]*display:\s*flex;[^}]*float:\s*none !important;[^}]*margin:\s*8px 0 12px;/s', $css);
		$this->assertMatchesRegularExpression('/\.gallery-album-list-pagination \.gallery-album-list-total\s*\{[^}]*margin-right:\s*10px;/s', $css);
	}

	public function test_progressive_navigation_preserves_history_and_has_a_normal_fallback(): void
	{
		$script = $this->read('styles/all/template/js/list_navigation.js');

		$this->assertStringContainsString('window.fetch(url.href', $script);
		$this->assertStringContainsString("credentials: 'same-origin'", $script);
		$this->assertStringContainsString("'X-Requested-With': 'XMLHttpRequest'", $script);
		$this->assertStringContainsString('window.history.pushState', $script);
		$this->assertStringContainsString("window.addEventListener('popstate'", $script);
		$this->assertStringContainsString('window.location.assign(url.href)', $script);
		$this->assertStringContainsString('window.location.reload()', $script);
		$this->assertStringContainsString('aria-busy', $script);
		$this->assertStringContainsString('phpbbgallery:list-updated', $script);
		$this->assertStringNotContainsString('jQuery', $script);
		$this->assertStringNotContainsString('Vue', $script);
	}

	private function read(string $path): string
	{
		return (string) file_get_contents(dirname(__DIR__) . '/' . $path);
	}
}
