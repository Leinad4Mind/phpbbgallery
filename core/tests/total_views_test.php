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

final class total_views_test extends TestCase
{
	public function test_total_views_are_exposed_by_public_and_acp_statistics(): void
	{
		$core_root = dirname(__DIR__);
		$index_controller = (string) file_get_contents($core_root . '/controller/index.php');
		$acp_controller = (string) file_get_contents($core_root . '/acp/main_module.php');
		$acp_template = (string) file_get_contents($core_root . '/adm/style/gallery_main.html');

		$this->assertStringContainsString("'TOTAL_VIEWS'", $index_controller);
		$this->assertStringContainsString("'TOTAL_IMAGE_COUNT'", $index_controller);
		$this->assertStringContainsString("'TOTAL_VIEWS'", $acp_controller);
		$this->assertStringContainsString('SUM(image_view_count) AS num_views', $acp_controller);
		$this->assertStringContainsString("lang('TOTAL_VIEWS')", $acp_template);

		foreach (\gallery_test_existing_styles(dirname(__DIR__)) as $style)
		{
			$template = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/index_body.html');
			$this->assertStringContainsString("lang('TOTAL_VIEWS')", $template, $style);
			$this->assertStringContainsString("lang('GALLERY_IMAGES')", $template, $style);
			$this->assertStringContainsString('TOTAL_IMAGE_COUNT is not same as(false)', $template, $style);
			$this->assertStringContainsString('<strong>{{ TOTAL_IMAGE_COUNT }}</strong>', $template, $style);
			$this->assertStringNotContainsString('<p>{{ TOTAL_IMAGES }}', $template, $style);
		}
	}

	public function test_every_language_defines_the_total_views_label(): void
	{
		$language_root = dirname(__DIR__) . '/language';
		foreach (glob($language_root . '/*/gallery.php') as $language_file)
		{
			$source = (string) file_get_contents($language_file);
			$this->assertStringContainsString("'TOTAL_VIEWS'", $source, $language_file);
		}
	}
}
