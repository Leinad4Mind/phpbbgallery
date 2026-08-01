<?php

namespace leinad4mind\autodbbackup\tests;

use PHPUnit\Framework\TestCase;

class package_security_test extends TestCase
{
	public function test_legacy_vulnerable_ui_is_not_packaged(): void
	{
		$extension = dirname(__DIR__);

		$this->assertFileDoesNotExist($extension . '/adm/style/js/jquery-ui.js');
		$this->assertFileDoesNotExist($extension . '/adm/style/js/jquery-timepicker.js');
		$this->assertFileDoesNotExist($extension . '/adm/style/js/jquery-slideraccess.js');
		$this->assertStringNotContainsString('jquery-ui', file_get_contents($extension . '/adm/style/auto_db_backup.html'));
	}

	public function test_cron_has_no_broad_store_scan_or_unbounded_schedule_loop(): void
	{
		$source = file_get_contents(dirname(__DIR__) . '/cron/task/auto_db_backup.php');

		$this->assertStringNotContainsString('fileatime', $source);
		$this->assertStringNotContainsString('opendir', $source);
		$this->assertStringNotContainsString('while ($next_', $source);
		$this->assertStringContainsString('backup_policy::filter_tables', $source);
		$this->assertStringContainsString('verify_backup', $source);
	}

	public function test_metadata_and_services_use_hardened_configuration(): void
	{
		$extension = dirname(__DIR__);
		$metadata = json_decode(file_get_contents($extension . '/composer.json'), true, 512, JSON_THROW_ON_ERROR);
		$services = file_get_contents($extension . '/config/services.yml');
		$parsed_services = \Symfony\Component\Yaml\Yaml::parse($services);

		$this->assertTrue($metadata['extra']['version-check']['ssl']);
		$this->assertSame('leinad4mind/autodbbackup', $metadata['name']);
		$this->assertSame('3.3.0', $metadata['version']);
		$this->assertContains('Leinad4Mind', array_column($metadata['authors'], 'name'));
		$this->assertStringNotContainsString('alias.yml', $services);
		$this->assertStringNotContainsString('autowire:', $services);
		$this->assertCount(4, $parsed_services['services']);
		$this->assertArrayHasKey('leinad4mind.autodbbackup.admin.controller', $parsed_services['services']);
		$this->assertFileDoesNotExist($extension . '/config/alias.yml');
		$this->assertFileExists($extension . '/migrations/version_3_2_0.php');
	}
}
