<?php
/**
 * phpBB Gallery - Core Extension tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;

final class addon_lifecycle_events_test extends TestCase
{
	public function test_upload_finalization_event_runs_after_the_image_row_is_updated(): void
	{
		$method = $this->extract_method(dirname(__DIR__) . '/upload.php', 'public function update_image(', "\n\t/**");
		$mutation = strpos($method, '$this->db->sql_query($sql)');
		$event = strpos($method, "trigger_event('phpbbgallery.core.upload.update_image_after'");

		$this->assertNotFalse($mutation);
		$this->assertNotFalse($event);
		$this->assertLessThan($event, $mutation);
		$this->assertStringContainsString("['image_id', 'image_index', 'image_data', 'sql_ary']", $method);
	}

	public function test_upload_review_validation_runs_before_any_image_is_finalized(): void
	{
		$controller = (string) file_get_contents(dirname(__DIR__) . '/controller/upload.php');
		$event = strpos($controller, "trigger_event('phpbbgallery.core.upload.review_validate'");
		$finalization = strpos($controller, 'update_image($image_id', $event ?: 0);

		$this->assertNotFalse($event);
		$this->assertNotFalse($finalization);
		$this->assertLessThan($finalization, $event);
		$this->assertStringContainsString("['validation_error', 'image_ids']", $controller);
	}

	public function test_image_edit_event_runs_after_authorized_persistence_and_before_success(): void
	{
		$method = $this->extract_method(dirname(__DIR__) . '/controller/image.php', 'public function edit(', "\n\t// Delete image");
		$mutation = strpos($method, '$this->db->sql_query($sql)');
		$event = strpos($method, "trigger_event('phpbbgallery.core.image_edit_after'");
		$success = strpos($method, "lang('IMAGES_UPDATED_SUCCESSFULLY')");

		$this->assertNotFalse($mutation);
		$this->assertNotFalse($event);
		$this->assertNotFalse($success);
		$this->assertLessThan($event, $mutation);
		$this->assertLessThan($success, $event);
		$this->assertStringContainsString("['image_id', 'image_data', 'updated_image_data', 'sql_ary']", $method);
	}

	private function extract_method(string $path, string $start_marker, string $end_marker): string
	{
		$source = (string) file_get_contents($path);
		$start = strpos($source, $start_marker);
		$this->assertNotFalse($start);
		$end = strpos($source, $end_marker, $start + strlen($start_marker));
		$this->assertNotFalse($end);

		return substr($source, $start, $end - $start);
	}
}
