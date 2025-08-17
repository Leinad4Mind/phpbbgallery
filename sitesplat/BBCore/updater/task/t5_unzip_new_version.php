<?php
/**
*
* @package sitesplat BBcore
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\BBCore\updater\task;

class t5_unzip_new_version
{
	protected $filesystem;
	protected $root_path;
	public function __construct(\phpbb\filesystem\filesystem_interface $filesystem, $root_path)
	{
		$this->filesystem = $filesystem;
		$this->root_path = $root_path;
	}

	public function run($style_name, $updater_config, $root_path)
	{
		$this->root_path = $root_path;
		$tmp_path = $this->root_path . 'store/';
		$tmp_file = $tmp_path . 'bbcore_autoupdate_' . $updater_config['style_data']['direct_download_dir'] . '.zip';
		$updater_config['tmp_dir'] = $tmp_path . 'bbcore_autoupdate_' . $updater_config['style_data']['direct_download_dir'] . '/';

		// make sure tmp dir doesn't exist
		if (file_exists($updater_config['tmp_dir']))
		{
			$this->filesystem->remove($updater_config['tmp_dir']);
		}

		// create tmp dir
		$this->filesystem->mkdir($updater_config['tmp_dir']);

		// unzip archive
		$zip = new \ZipArchive;
		$result = $zip->open($tmp_file);
		if ($result !== true)
		{
			throw new \Exception('DOWNLOADED_FILE_CORRUPTED');
		}
		$result = $zip->extractTo($updater_config['tmp_dir']);
		if ($result !== true)
		{
			throw new \Exception('DOWNLOADED_FILE_CORRUPTED');
		}
		$zip->close();

		// remove temporary zip file
		$this->filesystem->remove($tmp_file);

		$updater_config['last_step'] = 't5_unzip_new_version';
		return $updater_config;
	}
}
