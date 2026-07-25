<?php
/**
 * phpBB Gallery - Core report domain tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\report;
use PHPUnit\Framework\TestCase;

final class domain_report_types_test extends TestCase
{
	public function test_report_properties_parameters_and_returns_are_fully_typed(): void
	{
		$reflection = new \ReflectionClass(report::class);

		foreach ($reflection->getProperties() as $property)
		{
			if ($property->getDeclaringClass()->getName() === report::class)
			{
				$this->assertNotNull($property->getType(), report::class . '::$' . $property->getName());
			}
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== report::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), report::class . '::' . $method->getName() . '($' . $parameter->getName() . ')');
			}

			if (!$method->isConstructor())
			{
				$this->assertNotNull($method->getReturnType(), report::class . '::' . $method->getName() . '()');
			}
		}
	}

	public function test_report_identifier_normalization_is_stable(): void
	{
		$this->assertSame([8], report::cast_mixed_int2array(8));
		$this->assertSame([4, 9, 0], report::cast_mixed_int2array(['4', 9, 'invalid']));
	}

	public function test_empty_image_identifier_returns_an_empty_report_collection(): void
	{
		$reflection = new \ReflectionClass(report::class);
		$report = $reflection->newInstanceWithoutConstructor();

		$this->assertSame([], $report->get_data_by_image(0));
	}

	public function test_incomplete_report_is_rejected_before_accessing_dependencies(): void
	{
		$reflection = new \ReflectionClass(report::class);
		$report = $reflection->newInstanceWithoutConstructor();

		$report->add(['report_album_id' => 3, 'report_image_id' => 9]);
		$this->addToAssertionCount(1);
	}
}
