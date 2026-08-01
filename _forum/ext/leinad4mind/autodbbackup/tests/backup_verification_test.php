<?php

namespace leinad4mind\autodbbackup\tests;

use leinad4mind\autodbbackup\cron\task\auto_db_backup;
use PHPUnit\Framework\TestCase;

class backup_verification_test extends TestCase
{
	/** @var string */
	private $file;

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed
	protected function tearDown(): void
	{
		if ($this->file && is_file($this->file))
		{
			unlink($this->file);
		}
	}

	public function test_accepts_complete_text_backup(): void
	{
		$this->file = tempnam(sys_get_temp_dir(), 'autodbbackup_verify_');
		file_put_contents($this->file, "CREATE TABLE test;\n-- AUTO_DB_BACKUP_COMPLETE:token\n");

		$this->get_task()->verify_file($this->file, 'text', 'AUTO_DB_BACKUP_COMPLETE:token');
		$this->addToAssertionCount(1);
	}

	public function test_rejects_backup_without_completion_marker(): void
	{
		$this->file = tempnam(sys_get_temp_dir(), 'autodbbackup_verify_');
		file_put_contents($this->file, 'partial SQL');
		$this->expectException(\RuntimeException::class);
		$this->expectExceptionMessage('AUTO_DB_BACKUP_VERIFY_FAILED');

		$this->get_task()->verify_file($this->file, 'text', 'AUTO_DB_BACKUP_COMPLETE:token');
	}

	public function test_reads_gzip_backup_to_completion(): void
	{
		if (!extension_loaded('zlib'))
		{
			$this->markTestSkipped('zlib is unavailable');
		}

		$this->file = tempnam(sys_get_temp_dir(), 'autodbbackup_verify_');
		$handle = gzopen($this->file, 'wb');
		gzwrite($handle, "SQL\n-- AUTO_DB_BACKUP_COMPLETE:token\n");
		gzclose($handle);

		$this->get_task()->verify_file($this->file, 'gzip', 'AUTO_DB_BACKUP_COMPLETE:token');
		$this->addToAssertionCount(1);
	}

	private function get_task()
	{
		return new class extends auto_db_backup
		{
			public function __construct()
			{
			}

			public function verify_file($path, $file_type, $marker)
			{
				$this->verify_backup($path, $file_type, $marker);
			}
		};
	}
}
