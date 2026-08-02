<?php

namespace david63\autodbbackup\tests;

use david63\autodbbackup\core\backup_policy;
use PHPUnit\Framework\TestCase;

class backup_policy_test extends TestCase
{
	public function test_rejects_zero_interval(): void
	{
		$this->expectException(\InvalidArgumentException::class);
		$this->expectExceptionMessage('AUTO_DB_BACKUP_FREQ_ERROR');
		backup_policy::validate_settings(0, 5, 1, 0, 'text', array('text'));
	}

	public function test_rejects_unavailable_compression(): void
	{
		$this->expectException(\InvalidArgumentException::class);
		$this->expectExceptionMessage('AUTO_DB_BACKUP_FILETYPE_ERROR');
		backup_policy::validate_settings(24, 5, 1, 0, 'gzip', array('text'));
	}

	public function test_catches_up_without_a_loop(): void
	{
		$this->assertSame(11800, backup_policy::calculate_next_run(10000, 1000, 1, true));
		$this->assertSame(13600, backup_policy::calculate_next_run(10000, 0, 1, false));
	}

	public function test_filters_non_phpbb_tables(): void
	{
		$this->assertSame(array('phpbb_users', 'PHPBB_posts'), backup_policy::filter_tables(array('phpbb_users', 'other_data', 'PHPBB_posts'), 'phpbb_'));
	}

	public function test_datetime_round_trip_uses_user_timezone(): void
	{
		$timezone = new \DateTimeZone('Europe/Lisbon');
		$timestamp = backup_policy::parse_local_time('2026-08-01T12:30', $timezone);

		$this->assertIsInt($timestamp);
		$this->assertSame('2026-08-01T12:30', backup_policy::format_local_time($timestamp, $timezone));
	}

	public function test_rejects_dst_gap(): void
	{
		$this->assertFalse(backup_policy::parse_local_time('2026-03-29T01:30', new \DateTimeZone('Europe/Lisbon')));
	}

	public function test_accepts_only_phpbb_restore_filenames(): void
	{
		$this->assertTrue(backup_policy::is_backup_filename('backup_1785580000_0123456789abcdef.sql.gz'));
		$this->assertFalse(backup_policy::is_backup_filename('../backup_1785580000_0123456789abcdef.sql'));
		$this->assertFalse(backup_policy::is_backup_filename('customer.sql'));
	}
}
