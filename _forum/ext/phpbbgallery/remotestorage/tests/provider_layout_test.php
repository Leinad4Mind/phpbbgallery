<?php
/**
 * phpBB Gallery - Remote Storage provider layout tests
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\tests;

use PHPUnit\Framework\TestCase;

final class provider_layout_test extends TestCase
{
	private const PROVIDERS = [
		'azure',
		'box',
		'dropbox',
		'fourshared',
		'google_drive',
		'koofr',
		'mediafire',
		'pcloud',
		's3',
		'sftp',
	];

	public function test_concrete_providers_are_grouped_under_provider_directory(): void
	{
		$root = dirname(__DIR__);
		$directories = array_map('basename', glob($root . '/providers/*', GLOB_ONLYDIR));
		sort($directories);

		$expected = self::PROVIDERS;
		sort($expected);
		$this->assertSame($expected, $directories);

		foreach (self::PROVIDERS as $provider)
		{
			$directory = $root . '/providers/' . $provider;
			$this->assertDirectoryExists($directory);
			$this->assertDirectoryDoesNotExist($root . '/' . $provider);

			$files = glob($directory . '/*.php');
			$this->assertNotEmpty($files);
			foreach ($files as $file)
			{
				$this->assertStringContainsString(
					'namespace phpbbgallery\\remotestorage\\providers\\' . $provider . ';',
					(string) file_get_contents($file),
					basename($file) . ' must use the grouped provider namespace.'
				);
			}
		}
	}

	public function test_service_factories_follow_grouped_provider_namespaces(): void
	{
		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services.yml');

		foreach (self::PROVIDERS as $provider)
		{
			$this->assertStringContainsString(
				'class: phpbbgallery\\remotestorage\\providers\\' . $provider . '\\configured_factory',
				$services
			);
		}
	}

	public function test_shared_transport_and_migration_infrastructure_stays_provider_neutral(): void
	{
		$root = dirname(__DIR__);

		$this->assertDirectoryExists($root . '/http');
		$this->assertDirectoryExists($root . '/migration');
		$this->assertDirectoryDoesNotExist($root . '/providers/http');
		$this->assertDirectoryDoesNotExist($root . '/providers/migration');
	}
}
