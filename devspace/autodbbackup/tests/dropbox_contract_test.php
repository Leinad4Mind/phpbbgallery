<?php

namespace devspace\autodbbackup\tests;

use PHPUnit\Framework\TestCase;

class dropbox_contract_test extends TestCase
{
	public function test_devspace_dropbox_event_contract_is_preserved(): void
	{
		$cron = file_get_contents(dirname(__DIR__) . '/cron/task/auto_db_backup.php');

		$this->assertStringContainsString("trigger_event('devspace.autodbbackup.backup_file_export'", $cron);
		foreach (array('filename', 'extension', 'location', 'file_type') as $field)
		{
			$this->assertStringContainsString("'" . $field . "'", $cron);
		}

		$root = __DIR__;
		while (dirname($root) !== $root && !is_dir($root . '/.git'))
		{
			$root = dirname($root);
		}

		$listener_path = $root . '/devspace/dropboxupload/event/listener.php';
		if (is_file($listener_path))
		{
			$this->assertStringContainsString("'devspace.autodbbackup.backup_file_export'", file_get_contents($listener_path));
		}
	}
}
