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

	public function test_import_publishes_before_insert_and_rolls_back_database_failure(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/acp/main_module.php');
		$publish = strpos($source, '$storage_workspace->publish(');
		$insert = strpos($source, 'gallery_images ', $publish ?: 0);
		$rollback = strpos($source, '$storage_workspace->delete(', $insert ?: 0);
		$staging_cleanup = strpos($source, '$local_storage->delete(', $rollback ?: 0);

		$this->assertIsInt($publish);
		$this->assertIsInt($insert);
		$this->assertIsInt($rollback);
		$this->assertIsInt($staging_cleanup);
		$this->assertLessThan($insert, $publish);
		$this->assertLessThan($rollback, $insert);
		$this->assertLessThan($staging_cleanup, $rollback);
		$this->assertStringContainsString('staging/', $source);
		$this->assertStringContainsString('bin2hex(random_bytes(16))', $source);
	}
}
