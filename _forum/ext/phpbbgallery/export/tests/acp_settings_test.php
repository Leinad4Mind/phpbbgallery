<?php
/**
 * phpBB Gallery Export ACP settings tests.
 *
 * @package   phpbbgallery/export
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\export\tests;

use phpbbgallery\export\acp\main_module;
use phpbbgallery\export\job_storage;
use phpbbgallery\export\runner;
use PHPUnit\Framework\TestCase;

final class acp_settings_test extends TestCase
{
	public function test_defaults_are_the_requested_limits(): void
	{
		$migration = (string) file_get_contents(dirname(__DIR__) . '/migrations/m1_init.php');

		self::assertStringContainsString("['phpbb_gallery_export_max_images', 5000]", $migration);
		self::assertStringContainsString("['phpbb_gallery_export_max_bytes', 2147483648]", $migration);
		self::assertStringContainsString("['phpbb_gallery_export_batch_size', 25]", $migration);
	}

	public function test_submitted_values_are_normalized_to_safe_limits(): void
	{
		$method = new \ReflectionMethod(main_module::class, 'normalize_settings');
		$method->setAccessible(true);
		$module = new main_module();

		self::assertSame([
			'max_images' => 1,
			'max_bytes' => runner::MIN_EXPORT_BYTES,
			'batch_size' => 1,
		], $method->invoke($module, 0, 0, 0));
		self::assertSame([
			'max_images' => job_storage::MAX_IMAGES,
			'max_bytes' => runner::MAX_EXPORT_BYTES,
			'batch_size' => runner::MAX_BATCH_SIZE,
		], $method->invoke($module, PHP_INT_MAX, PHP_INT_MAX, PHP_INT_MAX));
	}

	public function test_acp_uses_a_separate_csrf_protected_settings_form(): void
	{
		$module = (string) file_get_contents(dirname(__DIR__) . '/acp/main_module.php');
		$template = (string) file_get_contents(dirname(__DIR__) . '/adm/style/gallery_export.html');

		self::assertStringContainsString("is_set_post('save_settings')", $module);
		self::assertStringContainsString("check_form_key('acp_gallery')", $module);
		self::assertStringContainsString('id="acp_gallery_settings"', $template);
		self::assertStringContainsString('name="save_settings"', $template);
		self::assertStringContainsString('name="export_max_images"', $template);
		self::assertStringContainsString('name="export_max_size_mib"', $template);
		self::assertStringContainsString('name="export_batch_size"', $template);
		self::assertGreaterThanOrEqual(2, substr_count($template, '{{ S_FORM_TOKEN }}'));
	}
}
