<?php
/**
*
* @package sitesplat BBcore
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\BBCore\updater\task;

class t4_download_newest_version
{
	protected $file_downloader;
	protected $filesystem;
	protected $host;
	protected $download_path;
	protected $root_path;
	public function __construct(\phpbb\file_downloader $file_downloader, \phpbb\filesystem\filesystem_interface $filesystem, $host, $download_path, $root_path)
	{
		$this->file_downloader = $file_downloader;
		$this->filesystem = $filesystem;
		$this->host = $host;
		$this->download_path = $download_path;
		$this->root_path = $root_path;
	}

	public function run($style_name, $updater_config)
	{
		$zip = $this->file_downloader->get($this->host, $this->download_path . $updater_config['style_data']['direct_download_dir'], $updater_config['cfg_data']['style_version'] . '_to_' . $updater_config['style_data']['version'] . '.zip');
		if ($zip === false)
		{
			throw new \Exception('PROBLEM_DOWNLOADING_UPDATE');
		}

		$tmp_path = $this->root_path . 'store/';
		$tmp_file = $tmp_path . 'bbcore_autoupdate_' . $updater_config['style_data']['direct_download_dir'] . '.zip';
		if (file_exists($tmp_file))
		{
			$this->filesystem->remove($tmp_file);
		}
		file_put_contents($tmp_file, $zip);

		$updater_config['last_step'] = 't4_download_newest_version';
		return $updater_config;
	}
}
