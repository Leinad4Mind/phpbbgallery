<?php
/**
 * @package Dropbox Upload
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace leinad4mind\dropboxupload\core;

class upload_policy
{
	const MIN_FREQUENCY = 1;
	const MAX_FREQUENCY = 25;
	const MAX_FOLDER_LENGTH = 512;
	protected static $folder_options = array('DEFAULT', 'CURRENT_DAY', 'DAY_OF_WEEK', 'WEEK_NO', 'MONTH', 'YEAR', 'MONTH_YEAR');
	public static function get_folder_options()
	{
		return self::$folder_options;
	}
	public static function normalize_folder($folder)
	{
		$folder = trim(trim((string) $folder), '/');
		if (strlen($folder) > self::MAX_FOLDER_LENGTH || strpos($folder, chr(92)) !== false || preg_match('#[\x00-\x1F\x7F]#', $folder))
		{
			throw new \InvalidArgumentException('DROPBOX_FOLDER_INVALID');
		}
		if ($folder === '')
		{
			return '';
		}
		$parts = explode('/', $folder);
		foreach ($parts as $part)
		{
			if ($part === '' || $part === '.' || $part === '..' || trim($part) !== $part)
			{
				throw new \InvalidArgumentException('DROPBOX_FOLDER_INVALID');
			}
		}
		return implode('/', $parts);
	}
	public static function validate_options($folder_option, $frequency)
	{
		if (!in_array($folder_option, self::$folder_options, true))
		{
			throw new \InvalidArgumentException('DROPBOX_FOLDER_OPTION_INVALID');
		}
		if ($frequency < self::MIN_FREQUENCY || $frequency > self::MAX_FREQUENCY)
		{
			throw new \InvalidArgumentException('DROPBOX_FREQUENCY_INVALID');
		}
	}
	public static function validate_credentials(array $credentials, $required)
	{
		$access = trim(isset($credentials['dropbox_access_token']) ? $credentials['dropbox_access_token'] : '');
		$app_key = trim(isset($credentials['dropbox_app_key']) ? $credentials['dropbox_app_key'] : '');
		$app_secret = trim(isset($credentials['dropbox_app_secret']) ? $credentials['dropbox_app_secret'] : '');
		$refresh = trim(isset($credentials['dropbox_refresh_token']) ? $credentials['dropbox_refresh_token'] : '');
		$refresh_values = array($app_key, $app_secret, $refresh);
		$refresh_count = count(array_filter($refresh_values, function ($value)
		{
			return $value !== '';
		}));
		if ($refresh_count > 0 && $refresh_count < 3)
		{
			throw new \InvalidArgumentException('DROPBOX_REFRESH_CREDENTIALS_INCOMPLETE');
		}
		if ($required && $access === '' && $refresh_count !== 3)
		{
			throw new \InvalidArgumentException('DROPBOX_CREDENTIALS_REQUIRED');
		}
		foreach ($credentials as $value)
		{
			if (strlen($value) > 4096 || preg_match('#[\x00-\x1F\x7F]#', $value))
			{
				throw new \InvalidArgumentException('DROPBOX_CREDENTIAL_INVALID');
			}
		}
	}
	public static function build_remote_path($folder, $folder_option, $filename, $timestamp, $timezone)
	{
		$folder = self::normalize_folder($folder);
		self::validate_backup_filename($filename);
		if (!in_array($folder_option, self::$folder_options, true))
		{
			throw new \InvalidArgumentException('DROPBOX_FOLDER_OPTION_INVALID');
		}
		try
		{
			$date = new \DateTimeImmutable('@' . (int) $timestamp);
			$date = $date->setTimezone(new \DateTimeZone($timezone));
		}
		catch (\Exception $exception)
		{
			$date = new \DateTimeImmutable('@' . (int) $timestamp);
		}
		$dynamic = '';
		switch ($folder_option)
		{
			case 'CURRENT_DAY':
				$dynamic = $date->format('Y-m-d');
			break;
			case 'DAY_OF_WEEK':
				$dynamic = $date->format('l');
			break;
			case 'WEEK_NO':
				$dynamic = 'Week' . $date->format('W');
			break;
			case 'MONTH':
				$dynamic = $date->format('F');
			break;
			case 'YEAR':
				$dynamic = $date->format('Y');
			break;
			case 'MONTH_YEAR':
				$dynamic = $date->format('F-Y');
			break;
		}
		$parts = array_filter(array($folder, $dynamic, $filename), function ($value)
		{
			return $value !== '';
		});
		return '/' . implode('/', $parts);
	}
	public static function resolve_backup_path($root_path, $location, $filename, $extension)
	{
		$full_filename = $filename . $extension;
		self::validate_backup_filename($full_filename);
		$store = realpath(rtrim($root_path, '/\\') . DIRECTORY_SEPARATOR . 'store');
		$event_path = realpath($location);
		if ($store === false || $event_path === false || !self::paths_equal($store, $event_path))
		{
			throw new \RuntimeException('DROPBOX_BACKUP_PATH_INVALID');
		}
		$backup = realpath($event_path . DIRECTORY_SEPARATOR . $full_filename);
		if ($backup === false || !is_file($backup) || !is_readable($backup) || !self::paths_equal(dirname($backup), $store))
		{
			throw new \RuntimeException('DROPBOX_BACKUP_FILE_INVALID');
		}
		return $backup;
	}
	protected static function validate_backup_filename($filename)
	{
		if (!preg_match('#^backup_[0-9]+_[A-Za-z0-9]+\.sql(?:\.(?:gz|bz2))?$#D', $filename))
		{
			throw new \InvalidArgumentException('DROPBOX_BACKUP_FILE_INVALID');
		}
	}
	protected static function paths_equal($first, $second)
	{
		$first = rtrim(str_replace(chr(92), '/', $first), '/');
		$second = rtrim(str_replace(chr(92), '/', $second), '/');
		if (DIRECTORY_SEPARATOR === chr(92))
		{
			return strtolower($first) === strtolower($second);
		}
		return $first === $second;
	}
}
