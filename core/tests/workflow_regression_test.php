<?php
/**
 * phpBB Gallery - Workflow regression tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;

final class workflow_regression_test extends TestCase
{
	public function test_array_requests_declare_an_element_type(): void
	{
		$gallery_root = dirname(__DIR__, 2);
		$import = (string) file_get_contents($gallery_root . '/acpimport/acp/main_module.php');
		$logs = (string) file_get_contents(dirname(__DIR__) . '/acp/gallery_logs_module.php');

		$this->assertStringContainsString('$request->variable(\'images\', [\'\'], true)', $import);
		$this->assertStringContainsString('$request->variable(\'mark\', [0])', $logs);
	}

	public function test_subscription_images_use_a_limited_query(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/ucp/main_module.php');

		$this->assertStringContainsString('sql_query_limit($sql, $images_per_page, $start)', $source);
		$this->assertStringNotContainsString('sql_query($sql, $images_per_page, $start)', $source);
	}

	public function test_exif_details_respect_the_user_expansion_setting(): void
	{
		$gallery_root = dirname(__DIR__, 2);
		$templates = [
			$gallery_root . '/exif/styles/prosilver/template/event/gallery_viewimage_details.html',
			$gallery_root . '/exif/styles/FLATBOOTS/template/event/gallery_viewimage_details.html',
		];

		foreach ($templates as $template_path)
		{
			$template = (string) file_get_contents($template_path);

			$this->assertStringContainsString('{% if not S_VIEWEXIF %}', $template, $template_path);
			$this->assertStringContainsString('dE(\'exif_data_fieldset\')', $template, $template_path);
			$this->assertStringContainsString('lang(\'SHOW_EXIF\')', $template, $template_path);
			$this->assertStringContainsString('display: none;', $template, $template_path);
		}
	}
}
