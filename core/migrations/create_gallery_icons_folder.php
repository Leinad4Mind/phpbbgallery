<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\migrations;

use phpbb\db\migration\migration;

/**
 * Create the folder album icons are uploaded into and picked from.
 *
 * Unlike the gallery's own upload directories under files/, this one has to stay
 * web-accessible: an album icon is shown as a plain <img> pointing straight at it,
 * the same way phpBB's own images/icons and images/avatars folders are served.
 */
class create_gallery_icons_folder extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\own_image_move'];
	}

	public function update_data(): array
	{
		return [
			['custom', [[$this, 'create_icons_folder']]],
		];
	}

	public function revert_data(): array
	{
		return [
			['custom', [[$this, 'archive_icons_folder']]],
		];
	}

	public function create_icons_folder(): void
	{
		global $phpbb_root_path;

		$icons_folder = $phpbb_root_path . 'images/galleryicons';

		if (!is_writable($phpbb_root_path . 'images'))
		{
			return;
		}

		@mkdir($icons_folder, 0755, true);

		if (!is_dir($icons_folder))
		{
			return;
		}

		// A directory-listing guard, not an access block: the folder must stay
		// reachable so an icon's URL works, matching images/icons/index.htm.
		$index = $icons_folder . '/index.htm';
		if (!file_exists($index))
		{
			file_put_contents($index, "<html>\n<head>\n<title></title>\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n</head>\n\n<body bgcolor=\"#FFFFFF\" text=\"#000000\">\n\n</body>\n</html>\n");
		}
	}

	/**
	 * Rename the folder away on purge rather than delete it, so an admin's uploaded
	 * icons - and any album still pointing at one - are not destroyed by uninstalling
	 * the extension.
	 *
	 * @return bool
	 */
	public function archive_icons_folder(): bool
	{
		global $phpbb_root_path;

		$images_root = realpath($phpbb_root_path . 'images');
		$icons_folder = $phpbb_root_path . 'images/galleryicons';
		if (!file_exists($icons_folder) && !is_link($icons_folder))
		{
			return true;
		}

		if ($images_root === false || !is_dir($images_root) || is_link($icons_folder))
		{
			throw new \RuntimeException('Unable to preserve the phpBB Gallery icons during purge.');
		}

		$source = realpath($icons_folder);
		$expected = $images_root . DIRECTORY_SEPARATOR . 'galleryicons';
		if ($source === false || !is_dir($source) || $this->normalize_path($source) !== $this->normalize_path($expected))
		{
			throw new \RuntimeException('Refusing to purge an unexpected phpBB Gallery icons path.');
		}

		$backup_base = dirname($source) . DIRECTORY_SEPARATOR . 'galleryicons_backup_' . gmdate('Ymd_His');
		$backup = $backup_base;
		$suffix = 0;
		while (file_exists($backup) || is_link($backup))
		{
			$suffix++;
			if ($suffix > 1000)
			{
				throw new \RuntimeException('Unable to allocate a phpBB Gallery icons purge backup path.');
			}
			$backup = $backup_base . '_' . $suffix;
		}

		if (!@rename($source, $backup))
		{
			throw new \RuntimeException('Unable to back up the phpBB Gallery icons during purge.');
		}

		return true;
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
