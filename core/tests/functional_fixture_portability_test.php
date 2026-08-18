<?php
/**
 * phpBB Gallery - Core Extension tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use FilesystemIterator;
use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

final class functional_fixture_portability_test extends TestCase
{
	public function test_album_fixtures_supply_required_parent_cache(): void
	{
		$extension_root = dirname(__DIR__, 2);
		$files_checked = [];
		$iterator = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator($extension_root, FilesystemIterator::SKIP_DOTS)
		);

		foreach ($iterator as $file)
		{
			$path = str_replace('\\', '/', $file->getPathname());
			if (!$file->isFile() || $file->getExtension() !== 'php' || !str_contains($path, '/tests/functional/'))
			{
				continue;
			}

			$source = (string) file_get_contents($file->getPathname());
			if (!preg_match('/INSERT INTO[^\r\n]*gallery_albums/', $source))
			{
				continue;
			}

			$files_checked[] = $path;
			$this->assertStringContainsString(
				'album_parents',
				$source,
				$path . ' must explicitly populate album_parents for strict MySQL/MariaDB.'
			);
		}

		$this->assertNotEmpty($files_checked, 'No functional album fixtures were checked.');
	}
}
