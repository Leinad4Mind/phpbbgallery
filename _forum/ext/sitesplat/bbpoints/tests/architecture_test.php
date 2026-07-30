<?php
/**
 * BBPoints public service contract tests.
 *
 * @package sitesplat/bbpoints
 * @copyright (c) 2015-2026 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace sitesplat\bbpoints\tests;

use PHPUnit\Framework\TestCase;
use sitesplat\bbpoints\core\ledger;
use sitesplat\bbpoints\core\operation;

final class architecture_test extends TestCase
{
	public function test_ledger_api_is_fully_typed(): void
	{
		foreach ([ledger::class, operation::class] as $class_name)
		{
			$reflection = new \ReflectionClass($class_name);
			foreach ($reflection->getProperties() as $property)
			{
				$this->assertNotNull($property->getType(), $class_name . '::$' . $property->getName());
			}
			foreach ($reflection->getMethods() as $method)
			{
				if ($method->getDeclaringClass()->getName() !== $class_name)
				{
					continue;
				}
				foreach ($method->getParameters() as $parameter)
				{
					$this->assertNotNull($parameter->getType(), $class_name . '::' . $method->getName());
				}
				if (!$method->isConstructor())
				{
					$this->assertNotNull($method->getReturnType(), $class_name . '::' . $method->getName());
				}
			}
		}
	}

	public function test_public_service_uses_phpbb_table_parameters(): void
	{
		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services.yml');

		$this->assertStringContainsString('sitesplat.bbpoints.ledger:', $services);
		$this->assertStringContainsString('class: sitesplat\bbpoints\core\ledger', $services);
		$this->assertStringContainsString("- '%sitesplat.bbpoints.table%'", $services);
		$this->assertStringContainsString("- '%sitesplat.bbpoints.operations_table%'", $services);
		$this->assertSame(2, substr_count($services, "- '%sitesplat.bbpoints.operations_table%'"));
		$this->assertStringContainsString("- '%tables.users%'", $services);
		$this->assertStringContainsString("- '%tables.posts%'", $services);
		$this->assertStringContainsString("- '%tables.topics%'", $services);
		$this->assertStringContainsString(
			"TRUNCATE ' . \$this->bbpoints_operations_table",
			(string) file_get_contents(dirname(__DIR__) . '/controller/admin_controller.php')
		);
	}

	public function test_declared_runtime_matches_the_typed_api(): void
	{
		$composer = json_decode((string) file_get_contents(dirname(__DIR__) . '/composer.json'), true, 512, JSON_THROW_ON_ERROR);

		$this->assertSame('1.3.0', $composer['version']);
		$this->assertSame('>=8.1', $composer['require']['php']);
		$this->assertSame('>=3.3.0,<4.0.0@dev', $composer['extra']['soft-require']['phpbb/phpbb']);
	}
}
