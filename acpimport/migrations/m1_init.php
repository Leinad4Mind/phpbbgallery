<?php
/**
 * phpBB Gallery - ACP Import Extension
 *
 * @package   phpbbgallery/acpimport
 * @author    nickvergessen
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\acpimport\migrations;

use phpbb\db\migration\migration;

class m1_init extends migration
{
	/**
	 * Migration dependencies
	 *
	 * @return array Array of migration dependencies
	 */
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\release_1_2_0'];
	}

	/**
	 * Revert the changes
	 *
	 * @return array Array of update data
	 */
	public function revert_data(): array
	{
		return [
				['custom', [[$this, 'archive_file_system']]],
		];
	}

	/**
	 * Update data
	 *
	 * @return array Array of update data
	 */
	public function update_data(): array
	{
		return [
				['permission.add', ['a_gallery_import', true, 'a_board']],
				['module.add', [
					'acp',
					'PHPBB_GALLERY',
					[
						'module_basename' => '\phpbbgallery\acpimport\acp\main_module',
						'module_langname' => 'ACP_IMPORT_ALBUMS',
						'module_mode'     => 'import_images',
						'module_auth'     => 'ext_phpbbgallery/acpimport && acl_a_gallery_import',
					]
				]],
				['custom', [[&$this, 'create_file_system']]],
		];
	}

	/**
	 * Create import directory
	 *
	 * @return void
	 */
	public function create_file_system(): void
	{
		global $phpbb_root_path;

		$phpbbgallery_import_file = $phpbb_root_path . 'files/phpbbgallery/import';

		if (!is_dir($phpbbgallery_import_file))
		{
			if (is_writable($phpbb_root_path . 'files'))
			{
				@mkdir($phpbbgallery_import_file, 0755, true);
			}
		}
	}

	/**
	 * Preserve the import directory during purge
	 *
	 * @return bool
	 */
	public function archive_file_system(): bool
	{
		global $phpbb_root_path;

		$files_root = realpath($phpbb_root_path . 'files');
		$import_root = $phpbb_root_path . 'files/phpbbgallery/import';
		if (!file_exists($import_root) && !is_link($import_root))
		{
			return true;
		}

		if ($files_root === false || !is_dir($files_root) || is_link($import_root))
		{
			throw new \RuntimeException('Unable to preserve the phpBB Gallery import files during purge.');
		}

		$source = realpath($import_root);
		$expected = $files_root . DIRECTORY_SEPARATOR . 'phpbbgallery' . DIRECTORY_SEPARATOR . 'import';
		if ($source === false || !is_dir($source) || $this->normalize_path($source) !== $this->normalize_path($expected))
		{
			throw new \RuntimeException('Refusing to purge an unexpected phpBB Gallery import path.');
		}

		$backup_base = dirname($source) . DIRECTORY_SEPARATOR . 'import_backup_' . gmdate('Ymd_His');
		$backup = $backup_base;
		$suffix = 0;
		while (file_exists($backup) || is_link($backup))
		{
			$suffix++;
			if ($suffix > 1000)
			{
				throw new \RuntimeException('Unable to allocate a phpBB Gallery import backup path.');
			}
			$backup = $backup_base . '_' . $suffix;
		}

		if (!@rename($source, $backup))
		{
			throw new \RuntimeException('Unable to back up the phpBB Gallery import files during purge.');
		}

		return true;
	}

	/**
	 * Backwards-compatible entry point for a purge queued with the old callback.
	 *
	 * @return bool
	 */
	public function remove_file_system(): bool
	{
		return $this->archive_file_system();
	}

	/**
	 * @param string $path
	 * @return string
	 */
	private function normalize_path(string $path): string
	{
		$path = rtrim(str_replace('\\', '/', $path), '/');
		if (DIRECTORY_SEPARATOR === '\\')
		{
			return strtolower($path);
		}

		return $path;
	}
}
