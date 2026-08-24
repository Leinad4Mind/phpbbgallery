<?php
/**
 * phpBB Gallery - Release package builder tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\release\package_builder;
use PHPUnit\Framework\TestCase;

final class release_package_builder_test extends TestCase
{
	/** @var list<string> */
	private array $temporary_directories = [];

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function tearDown(): void
	{
		foreach ($this->temporary_directories as $directory)
		{
			$this->remove_directory($directory);
		}
		$this->temporary_directories = [];
	}

	public function test_builder_creates_clean_reproducible_component_packages(): void
	{
		require_once dirname(__DIR__, 2) . '/build_release_packages.php';

		if (!class_exists('ZipArchive') || !class_exists('PharData') || !function_exists('proc_open'))
		{
			$this->markTestSkipped('ZIP, PharData and proc_open are required for release packaging.');
		}

		$suite_root = realpath(dirname(__DIR__, 2));
		$repository_root = \phpbbgallery\release\find_repository_root((string) $suite_root);
		$suite_path = $suite_root === $repository_root ? '' : substr((string) $suite_root, strlen($repository_root) + 1);
		$builder = new package_builder($repository_root, $suite_path);
		$first_output = $this->temporary_directory();
		$second_output = $this->temporary_directory();

		$first = $builder->build($first_output);
		$second = $builder->build($second_output);

		$this->assertMatchesRegularExpression('/^[a-f0-9]{40}$/D', $first['commit']);
		$this->assertSame($first['commit'], $second['commit']);
		$this->assertCount(15, $first['packages']);
		$this->assertContains('featured', package_builder::COMPONENTS);
		$this->assertSame(package_builder::COMPONENTS, array_column($first['packages'], 'component'));

		$first_hashes = array_column($first['packages'], 'sha256', 'filename');
		$second_hashes = array_column($second['packages'], 'sha256', 'filename');
		$this->assertSame($first_hashes, $second_hashes, 'Building the same Git ref twice must produce identical ZIP files.');

		$manifest = json_decode((string) file_get_contents($first_output . '/release-manifest.json'), true, 512, JSON_THROW_ON_ERROR);
		$this->assertSame($first, $manifest);
		$this->assertFileExists($first_output . '/SHA256SUMS');

		foreach ($first['packages'] as $package)
		{
			$package_path = $first_output . '/' . $package['filename'];
			$this->assertFileExists($package_path);
			$this->assertSame($package['sha256'], hash_file('sha256', $package_path));
			$this->assertSame($package['bytes'], filesize($package_path));
			$this->assert_package_entries($package_path, $package['component']);
		}
	}

	private function assert_package_entries(string $package_path, string $component): void
	{
		$zip = new \ZipArchive();
		$this->assertTrue($zip->open($package_path) === true);
		$prefix = 'phpbbgallery/' . $component . '/';
		$entries = [];

		try
		{
			for ($index = 0; $index < $zip->numFiles; $index++)
			{
				$name = (string) $zip->getNameIndex($index);
				$entries[] = $name;
				$this->assertTrue($name === 'phpbbgallery/' || str_starts_with($name, $prefix), $name);
				$this->assertStringNotContainsString('\\', $name);
				$this->assertDoesNotMatchRegularExpression('#/(?:tests|vendor)(?:/|$)|/phpunit\.xml\.dist$|/\.git#D', $name);
			}
		}
		finally
		{
			$zip->close();
		}

		$this->assertContains($prefix . 'composer.json', $entries);
		$this->assertContains($prefix . 'ext.php', $entries);
		$this->assertContains($prefix . 'license.txt', $entries);
	}

	private function temporary_directory(): string
	{
		$directory = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR .
			'phpbbgallery-package-test-' . bin2hex(random_bytes(12));
		$this->assertTrue(mkdir($directory, 0700, true));
		$this->temporary_directories[] = $directory;
		return $directory;
	}

	private function remove_directory(string $directory): void
	{
		$resolved = realpath($directory);
		$base = realpath(sys_get_temp_dir());
		if ($resolved === false || $base === false ||
			!str_starts_with($resolved, rtrim($base, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'phpbbgallery-package-test-'))
		{
			return;
		}

		$iterator = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator($resolved, \FilesystemIterator::SKIP_DOTS),
			\RecursiveIteratorIterator::CHILD_FIRST
		);
		foreach ($iterator as $file)
		{
			$file->isDir() ? rmdir($file->getPathname()) : unlink($file->getPathname());
		}
		rmdir($resolved);
	}
}
