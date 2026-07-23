<?php
/**
 *
 * HTML email extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2015 ForumHulp.com <http://forumhulp.com>
 * @copyright (c) 2026 Leinad4Mind <https://leinad4mind.top>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\htmlemail\service;

class template_editor
{
	protected string $phpbb_root_path;

	public function __construct(string $phpbb_root_path)
	{
		$this->phpbb_root_path = (string) realpath($phpbb_root_path);
	}

	/**
	 * Verify if path is valid and within root path
	 *
	 * @param string $path
	 * @return bool
	 */
	protected function is_valid_path(string $path): bool
	{
		$real_path = realpath($path);
		if ($real_path === false)
		{
			return false;
		}

		if (strpos($real_path, $this->phpbb_root_path) !== 0)
		{
			return false;
		}

		return true;
	}

	/**
	 * Read file content
	 *
	 * @param string $absolute_path
	 * @return string|false
	 */
	public function read(string $absolute_path): string|false
	{
		if (!$this->is_valid_path($absolute_path) || !is_readable($absolute_path))
		{
			return false;
		}

		return file_get_contents($absolute_path);
	}

	/**
	 * Write file content and create backup
	 *
	 * @param string $absolute_path
	 * @param string $content
	 * @return bool
	 */
	public function write(string $absolute_path, string $content): bool
	{
		if (!$this->is_valid_path($absolute_path) || !is_writable($absolute_path))
		{
			return false;
		}

		// Create backup if it doesn't exist yet
		$backup_path = $absolute_path . '.bak';
		if (!file_exists($backup_path))
		{
			if (!copy($absolute_path, $backup_path))
			{
				return false;
			}
		}

		return file_put_contents($absolute_path, $content) !== false;
	}

	/**
	 * Restore file from backup
	 *
	 * @param string $absolute_path
	 * @return bool
	 */
	public function restore(string $absolute_path): bool
	{
		$backup_path = $absolute_path . '.bak';

		if (!file_exists($backup_path))
		{
			return false;
		}

		if (!$this->is_valid_path($backup_path) || !$this->is_valid_path($absolute_path))
		{
			return false;
		}

		if (!is_writable($absolute_path))
		{
			return false;
		}

		$restored = copy($backup_path, $absolute_path);
		if ($restored)
		{
			unlink($backup_path);
		}

		return $restored;
	}
}
