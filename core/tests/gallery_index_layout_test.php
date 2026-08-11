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
	public function test_every_style_exposes_classic_modern_card_and_futuristic_layouts_on_index_and_inside_albums(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$index = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/index_body.html');
			$album = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/album_body.html');

			foreach (['index' => $index, 'album' => $album] as $context => $template)
			{
				$message = $style . '/' . $context;
				$this->assertStringContainsString("GALLERY_INDEX_ALBUM_LAYOUT == 'classic'", $template, $message);
				$this->assertStringContainsString("GALLERY_INDEX_ALBUM_LAYOUT == 'modern'", $template, $message);
				$this->assertStringContainsString("GALLERY_INDEX_ALBUM_LAYOUT == 'futuristic'", $template, $message);
				$this->assertStringContainsString("{% include 'gallery/albumlist_body.html' %}", $template, $message);
				$this->assertStringContainsString("{% include '@phpbbgallery_core/gallery/albumlist_modern.html' %}", $template, $message);
				$this->assertStringContainsString('@phpbbgallery_core/gallery/albumlist_futuristic.html', $template, $message);
				$this->assertStringContainsString("{% include 'gallery/albumlist_polaroid.html' %}", $template, $message);
			}
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
		$this->assertStringContainsString('albumrow.UC_LAST_IMAGE_THUMBNAIL and not albumrow.S_ALBUM_VISUAL_IS_LAST_IMAGE', $template);
		$this->assertStringContainsString('albumrow.U_LAST_IMAGE', $template);
		$this->assertStringContainsString('grid-template-columns: minmax(0, 1fr) minmax(245px, 32%);', $css);
		$this->assertStringContainsString('@media (max-width: 700px)', $css);
	}

	public function test_classic_layout_controls_image_grids_without_duplicating_style_markup(): void
	{
		$core_root = dirname(__DIR__);
		$selector = (string) file_get_contents($core_root . '/styles/all/template/gallery/imageblock_layout.html');
		$classic = (string) file_get_contents($core_root . '/styles/all/template/gallery/imageblock_classic.html');
		$css = (string) file_get_contents($core_root . '/styles/all/theme/gallery.css');

		$this->assertStringContainsString("GALLERY_INDEX_ALBUM_LAYOUT == 'classic'", $selector);
		$this->assertStringContainsString('@phpbbgallery_core/gallery/imageblock_classic.html', $selector);
		$this->assertStringContainsString('gallery/imageblock_polaroid.html', $selector);
		$this->assertStringContainsString('gallery-classic-image-grid', $classic);
		$this->assertStringContainsString('phpbbgallery_core_album_image_actions', $classic);
		$this->assertStringContainsString('phpbbgallery_core_album_image_metadata', $classic);
		$this->assertStringContainsString('album_rating_stars.html', $classic);
		$this->assertStringContainsString('S_STATUS_UNAPPROVED_ACTION', $classic);
		$this->assertStringContainsString('grid-template-columns: repeat(auto-fill, minmax(min(100%, 210px), 1fr));', $css);
		$this->assertMatchesRegularExpression(
			'/\\.gallery-classic-thumbnail\\s*\\{[^}]*box-sizing:\\s*border-box;[^}]*overflow:\\s*hidden;/s',
			$css
		);
		$this->assertMatchesRegularExpression(
			'/\\.gallery-classic-thumbnail img\\s*\\{[^}]*max-width:\\s*100%;[^}]*max-height:\\s*calc\\(var\\(--gallery-classic-thumbnail-size\\) - 16px\\);[^}]*object-fit:\\s*contain;/s',
			$css
		);
	}

	public function test_prosilver_classic_titles_align_to_the_start_without_changing_bootstrap_styles(): void
	{
		$core_root = dirname(__DIR__);
		$selector = (string) file_get_contents($core_root . '/styles/prosilver/template/gallery/imageblock_layout.html');
		$bboots_selector = (string) file_get_contents($core_root . '/styles/BBOOTS/template/gallery/imageblock_layout.html');
		$flatboots_selector = (string) file_get_contents($core_root . '/styles/FLATBOOTS/template/gallery/imageblock_layout.html');
		$search = (string) file_get_contents($core_root . '/styles/prosilver/template/gallery/search_results.html');
		$classic = (string) file_get_contents($core_root . '/styles/all/template/gallery/imageblock_classic.html');
		$css = (string) file_get_contents($core_root . '/styles/all/theme/gallery.css');

		$this->assertStringContainsString('GALLERY_CLASSIC_TITLE_ALIGN_START: true', $selector);
		$this->assertStringContainsString('GALLERY_CLASSIC_TITLE_ALIGN_START: true', $search);
		$this->assertStringContainsString('gallery-classic-image-block--title-start', $classic);
		$this->assertMatchesRegularExpression(
			'/\.gallery-classic-image-block--title-start \.gallery-classic-image-title\s*\{[^}]*justify-content:\s*flex-start;[^}]*text-align:\s*start;/s',
			$css
		);
		$this->assertStringNotContainsString('GALLERY_CLASSIC_TITLE_ALIGN_START', $bboots_selector);
		$this->assertStringNotContainsString('GALLERY_CLASSIC_TITLE_ALIGN_START', $flatboots_selector);
	}

	public function test_futuristic_layout_preserves_gallery_contracts_and_has_a_theme_variant(): void
	{
		$core_root = dirname(__DIR__);
		$albums = (string) file_get_contents($core_root . '/styles/all/template/gallery/albumlist_futuristic.html');
		$images = (string) file_get_contents($core_root . '/styles/all/template/gallery/imageblock_futuristic.html');
		$css = (string) file_get_contents($core_root . '/styles/all/theme/gallery.css');

		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$variant = strtolower($style);
			$selector = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/imageblock_layout.html');
			$this->assertStringContainsString("GALLERY_INDEX_ALBUM_LAYOUT == 'futuristic'", $selector, $style);
			$this->assertStringContainsString("GALLERY_FUTURISTIC_VARIANT: '" . $variant . "'", $selector, $style);
			$this->assertStringContainsString('.gallery-futuristic--' . $variant, $css, $style);
		}

		$this->assertStringContainsString('albumrow.S_PERSONAL_SECTION_START', $albums);
		$this->assertStringContainsString('albumrow.S_UNREAD_ALBUM', $albums);
		$this->assertStringContainsString('albumrow.S_LOCKED_ALBUM', $albums);
		$this->assertStringContainsString('albumrow.subalbum|length', $albums);
		$this->assertStringContainsString('albumrow.UNAPPROVED_IMAGES', $albums);
		$this->assertStringContainsString('albumrow.LAST_USER_FULL', $albums);
		$this->assertStringContainsString('albumrow.UC_LAST_IMAGE_THUMBNAIL and not albumrow.S_ALBUM_VISUAL_IS_LAST_IMAGE', $albums);
		$this->assertStringContainsString('albumrow.U_LAST_IMAGE', $albums);
		$this->assertStringContainsString('phpbbgallery_core_album_image_actions', $images);
		$this->assertStringContainsString('phpbbgallery_core_album_image_metadata', $images);
		$this->assertStringContainsString('album_rating_stars.html', $images);
		$this->assertStringContainsString('S_STATUS_UNAPPROVED_ACTION', $images);
		$this->assertStringContainsString('grid-template-columns: repeat(auto-fill, minmax(min(100%, 230px), 1fr));', $css);
		$this->assertStringContainsString('@media (prefers-reduced-motion', str_replace('(hover: hover) and ', '', $css));
	}

	public function test_optional_real_image_id_copies_the_active_bbcode_in_every_card_layout(): void
	{
		$core_root = dirname(__DIR__);
		$classic = (string) file_get_contents($core_root . '/styles/all/template/gallery/imageblock_classic.html');
		$futuristic = (string) file_get_contents($core_root . '/styles/all/template/gallery/imageblock_futuristic.html');
		$control = (string) file_get_contents($core_root . '/styles/all/template/gallery/image_bbcode_copy.html');
		$javascript = (string) file_get_contents($core_root . '/styles/all/template/js/image_bbcode_copy.js');

		$this->assertStringNotContainsString('loop.index', $futuristic);
		$this->assertStringNotContainsString('gallery-futuristic-image-index', $futuristic);
		$this->assertStringContainsString('image_bbcode_copy.html', $classic);
		$this->assertStringContainsString('image_bbcode_copy.html', $futuristic);

		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$cards = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/imageblock_polaroid.html');
			$this->assertStringContainsString('image_bbcode_copy.html', $cards, $style);
		}
		foreach (['all', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$footer = (string) file_get_contents($core_root . '/styles/' . $style . '/template/event/overall_footer_after.html');
			$this->assertStringContainsString('image_bbcode_copy.js', $footer, $style);
		}

		$this->assertStringContainsString('S_GALLERY_IMAGE_ID_BBCODE', $control);
		$this->assertStringContainsString('image.IMAGE_ID', $control);
		$this->assertStringContainsString("GALLERY_BBCODE_TAG|default('image')", $control);
		$this->assertStringContainsString('data-gallery-copy-bbcode', $control);
		$this->assertStringContainsString('navigator.clipboard.writeText', $javascript);
		$this->assertStringContainsString("document.execCommand('copy')", $javascript);
		$this->assertStringContainsString('is-copied', $javascript);
	}

	public function test_album_list_distinguishes_its_main_visual_from_the_latest_image(): void
	{
		$display = (string) file_get_contents(dirname(__DIR__) . '/album/display.php');

		$this->assertStringContainsString("'S_ALBUM_VISUAL_IS_LAST_IMAGE' => !\$row['album_image']", $display);
		$this->assertStringContainsString("'LAST_IMAGE_ID'", $display);
		$this->assertStringContainsString("'UC_LAST_IMAGE_THUMBNAIL'", $display);
		$this->assertStringContainsString("'U_LAST_IMAGE'", $display);
		$this->assertStringContainsString("['image_id' => \$row['album_last_image_id']]", $display);
	}

	public function test_uploaded_album_icons_use_the_board_root_in_every_layout(): void
	{
		$core_root = dirname(__DIR__);
		$display = (string) file_get_contents($core_root . '/album/display.php');

		$this->assertStringContainsString("rtrim(\$this->symfony_request->getBasePath(), '/')", $display);
		$this->assertStringContainsString("\$board_path . '/' . ltrim(\$album_image, '/')", $display);
		$this->assertSame(2, substr_count($display, "'ALBUM_IMAGE_SRC'"));
		$services = (string) file_get_contents($core_root . '/config/services.yml');
		$display_service = strstr($services, 'phpbbgallery.core.album.display:');
		$display_service = strstr($display_service, 'phpbbgallery.core.album.loader:', true);
		$this->assertStringContainsString("- '@symfony_request'", $display_service);

		$templates = [
			$core_root . '/styles/prosilver/template/gallery/albumlist_body.html',
			$core_root . '/styles/BBOOTS/template/gallery/albumlist_body.html',
			$core_root . '/styles/FLATBOOTS/template/gallery/albumlist_body.html',
			$core_root . '/styles/all/template/gallery/albumlist_modern.html',
			$core_root . '/styles/all/template/gallery/albumlist_futuristic.html',
		];
		foreach ($templates as $template_path)
		{
			$template = (string) file_get_contents($template_path);
			$this->assertStringContainsString('albumrow.ALBUM_IMAGE_SRC', $template, $template_path);
			$this->assertStringNotContainsString('T_IMAGES_PATH }}{{ albumrow.ALBUM_IMAGE', $template, $template_path);
		}
	}

	public function test_album_recent_random_and_search_grids_use_the_layout_selector_in_every_style(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			foreach (['album_body.html', 'recent_body.html', 'search_recent.html', 'search_random.html'] as $filename)
			{
				$template = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/' . $filename);
				$this->assertStringContainsString(
					'@phpbbgallery_core/gallery/imageblock_layout.html',
					$template,
					$style . '/' . $filename
				);
			}

			$search_results = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/search_results.html');
			$this->assertTrue(
				str_contains($search_results, '@phpbbgallery_core/gallery/imageblock_layout.html')
					|| str_contains($search_results, '@phpbbgallery_core/gallery/imageblock_classic.html'),
				$style . '/search_results.html'
			);
		}
	}

	public function test_album_and_image_section_titles_share_the_same_visual_hierarchy(): void
	{
		$css = (string) file_get_contents(dirname(__DIR__) . '/styles/all/theme/gallery.css');

		$this->assertStringContainsString('.gallery-album-section-title h3,', $css);
		$this->assertStringContainsString('.gallery-image-block-title', $css);
		$this->assertMatchesRegularExpression(
			'/\\.gallery-album-section-title,[^{]+\\.gallery-image-block-title\\s*\\{[^}]*color:\\s*#2880b2;[^}]*font-size:\\s*20px;/s',
			$css
		);
	}

	public function test_index_controller_assigns_only_a_normalized_layout(): void
	{
		$controller = (string) file_get_contents(dirname(__DIR__) . '/controller/index.php');

		$this->assertSame(2, substr_count($controller, '$this->gallery_config->get_index_album_layout()'));
		$this->assertStringNotContainsString("get('index_album_layout')", $controller);
	}

	public function test_album_controller_assigns_the_same_normalized_layout_to_subalbum_lists(): void
	{
		$controller = (string) file_get_contents(dirname(__DIR__) . '/controller/album.php');

		$this->assertSame(1, substr_count($controller, '$this->gallery_config->get_index_album_layout()'));
		$this->assertStringContainsString("'GALLERY_INDEX_ALBUM_LAYOUT' => \$this->gallery_config->get_index_album_layout()", $controller);
		$this->assertStringNotContainsString("get('index_album_layout')", $controller);
	}

	public function test_search_controller_assigns_the_same_normalized_layout_to_image_results(): void
	{
		$controller = (string) file_get_contents(dirname(__DIR__) . '/controller/search.php');

		$this->assertSame(1, substr_count($controller, '$this->gallery_config->get_index_album_layout()'));
		$this->assertStringContainsString(
			"\$this->template->assign_var('GALLERY_INDEX_ALBUM_LAYOUT', \$this->gallery_config->get_index_album_layout())",
			$controller
		);
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
