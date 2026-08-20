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
		$selector = (string) file_get_contents($core_root . '/styles/all/template/gallery/albumlist_layout.html');

		$this->assertStringContainsString("GALLERY_INDEX_ALBUM_LAYOUT == 'classic'", $selector);
		$this->assertStringContainsString("GALLERY_INDEX_ALBUM_LAYOUT == 'modern'", $selector);
		$this->assertStringContainsString("GALLERY_INDEX_ALBUM_LAYOUT == 'futuristic'", $selector);
		$this->assertStringContainsString("{% include 'gallery/albumlist_body.html' %}", $selector);
		$this->assertStringContainsString("{% include '@phpbbgallery_core/gallery/albumlist_modern.html' %}", $selector);
		$this->assertStringContainsString('@phpbbgallery_core/gallery/albumlist_futuristic.html', $selector);
		$this->assertStringContainsString("{% include 'gallery/albumlist_polaroid.html' %}", $selector);
		foreach (\gallery_test_existing_styles(dirname(__DIR__)) as $style)
		{
			$index = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/index_body.html');
			$album = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/album_body.html');

			$this->assertStringContainsString('albumlist_index_sections.html', $index, $style . '/index');
			$this->assertStringContainsString('albumlist_layout.html', $album, $style . '/album');
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
		$this->assertStringContainsString("{% include '@phpbbgallery_core/gallery/subalbum_links.html' %}", $template);
		$this->assertStringContainsString('albumrow.UNAPPROVED_IMAGES', $template);
		$this->assertStringContainsString('albumrow.LAST_USER_FULL', $template);
		$this->assertStringContainsString('gallery-modern-album-main--without-visual', $template);
		$this->assertStringContainsString('S_ALBUM_LIST_HAS_CUSTOM_ICONS', $template);
		$this->assertStringContainsString('albumrow.S_ALBUM_GROUP_HAS_CUSTOM_ICONS', $template);
		$this->assertStringContainsString('gallery-modern-album-list--with-custom-icons', $template);
		$this->assertStringContainsString('gallery-modern-album-visual--placeholder', $template);
		$this->assertStringContainsString('gallery-modern-last-image-thumbnail', $template);
		$this->assertStringContainsString('albumrow.UC_LAST_IMAGE_THUMBNAIL', $template);
		$this->assertStringNotContainsString('not albumrow.S_ALBUM_VISUAL_IS_LAST_IMAGE', $template);
		$this->assertTrue(strpos($template, 'gallery-modern-last-image-details') < strpos($template, 'gallery-modern-last-image-thumbnail'));
		$this->assertStringContainsString('albumrow.U_LAST_IMAGE', $template);
		$this->assertStringContainsString('grid-template-columns: minmax(0, 1fr) minmax(245px, 32%);', $css);
		$this->assertStringContainsString("'S_ALBUM_LIST_HAS_CUSTOM_ICONS' => \$this->has_album_custom_icons", (string) file_get_contents($core_root . '/album/display.php'));
		$this->assertMatchesRegularExpression('/\\.gallery-modern-album-main--without-visual\\s*\\{[^}]*grid-template-columns:\\s*minmax\\(0, 1fr\\);/s', $css);
		$this->assertMatchesRegularExpression('/\\.gallery-modern-album-visual--placeholder\\s*\\{[^}]*pointer-events:\\s*none;/s', $css);
		$this->assertDoesNotMatchRegularExpression('/\\.gallery-modern-album-visual--placeholder\\s*\\{[^}]*background:\\s*transparent;/s', $css);
		$this->assertMatchesRegularExpression('/\\.gallery-modern-last-image-thumbnail\\s*\\{[^}]*margin-inline-start:\\s*auto;/s', $css);
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
		$this->assertStringContainsString('grid-template-columns: repeat(4, minmax(0, 1fr));', $css);
		$this->assertMatchesRegularExpression(
			'/@media \(max-width:\s*900px\)\s*\{[^}]*\.gallery-classic-image-grid\s*\{[^}]*grid-template-columns:\s*repeat\(2, minmax\(0, 1fr\)\);/s',
			$css
		);
		$this->assertMatchesRegularExpression(
			'/@media \(max-width:\s*520px\)\s*\{[^}]*\.gallery-classic-image-grid\s*\{[^}]*grid-template-columns:\s*minmax\(0, 1fr\);/s',
			$css
		);
		$this->assertMatchesRegularExpression(
			'/\\.gallery-classic-thumbnail\\s*\\{[^}]*box-sizing:\\s*border-box;[^}]*overflow:\\s*hidden;/s',
			$css
		);
		$this->assertMatchesRegularExpression(
			'/\\.gallery-classic-thumbnail img\\s*\\{[^}]*height:\\s*var\\(--gallery-classic-thumbnail-size, 70px\\);[^}]*object-fit:\\s*contain;[^}]*width:\\s*min\\(100%, var\\(--gallery-classic-thumbnail-size, 70px\\)\\);/s',
			$css
		);
		$this->assertMatchesRegularExpression(
			'/\\.gallery-classic-image\\s*\\{(?:(?!border:)[^}])*border-radius:\\s*3px;/s',
			$css
		);
	}

	public function test_displayed_thumbnail_size_is_shared_by_every_public_card_layout(): void
	{
		$core_root = dirname(__DIR__);
		$classic = (string) file_get_contents($core_root . '/styles/all/template/gallery/imageblock_classic.html');
		$futuristic = (string) file_get_contents($core_root . '/styles/all/template/gallery/imageblock_futuristic.html');
		$cards = (string) file_get_contents($core_root . '/styles/prosilver/template/gallery/imageblock_polaroid.html');
		$css = (string) file_get_contents($core_root . '/styles/all/theme/gallery.css');

		$this->assertStringContainsString('--gallery-classic-thumbnail-size: {{ S_THUMBNAIL_SIZE|default(70) }}px;', $classic);
		$this->assertStringContainsString('--gallery-futuristic-thumbnail-size: {{ S_THUMBNAIL_SIZE|default(70) }}px;', $futuristic);
		$this->assertStringContainsString('--gallery-thumbnail-size: {{ S_THUMBNAIL_SIZE|default(70) }}px;', $cards);
		$this->assertStringContainsString('var(--gallery-classic-thumbnail-size, 70px)', $css);
		$this->assertStringContainsString('var(--gallery-futuristic-thumbnail-size, 70px)', $css);
		$this->assertStringContainsString('var(--gallery-thumbnail-size, 70px)', $css);

		$this->assertMatchesRegularExpression(
			'/\\.gallery-image-card-thumbnail img\\s*\\{[^}]*height:\\s*auto;[^}]*max-height:\\s*var\\(--gallery-thumbnail-size, 70px\\);[^}]*object-fit:\\s*contain;[^}]*width:\\s*min\\(100%, var\\(--gallery-thumbnail-size, 70px\\)\\);/s',
			$css
		);
		$this->assertMatchesRegularExpression(
			'/\\.gallery-futuristic-thumbnail img\\s*\\{[^}]*height:\\s*min\\(calc\\(100% - 20px\\), var\\(--gallery-futuristic-thumbnail-size, 70px\\)\\);[^}]*object-fit:\\s*contain;[^}]*width:\\s*min\\(calc\\(100% - 20px\\), var\\(--gallery-futuristic-thumbnail-size, 70px\\)\\);/s',
			$css
		);
		$this->assertMatchesRegularExpression(
			'/\\.gallery-classic-thumbnail img\\s*\\{[^}]*height:\\s*var\\(--gallery-classic-thumbnail-size, 70px\\);[^}]*object-fit:\\s*contain;[^}]*width:\\s*min\\(100%, var\\(--gallery-classic-thumbnail-size, 70px\\)\\);/s',
			$css
		);
	}
	public function test_prosilver_classic_has_bordered_cards_borderless_ids_and_last_image_thumbnails(): void
	{
		$core_root = dirname(__DIR__);
		$classic = (string) file_get_contents($core_root . '/styles/all/template/gallery/imageblock_classic.html');
		$selector = (string) file_get_contents($core_root . '/styles/prosilver/template/gallery/imageblock_layout.html');
		$search = (string) file_get_contents($core_root . '/styles/prosilver/template/gallery/search_results.html');
		$albums = (string) file_get_contents($core_root . '/styles/prosilver/template/gallery/albumlist_body.html');
		$css = (string) file_get_contents($core_root . '/styles/all/theme/gallery.css');

		$this->assertStringContainsString("GALLERY_CLASSIC_VARIANT|default('default')", $classic);
		$this->assertStringContainsString("GALLERY_CLASSIC_VARIANT: 'prosilver'", $selector);
		$this->assertStringContainsString("GALLERY_CLASSIC_VARIANT: 'prosilver'", $search);
		$this->assertStringContainsString('border: 1px solid #cadceb;', $css);
		$prosilver_copy_style = strstr($css, '.gallery-classic-image-block--prosilver .gallery-image-bbcode-copy,');
		$this->assertIsString($prosilver_copy_style);
		$prosilver_copy_style = strstr($prosilver_copy_style, '}', true);
		$this->assertIsString($prosilver_copy_style);
		$this->assertStringContainsString('border: 0;', $prosilver_copy_style);

		$this->assertStringContainsString('gallery-classic-last-image', $albums);
		$this->assertStringContainsString('albumrow.UC_LAST_IMAGE_THUMBNAIL', $albums);
		$this->assertStringContainsString('albumrow.U_LAST_IMAGE', $albums);
		$this->assertStringNotContainsString('albumrow.UC_FAKE_THUMBNAIL', $albums);
		$this->assertLessThan(strpos($albums, 'gallery-classic-last-image-details'), strpos($albums, 'gallery-classic-last-image-thumbnail'));
		$this->assertStringContainsString('display: flex;', strstr($css, '.gallery-classic-last-image'));
	}

	public function test_classic_titles_are_centred_consistently(): void
	{
		$core_root = dirname(__DIR__);
		$selector = (string) file_get_contents($core_root . '/styles/prosilver/template/gallery/imageblock_layout.html');
		$search = (string) file_get_contents($core_root . '/styles/prosilver/template/gallery/search_results.html');
		$classic = (string) file_get_contents($core_root . '/styles/all/template/gallery/imageblock_classic.html');
		$css = (string) file_get_contents($core_root . '/styles/all/theme/gallery.css');

		$this->assertStringNotContainsString('GALLERY_CLASSIC_TITLE_ALIGN_START', $selector . $search . $classic);
		$this->assertMatchesRegularExpression(
			'/\.gallery-classic-image-title\s*\{[^}]*justify-content:\s*center;[^}]*max-width:\s*100%;[^}]*text-align:\s*center;[^}]*text-overflow:\s*ellipsis;[^}]*width:\s*100%;/s',
			$css
		);
		$this->assertMatchesRegularExpression(
			'/\.gallery-classic-image-title a\s*\{[^}]*display:\s*block;[^}]*max-width:\s*100%;[^}]*overflow:\s*hidden;[^}]*text-overflow:\s*ellipsis;[^}]*white-space:\s*nowrap;[^}]*width:\s*100%;/s',
			$css
		);
	}

	public function test_futuristic_layout_preserves_gallery_contracts_and_has_a_theme_variant(): void
	{
		$core_root = dirname(__DIR__);
		$albums = (string) file_get_contents($core_root . '/styles/all/template/gallery/albumlist_futuristic.html');
		$images = (string) file_get_contents($core_root . '/styles/all/template/gallery/imageblock_futuristic.html');
		$css = (string) file_get_contents($core_root . '/styles/all/theme/gallery.css');

		foreach (\gallery_test_existing_styles(dirname(__DIR__)) as $style)
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
		$this->assertStringContainsString("{% include '@phpbbgallery_core/gallery/subalbum_links.html' %}", $albums);
		$this->assertStringContainsString('albumrow.UNAPPROVED_IMAGES', $albums);
		$this->assertStringContainsString('albumrow.LAST_USER_FULL', $albums);
		$this->assertStringContainsString('gallery-futuristic-album-main--without-visual', $albums);
		$this->assertStringContainsString('{% if albumrow.ALBUM_IMAGE_SRC %}', $albums);
		$this->assertStringNotContainsString('albumrow.UC_THUMBNAIL', $albums);
		$this->assertStringContainsString('{% if albumrow.UC_LAST_IMAGE_THUMBNAIL %}', $albums);
		$this->assertStringNotContainsString('albumrow.UC_LAST_IMAGE_THUMBNAIL and not albumrow.S_ALBUM_VISUAL_IS_LAST_IMAGE', $albums);
		$this->assertStringContainsString('albumrow.U_LAST_IMAGE', $albums);
		$this->assertStringContainsString("{% include '@phpbbgallery_core/gallery/subalbum_links.html' %}", $albums);
		$subalbums = (string) file_get_contents($core_root . '/styles/all/template/gallery/subalbum_links.html');
		$css = (string) file_get_contents($core_root . '/styles/all/theme/gallery.css');
		$this->assertStringContainsString('albumrow.S_SUBALBUMS_AS_ICONS and subalbum.SUBALBUM_IMAGE_SRC', $subalbums);
		$this->assertStringContainsString('gallery-subalbum-link--text', $subalbums);
		$this->assertMatchesRegularExpression('/\.gallery-subalbum-link--text\s*\{[^}]*align-items:\s*center;/s', $css);
		$this->assertMatchesRegularExpression('/\.gallery-subalbum-link--text \.icon\s*\{[^}]*line-height:\s*1;/s', $css);
		$this->assertStringContainsString('gallery-subalbum-link--icon', $subalbums);
		$this->assertStringContainsString("'SUBALBUM_IMAGE_SRC' => \$subalbum['image_src']", (string) file_get_contents($core_root . '/album/display.php'));
		$this->assertStringContainsString("'S_SUBALBUMS_AS_TEXT'", (string) file_get_contents($core_root . '/album/display.php'));
		$this->assertStringContainsString("'S_SUBALBUMS_AS_ICONS'", (string) file_get_contents($core_root . '/album/display.php'));
		$this->assertStringNotContainsString('S_DISPLAY_SUBALBUM_ICONS', $albums . $subalbums);
		foreach (\gallery_test_existing_styles(dirname(__DIR__)) as $style)
		{
			foreach (['albumlist_body.html', 'albumlist_polaroid.html'] as $template)
			{
				$this->assertStringContainsString("{% include '@phpbbgallery_core/gallery/subalbum_links.html' %}", (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/' . $template), $style . '/' . $template);
			}
		}
		$this->assertStringContainsString("{% include '@phpbbgallery_core/gallery/subalbum_links.html' %}", (string) file_get_contents($core_root . '/styles/all/template/gallery/albumlist_modern.html'));
		$this->assertMatchesRegularExpression('/\.gallery-classic-album-custom-visual\s*\{[^}]*background-image:\s*none !important;/s', $css);
		$this->assertMatchesRegularExpression(
			'/\.gallery-futuristic-album-visual\.gallery-album-custom-icon-frame \.gallery-album-custom-icon\s*\{[^}]*background:\s*transparent;[^}]*height:\s*100%;[^}]*width:\s*100%;/s',
			$css
		);
		$this->assertStringContainsString('phpbbgallery_core_album_image_actions', $images);
		$this->assertStringContainsString('phpbbgallery_core_album_image_metadata', $images);
		$this->assertStringContainsString('album_rating_stars.html', $images);
		$this->assertStringContainsString('S_STATUS_UNAPPROVED_ACTION', $images);
		$this->assertMatchesRegularExpression(
			'/\.gallery-futuristic--prosilver\s*\{[^}]*--gallery-futuristic-accent:\s*#1596c8;[^}]*--gallery-futuristic-secondary:\s*#078bc3;/s',
			$css
		);
		$this->assertMatchesRegularExpression(
			'/\.gallery-futuristic--flatboots\s*\{[^}]*--gallery-futuristic-accent:\s*#9e7233;[^}]*--gallery-futuristic-accent-soft:\s*rgba\(158, 114, 51, \.17\);[^}]*--gallery-futuristic-secondary:\s*#daa520;[^}]*--gallery-futuristic-secondary-soft:\s*rgba\(218, 165, 32, \.14\);/s',
			$css
		);
		$this->assertMatchesRegularExpression(
			'/\.gallery-futuristic-section-icon > \.icon\s*\{[^}]*align-items:\s*center;[^}]*justify-content:\s*center;[^}]*width:\s*100%;/s',
			$css
		);
		$this->assertMatchesRegularExpression(
			'/\.gallery-futuristic-section-icon > \.icon::before\s*\{[^}]*padding:\s*0;/s',
			$css
		);
		$this->assertStringNotContainsString('--gallery-futuristic-secondary: #6d63c9;', $css);
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
		$this->assertLessThan(strpos($classic, 'gallery-classic-image-title'), strpos($classic, 'image_bbcode_copy.html'));
		$this->assertLessThan(strpos($futuristic, 'gallery-futuristic-image-title'), strpos($futuristic, 'image_bbcode_copy.html'));
		$this->assertStringNotContainsString('GALLERY_BBCODE_COPY_OVERLAY: true', $classic . $futuristic);

		foreach (\gallery_test_existing_styles(dirname(__DIR__)) as $style)
		{
			$cards = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/imageblock_polaroid.html');
			$this->assertStringContainsString('image_bbcode_copy.html', $cards, $style);
			$this->assertStringContainsString('gallery-polaroid-image-heading--with-copy', $cards, $style);
			$this->assertLessThan(strpos($cards, 'gallery-image-card-title'), strpos($cards, 'image_bbcode_copy.html'), $style);
			$this->assertStringNotContainsString('GALLERY_BBCODE_COPY_OVERLAY: true', $cards, $style);
		}
		foreach (\gallery_test_existing_styles(dirname(__DIR__), ['all', 'BBOOTS', 'FLATBOOTS']) as $style)
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
		$css = (string) file_get_contents($core_root . '/styles/all/theme/gallery.css');
		$this->assertMatchesRegularExpression('/\.gallery-image-card-heading\s*\{[^}]*align-items:\s*center;[^}]*flex-direction:\s*column;[^}]*text-align:\s*center;/s', $css);
		$this->assertMatchesRegularExpression('/\.gallery-image-bbcode-copy\s*\{[^}]*align-self:\s*flex-start;[^}]*padding:\s*0;/s', $css);
		$this->assertMatchesRegularExpression('/\.gallery-polaroid-image-heading\s*\{[^}]*padding:\s*5px 9px 0;/s', $css);
		$this->assertMatchesRegularExpression('/\.gallery-polaroid-image-heading--with-copy\s*\{[^}]*padding-top:\s*35px;/s', $css);
		$this->assertMatchesRegularExpression('/\.gallery-polaroid-image-heading > \.gallery-image-bbcode-copy\s*\{[^}]*border:\s*0;[^}]*inset-inline-start:\s*9px;[^}]*min-height:\s*30px;[^}]*position:\s*absolute;[^}]*top:\s*5px;/s', $css);
		$this->assertMatchesRegularExpression('/\.gallery-futuristic-image-header\s*\{[^}]*flex-direction:\s*column;(?:(?!gap:)[^}])*padding:\s*2px 10px 6px;[^}]*text-align:\s*left;/s', $css);
		$this->assertMatchesRegularExpression('/\.gallery-classic-image-heading > \.gallery-image-bbcode-copy\s*\{[^}]*margin-inline-start:\s*7px;/s', $css);
	}

	public function test_album_list_distinguishes_its_main_visual_from_the_latest_image(): void
	{
		$core_root = dirname(__DIR__);
		$this->assertMatchesRegularExpression('/\.phpbbgallery-forum-index \.gallery-classic-image\s*\{[^}]*border:\s*1px solid rgba\(127, 127, 127, \.22\);[^}]*box-sizing:\s*border-box;/s', $css);
		$this->assertMatchesRegularExpression('/\.phpbbgallery-forum-index \.gallery-image-bbcode-copy,[^{]*\.phpbbgallery-forum-index \.gallery-image-bbcode-copy\.is-copied\s*\{[^}]*border:\s*0;[^}]*box-shadow:\s*none;/s', $css);
		$display = (string) file_get_contents($core_root . '/album/display.php');
		$last_image = (string) file_get_contents($core_root . '/styles/all/template/gallery/albumlist_polaroid_last_image.html');

		$this->assertStringContainsString("'S_ALBUM_VISUAL_IS_LAST_IMAGE' => !\$row['album_image']", $display);
		$this->assertStringContainsString("'LAST_IMAGE_ID'", $display);
		$this->assertStringContainsString("'UC_THUMBNAIL'\t\t\t=> \$lastimage_uc_thumbnail", $display);
		$this->assertStringContainsString("'UC_LAST_IMAGE_THUMBNAIL' => \$this->config['phpbb_gallery_mini_thumbnail_disp'] ? \$lastimage_uc_last_thumbnail : ''", $display);
		$this->assertStringContainsString("'U_LAST_IMAGE'", $display);
		$this->assertStringContainsString("['image_id' => \$row['album_last_image_id']]", $display);
		$this->assertStringContainsString('albumrow.UC_LAST_IMAGE_THUMBNAIL and not albumrow.S_ALBUM_VISUAL_IS_LAST_IMAGE', $last_image);
		$this->assertStringContainsString('not albumrow.UC_LAST_IMAGE_THUMBNAIL or albumrow.S_ALBUM_VISUAL_IS_LAST_IMAGE', $last_image);
		$this->assertSame(1, substr_count($last_image, 'albumrow.U_LAST_IMAGE'));
		$this->assertSame(2, substr_count($last_image, 'albumrow.S_ALBUM_VISUAL_IS_LAST_IMAGE'));

		foreach (\gallery_test_existing_styles($core_root) as $style)
		{
			$polaroid = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/albumlist_polaroid.html');
			$this->assertStringContainsString('albumrow.ALBUM_IMAGE_SRC or albumrow.UC_LAST_IMAGE_THUMBNAIL', $polaroid, $style);
			$this->assertStringContainsString("{% include '@phpbbgallery_core/gallery/albumlist_polaroid_last_image.html' %}", $polaroid, $style);
			$this->assertStringContainsString('class="gallery-polaroid-image-count"', $polaroid, $style);
		}

		$css = (string) file_get_contents($core_root . '/styles/all/theme/gallery.css');
		$this->assertMatchesRegularExpression('/\.gallery-polaroid-image-count\s*\{[^}]*text-align:\s*center;/s', $css);
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

		$templates = \gallery_test_existing_files([
			$core_root . '/styles/prosilver/template/gallery/albumlist_body.html',
			$core_root . '/styles/BBOOTS/template/gallery/albumlist_body.html',
			$core_root . '/styles/FLATBOOTS/template/gallery/albumlist_body.html',
			$core_root . '/styles/all/template/gallery/albumlist_modern.html',
			$core_root . '/styles/all/template/gallery/albumlist_futuristic.html',
		]);
		foreach ($templates as $template_path)
		{
			$template = (string) file_get_contents($template_path);
			$this->assertStringContainsString('albumrow.ALBUM_IMAGE_SRC', $template, $template_path);
			$this->assertStringContainsString('gallery-album-custom-icon-frame', $template, $template_path);
			$this->assertStringContainsString('gallery-album-custom-icon', $template, $template_path);
			$this->assertStringNotContainsString('T_IMAGES_PATH }}{{ albumrow.ALBUM_IMAGE', $template, $template_path);
		}
		$classic_templates = \gallery_test_existing_files([
			$core_root . '/styles/prosilver/template/gallery/albumlist_body.html',
			$core_root . '/styles/BBOOTS/template/gallery/albumlist_body.html',
			$core_root . '/styles/FLATBOOTS/template/gallery/albumlist_body.html',
		]);
		foreach ($classic_templates as $template_path)
		{
			$this->assertStringContainsString('gallery-classic-album-icon-frame', (string) file_get_contents($template_path), $template_path);
		}
		foreach (array_slice($classic_templates, 1) as $template_path)
		{
			$template = (string) file_get_contents($template_path);
			$this->assertStringNotContainsString('> Thumbnail</th>', $template, $template_path);
			$this->assertStringNotContainsString('albumrow.UC_FAKE_THUMBNAIL', $template, $template_path);
		}

		$css = (string) file_get_contents($core_root . '/styles/all/theme/gallery.css');
		$this->assertStringContainsString('height: 30px;', $css);
		$this->assertStringContainsString('width: 30px;', $css);
		$this->assertStringContainsString('transform: scale(3);', $css);
		$this->assertStringContainsString('.gallery-album-custom-icon-frame:focus .gallery-album-custom-icon', $css);
		$this->assertMatchesRegularExpression(
			'/\\.gallery-classic-album-icon-frame \\.gallery-album-custom-icon\\s*\\{[^}]*height:\\s*50px;[^}]*max-height:\\s*50px;[^}]*max-width:\\s*50px;[^}]*object-fit:\\s*contain;[^}]*width:\\s*50px;/s',
			$css
		);
		$this->assertMatchesRegularExpression(
			'/\\.gallery-classic-album-icon-frame \\.gallery-album-custom-icon:hover,[^{]+\\.gallery-classic-album-icon-frame:focus \\.gallery-album-custom-icon\\s*\\{[^}]*box-shadow:\\s*none;[^}]*transform:\\s*none;/s',
			$css
		);
		$this->assertMatchesRegularExpression(
			'/\\.gallery-modern-album-visual\\.gallery-album-custom-icon-frame \\.gallery-album-custom-icon\\s*\\{[^}]*height:\\s*calc\\(100% - 8px\\);[^}]*max-height:\\s*calc\\(100% - 8px\\);[^}]*max-width:\\s*calc\\(100% - 8px\\);[^}]*transition:\\s*none;[^}]*width:\\s*calc\\(100% - 8px\\);/s',
			$css
		);
		$this->assertMatchesRegularExpression(
			'/\\.gallery-modern-album-visual\\.gallery-album-custom-icon-frame \\.gallery-album-custom-icon:hover,[^{]+\\.gallery-modern-album-visual\\.gallery-album-custom-icon-frame:focus \\.gallery-album-custom-icon\\s*\\{[^}]*box-shadow:\\s*none;[^}]*transform:\\s*none;/s',
			$css
		);
	}

	public function test_album_recent_random_and_search_grids_use_the_layout_selector_in_every_style(): void
	{
		$core_root = dirname(__DIR__);
		foreach (\gallery_test_existing_styles(dirname(__DIR__)) as $style)
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

	public function test_recent_comments_are_hidden_only_when_collapse_is_enabled(): void
	{
		$core_root = dirname(__DIR__);

		foreach (\gallery_test_existing_styles($core_root) as $style)
		{
			$template = $style === 'prosilver' ? 'index_body.html' : 'recent_body.html';
			$source = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/' . $template);

			$this->assertStringContainsString(
				'{% if COLLAPSE_COMMENTS %} style="display: none;"{% endif %}',
				$source,
				$style
			);
			$this->assertStringNotContainsString('COMMENTS_EXPAND', $source, $style);
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

	public function test_forum_index_image_blocks_use_the_selected_normalized_layout(): void
	{
		$core_root = dirname(__DIR__);
		$listener = (string) file_get_contents($core_root . '/event/main_listener.php');

		$this->assertStringContainsString(
			"'GALLERY_INDEX_ALBUM_LAYOUT' => \$this->gallery_config->get_index_album_layout()",
			$listener
		);
		foreach ([
			'all/template/event/index_body_forumlist_body_before.html',
			'prosilver/template/event/index_body_markforums_before.html',
		] as $template_path)
		{
			$template = (string) file_get_contents($core_root . '/styles/' . $template_path);
			$this->assertStringContainsString("{% include 'gallery/imageblock_layout.html' %}", $template, $template_path);
			$this->assertStringNotContainsString('imageblock_polaroid.html', $template, $template_path);
		}
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
		foreach (\gallery_test_existing_styles(dirname(__DIR__), ['BBOOTS', 'FLATBOOTS'], $this) as $style)
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
	public function test_image_cards_center_thumbnails_and_keep_approval_inside_metadata(): void
	{
		$core_root = dirname(__DIR__);
		foreach (\gallery_test_existing_styles($core_root, ['prosilver', 'BBOOTS', 'FLATBOOTS'], $this) as $style)
		{
			$template = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/imageblock_polaroid.html');

			$this->assertStringContainsString('gallery-image-card-media', $template, $style);
			$this->assertStringContainsString('gallery-image-card-thumbnail', $template, $style);
			$this->assertStringContainsString('gallery-image-card-approval', $template, $style);
			$this->assertStringContainsString('gallery-image-card-details', $template, $style);
			$this->assertLessThan(strpos($template, "lang('ALBUM_NAME')"), strpos($template, 'gallery-image-card-approval'), $style);
			$this->assertStringNotContainsString('gallery-image-card-media--with-approval', $template, $style);
			$this->assertStringNotContainsString(' image_unapproved', $template, $style);
			$this->assertStringNotContainsString('class="mcp_approve"', $template, $style);
		}

		$futuristic = (string) file_get_contents($core_root . '/styles/all/template/gallery/imageblock_futuristic.html');
		$this->assertStringContainsString('gallery-futuristic-approval', $futuristic);
		$this->assertLessThan(strpos($futuristic, "lang('ALBUM_NAME')"), strpos($futuristic, 'gallery-futuristic-approval'));
		$this->assertStringNotContainsString(' image_unapproved', $futuristic);
		$this->assertStringNotContainsString(' image_reported', $futuristic);

		$css = (string) file_get_contents($core_root . '/styles/all/theme/gallery.css');
		$prosilver = (string) file_get_contents($core_root . '/styles/prosilver/template/gallery/imageblock_polaroid.html');
		$classic = (string) file_get_contents($core_root . '/styles/all/template/gallery/imageblock_classic.html');
		$futuristic = (string) file_get_contents($core_root . '/styles/all/template/gallery/imageblock_futuristic.html');
		$search = (string) file_get_contents($core_root . '/styles/prosilver/template/gallery/search_results.html');
		$this->assertStringContainsString('gallery-approval-button--reject', $prosilver);
		$this->assertStringContainsString('gallery-approval-button--approve', $prosilver);
		foreach ([$prosilver, $classic, $futuristic, $search] as $template)
		{
			$this->assertStringContainsString('<button class="button2 gallery-approval-button gallery-approval-button--reject"', $template);
			$this->assertStringContainsString('<button class="button1 gallery-approval-button gallery-approval-button--approve"', $template);
			$this->assertStringContainsString('fa fa-times fa-fw', $template);
			$this->assertStringContainsString('fa fa-check fa-fw', $template);
		}
		$this->assertMatchesRegularExpression('/\.gallery-image-card-media\s*\{[^}]*display:\s*flex;[^}]*flex:\s*0 0 auto;[^}]*flex-direction:\s*column;[^}]*min-height:\s*0;/s', $css);
		$this->assertMatchesRegularExpression('/\.gallery-image-card-thumbnail\s*\{[^}]*align-items:\s*center;[^}]*display:\s*flex;[^}]*justify-content:\s*center;/s', $css);
		$this->assertMatchesRegularExpression('/\.gallery-image-card-approval \.post-notice,[^{]+\{[^}]*display:\s*flex;[^}]*justify-content:\s*center;[^}]*min-height:\s*46px;/s', $css);
		$this->assertMatchesRegularExpression('/\.gallery-approval-button\s*\{[^}]*border-radius:\s*4px;[^}]*display:\s*inline-flex;[^}]*min-height:\s*30px;[^}]*padding:\s*5px 10px;/s', $css);
		$this->assertMatchesRegularExpression('/\.gallery-approval-button--approve\s*\{[^}]*background-color:\s*#2f8f55;[^}]*color:\s*#fff;/s', $css);
		$this->assertMatchesRegularExpression('/\.gallery-approval-button--reject\s*\{[^}]*border-color:\s*#d9534f;[^}]*color:\s*#bc2a4d;/s', $css);
		$this->assertMatchesRegularExpression('/\.gallery-image-card-details\s*\{[^}]*display:\s*flex;[^}]*flex-direction:\s*column;[^}]*width:\s*100%;/s', $css);
		$this->assertMatchesRegularExpression('/\.gallery-futuristic-approval\s*\{[^}]*display:\s*flex;[^}]*justify-content:\s*center;[^}]*width:\s*100%;/s', $css);
	}
}
