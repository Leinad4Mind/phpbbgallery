<?php
/**
 * Image revisions addon lifecycle tests.
 *
 * @package   phpbbgallery/imagerevisions
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\imagerevisions\tests;

use PHPUnit\Framework\TestCase;

final class lifecycle_test extends TestCase
{
	public function test_enablement_reconciles_database_rows_and_owned_files_after_migrations(): void
	{
		$extension = (string) file_get_contents(dirname(__DIR__) . '/ext.php');

		$this->assertStringContainsString("\$old_state === 'reconcile'", $extension);
		$this->assertStringContainsString('phpbbgallery.core.file.tool', $extension);
		$this->assertSame(2, substr_count($extension, 'reconcile_orphans()'));
		$this->assertStringContainsString("\$prefix . 'gallery_imagerevisions_album_rules'", $extension);
	}
}
