<?php
/**
 * BBPoints Images source-access integration tests
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbpointsimages\tests;

use PHPUnit\Framework\TestCase;

final class source_access_test extends TestCase
{
	public function test_listener_gates_only_the_core_source_event_and_handles_cancel_safely(): void
	{
		$source = file_get_contents(dirname(__DIR__) . '/event/main_listener.php');

		$this->assertStringContainsString("'phpbbgallery.core.file.source_access' => 'source_access'", $source);
		$this->assertStringContainsString('if (!confirm_box(true))', $source);
		$this->assertStringContainsString("is_set_post('cancel')", $source);
		$this->assertStringContainsString('login_box($source_url', $source);
		$this->assertStringContainsString('record_download($image_id, $buyer_id)', $source);
		$this->assertStringContainsString('catch (insufficient_funds $exception)', $source);
	}

	public function test_purchase_manager_is_wired_to_the_atomic_bbpoints_ledger(): void
	{
		$services = file_get_contents(dirname(__DIR__) . '/config/services.yml');

		$this->assertStringContainsString('phpbbgallery.bbpointsimages.purchase_manager:', $services);
		$this->assertStringContainsString("- '@sitesplat.bbpoints.ledger'", $services);
		$this->assertStringContainsString("- '%phpbbgallery.bbpointsimages.tables.purchases%'", $services);
		$this->assertStringContainsString("- '%phpbbgallery.bbpointsimages.tables.contributors%'", $services);
	}

	public function test_download_counter_is_exposed_in_every_supported_style(): void
	{
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$template = dirname(__DIR__) . '/styles/' . $style
				. '/template/event/phpbbgallery_core_viewimage_details.html';
			$this->assertFileExists($template);
			$this->assertStringContainsString('BBPOINTSIMAGES_DOWNLOAD_COUNT', file_get_contents($template));
		}
	}
}
