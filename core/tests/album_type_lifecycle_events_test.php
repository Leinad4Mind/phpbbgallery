<?php
/**
 * phpBB Gallery album-type lifecycle boundary tests.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;

final class album_type_lifecycle_events_test extends TestCase
{
	public function test_album_manager_exposes_neutral_type_lifecycle_events(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/album/manage.php');

		foreach (['validate_type_data', 'created', 'prepare_update', 'updated'] as $event)
		{
			$this->assertStringContainsString('phpbbgallery.core.album.manage.' . $event, $source);
		}
		$this->assertStringNotContainsString('parse_contest_date', $source);
		$this->assertStringNotContainsString('update_contest_data', $source);
		$this->assertStringNotContainsString('$gallery_contest', $source);
	}
}
