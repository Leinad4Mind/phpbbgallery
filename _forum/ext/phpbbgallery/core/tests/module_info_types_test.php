<?php
/**
 * phpBB Gallery - ACP/UCP module metadata tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;

final class module_info_types_test extends TestCase
{
	private const MODULES = [
		\phpbbgallery\core\acp\albums_info::class => ['manage'],
		\phpbbgallery\core\acp\config_info::class => ['main'],
		\phpbbgallery\core\acp\gallery_logs_info::class => ['main'],
		\phpbbgallery\core\acp\main_info::class => ['overview'],
		\phpbbgallery\core\acp\permissions_info::class => ['manage', 'copy'],
		\phpbbgallery\core\ucp\main_info::class => ['manage_albums', 'manage_subscriptions'],
		\phpbbgallery\core\ucp\settings_info::class => ['manage'],
	];

	public function test_module_metadata_contracts_are_public_and_typed(): void
	{
		foreach (array_keys(self::MODULES) as $class_name)
		{
			$method = new \ReflectionMethod($class_name, 'module');

			$this->assertTrue($method->isPublic(), $class_name);
			$this->assertSame('array', (string) $method->getReturnType(), $class_name);
			$this->assertSame([], $method->getParameters(), $class_name);
		}
	}

	public function test_module_metadata_exposes_expected_modes_and_guards(): void
	{
		foreach (self::MODULES as $class_name => $expected_modes)
		{
			$metadata = (new $class_name())->module();

			$this->assertNotSame('', $metadata['title'] ?? '', $class_name);
			$this->assertNotSame('', $metadata['version'] ?? '', $class_name);
			$this->assertSame($expected_modes, array_keys($metadata['modes'] ?? []), $class_name);
			foreach ($metadata['modes'] as $mode)
			{
				$this->assertNotSame('', $mode['title'] ?? '', $class_name);
				$this->assertStringContainsString('ext_phpbbgallery/core', $mode['auth'] ?? '', $class_name);
				$this->assertContains('PHPBB_GALLERY', $mode['cat'] ?? [], $class_name);
			}
		}
	}
}
