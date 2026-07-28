<?php
/**
 * BBopenGraph configuration validation tests
 *
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace sitesplat\opengraph\tests;

use PHPUnit\Framework\TestCase;
use sitesplat\opengraph\event\listener;

require_once dirname(__DIR__) . '/event/listener.php';

final class file_exists_validation_test extends TestCase
{
	public function test_unrelated_configuration_does_not_require_opengraph_path(): void
	{
		$event = new \phpbb\event\data([
			'cfg_array' => ['watermark_position' => '12'],
			'config_definition' => ['validate' => ''],
			'error' => [],
		]);

		$this->listener()->file_excist($event);

		$this->assertSame([], $event['error']);
	}

	public function test_empty_opengraph_path_is_valid(): void
	{
		$event = new \phpbb\event\data([
			'cfg_array' => [],
			'config_definition' => ['validate' => 'file_excist'],
			'error' => [],
		]);

		$this->listener()->file_excist($event);

		$this->assertSame([], $event['error']);
	}

	public function test_bbtags_manager_is_resolved_from_its_container_service(): void
	{
		$bbtags_manager = new \stdClass();
		$container = $this->container($bbtags_manager);
		$listener = $this->listener();
		$this->set_property($listener, 'container', $container);
		$this->set_property($listener, 'config', ['bbtags_catalog_version' => 1]);
		$this->set_property($listener, 'manager', false);

		$this->invoke_initialise_bbtags_manager($listener);

		$this->assertSame($bbtags_manager, $this->property($listener, 'manager'));
	}

	public function test_missing_bbtags_service_is_ignored_safely(): void
	{
		$container = $this->container();
		$listener = $this->listener();
		$this->set_property($listener, 'container', $container);
		$this->set_property($listener, 'config', ['bbtags_catalog_version' => 1]);
		$this->set_property($listener, 'manager', false);

		$this->invoke_initialise_bbtags_manager($listener);

		$this->assertFalse($this->property($listener, 'manager'));
	}

	public function test_pending_bbtags_migrations_do_not_load_the_manager(): void
	{
		$listener = $this->listener();
		$this->set_property($listener, 'config', []);
		$this->set_property($listener, 'manager', false);

		$this->invoke_initialise_bbtags_manager($listener);

		$this->assertFalse($this->property($listener, 'manager'));
	}

	/**
	 * @param object|null $bbtags_manager
	 * @return object
	 */
	private function container($bbtags_manager = null): object
	{
		$services = [
			'ext.manager' => new class {
				public function is_enabled(string $extension): bool
				{
					return $extension === 'sitesplat/bbtags';
				}
			},
		];
		if ($bbtags_manager !== null)
		{
			$services['sitesplat.bbtags.manager'] = $bbtags_manager;
		}

		return new class($services) {
			/** @var array<string, object> */
			private $services;

			/**
			 * @param array<string, object> $services
			 */
			public function __construct(array $services)
			{
				$this->services = $services;
			}

			public function get(string $id): object
			{
				return $this->services[$id];
			}

			public function has(string $id): bool
			{
				return isset($this->services[$id]);
			}
		};
	}

	private function listener(): listener
	{
		$reflection = new \ReflectionClass(listener::class);

		return $reflection->newInstanceWithoutConstructor();
	}

	private function invoke_initialise_bbtags_manager(listener $listener): void
	{
		$method = new \ReflectionMethod($listener, 'initialise_bbtags_manager');
		$method->invoke($listener);
	}

	/**
	 * @return mixed
	 */
	private function property(listener $listener, string $name)
	{
		$property = new \ReflectionProperty($listener, $name);

		return $property->getValue($listener);
	}

	/**
	 * @param mixed $value
	 */
	private function set_property(listener $listener, string $name, $value): void
	{
		$property = new \ReflectionProperty($listener, $name);
		$property->setValue($listener, $value);
	}
}
