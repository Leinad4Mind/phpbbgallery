<?php
/**
 * phpBB Gallery - ACP albums module tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\acp\albums_module;
use PHPUnit\Framework\TestCase;

final class acp_albums_types_test extends TestCase
{
	public function test_properties_parameters_and_returns_are_fully_typed(): void
	{
		$reflection = new \ReflectionClass(albums_module::class);

		foreach ($reflection->getProperties() as $property)
		{
			if ($property->getDeclaringClass()->getName() === albums_module::class)
			{
				$this->assertNotNull($property->getType(), albums_module::class . '::$' . $property->getName());
			}
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== albums_module::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), albums_module::class . '::' . $method->getName() . '($' . $parameter->getName() . ')');
			}

			$this->assertNotNull($method->getReturnType(), albums_module::class . '::' . $method->getName() . '()');
		}
	}

	public function test_update_detection_uses_the_phpbb_request_abstraction(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/acp/albums_module.php');

		$this->assertStringContainsString('$request->is_set_post(\'update\')', $source);
		$this->assertStringNotContainsString('$' . '_POST', $source);
	}

	public function test_image_capability_comes_from_the_album_type_registry(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/acp/albums_module.php');

		$this->assertSame(2, substr_count($source, '$album_type_registry->accepts_images('));
		$this->assertStringNotContainsString('block::TYPE_CONTEST', $source);
	}
}
