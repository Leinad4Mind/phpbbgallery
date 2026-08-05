<?php
/**
 * phpBB Gallery - Extensible image sorting tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;

final class image_sort_extension_test extends TestCase
{
	public function test_album_and_previous_next_queries_share_the_sort_event(): void
	{
		foreach (['album.php', 'image.php'] as $controller)
		{
			$source = (string) file_get_contents(dirname(__DIR__) . '/controller/' . $controller);
			$event = strpos($source, 'phpbbgallery.core.image.sort_options');
			$normalization = strpos($source, 'normalize_sort_key', $event === false ? 0 : $event);

			$this->assertNotFalse($event, $controller);
			$this->assertNotFalse($normalization, $controller);
			$this->assertLessThan($normalization, $event, $controller);
			$this->assertStringContainsString("FROM ' . \$sort_from . '", $source, $controller);
		}
	}

	public function test_acp_global_and_album_defaults_share_the_sort_label_event(): void
	{
		$config = (string) file_get_contents(dirname(__DIR__) . '/acp/config_module.php');
		$albums = (string) file_get_contents(dirname(__DIR__) . '/acp/albums_module.php');

		$this->assertStringContainsString('phpbbgallery.core.image.sort_labels', $config);
		$this->assertStringContainsString('phpbbgallery.core.image.sort_labels', $albums);
		$this->assertStringContainsString("lang('IMAGE_UPLOAD_TIME')", $config);
		$this->assertStringContainsString("lang('IMAGE_UPLOAD_TIME')", $albums);
	}

	public function test_successful_core_rotation_is_reported_to_addons(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/image.php');

		$this->assertStringContainsString('$file_changed = true;', $source);
		$this->assertStringContainsString(
			"['image_id', 'image_data', 'updated_image_data', 'sql_ary', 'file_changed']",
			$source
		);
	}
}
