<?php
/**
 * Favorite addon lifecycle tests.
 *
 * @package   phpbbgallery/favorite
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\favorite\tests;

use PHPUnit\Framework\TestCase;

final class lifecycle_test extends TestCase
{
	public function test_enablement_reconciles_after_migrations(): void
	{
		$extension = (string) file_get_contents(dirname(__DIR__) . '/ext.php');

		$this->assertStringContainsString("\$old_state === 'reconcile'", $extension);
		$this->assertStringContainsString('reconcile_orphans()', $extension);
		$this->assertStringContainsString("parent::enable_step(\$old_state) ? 'migrations' : 'reconcile'", $extension);
	}

	public function test_flatboots_favorite_action_matches_the_viewtopic_button_size(): void
	{
		$template = (string) file_get_contents(\gallery_test_existing_file(
			dirname(__DIR__) . '/styles/FLATBOOTS/template/event/phpbbgallery_core_viewimage_actions.html',
			$this
		));

		$this->assertStringContainsString('class="btn btn-sm btn-default"', $template);
		$this->assertStringNotContainsString('btn-xs', $template);
	}

	public function test_every_image_page_favorite_action_toggles_over_ajax(): void
	{
		$root = dirname(__DIR__) . '/styles/';
		foreach (\gallery_test_existing_styles(dirname(__DIR__)) as $style)
		{
			$template = (string) file_get_contents($root . $style . '/template/event/phpbbgallery_core_viewimage_actions.html');
			$this->assertStringContainsString('data-gallery-favorite-ajax', $template, $style);
			$this->assertStringContainsString('data-ajax="false"', $template, $style);
			$this->assertStringContainsString('data-favorited="', $template, $style);
			$this->assertStringContainsString('data-toggle-url="{{ U_FAVORITE_IMAGE_TOGGLE }}"', $template, $style);
			$this->assertStringContainsString('class="icon ', $template, $style);
			$this->assertStringContainsString('class="sr-only"', $template, $style);
		}

		$javascript = (string) file_get_contents(dirname(__DIR__) . '/styles/all/template/favorite.js');
		$this->assertStringContainsString("document.addEventListener('click'", $javascript);
		$this->assertStringContainsString("request.setRequestHeader('X-Requested-With', 'XMLHttpRequest')", $javascript);
		$this->assertStringContainsString('request.withCredentials = true', $javascript);
		$this->assertStringContainsString("toggle.getAttribute('aria-busy') === 'true'", $javascript);
		$this->assertStringContainsString("icon.classList.toggle('fa-heart', favorited)", $javascript);
		$this->assertStringContainsString("icon.classList.toggle('fa-star', favorited)", $javascript);
	}
}
