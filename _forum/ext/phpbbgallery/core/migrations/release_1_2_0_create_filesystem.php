<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\migrations;

use phpbb\db\migration\migration;

class release_1_2_0_create_filesystem extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\release_1_2_0_add_bbcode'];
	}

	public function update_data(): array
	{
		return array(
			array('custom', array(array(&$this, 'create_file_system'))),
			array('custom', array(array(&$this, 'copy_images'))),
		);
	}

	public function revert_data(): array
	{
		return [
			['custom', [[$this, 'archive_file_system']]],
		];
	}

	public function create_file_system(): void
	{
		global $phpbb_root_path;

		$phpbbgallery_core_file = $phpbb_root_path . 'files/phpbbgallery/core';
		$phpbbgallery_core_file_medium = $phpbb_root_path . 'files/phpbbgallery/core/medium';
		$phpbbgallery_core_file_mini = $phpbb_root_path . 'files/phpbbgallery/core/mini';
		$phpbbgallery_core_file_source = $phpbb_root_path . 'files/phpbbgallery/core/source';

		if (is_writable($phpbb_root_path . 'files'))
		{
			@mkdir($phpbbgallery_core_file, 0755, true);
			@mkdir($phpbbgallery_core_file_medium, 0755, true);
			@mkdir($phpbbgallery_core_file_mini, 0755, true);
			@mkdir($phpbbgallery_core_file_source, 0755, true);
		}
	}

	public function archive_file_system(): bool
	{
		global $phpbb_root_path;

		$files_root = realpath($phpbb_root_path . 'files');
		$gallery_root = $phpbb_root_path . 'files/phpbbgallery/core';
		if (!file_exists($gallery_root) && !is_link($gallery_root))
		{
			return true;
		}

		if ($files_root === false || !is_dir($files_root) || is_link($gallery_root))
		{
			throw new \RuntimeException('Unable to preserve the phpBB Gallery files during purge.');
		}

		$source = realpath($gallery_root);
		$expected = $files_root . DIRECTORY_SEPARATOR . 'phpbbgallery' . DIRECTORY_SEPARATOR . 'core';
		if ($source === false || !is_dir($source) || $this->normalize_path($source) !== $this->normalize_path($expected))
		{
			throw new \RuntimeException('Refusing to purge an unexpected phpBB Gallery file path.');
		}

		$backup_base = dirname($source) . DIRECTORY_SEPARATOR . 'core_backup_' . gmdate('Ymd_His');
		$backup = $backup_base;
		$suffix = 0;
		while (file_exists($backup) || is_link($backup))
		{
			$suffix++;
			if ($suffix > 1000)
			{
				throw new \RuntimeException('Unable to allocate a phpBB Gallery purge backup path.');
			}
			$backup = $backup_base . '_' . $suffix;
		}

		if (!@rename($source, $backup))
		{
			throw new \RuntimeException('Unable to back up the phpBB Gallery files during purge.');
		}

		return true;
	}

	/**
	 * Backwards-compatible entry point for a purge already queued with the old callback.
	 *
	 * @return bool
	 */
	public function remove_file_system(): bool
	{
		return $this->archive_file_system();
	}

	public function copy_images(): void
	{
		global $phpbb_root_path;
		$phpbbgallery_core_file_source = $phpbb_root_path . 'files/phpbbgallery/core/source';
		$phpbbgallery_core_images_source = $phpbb_root_path . 'ext/phpbbgallery/core/images';
		copy($phpbbgallery_core_images_source . '/upload/image_not_exist.jpg', $phpbbgallery_core_file_source . '/image_not_exist.jpg');
		copy($phpbbgallery_core_images_source . '/upload/no_hotlinking.jpg', $phpbbgallery_core_file_source . '/no_hotlinking.jpg');
		copy($phpbbgallery_core_images_source . '/upload/not_authorised.jpg', $phpbbgallery_core_file_source . '/not_authorised.jpg');
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
