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
		$template = (string) file_get_contents(dirname(__DIR__) . '/styles/FLATBOOTS/template/event/phpbbgallery_core_viewimage_actions.html');

		$this->assertStringContainsString('class="btn btn-sm btn-default"', $template);
		$this->assertStringNotContainsString('btn-xs', $template);
	}
}
