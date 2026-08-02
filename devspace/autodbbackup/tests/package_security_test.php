<?php

namespace devspace\autodbbackup\tests;

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
		$this->assertFileDoesNotExist($extension . '/adm/style/js/donate-collapse.js');
		$this->assertFileDoesNotExist($extension . '/adm/style/images/qrcode.png');
		$this->assertStringNotContainsString('paypal', strtolower($this->read_package_text($extension)));
	}

	public function test_cron_has_no_broad_store_scan_or_unbounded_schedule_loop(): void
	{
		$source = file_get_contents(dirname(__DIR__) . '/cron/task/auto_db_backup.php');

		$this->assertStringNotContainsString('fileatime', $source);
		$this->assertStringNotContainsString('opendir', $source);
		$this->assertStringNotContainsString('while ($next_', $source);
		$this->assertStringContainsString('backup_policy::filter_tables', $source);
		$this->assertStringContainsString('verify_backup', $source);
		$this->assertStringContainsString("trigger_event('devspace.autodbbackup.backup_file_export'", $source);
		$this->assertStringContainsString("'sha256'", $source);
		$this->assertStringNotContainsString('extract(', $source);
	}

	public function test_metadata_and_services_use_hardened_configuration(): void
	{
		$extension = dirname(__DIR__);
		$metadata = json_decode(file_get_contents($extension . '/composer.json'), true, 512, JSON_THROW_ON_ERROR);
		$services = file_get_contents($extension . '/config/services.yml');
		$parsed_services = \Symfony\Component\Yaml\Yaml::parse($services);

		$this->assertTrue($metadata['extra']['version-check']['ssl']);
		$this->assertSame('devspace/autodbbackup', $metadata['name']);
		$this->assertSame('3.3.1', $metadata['version']);
		$this->assertSame('Leinad4Mind', $metadata['authors'][0]['name']);
		$this->assertSame('Developer', $metadata['authors'][0]['role']);
		$this->assertSame('devspace', $metadata['authors'][1]['name']);
		$this->assertSame('Maintainer', $metadata['authors'][1]['role']);
		$this->assertStringNotContainsString('alias.yml', $services);
		$this->assertStringNotContainsString('autowire:', $services);
		$this->assertCount(4, $parsed_services['services']);
		$this->assertArrayHasKey('devspace.autodbbackup.admin.controller', $parsed_services['services']);
		$this->assertFileDoesNotExist($extension . '/config/alias.yml');
		$this->assertFileExists($extension . '/migrations/v_3_3_1/security_upgrade.php');
		$migration = file_get_contents($extension . '/migrations/v_3_3_1/security_upgrade.php');
		$this->assertStringContainsString('devspace\\\\autodbbackup\\\\migrations\\\\v_3_3_0\\\\install_config', $migration);
		$this->assertStringNotContainsString('config.update', $migration);
	}

	private function read_package_text(string $extension): string
	{
		$text = '';
		$iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($extension, \FilesystemIterator::SKIP_DOTS));
		foreach ($iterator as $file)
		{
			if (strpos($file->getPathname(), DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR) !== false)
			{
				continue;
			}

			if ($file->isFile() && in_array($file->getExtension(), array('php', 'html', 'js', 'css', 'json', 'yml'), true))
			{
				$text .= file_get_contents($file->getPathname());
			}
		}

		return $text;
	}
}
