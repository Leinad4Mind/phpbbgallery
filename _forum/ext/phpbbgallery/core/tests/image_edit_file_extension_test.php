<?php
/**
 * phpBB Gallery - Image edit extension point tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;

final class image_edit_file_extension_test extends TestCase
{
	public function test_file_event_runs_after_authorization_and_csrf_validation(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/image.php');
		$form_key = strpos($source, "check_form_key('gallery')");
		$authorization = strpos($source, 'can_manage_image(');
		$file_event = strpos($source, "trigger_event('phpbbgallery.core.image_edit_file'");

		$this->assertNotFalse($form_key);
		$this->assertNotFalse($authorization);
		$this->assertNotFalse($file_event);
		$this->assertLessThan($file_event, $form_key);
		$this->assertLessThan($file_event, $authorization);
	}

	public function test_listener_errors_block_the_database_update_and_changed_files_are_not_rotated_twice(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/image.php');
		$this->assertStringContainsString('if (!$errors && !$file_changed && $this->gallery_config->get(\'allow_rotate\')', $source);
		$this->assertStringContainsString("\$error = implode('<br />', \$errors);", $source);
		$this->assertStringContainsString("\$vars = ['image_id', 'image_data', 'album_data', 'errors', 'rotate', 'file_changed'];", $source);
	}

	public function test_display_event_exposes_only_the_context_an_addon_needs(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/image.php');
		$this->assertStringContainsString(
			"\$vars = ['template_vars', 'disp_image_data', 'image_id', 'image_data', 'album_data'];",
			$source
		);
	}
}
