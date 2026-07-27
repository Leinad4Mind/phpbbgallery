<?php
/**
 * phpBB Gallery - Export Extension
 *
 * @package   phpbbgallery/export
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\export\migrations;

use phpbb\db\migration\migration;

class m1_init extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\release_1_2_0'];
	}

	public function update_data(): array
	{
		return [
			['permission.add', ['a_gallery_export', true, 'a_board']],
			['module.add', ['acp', 'PHPBB_GALLERY', [
				'module_basename'	=> '\phpbbgallery\export\acp\main_module',
				'module_langname'	=> 'ACP_GALLERY_EXPORT',
				'module_mode'		=> 'export',
				'module_auth'		=> 'ext_phpbbgallery/export && acl_a_gallery_export',
			]]],

			// Images written per request. Small enough that a shared host finishes a
			// batch well inside its time limit, large enough to not thrash the disk.
			['config.add', ['phpbb_gallery_export_batch_size', 25]],
			['config.add', ['phpbb_gallery_export_max_images', 5000]],
			['config.add', ['phpbb_gallery_export_max_bytes', 2147483648]],
			['config.add', ['phpbb_gallery_export_ttl', 86400]],
			['config.add', ['phpbb_gallery_export_ucp_enable', 1]],
			['config.add', ['phpbb_gallery_export_ucp_max_images', 500]],
			['config.add', ['phpbb_gallery_export_prune_time', 0]],

			['custom', [[&$this, 'create_file_system']]],
		];
	}

	public function revert_data(): array
	{
		return [
			['custom', [[&$this, 'remove_file_system']]],
		];
	}

	/**
	 * Create the directory finished archives are written to.
	 *
	 * It lives under files/, which phpBB already closes to the web server, and gets
	 * its own copy of that protection so a server that serves this directory
	 * directly still refuses.
	 *
	 * @return void
	 */
	public function create_file_system(): void
	{
		global $phpbb_root_path;

		$export_path = $phpbb_root_path . 'files/phpbbgallery/export';

		if (!is_dir($export_path) && is_writable($phpbb_root_path . 'files'))
		{
			@mkdir($export_path, 0755, true);
		}

		if (!is_dir($export_path))
		{
			return;
		}

		$index = $export_path . '/index.htm';
		if (!file_exists($index))
		{
			@file_put_contents($index, "<html>\n<head>\n<title></title>\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n</head>\n<body bgcolor=\"#FFFFFF\" text=\"#000000\">\n</body>\n</html>\n");
		}

		$htaccess = $export_path . '/.htaccess';
		if (!file_exists($htaccess))
		{
			@file_put_contents($htaccess, $this->get_htaccess());
		}
	}

	/**
	 * Give back the directory on purge, but never the archives inside it.
	 *
	 * An administrator may have left an export there on purpose, so anything beyond
	 * the two protection files this migration wrote is left exactly where it is.
	 *
	 * @return void
	 */
	public function remove_file_system(): void
	{
		global $phpbb_root_path;

		$export_path = $phpbb_root_path . 'files/phpbbgallery/export';
		if (!is_dir($export_path) || is_link($export_path))
		{
			return;
		}

		foreach (['index.htm', '.htaccess'] as $file)
		{
			$path = $export_path . '/' . $file;
			if (is_file($path))
			{
				@unlink($path);
			}
		}

		$remaining = @scandir($export_path);
		if ($remaining !== false && count(array_diff($remaining, ['.', '..'])) === 0)
		{
			@rmdir($export_path);
		}
	}

	/**
	 * The protection phpBB puts on files/, repeated for this directory.
	 *
	 * @return string
	 */
	private function get_htaccess(): string
	{
		return "<IfModule mod_version.c>\n"
			. "\t<IfVersion < 2.4>\n"
			. "\t\tOrder Allow,Deny\n"
			. "\t\tDeny from All\n"
			. "\t</IfVersion>\n"
			. "\t<IfVersion >= 2.4>\n"
			. "\t\tRequire all denied\n"
			. "\t</IfVersion>\n"
			. "</IfModule>\n"
			. "<IfModule !mod_version.c>\n"
			. "\t<IfModule !mod_authz_core.c>\n"
			. "\t\tOrder Allow,Deny\n"
			. "\t\tDeny from All\n"
			. "\t</IfModule>\n"
			. "\t<IfModule mod_authz_core.c>\n"
			. "\t\tRequire all denied\n"
			. "\t</IfModule>\n"
			. "</IfModule>\n";
	}
}
