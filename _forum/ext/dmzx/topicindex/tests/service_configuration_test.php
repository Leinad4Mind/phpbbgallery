<?php

namespace dmzx\topicindex\tests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Symfony\Component\Yaml\Yaml;

class service_configuration_test extends TestCase
{
	public function test_service_argument_counts_match_constructors()
	{
		$topicindex_root = dirname(__DIR__);
		$bridge_root = dirname($topicindex_root, 2) . '/kasimi/topicindexbridge';
		$configurations = array_merge(
			Yaml::parseFile($topicindex_root . '/config/services.yml')['services'],
			Yaml::parseFile($bridge_root . '/config/services.yml')['services']
		);
		$services = [
			'dmzx.topicindex.listener' => \dmzx\topicindex\event\listener::class,
			'dmzx.topicindex.admin.controller' => \dmzx\topicindex\controller\admin_controller::class,
			'dmzx.topicindex.controller' => \dmzx\topicindex\controller\main::class,
			'dmzx.topicindex.core.functions' => \dmzx\topicindex\core\functions_topicindex::class,
			'kasimi.topicindexbridge.manager' => \kasimi\topicindexbridge\core\bridge_manager::class,
			'kasimi.topicindexbridge.listener' => \kasimi\topicindexbridge\event\main_listener::class,
		];

		foreach ($services as $service_id => $class_name)
		{
			$constructor = (new ReflectionClass($class_name))->getConstructor();
			$this->assertCount($constructor->getNumberOfParameters(), $configurations[$service_id]['arguments'], $service_id);
		}

		$bridge_arguments = $configurations['kasimi.topicindexbridge.manager']['arguments'];
		$this->assertContains('@service_container', $bridge_arguments);
		$this->assertNotContains('@?bbprefix.manager', $bridge_arguments);
	}
}
