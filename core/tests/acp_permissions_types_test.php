<?php
/**
 * phpBB Gallery - ACP permissions module tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\acp\permissions_module;
use PHPUnit\Framework\TestCase;

final class acp_permissions_types_test extends TestCase
{
	public function test_properties_parameters_and_returns_are_fully_typed(): void
	{
		$reflection = new \ReflectionClass(permissions_module::class);

		foreach ($reflection->getProperties() as $property)
		{
			if ($property->getDeclaringClass()->getName() === permissions_module::class)
			{
				$this->assertNotNull($property->getType(), permissions_module::class . '::$' . $property->getName());
			}
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== permissions_module::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), permissions_module::class . '::' . $method->getName() . '($' . $parameter->getName() . ')');
			}

			$this->assertNotNull($method->getReturnType(), permissions_module::class . '::' . $method->getName() . '()');
		}
	}

	public function test_inheritance_helpers_have_explicit_validation_results(): void
	{
		foreach (['inherit_albums', 'inherit_victims', 'p_system_inherit_victims'] as $method_name)
		{
			$type = (string) (new \ReflectionMethod(permissions_module::class, $method_name))->getReturnType();
			$this->assertContains($type, ['string|bool', 'bool|string'], $method_name);
		}
	}

	public function test_system_victim_validation_initializes_the_converted_list(): void
	{
		global $phpbb_container;

		$had_container = isset($phpbb_container);
		$previous_container = $phpbb_container ?? null;
		$phpbb_container = new class
		{
			public function get(string $service): object
			{
				return new class
				{
					public const OWN_ALBUM = 1;
					public const PERSONAL_ALBUM = 2;
				};
			}
		};

		try
		{
			$module = new permissions_module();
			$language = $this->createMock(\phpbb\language\language::class);
			$language->method('lang')
				->willReturnCallback(static fn (string $key): string => $key);
			$module->language = $language;
			$method = new \ReflectionMethod(permissions_module::class, 'p_system_inherit_victims');

			$this->assertTrue($method->invoke($module, 1, [5], 0, 5));
		}
		finally
		{
			if ($had_container)
			{
				$phpbb_container = $previous_container;
			}
			else
			{
				unset($phpbb_container);
			}
		}
	}

	public function test_submit_detection_uses_the_phpbb_request_abstraction(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/acp/permissions_module.php');

		$this->assertStringNotContainsString('$' . '_POST', $source);
		$this->assertStringContainsString('$converted_victims = array();', $source);
		$this->assertSame(6, substr_count($source, 'is_set_post('));
	}
}
