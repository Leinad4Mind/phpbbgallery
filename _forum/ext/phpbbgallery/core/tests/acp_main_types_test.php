<?php
/**
 * phpBB Gallery - ACP overview module tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\acp\main_module;
use PHPUnit\Framework\TestCase;

final class acp_main_types_test extends TestCase
{
	public function test_properties_parameters_and_returns_are_fully_typed(): void
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

	public function test_overview_actions_are_explicit_commands(): void
	{
		$this->assertSame('void', (string) (new \ReflectionMethod(main_module::class, 'main'))->getReturnType());
		$this->assertSame('void', (string) (new \ReflectionMethod(main_module::class, 'overview'))->getReturnType());
	}

	public function test_cache_purge_is_php8_safe_and_uses_numbered_upload_path(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/acp/main_module.php');

		$this->assertStringNotContainsString('@readdir(', $source);
		$this->assertStringNotContainsString('@closedir(', $source);
		$this->assertSame(6, substr_count($source, '!== false && ('));
		$this->assertStringContainsString('@unlink($gallery_url->path(\'upload\') . $i . \'/\' . $upload_file);', $source);
	}
}
