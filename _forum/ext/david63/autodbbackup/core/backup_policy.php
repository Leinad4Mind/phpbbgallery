<?php
/**
 *
 * @package Auto db Backup
 * @copyright (c) 2015 david63
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace david63\autodbbackup\core;

/**
 * Validation and scheduling rules for automatic backups.
 */
class backup_policy
{
	const MIN_INTERVAL_HOURS = 1;
	const MAX_INTERVAL_HOURS = 350;
	const MIN_COPIES = 0;
	const MAX_COPIES = 99;
	const LOCAL_TIME_FORMAT = '!Y-m-d\TH:i';
	const LOCAL_TIME_OUTPUT_FORMAT = 'Y-m-d\TH:i';

	/**
	 * Validate settings received from the ACP or loaded by the cron task.
	 *
	 * @param int   $interval_hours Backup interval in hours
	 * @param int   $copies Number of retained copies
	 * @param int   $enabled Whether backups are enabled
	 * @param int   $maintain Whether the configured wall-clock schedule is maintained
	 * @param string $file_type Backup file type
	 * @param array $available_file_types File types available on this server
	 *
	 * @throws \InvalidArgumentException When any setting is invalid
	 */
	public static function validate_settings($interval_hours, $copies, $enabled, $maintain, $file_type, array $available_file_types)
	{
		if ($interval_hours < self::MIN_INTERVAL_HOURS || $interval_hours > self::MAX_INTERVAL_HOURS)
		{
			throw new \InvalidArgumentException('AUTO_DB_BACKUP_FREQ_ERROR');
		}

		if ($copies < self::MIN_COPIES || $copies > self::MAX_COPIES)
		{
			throw new \InvalidArgumentException('AUTO_DB_BACKUP_COPIES_ERROR');
		}

		if (!in_array($enabled, array(0, 1), true) || !in_array($maintain, array(0, 1), true))
		{
			throw new \InvalidArgumentException('AUTO_DB_BACKUP_BOOLEAN_ERROR');
		}

		if (!in_array($file_type, $available_file_types, true))
		{
			throw new \InvalidArgumentException('AUTO_DB_BACKUP_FILETYPE_ERROR');
		}
	}

	/**
	 * Calculate the next normal run without using an unbounded catch-up loop.
	 *
	 * @param int  $now Current Unix timestamp
	 * @param int  $previous_next Previously scheduled Unix timestamp
	 * @param int  $interval_hours Backup interval in hours
	 * @param bool $maintain Whether the previous wall-clock schedule is maintained
	 *
	 * @return int Next Unix timestamp
	 */
	public static function calculate_next_run($now, $previous_next, $interval_hours, $maintain)
	{
		if ($interval_hours < self::MIN_INTERVAL_HOURS || $interval_hours > self::MAX_INTERVAL_HOURS)
		{
			throw new \InvalidArgumentException('AUTO_DB_BACKUP_FREQ_ERROR');
		}

		$interval = $interval_hours * 3600;

		if (!$maintain || $previous_next <= 0)
		{
			return $now + $interval;
		}

		if ($previous_next > $now)
		{
			return $previous_next;
		}

		$missed_intervals = intdiv($now - $previous_next, $interval) + 1;

		return $previous_next + ($missed_intervals * $interval);
	}

	/**
	 * Restrict a database table list to the configured phpBB prefix.
	 *
	 * @param array  $tables Database table names
	 * @param string $table_prefix phpBB table prefix
	 *
	 * @return array Filtered table names
	 */
	public static function filter_tables(array $tables, $table_prefix)
	{
		if ($table_prefix === '')
		{
			return array_values($tables);
		}

		return array_values(array_filter($tables, function ($table_name) use ($table_prefix)
		{
			return stripos($table_name, $table_prefix) === 0;
		}));
	}

	/**
	 * Parse an ACP datetime in the user's timezone.
	 *
	 * @param string        $value Submitted datetime-local value
	 * @param \DateTimeZone $timezone User timezone
	 *
	 * @return int|false Unix timestamp, or false on invalid input
	 */
	public static function parse_local_time($value, \DateTimeZone $timezone)
	{
		$date = \DateTimeImmutable::createFromFormat(self::LOCAL_TIME_FORMAT, $value, $timezone);
		$errors = \DateTimeImmutable::getLastErrors();

		if ($date === false || ($errors !== false && ($errors['warning_count'] || $errors['error_count'])))
		{
			return false;
		}

		if ($date->format(self::LOCAL_TIME_OUTPUT_FORMAT) !== $value)
		{
			return false;
		}

		return $date->getTimestamp();
	}

	/**
	 * Format a stored Unix timestamp in the user's timezone.
	 *
	 * @param int           $timestamp Unix timestamp
	 * @param \DateTimeZone $timezone User timezone
	 *
	 * @return string Value suitable for an HTML datetime-local control
	 */
	public static function format_local_time($timestamp, \DateTimeZone $timezone)
	{
		$date = new \DateTimeImmutable('@' . $timestamp);

		return $date->setTimezone($timezone)->format(self::LOCAL_TIME_OUTPUT_FORMAT);
	}

	/**
	 * Check the strict filename used by phpBB's backup/restore UI.
	 *
	 * @param string $filename Filename without a path
	 *
	 * @return bool
	 */
	public static function is_backup_filename($filename)
	{
		return (bool) preg_match('#^backup_\d{10,}_(?:[a-z\d]{16}|[a-z\d]{32})\.sql(?:\.(?:gz|bz2))?$#i', $filename);
	}
}
