<?php

namespace forumhulp\faultylogins\tests\migrations;

use PHPUnit\Framework\TestCase;

class migration_test extends TestCase
{
	public function test_schema_uses_portable_composite_index_and_no_version_config()
	{
		$contents = file_get_contents(dirname(__DIR__, 2) . '/migrations/install_faultylogins_3_2_0.php');
		self::assertStringContainsString("['INDEX', ['ip_address', 'attempt_time']]", $contents);
		self::assertStringNotContainsString('config.update', $contents);
		self::assertStringNotContainsString('faultylogins_version', $contents);
	}
}
