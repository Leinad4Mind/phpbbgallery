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
	public function test_fixtures_supply_required_text_fields(): void
	{
		$extension_root = dirname(__DIR__, 2);
		$files_checked = [];
		$requirements = [
			'gallery_albums' => ['album_parents', 'album_desc'],
			'gallery_images' => ['image_desc'],
			'gallery_users' => ['user_permissions'],
		];
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
			foreach ($requirements as $table => $required_fields)
			{
				if (!preg_match('/INSERT INTO[^\r\n]*' . $table . '/', $source))
				{
					continue;
				}

				$files_checked[] = $path . ':' . $table;
				foreach ($required_fields as $required_field)
				{
					$this->assertStringContainsString(
						$required_field,
						$source,
						$path . ' must explicitly populate ' . $required_field . ' for strict MySQL/MariaDB.'
					);
				}
			}
		}

		$this->assertNotEmpty($files_checked, 'No functional album fixtures were checked.');
	}
}
