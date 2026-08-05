<?php
/**
 * phpBB Gallery - ACP Cleanup module tests
 *
 * @package   phpbbgallery/acpcleanup
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\acpcleanup\tests;

use phpbbgallery\acpcleanup\acp\main_module;
use PHPUnit\Framework\TestCase;

final class main_module_test extends TestCase
{
	public function test_module_contract_is_fully_typed(): void
	{
		$reflection = new \ReflectionClass(main_module::class);

		foreach ($reflection->getProperties() as $property)
		{
			if ($property->getDeclaringClass()->getName() === main_module::class)
			{
				$this->assertNotNull($property->getType(), main_module::class . '::$' . $property->getName());
			}
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== main_module::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), main_module::class . '::' . $method->getName() . '($' . $parameter->getName() . ')');
			}
			$this->assertNotNull($method->getReturnType(), main_module::class . '::' . $method->getName() . '()');
		}
	}

	public function test_prune_and_cancel_flags_use_the_phpbb_request_service(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/acp/main_module.php');
		$fields = [
			'cancel',
			'prune_username_check',
			'prune_anonymous',
			'prune_time_check',
			'prune_comments_check',
			'prune_ratings_check',
			'prune_rating_avg_check',
		];

		$this->assertStringNotContainsString('$' . '_POST', $source);
		foreach ($fields as $field)
		{
			$this->assertStringContainsString('$request->is_set_post(\'' . $field . '\')', $source, $field);
		}
	}

	public function test_source_checks_use_the_active_storage_contract(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/acp/main_module.php');

		$this->assertStringNotContainsString('opendir(', $source);
		$this->assertStringNotContainsString('readdir(', $source);
		$this->assertStringContainsString('$storage_workspace->exists(', $source);
		$this->assertStringContainsString('$storage_workspace->list_objects(', $source);
		$this->assertStringContainsString('$storage_workspace->materialize(', $source);
	}

	public function test_orphan_scan_supports_distributed_keys_and_filters_non_sources(): void
	{
		$root = sys_get_temp_dir() . '/phpbbgallery-cleanup-list-' . bin2hex(random_bytes(6));
		$source = $root . '/source';
		$provider = new \phpbbgallery\core\storage\local_provider($source, $root . '/medium', $root . '/mini');
		$workspace = new \phpbbgallery\core\storage\workspace($provider, $root . '/workspace');
		$input = $root . '/input.jpg';
		try
		{
			mkdir($root, 0700, true);
			file_put_contents($input, 'image');
			foreach (['known.jpg', '7/71/orphan.webp', 'orphan.png', 'cached_wm.jpg', 'notes.txt', 'image_not_exist.jpg'] as $key)
			{
				$this->assertTrue($provider->write(\phpbbgallery\core\storage\provider_interface::SOURCE, $key, $input));
			}

			$module = new main_module();
			$method = new \ReflectionMethod($module, 'find_orphan_source_keys');
			$this->assertSame(['7/71/orphan.webp', 'orphan.png'], $method->invoke($module, $workspace, ['known.jpg']));
		}
		finally
		{
			$this->remove_directory($root);
		}
	}

	public function test_orphan_scan_rejects_a_repeated_provider_cursor(): void
	{
		$provider = $this->createMock(\phpbbgallery\core\storage\provider_interface::class);
		$provider->method('list_objects')->willReturn(['keys' => [], 'cursor' => 'same']);
		$workspace = new \phpbbgallery\core\storage\workspace($provider, sys_get_temp_dir());
		$module = new main_module();
		$method = new \ReflectionMethod($module, 'find_orphan_source_keys');

		$this->expectException(\RuntimeException::class);
		$this->expectExceptionMessage('repeated object cursor');
		$method->invoke($module, $workspace, []);
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
