<?php
/**
 * phpBB Gallery - Index controller tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\controller\index;
use PHPUnit\Framework\TestCase;

final class controller_index_types_test extends TestCase
{
	public function test_index_controller_properties_and_methods_are_fully_typed(): void
	{
		$reflection = new \ReflectionClass(index::class);

		foreach ($reflection->getProperties() as $property)
		{
			if ($property->getDeclaringClass()->getName() === index::class)
			{
				$this->assertNotNull($property->getType(), index::class . '::$' . $property->getName());
			}
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== index::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), index::class . '::' . $method->getName() . '($' . $parameter->getName() . ')');
			}

			if (!$method->isConstructor())
			{
				$this->assertNotNull($method->getReturnType(), index::class . '::' . $method->getName() . '()');
			}
		}
	}

	public function test_route_actions_return_responses_and_use_integer_pages(): void
	{
		$reflection = new \ReflectionClass(index::class);

		$this->assertSame('Symfony\\Component\\HttpFoundation\\Response', (string) $reflection->getMethod('base')->getReturnType());
		$this->assertSame('Symfony\\Component\\HttpFoundation\\Response', (string) $reflection->getMethod('personal')->getReturnType());
		$this->assertSame('int', (string) $reflection->getMethod('personal')->getParameters()[0]->getType());
	}

	public function test_empty_latest_image_results_have_a_stable_identifier(): void
	{
		$reflection = new \ReflectionClass(index::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$normalizer = $reflection->getMethod('normalize_last_image');

		$this->assertSame(['image_id' => 0], $normalizer->invoke($controller, false));
		$this->assertSame(['image_id' => 0], $normalizer->invoke($controller, []));
		$this->assertSame(['image_id' => 17, 'image_name' => 'Example'], $normalizer->invoke($controller, ['image_id' => 17, 'image_name' => 'Example']));
	}

	public function test_rrc_mode_flags_remain_stable(): void
	{
		$this->assertSame(4, index::RRC_MODE_RECENT_COMMENTS);
		$this->assertSame(2, index::RRC_MODE_RANDOM_IMAGES);
		$this->assertSame(1, index::RRC_MODE_RECENT_IMAGES);
	}
}
