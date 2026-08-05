<?php

namespace forumhulp\notification_manager\tests;

require_once dirname(__DIR__, 4) . '/phpbb/extension/extension_interface.php';
require_once dirname(__DIR__, 4) . '/phpbb/extension/base.php';
require_once dirname(__DIR__) . '/ext.php';
require_once dirname(__DIR__) . '/ucp/noties_info.php';

use PHPUnit\Framework\TestCase;

class runtime_compatibility_test extends TestCase
{
	public function test_extension_and_ucp_metadata_classes_load(): void
	{
		$this->assertTrue(class_exists(\forumhulp\notification_manager\ext::class));
		$this->assertTrue(class_exists(\forumhulp\notification_manager\ucp\noties_info::class));
		$this->assertSame('bool', (string) (new \ReflectionMethod(
			\forumhulp\notification_manager\ext::class,
			'is_enableable'
		))->getReturnType());
	}
}
