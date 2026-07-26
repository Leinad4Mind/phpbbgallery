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

	private function listener(): listener
	{
		$reflection = new \ReflectionClass(listener::class);

		return $reflection->newInstanceWithoutConstructor();
	}
}
