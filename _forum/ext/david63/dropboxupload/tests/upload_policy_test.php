<?php

namespace david63\dropboxupload\tests;

use david63\dropboxupload\core\upload_policy;
use PHPUnit\Framework\TestCase;

class upload_policy_test extends TestCase
{
	public function test_normalizes_safe_nested_folder()
	{
		$this->assertSame('Backups/Daily', upload_policy::normalize_folder('/Backups/Daily/'));
	}

	public function test_rejects_traversal_folder()
	{
		$this->expectException(\InvalidArgumentException::class);
		$this->expectExceptionMessage('DROPBOX_FOLDER_INVALID');
		upload_policy::normalize_folder('Backups/../Private');
	}

	public function test_rejects_invalid_options_and_frequency()
	{
		$this->expectException(\InvalidArgumentException::class);
		$this->expectExceptionMessage('DROPBOX_FREQUENCY_INVALID');
		upload_policy::validate_options('DEFAULT', 0);
	}

	public function test_requires_complete_refresh_credentials()
	{
		$this->expectException(\InvalidArgumentException::class);
		$this->expectExceptionMessage('DROPBOX_REFRESH_CREDENTIALS_INCOMPLETE');
		upload_policy::validate_credentials(array('dropbox_app_key' => 'key'), true);
	}

	public function test_builds_deterministic_remote_path()
	{
		$path = upload_policy::build_remote_path('Forum', 'CURRENT_DAY', 'backup_1_abc.sql.gz', 0, 'UTC');
		$this->assertSame('/Forum/1970-01-01/backup_1_abc.sql.gz', $path);
	}

	public function test_preserves_zero_folder_name()
	{
		$path = upload_policy::build_remote_path('0', 'DEFAULT', 'backup_1_abc.sql', 0, 'UTC');
		$this->assertSame('/0/backup_1_abc.sql', $path);
	}

	public function test_resolves_only_backup_inside_store()
	{
		$root = sys_get_temp_dir() . '/dropbox_policy_' . bin2hex(random_bytes(6));
		$store = $root . '/store';
		mkdir($store, 0777, true);
		$file = $store . '/backup_1_abc.sql';
		file_put_contents($file, 'backup');
		try
		{
			$this->assertSame(realpath($file), upload_policy::resolve_backup_path($root, $store, 'backup_1_abc', '.sql'));
		}
		finally
		{
			unlink($file);
			rmdir($store);
			rmdir($root);
		}
	}

	public function test_rejects_event_location_outside_store()
	{
		$this->expectException(\RuntimeException::class);
		$this->expectExceptionMessage('DROPBOX_BACKUP_PATH_INVALID');
		upload_policy::resolve_backup_path(sys_get_temp_dir(), __DIR__, 'backup_1_abc', '.sql');
	}
}
