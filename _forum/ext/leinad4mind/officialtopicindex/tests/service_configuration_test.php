<?php

namespace leinad4mind\officialtopicindex\tests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Symfony\Component\Yaml\Yaml;

class service_configuration_test extends TestCase
{
	public function test_service_argument_counts_match_constructors()
	{
		$officialtopicindex_root = dirname(__DIR__);
		$bridge_root = dirname($officialtopicindex_root, 2) . '/kasimi/topicindexbridge';
		$configurations = array_merge(
			Yaml::parseFile($officialtopicindex_root . '/config/services.yml')['services'],
			Yaml::parseFile($bridge_root . '/config/services.yml')['services']
		);
		$services = [
			'leinad4mind.officialtopicindex.listener' => \leinad4mind\officialtopicindex\event\listener::class,
			'leinad4mind.officialtopicindex.admin.controller' => \leinad4mind\officialtopicindex\controller\admin_controller::class,
			'leinad4mind.officialtopicindex.controller' => \leinad4mind\officialtopicindex\controller\main::class,
			'leinad4mind.officialtopicindex.core.functions' => \leinad4mind\officialtopicindex\core\functions_officialtopicindex::class,
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
