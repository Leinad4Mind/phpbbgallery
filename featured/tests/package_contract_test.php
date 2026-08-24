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
		$this->assertStringContainsString('->curated(', $listener);
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
		$this->assertStringNotContainsString('The request could not be completed.', $script);
		$this->assertStringContainsString('class="icon fa fa-chevron-left', $template);
		$this->assertStringContainsString('class="icon fa fa-chevron-right', $template);
		$this->assertStringContainsString('gallery-featured-control gallery-featured-play', $template);
	}

	public function test_every_style_exposes_the_block_and_moderation_action(): void
	{
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$events = $this->root . '/styles/' . $style . '/template/event/';
			$index = (string) file_get_contents($events . 'phpbbgallery_core_index_featured_before.html');
			$action = (string) file_get_contents($events . 'phpbbgallery_core_viewimage_actions.html');
			$this->assertStringContainsString("{% include '@phpbbgallery_featured/featured_slideshow.html' %}", $index, $style);
			$this->assertStringContainsString("featured_style = '" . strtolower($style) . "'", $index, $style);
			$this->assertStringContainsString('data-gallery-featured-toggle', $action, $style);
			$this->assertStringContainsString('FEATURE_IMAGE_LABEL', $action, $style);
			$this->assertStringContainsString('S_IMAGE_FEATURED', $action, $style);
		}
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
		$this->assertStringContainsString('grid-template-columns: minmax(0, 1.7fr) minmax(220px, .7fr)', $css);
		$this->assertStringContainsString('.gallery-featured--count-two { --gallery-featured-visible: 2; }', $css);
		$this->assertStringContainsString('.gallery-featured--count-three { --gallery-featured-visible: 3; }', $css);
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
