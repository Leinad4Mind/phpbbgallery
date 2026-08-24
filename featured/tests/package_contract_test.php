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
		$this->assertStringContainsString('prefers-reduced-motion', $script);
		$this->assertStringContainsString("event.key === 'ArrowLeft'", $script);
		$this->assertStringContainsString('touchstart', $script);
		$this->assertStringContainsString('payload.S_CONFIRM_ACTION', $script);
		$this->assertStringNotContainsString('The request could not be completed.', $script);
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
