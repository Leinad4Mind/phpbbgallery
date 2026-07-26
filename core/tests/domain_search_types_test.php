<?php
/**
 * phpBB Gallery - Core search domain tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\search;
use PHPUnit\Framework\TestCase;

final class domain_search_types_test extends TestCase
{
	public function test_search_properties_parameters_and_returns_are_fully_typed(): void
	{
		$reflection = new \ReflectionClass(search::class);

		foreach ($reflection->getProperties() as $property)
		{
			if ($property->getDeclaringClass()->getName() === search::class)
			{
				$this->assertNotNull($property->getType(), search::class . '::$' . $property->getName());
			}
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== search::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), search::class . '::' . $method->getName() . '($' . $parameter->getName() . ')');
			}

			if (!$method->isConstructor())
			{
				$this->assertNotNull($method->getReturnType(), search::class . '::' . $method->getName() . '()');
			}
		}
	}

	public function test_zero_limit_searches_stop_before_accessing_dependencies(): void
	{
		$reflection = new \ReflectionClass(search::class);
		$search = $reflection->newInstanceWithoutConstructor();

		$this->assertNull($search->random(0));
		$this->assertNull($search->recent(0));
	}

	public function test_count_and_rendering_contracts_are_explicit(): void
	{
		$this->assertSame('int', (string) (new \ReflectionMethod(search::class, 'recent_count'))->getReturnType());

		foreach (['random', 'recent_comments', 'recent', 'rating'] as $method_name)
		{
			$this->assertSame('void', (string) (new \ReflectionMethod(search::class, $method_name))->getReturnType());
		}
	}

	public function test_image_result_filter_normalizes_ids_and_excludes_orphans(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->once())
			->method('sql_in_set')
			->with('i.image_id', [3, 7])
			->willReturn('i.image_id IN (3, 7)');
		$reflection = new \ReflectionClass(search::class);
		$search = $reflection->newInstanceWithoutConstructor();
		$reflection->getProperty('db')->setValue($search, $db);

		$this->assertSame(
			'i.image_status <> ' . \phpbbgallery\core\block::STATUS_ORPHAN . ' AND i.image_id IN (3, 7)',
			$reflection->getMethod('get_image_result_where')->invoke($search, ['3', 7])
		);
	}
}
