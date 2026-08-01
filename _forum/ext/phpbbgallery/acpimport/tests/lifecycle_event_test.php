<?php
/**
 * ACP Import lifecycle event contract test.
 *
 * @package   phpbbgallery/acpimport
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\acpimport\tests;

use PHPUnit\Framework\TestCase;

final class lifecycle_event_test extends TestCase
{
	public function test_import_dispatches_complete_image_after_insert_and_before_source_cleanup(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/acp/main_module.php');
		$insert = strpos($source, "INSERT INTO ' . \$table_prefix . 'gallery_images");
		$event = strpos($source, 'phpbbgallery.acpimport.insert_image_after');
		$cleanup = strpos($source, 'file_exists($image_src_full)', $event);

		$this->assertIsInt($insert);
		$this->assertIsInt($event);
		$this->assertIsInt($cleanup);
		$this->assertGreaterThan($insert, $event);
		$this->assertGreaterThan($event, $cleanup);
		$this->assertStringContainsString("['image_id' => \$image_id] + \$sql_ary", $source);
	}
}
