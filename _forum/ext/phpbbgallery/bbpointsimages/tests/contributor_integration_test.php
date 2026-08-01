<?php
/**
 * BBPoints Images contributor integration tests
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbpointsimages\tests;

use PHPUnit\Framework\TestCase;

final class contributor_integration_test extends TestCase
{
	public function test_listener_covers_resumable_upload_edit_author_change_delete_and_private_contests(): void
	{
		$listener = file_get_contents(dirname(__DIR__) . '/event/main_listener.php');
		foreach ([
			'phpbbgallery.core.upload.review_validate',
			'phpbbgallery.core.upload.review_display',
			'phpbbgallery.core.upload.update_image_after',
			'phpbbgallery.core.image_edit_file',
			'phpbbgallery.core.image_edit_display',
			'phpbbgallery.core.image_edit_after',
			'phpbbgallery.core.image.change_author_after',
			'phpbbgallery.core.image.delete_images',
		] as $event)
		{
			$this->assertStringContainsString("'$event'", $listener);
		}
		$this->assertStringContainsString("!empty(\$event['hide_contest_private_data'])", $listener);
		$this->assertStringContainsString("'mode=searchuser&amp;form=postform&amp;field=bbpointsimages_contributors_'", $listener);
	}

	public function test_field_and_attribution_are_available_in_every_supported_style(): void
	{
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$event_root = dirname(__DIR__) . '/styles/' . $style . '/template/event/';
			$edit = file_get_contents($event_root . 'phpbbgallery_core_edit_addfields.html');
			$view = file_get_contents($event_root . 'phpbbgallery_core_viewimage_details.html');
			$this->assertStringContainsString('bbpointsimages_contributors_{{ image.S_ROW_COUNT }}', $edit, $style);
			$this->assertStringContainsString('find_username(this.href)', $edit, $style);
			$this->assertStringContainsString('bbpointsimages_contributors|length', $view, $style);
		}
	}

	public function test_core_exposes_contest_privacy_to_view_listeners(): void
	{
		$core = file_get_contents(dirname(__DIR__, 2) . '/core/controller/image.php');
		$this->assertStringContainsString(
			"['image_id', 'image_data', 'album_data', 'page_title', 'hide_contest_private_data']",
			$core
		);
	}
}
