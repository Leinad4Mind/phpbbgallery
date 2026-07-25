<?php
/**
 * phpBB Gallery - Cron cleaner tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\config;
use phpbbgallery\core\cron\cron_cleaner;
use phpbbgallery\core\upload;
use PHPUnit\Framework\TestCase;

final class cron_cleaner_types_test extends TestCase
{
	public function test_properties_parameters_and_returns_are_fully_typed(): void
	{
		$reflection = new \ReflectionClass(cron_cleaner::class);

		foreach ($reflection->getProperties() as $property)
		{
			if ($property->getDeclaringClass()->getName() === cron_cleaner::class)
			{
				$this->assertNotNull($property->getType(), cron_cleaner::class . '::$' . $property->getName());
			}
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== cron_cleaner::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), cron_cleaner::class . '::' . $method->getName() . '($' . $parameter->getName() . ')');
			}

			if (!$method->isConstructor())
			{
				$this->assertNotNull($method->getReturnType(), cron_cleaner::class . '::' . $method->getName() . '()');
			}
		}
	}

	public function test_run_prunes_orphans_and_records_completion_time(): void
	{
		$config = $this->createMock(config::class);
		$upload = $this->createMock(upload::class);
		$upload->expects($this->once())
			->method('prune_orphan');
		$config->expects($this->once())
			->method('set')
			->with(
				'prune_orphan_time',
				$this->callback(static fn (mixed $timestamp): bool => is_int($timestamp) && abs(time() - $timestamp) <= 1)
			);

		(new cron_cleaner($config, $upload))->run();
	}

	public function test_should_run_only_after_the_daily_interval(): void
	{
		$config = $this->createMock(config::class);
		$upload = $this->createMock(upload::class);
		$config->expects($this->exactly(2))
			->method('get')
			->with('prune_orphan_time')
			->willReturnOnConsecutiveCalls(time() - 86401, time());
		$cleaner = new cron_cleaner($config, $upload);

		$this->assertTrue($cleaner->should_run());
		$this->assertFalse($cleaner->should_run());
		$this->assertTrue($cleaner->is_runnable());
	}
}
