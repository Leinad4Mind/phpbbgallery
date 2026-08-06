<?php

namespace forumhulp\uploadimage\tests;

use PHPUnit\Framework\TestCase;

class compatibility_test extends TestCase
{
	public function test_composer_targets_supported_php_and_phpbb_versions(): void
	{
		$composer = json_decode((string) file_get_contents(dirname(__DIR__) . '/composer.json'), true, 512, JSON_THROW_ON_ERROR);

		$this->assertSame('3.3.0', $composer['version']);
		$this->assertSame('>=8.1', $composer['require']['php']);
		$this->assertSame('>=3.3.12,<4.0.0@dev', $composer['require']['phpbb/phpbb']);
	}

	public function test_runtime_classes_declare_module_state(): void
	{
		$module = new \ReflectionClass(\forumhulp\uploadimage\acp\uploadimage_module::class);

		foreach (['u_action', 'page_title', 'tpl_name'] as $property)
		{
			$this->assertTrue($module->hasProperty($property), $property);
		}
	}

	public function test_lifecycle_does_not_enable_the_helper_implicitly(): void
	{
		$extension = (string) file_get_contents(dirname(__DIR__) . '/ext.php');

		$this->assertStringNotContainsString("->enable('forumhulp/helper')", $extension);
		$this->assertStringContainsString("is_enabled('forumhulp/helper')", $extension);
	}

	public function test_service_uses_phpbb_file_abstractions(): void
	{
		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services.yml');

		$this->assertStringContainsString("'@files.factory'", $services);
		$this->assertStringContainsString("'@filesystem'", $services);
		$this->assertStringNotContainsString("'@service_container'", $services);
	}
}
