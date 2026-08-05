<?php
/**
 * phpBB Gallery - provider-backed file deletion tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\config;
use phpbbgallery\core\file\file;
use phpbbgallery\core\storage\local_provider;
use phpbbgallery\core\storage\provider_interface;
use PHPUnit\Framework\TestCase;

final class storage_deletion_test extends TestCase
{
	private string $root;
	private local_provider $storage;

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		parent::setUp();
		$this->root = sys_get_temp_dir() . '/phpbbgallery-delete-' . bin2hex(random_bytes(6));
		mkdir($this->root);
		$this->storage = new local_provider(
			$this->root . '/source',
			$this->root . '/medium',
			$this->root . '/mini'
		);
	}

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function tearDown(): void
	{
		$this->remove_directory($this->root);
		parent::tearDown();
	}

	public function test_delete_removes_all_variants_and_watermarked_objects(): void
	{
		$key = '7/71/image.jpg';
		$watermarked_key = '7/71/image_wm.jpg';
		$input = $this->root . '/input.jpg';
		file_put_contents($input, 'image');
		foreach ([provider_interface::SOURCE, provider_interface::MEDIUM, provider_interface::MINI] as $variant)
		{
			$this->assertTrue($this->storage->write($variant, $key, $input));
		}
		foreach ([provider_interface::SOURCE, provider_interface::MEDIUM] as $variant)
		{
			$this->assertTrue($this->storage->write($variant, $watermarked_key, $input));
		}

		$this->tool()->delete($key);

		foreach ([provider_interface::SOURCE, provider_interface::MEDIUM, provider_interface::MINI] as $variant)
		{
			$this->assertFalse($this->storage->exists($variant, $key));
		}
		foreach ([provider_interface::SOURCE, provider_interface::MEDIUM] as $variant)
		{
			$this->assertFalse($this->storage->exists($variant, $watermarked_key));
		}
	}

	public function test_cache_deletion_preserves_source_and_removes_derived_objects(): void
	{
		$key = 'image.png';
		$input = $this->root . '/input.png';
		file_put_contents($input, 'image');
		foreach ([provider_interface::SOURCE, provider_interface::MEDIUM, provider_interface::MINI] as $variant)
		{
			$this->assertTrue($this->storage->write($variant, $key, $input));
		}

		$this->tool()->delete_cache($key);

		$this->assertTrue($this->storage->exists(provider_interface::SOURCE, $key));
		$this->assertFalse($this->storage->exists(provider_interface::MEDIUM, $key));
		$this->assertFalse($this->storage->exists(provider_interface::MINI, $key));
	}

	private function tool(): file
	{
		return new file(
			$this->createMock(\phpbb\request\request_interface::class),
			$this->createMock(\phpbbgallery\core\url::class),
			new config(new \phpbb\config\config([])),
			file::GDLIB2,
			$this->storage
		);
	}

	private function remove_directory(string $directory): void
	{
		if (!is_dir($directory))
		{
			return;
		}

		$iterator = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator($directory, \FilesystemIterator::SKIP_DOTS),
			\RecursiveIteratorIterator::CHILD_FIRST
		);
		foreach ($iterator as $item)
		{
			$item->isDir() ? rmdir($item->getPathname()) : unlink($item->getPathname());
		}
		rmdir($directory);
	}
}
