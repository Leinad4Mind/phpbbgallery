<?php
/**
 * BBTags runtime migration readiness tests.
 *
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace sitesplat\bbtags\tests;

use PHPUnit\Framework\TestCase;
use sitesplat\bbtags\event\listener;

class listener_catalog_readiness_test extends TestCase
{
	public function test_catalog_requires_the_completed_migration_marker(): void
	{
		$listener = $this->listener([]);

		$this->assertFalse($this->catalog_is_ready($listener));

		$listener = $this->listener(['bbtags_catalog_version' => 1]);

		$this->assertTrue($this->catalog_is_ready($listener));
	}

	public function test_runtime_queries_are_skipped_while_migrations_are_pending(): void
	{
		$listener = $this->listener([]);

		$this->assertNull($listener->load_tags());
		$this->assertNull($listener->modify_template_vars(null));
		$this->assertNull($listener->save_tags(null));
		$this->assertNull($listener->delete_tags(null));
	}

	private function listener(array $config): listener
	{
		$reflection = new \ReflectionClass(listener::class);
		$listener = $reflection->newInstanceWithoutConstructor();
		$property = new \ReflectionProperty($listener, 'config');
		$property->setValue($listener, $config);

		return $listener;
	}

	private function catalog_is_ready(listener $listener): bool
	{
		$method = new \ReflectionMethod($listener, 'catalog_is_ready');

		return $method->invoke($listener);
	}
}
