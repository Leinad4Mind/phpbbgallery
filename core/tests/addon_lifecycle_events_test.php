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
		$this->assertStringContainsString(
			"['image_id', 'image_index', 'image_data', 'sql_ary', 'file_link']",
			$method
		);
	}

	public function test_upload_review_validation_runs_before_any_image_is_finalized(): void
	{
		$controller = (string) file_get_contents(dirname(__DIR__) . '/controller/upload.php');
		$event = strpos($controller, "trigger_event('phpbbgallery.core.upload.review_validate'");
		$finalization = strpos($controller, 'update_image($image_id', $event ?: 0);

		$this->assertNotFalse($event);
		$this->assertNotFalse($finalization);
		$this->assertLessThan($finalization, $event);
		$this->assertStringContainsString("['validation_error', 'image_ids', 'album_id', 'album_data']", $controller);
	}

	public function test_upload_review_display_can_extend_each_image_block(): void
	{
		$controller = (string) file_get_contents(dirname(__DIR__) . '/controller/upload.php');
		$event = strpos($controller, "trigger_event('phpbbgallery.core.upload.review_display'");
		$assignment = strpos($controller, "assign_block_vars('image', \$image_template_vars)", $event ?: 0);

		$this->assertNotFalse($event);
		$this->assertNotFalse($assignment);
		$this->assertLessThan($assignment, $event);
		$this->assertStringContainsString("['image_id', 'image_index', 'image_data', 'image_template_vars']", $controller);
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
		$this->assertStringContainsString("['image_id', 'image_data', 'updated_image_data', 'sql_ary', 'file_changed']", $method);
	}

	public function test_approval_and_author_changes_dispatch_after_persistence(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/image/image.php');
		$this->assertStringContainsString('phpbbgallery.core.image.approve_after', $source);
		$this->assertStringContainsString('phpbbgallery.core.image.change_author_after', $source);
		$this->assertGreaterThan(
			strpos($source, "SET image_status = '"),
			strpos($source, "trigger_event('phpbbgallery.core.image.approve_after'")
		);
		$this->assertGreaterThan(
			strpos($source, "sql_transaction('commit')"),
			strpos($source, "trigger_event('phpbbgallery.core.image.change_author_after'")
		);
	}

	public function test_prosilver_image_edit_form_exposes_the_shared_addon_field_hook(): void
	{
		$template = (string) file_get_contents(
			dirname(__DIR__) . '/styles/prosilver/template/gallery/image_edit_body.html'
		);

		$this->assertStringContainsString('{% EVENT phpbbgallery_core_edit_addfields %}', $template);
		$this->assertGreaterThan(
			strpos($template, '{% endfor %}'),
			strpos($template, '{% EVENT phpbbgallery_core_edit_addfields %}')
		);
	}

	public function test_image_edit_forms_expose_a_per_image_addon_field_hook(): void
	{
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$template = (string) file_get_contents(
				dirname(__DIR__) . '/styles/' . $style . '/template/gallery/posting_body.html'
			);
			$loop_start = strpos($template, '{% for image in image %}');
			$hook = strpos($template, '{% EVENT phpbbgallery_core_edit_image_addfields %}', $loop_start);
			$loop_end = strpos($template, '{% endfor %}', $hook);

			$this->assertNotFalse($loop_start, $style);
			$this->assertNotFalse($hook, $style);
			$this->assertNotFalse($loop_end, $style);
			$this->assertGreaterThan($loop_start, $hook, $style);
			$this->assertGreaterThan($hook, $loop_end, $style);
		}

		$image_edit = (string) file_get_contents(
			dirname(__DIR__) . '/styles/prosilver/template/gallery/image_edit_body.html'
		);
		$this->assertMatchesRegularExpression(
			'/\{% for image in image %\}.*\{% EVENT phpbbgallery_core_edit_image_addfields %\}.*\{% endfor %\}/s',
			$image_edit
		);
	}

	public function test_prosilver_upload_addon_fields_share_the_image_details_column(): void
	{
		$template = (string) file_get_contents(
			dirname(__DIR__) . '/styles/prosilver/template/gallery/posting_body.html'
		);

		$loop = strpos($template, '{% for image in image %}');
		$details = strpos($template, '<dd>', $loop);
		$hook = strpos($template, '{% EVENT phpbbgallery_core_edit_image_addfields %}', $details);
		$details_end = strpos($template, "\t\t\t\t</dl>", $hook);

		$this->assertNotFalse($loop);
		$this->assertNotFalse($details);
		$this->assertNotFalse($hook);
		$this->assertNotFalse($details_end);
		$this->assertGreaterThan($details, $hook);
		$this->assertGreaterThan($hook, $details_end);
		$this->assertStringNotContainsString('gallery-image-addon-fields', $template);
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
