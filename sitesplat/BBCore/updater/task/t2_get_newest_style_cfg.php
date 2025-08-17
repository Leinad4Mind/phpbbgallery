<?php
/**
*
* @package sitesplat BBcore
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\BBCore\updater\task;

class t2_get_newest_style_cfg
{
	protected $file_downloader;
	protected $host;
	protected $versioncheck_path;
	public function __construct(\phpbb\file_downloader $file_downloader, $host, $versioncheck_path)
	{
		$this->file_downloader = $file_downloader;
		$this->host = $host;
		$this->versioncheck_path = $versioncheck_path;
	}

	public function run($style_name, $updater_config)
	{
		$info = $this->file_downloader->get($this->host, $this->versioncheck_path, $style_name);
		$updater_config['style_data'] = json_decode($info, true);

		$updater_config['last_step'] = 't2_get_newest_style_cfg';
		return $updater_config;
	}
}
