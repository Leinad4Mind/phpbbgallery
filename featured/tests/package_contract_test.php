<?php

namespace phpbbgallery\featured\tests;

use PHPUnit\Framework\TestCase;

class package_contract_test extends TestCase
{
	private string $root;

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		$this->root = dirname(__DIR__);
	}

	public function test_package_requires_core_42_and_owns_its_table(): void
	{
		$composer = json_decode((string) file_get_contents($this->root . '/composer.json'), true, 512, JSON_THROW_ON_ERROR);
		$this->assertSame('1.0.0', $composer['version']);
		$this->assertSame('>=4.2.0,<5.0.0@dev', $composer['extra']['soft-require']['phpbbgallery/core']);
		$this->assertStringContainsString('gallery_featured', (string) file_get_contents($this->root . '/migrations/m1_init.php'));
		$display_migration = (string) file_get_contents($this->root . '/migrations/m2_display_controls.php');
		$this->assertStringContainsString('phpbb_gallery_featured_location', $display_migration);
		$this->assertStringContainsString('inherit_enabled_state', $display_migration);
		$listener = (string) file_get_contents($this->root . '/event/main_listener.php');
		$this->assertStringNotContainsString("'legend' => 'FEATURED_SETTINGS'", $listener);
		$this->assertStringContainsString("['vars']['FEATURED_SETTINGS'] = [", $listener);
	}

	public function test_permission_and_visibility_boundaries_are_present(): void
	{
		$controller = (string) file_get_contents($this->root . '/controller/main.php');
		$listener = (string) file_get_contents($this->root . '/event/main_listener.php');
		$this->assertStringContainsString("acl_check('m_edit'", $controller);
		$this->assertStringContainsString('STATUS_APPROVED', $controller);
		$this->assertStringContainsString('phpbbgallery.core.index.image_blocks', $listener);
		$this->assertStringContainsString('core.index_modify_page_title', $listener);
		$this->assertStringContainsString('->curated(', $listener);
		$this->assertStringContainsString("'featuredslide'", $listener);
		$this->assertStringContainsString('S_FEATURED_', $listener);
		$this->assertStringContainsString('featured_location', $listener);
		$this->assertStringContainsString('featured_position', $listener);
	}

	public function test_slideshow_is_accessible_and_has_progressive_fallback(): void
	{
		$template = (string) file_get_contents($this->root . '/styles/all/template/featured_slideshow.html');
		$script = (string) file_get_contents($this->root . '/styles/all/template/featured.js');
		$this->assertStringContainsString('aria-roledescription="carousel"', $template);
		$this->assertStringContainsString('data-play-label=', $template);
		$this->assertStringContainsString('data-pause-label=', $template);
		$this->assertStringContainsString('prefers-reduced-motion', $script);
		$this->assertStringContainsString("event.key === 'ArrowLeft'", $script);
		$this->assertStringContainsString('touchstart', $script);
		$this->assertStringContainsString("document.addEventListener('visibilitychange'", $script);
		$this->assertStringContainsString('label.textContent = playing', $script);
		$this->assertStringContainsString("root.classList.add('is-enhanced')", $script);
		$this->assertStringContainsString("getPropertyValue('--gallery-featured-visible')", $script);
		$this->assertStringContainsString("slide.setAttribute('aria-hidden'", $script);
		$this->assertStringContainsString("slide.style.flexBasis = width + 'px'", $script);
		$this->assertStringContainsString('data-gallery-featured-track', $template);
		$this->assertStringContainsString('payload.S_CONFIRM_ACTION', $script);
		$this->assertStringContainsString("classList.toggle('active', featured)", $script);
		$this->assertStringNotContainsString('The request could not be completed.', $script);
		$this->assertStringContainsString('class="icon fa fa-chevron-left', $template);
		$this->assertStringContainsString('class="icon fa fa-chevron-right', $template);
		$this->assertStringContainsString('gallery-featured-control gallery-featured-play', $template);
	}

	public function test_every_style_exposes_the_block_and_moderation_action(): void
	{
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$core_index = (string) file_get_contents(dirname($this->root) . '/core/styles/' . $style . '/template/gallery/index_body.html');
			if ($style === 'FLATBOOTS')
			{
				$core_index .= (string) file_get_contents(dirname($this->root) . '/core/styles/FLATBOOTS/template/gallery/recent_body.html');
			}
			$events = $this->root . '/styles/' . $style . '/template/event/';
			$gallery_top = (string) file_get_contents($events . 'phpbbgallery_core_index_featured_top.html');
			$gallery_bottom = (string) file_get_contents($events . 'phpbbgallery_core_index_featured_bottom.html');
			$forum_top_name = $style === 'prosilver' ? 'index_body_markforums_before.html' : 'index_body_forumlist_body_before.html';
			$forum_top = (string) file_get_contents($events . $forum_top_name);
			$forum_bottom = (string) file_get_contents($events . 'index_body_stat_blocks_before.html');
			$action = (string) file_get_contents($events . 'phpbbgallery_core_viewimage_actions.html');
			$this->assertStringContainsString('phpbbgallery_core_index_featured_top', $core_index, $style);
			$this->assertStringContainsString('phpbbgallery_core_index_featured_bottom', $core_index, $style);
			foreach ([$gallery_top, $gallery_bottom, $forum_top, $forum_bottom] as $placement)
			{
				$this->assertStringContainsString("{% include '@phpbbgallery_featured/featured_slideshow.html' %}", $placement, $style);
				$this->assertStringContainsString("featured_style = '" . strtolower($style) . "'", $placement, $style);
			}
			$this->assertStringContainsString('S_FEATURED_GALLERY_INDEX_TOP', $gallery_top, $style);
			$this->assertStringContainsString('S_FEATURED_GALLERY_INDEX_BOTTOM', $gallery_bottom, $style);
			$this->assertStringContainsString('S_FEATURED_FORUM_INDEX_TOP', $forum_top, $style);
			$this->assertStringContainsString('S_FEATURED_FORUM_INDEX_BOTTOM', $forum_bottom, $style);
			$this->assertStringContainsString('data-gallery-featured-toggle', $action, $style);
			$this->assertStringContainsString('FEATURE_IMAGE_LABEL', $action, $style);
			$this->assertStringContainsString('S_IMAGE_FEATURED', $action, $style);
			if ($style === 'prosilver')
			{
				$this->assertStringContainsString('gallery-featured-toggle--prosilver', $action);
				$this->assertStringContainsString('{% if S_IMAGE_FEATURED %} active{% endif %}', $action);
			}
		}
	}

	public function test_acp_hides_position_only_when_neither_index_is_selected(): void
	{
		$script = (string) file_get_contents($this->root . '/adm/style/featured_acp.js');
		$this->assertStringContainsString("location.value === '0'", $script);
		$this->assertStringContainsString('row.hidden = hidden', $script);
		$this->assertStringContainsString("location.addEventListener('change'", $script);
		$this->assertStringContainsString("document.getElementById('featured_position')", $script);

		$template = (string) file_get_contents($this->root . '/styles/all/template/featured_slideshow.html');
		$this->assertStringContainsString('S_FEATURED_IMAGES', $template);
		$this->assertStringContainsString('with { imageblock: featuredslide }', $template);
	}

	public function test_slideshow_has_distinct_theme_variants(): void
	{
		$template = (string) file_get_contents($this->root . '/styles/all/template/featured_slideshow.html');
		$css = (string) file_get_contents($this->root . '/styles/all/theme/featured.css');
		$this->assertStringContainsString("gallery-featured--{{ featured_style|default('prosilver') }}", $template);
		$this->assertStringContainsString('.gallery-featured--prosilver', $css);
		$this->assertStringContainsString('.gallery-featured--bboots', $css);
		$this->assertStringContainsString('.gallery-featured--flatboots', $css);
		foreach (['classic', 'modern', 'cards', 'futuristic'] as $layout)
		{
			$this->assertStringContainsString('gallery-featured--layout-' . $layout, $css);
		}
		foreach (['one', 'two', 'three', 'many'] as $count)
		{
			$this->assertStringContainsString('gallery-featured--count-' . $count, $template . $css);
		}
		$this->assertStringContainsString("GALLERY_INDEX_ALBUM_LAYOUT|default('cards')", $template);
		$this->assertStringContainsString('data-featured-count="{{ featured_count }}"', $template);
		$this->assertStringContainsString('fa fa-star gallery-featured-heading-icon', $template);
		$this->assertMatchesRegularExpression('/\.gallery-featured--flatboots\.gallery-featured--layout-classic \.gallery-featured-heading-icon\s*\{[^}]*display:\s*inline-block;/s', $css);
		$this->assertMatchesRegularExpression('/\.gallery-featured-toggle--prosilver\[data-featured="1"\][^{]*\{[^}]*background-image:\s*linear-gradient\(to bottom, #12a3eb 0%, #0076b1 100%\);[^}]*color:\s*#fff;/s', $css);
		$this->assertStringContainsString('grid-template-columns: minmax(0, 1.7fr) minmax(220px, .7fr)', $css);
		$this->assertStringContainsString('.gallery-featured--count-two { --gallery-featured-visible: 2; }', $css);
		$this->assertStringContainsString('.gallery-featured--count-three { --gallery-featured-visible: 3; }', $css);
		$this->assertMatchesRegularExpression('/\.gallery-featured--layout-classic \.gallery-featured-header h2\s*\{[^}]*font-weight:\s*700;/s', $css);
		$this->assertMatchesRegularExpression('/\.gallery-featured--prosilver\.gallery-featured--layout-futuristic \.gallery-featured-header h2\s*\{[^}]*font-weight:\s*700;/s', $css);
		$this->assertStringContainsString('.gallery-featured--layout-classic.gallery-featured--count-one .gallery-featured-caption h3', $css);
		$this->assertMatchesRegularExpression(
			'/\.gallery-featured--prosilver\.gallery-featured--layout-classic\s*\{[^}]*background-color:\s*#0076b1;[^}]*border:\s*0;[^}]*border-radius:\s*7px;[^}]*padding:\s*5px;/s',
			$css
		);
		$this->assertMatchesRegularExpression(
			'/\.gallery-featured--flatboots\.gallery-featured--layout-futuristic\s*\{[^}]*border-top:\s*0;[^}]*position:\s*relative;/s',
			$css
		);
		$this->assertMatchesRegularExpression(
			'/\.gallery-featured--flatboots\.gallery-featured--layout-futuristic::before\s*\{[^}]*background:\s*linear-gradient\(90deg, #9e7233, #daa520\);[^}]*height:\s*3px;/s',
			$css
		);
		$this->assertMatchesRegularExpression(
			'/\.gallery-featured--flatboots\.gallery-featured--layout-futuristic \.gallery-featured-header\s*\{[^}]*background:\s*rgba\(255, 255, 255, \.78\);[^}]*border-bottom:\s*1px solid rgba\(137, 113, 56, \.24\);/s',
			$css
		);
		$this->assertMatchesRegularExpression(
			'/\.gallery-featured--flatboots\.gallery-featured--layout-futuristic \.gallery-featured-header h2\s*\{[^}]*color:\s*#7f8c8d;[^}]*text-shadow:\s*none;/s',
			$css
		);
		$this->assertMatchesRegularExpression('/\.gallery-featured-slide\s*\{[^}]*box-sizing:\s*border-box;/s', $css);
		$this->assertStringContainsString('.gallery-featured-control .icon::before { padding-right: 0; }', $css);
		$this->assertStringNotContainsString('border-left: 4px solid #daa520;', $css);
	}

	public function test_bundled_translations_are_not_english_copies(): void
	{
		$english = hash_file('sha256', $this->root . '/language/en/featured.php');
		$languages = glob($this->root . '/language/*', GLOB_ONLYDIR) ?: [];
		$this->assertCount(11, $languages);

		foreach ($languages as $language)
		{
			if (basename($language) === 'en')
			{
				continue;
			}

			$this->assertNotSame($english, hash_file('sha256', $language . '/featured.php'), basename($language));
		}
	}
}
