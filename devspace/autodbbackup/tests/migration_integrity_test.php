<?php

namespace devspace\autodbbackup\tests;

use PHPUnit\Framework\TestCase;

class migration_integrity_test extends TestCase
{
	public function test_security_upgrade_preserves_released_chain(): void
	{
		$extension = dirname(__DIR__);
		$released = file_get_contents($extension . '/migrations/v_3_3_0/install_config.php');
		$upgrade = file_get_contents($extension . '/migrations/v_3_3_1/security_upgrade.php');

		$this->assertStringContainsString('v_3_3_0\\\\install_config', $upgrade);
		$this->assertStringContainsString("config_text.add', array('auto_db_backup_manifest'", $upgrade);
		$this->assertStringContainsString("config.remove', array('auto_db_backup_optimize'", $upgrade);
		$this->assertStringNotContainsString('config.update', $released . $upgrade);
		$this->assertStringNotContainsString('auto_db_backup_version', $released . $upgrade);
	}
}
