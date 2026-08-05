<?php

namespace forumhulp\searchresults\tests;

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

	public function test_runtime_classes_do_not_rely_on_dynamic_properties(): void
	{
		$module = new \ReflectionClass(\forumhulp\searchresults\acp\searchresults_module::class);
		$listener = new \ReflectionClass(\forumhulp\searchresults\event\listener::class);

		foreach (['u_action', 'page_title', 'tpl_name', 'searchresults_table'] as $property)
		{
			$this->assertTrue($module->hasProperty($property), $property);
		}
		$this->assertFalse($listener->hasProperty('split_words'));
	}

	public function test_lifecycle_does_not_enable_the_helper_implicitly(): void
	{
		$extension = (string) file_get_contents(dirname(__DIR__) . '/ext.php');

		$this->assertStringNotContainsString("->enable('forumhulp/helper')", $extension);
		$this->assertStringContainsString("is_enabled('forumhulp/helper')", $extension);
	}
}
