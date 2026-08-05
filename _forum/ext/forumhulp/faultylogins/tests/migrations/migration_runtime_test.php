<?php

namespace forumhulp\faultylogins\tests\migrations;

use PHPUnit\Framework\TestCase;

class migration_runtime_test extends TestCase
{
	public function test_schema_and_data_are_buildable()
	{
		$project_root = dirname(__DIR__, 6);
		require_once $project_root . '/_forum/phpbb/db/migration/migration_interface.php';
		require_once $project_root . '/_forum/phpbb/db/migration/migration.php';
		require_once dirname(__DIR__, 2) . '/migrations/install_faultylogins_3_2_0.php';

		$reflection = new \ReflectionClass('forumhulp\\faultylogins\\migrations\\install_faultylogins_3_2_0');
		$migration = $reflection->newInstanceWithoutConstructor();
		$prefix = $reflection->getParentClass()->getProperty('table_prefix');
		$prefix->setAccessible(true);
		$prefix->setValue($migration, 'phpbb_');

		$schema = $migration->update_schema();
		$table = $schema['add_tables']['phpbb_faultylogins_attempts'];
		self::assertSame('attempt_id', $table['PRIMARY_KEY']);
		self::assertSame(['INDEX', ['ip_address', 'attempt_time']], $table['KEYS']['ip_time']);
		self::assertSame(['MTEXT_UNI', ''], $table['COLUMNS']['password_cipher']);

		$data = $migration->update_data();
		self::assertNotEmpty($data);
		self::assertStringNotContainsString('faultylogins_version', serialize($data));
	}
}
